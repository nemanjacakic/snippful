<style>
    .snippet {
        margin-bottom: 3em;
    }

    .snippet__title {
        text-transform: lowercase;
    }

    .snippet__meta {
        margin: 10px 0;
    }

    .snippet__tag:after {
        content: ',';
    }

    .snippet__tag:last-of-type  {
        padding-right: 0;
    }

    .snippet__tag:last-of-type:after {
        content: '';
    }
</style>
<template>
    <div>
        <h2>
            <router-link class="snippet__title" :to="{ name: 'edit',  params: { id: snippet.id } }">{{ snippet.title }}</router-link>
        </h2>
        <div class="snippet__meta">
        <div class="u-info" v-if="snippet.tags.length !== 0">
            <div class="u-info__label">tags:</div>
            <ul class="list-inline snippet__tags u-info__content">
                 <li v-for="tag in snippet.tags" class="snippet__tag">{{ tag.name }}</li>
            </ul>
        </div>
        <div class="u-info">
            <div class="u-info__label">last updated: </div>
            <div class="u-info__content">{{ snippet.updatedAt }}</div>
        </div>
        <div class="u-info">
            <div class="u-manage-buttons">
            <router-link class="btn btn-info" :to="{ name: 'edit',  params: { id: snippet.id } }">Edit</router-link>
            <button class="btn btn-danger" @click.prevent="destroy(snippet.id)">Delete</button>
            </div>
        </div>
        </div>
        <p>
            {{ snippet.description }}
        </p>
        <code-editor :readOnly="true" :value="snippet.body" :mode="snippet.mode"></code-editor>
    </div>
</template>

<script>
import alertify from 'alertifyjs';
import CodeEditor from '../CodeEditor.vue';

export default {
    props: ['value'],
    data() {
        return {
            snippet: {
                id: 0,
                title: '',
                description: '',
                body: '',
                tags: []
            }
        }
    },
    components: {
        CodeEditor
    },
    mounted() {
        this.snippet = this.value;
    },
    watch: {
        'value': function(newVal, oldVal) {
            this.snippet = newVal;
        },
    },
    methods: {
        destroy(id) {
            alertify.confirm(
                'Are you sure ?',
                'This will delete current snippet',
                () => {
                axios.delete('snippets/' + id)
                .then(response => {
                    this.$emit('delete', id);
                    alertify.success('Snippet deleted');
                })
                .catch(({response}) => {
                    alertify.error(response.data.error.message);
                });
            },() => {}).set('labels', {ok:'Yes', cancel:'No'}); ;
        }
    }
}

</script>