<template>
<div>
    <form @submit.prevent="store">
        <div class="col-sm-8">
    <label for="title" class="form-label">Title</label>
    <div class="form-group">
        <input class="form-control" type="text" name="title" v-model="snippet.title">
        <p v-if="errors.title" v-for="error in errors.title" class="text-danger">{{ error }}</p>
    </div>


    <div class="form-group">
    <label for="description" class="form-label">Body</label>
        <code-editor v-model="snippet.body" :mode="snippet.mode" @modeChange="updateMode"></code-editor>
        <p v-if="errors.body" v-for="error in errors.body" class="text-danger">{{ error }}</p>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Update</button>
    </div>
    </div>
        <div class="col-sm-4">
        <tags-input v-model="snippet.tags"></tags-input>
    <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" v-model="snippet.description"></textarea>
        <p v-if="errors.description" v-for="error in errors.description" class="text-danger">{{ error }}</p>
    </div>
    </div>
    </form>
</div>
</template>

<script>
    import alertify from 'alertifyjs';
    import TagsInput from '../Tags/TagsInput.vue';
    import CodeEditor from '../CodeEditor.vue';
    import router from '../../routes';

    export default {
        data() {

            return {
                snippet: {
                    id: '',
                    title: '',
                    description: '',
                    body: '',
                    mode: '',
                    tags: [],
                },
                errors: {},
                tags: {}
            }
        },
        components: {
            TagsInput,
            CodeEditor
        },
        created() {
            axios.get('snippets/' + this.$route.params.id)
                .then(({data}) => {
                    this.snippet = data;
                    this.snippet.tags = data.tags.map(tag => tag.id);
                    this.$emit('loaded');
            });

        },
        methods: {
            store() {
                axios.put('snippets/' + this.snippet.id,
                {
                    title: this.snippet.title,
                    description: this.snippet.description,
                    body: this.snippet.body,
                    mode: this.snippet.mode,
                    tags: this.snippet.tags
                })
                .then(response => {
                    alertify.success('Snippet updated');

                    router.push({ name: 'dashboard' });
                }).catch(({response}) => {
                   this.errors = response.data.error.message;
                });
            },
            updateMode(mode) {
                this.snippet.mode = mode;
            }
        }
    }
</script>
