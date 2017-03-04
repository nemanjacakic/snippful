<style>
    .tag {
        margin-bottom: 10px;
    }

    .tag-edit__form {
        display: inline-block;
    }

    .has-error {
        border: 1px solid red;
    }
</style>

<template>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4 tag" v-for="tag in tags">
                        <div class="u-manage-buttons">
                            <button class="btn btn-sm btn-info" @click.prevent="edit(tag)" v-text="currentlyEditing(tag) ? 'Save' : 'Edit'" ></button>
                            <button class="btn btn-sm btn-danger" @click.prevent="destroy(tag.id)">Delete</button>
                            </div>
                        <span v-if="!currentlyEditing(tag)">{{ tag.name }}</span>
                        <form class="tag-edit__form" v-if="currentlyEditing(tag)">
                            <input type="text" :class="{'has-error' : errors}" :name="'tag' + tag.id" v-model="editedTag.name">
                        </form>
                    </div>

                    <p class="text-center" v-if="!tags.length">You don't have any tags.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <tag-create @created="updateTagList"></tag-create>
                </div>
        </div>
    </div>
</template>

<script>
    import alertify from 'alertifyjs';
    import TagCreate from './TagCreate.vue';

    export default {
        data() {
            return {
                tags: [],
                editedTag: '',
                errors: false
            }
        },
        components: {
            TagCreate
        },
        mounted() {
            axios.get('tags')
                .then(({ data }) => {
                    this.tags = data.map(tag => {
                        tag.editing = false;
                        return tag;
                    });
                    this.$emit('loaded');
            });

        },
        methods: {
            currentlyEditing(tag) {
                return tag.id === this.editedTag.id;
            },
            edit(tag) {
                if (tag.id === this.editedTag.id) {
                    axios.put('tags/' + this.editedTag.id,
                    {
                        name: this.editedTag.name,
                    })
                    .then(response => {
                        alertify.success('Tag updated');
                        let index = this.tags.findIndex((tag, index) => {
                            return tag.id === this.editedTag.id;
                        });

                        this.tags[index] = response.data;

                        this.editedTag = {};
                        this.errors = false;
                    }).catch(({response}) => {
                       this.errors = true;
                    });
                } else {
                    this.editedTag = Object.assign({}, tag);
                    this.errors = false;
                }
            },
            destroy(id) {
                alertify.confirm(
                    'Are you sure ?',
                    'This will delete current tag',
                    () => {
                    axios.delete('tags/' + id)
                    .then(response => {
                        this.tags = this.tags.filter(tag => {
                            return tag.id !== id;
                        });

                        alertify.success('Tag deleted');
                    })
                    .catch(({response}) => {
                        alertify.error(response.data.error.message);
                    });
                },() => {}).set('labels', {ok:'Yes', cancel:'No'});
            },
            updateTagList(tag) {
                this.tags.push(tag);
            }
        }
    }
</script>