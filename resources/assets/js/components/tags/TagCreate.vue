<style>
    .tag-create__button {
        background: #2579a9;
        color: white;
    }

    .tag-create__button:hover,
    .tag-create__button:focus {
        background: #174c6a;
        color: white;
    }

    .tag-create {
        margin: 1em 0;
    }
</style>

<template>
    <form @submit.prevent="store" class="form-inline tag-create">
       <div class="form-group">
    <input class="form-control" type="text" name="name" v-model="name" placeholder="new tag">
    </div>
        <button type="submit" class="btn tag-create__button">add</button>

        <p v-if="errors.name" v-for="error in errors.name" class="text-danger">{{ error }}</p>
    </form>
</template>

<script>
    import alertify from 'alertifyjs';

    export default {
        data() {
            return {
                name: '',
                errors: ''
            }
        },
        methods: {
            store() {
                axios.post('tags',
                {
                    name: this.name
                }).then(({ data : tag }) => {
                    this.$emit('created', tag);
                    this.name = '';
                    alertify.success('Tag created');
                }).catch(({response}) => {
                    this.errors = response.data.error.message;
                });
            }
        }
    }
</script>