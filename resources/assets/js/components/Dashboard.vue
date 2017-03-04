<style>
    .page__header {
        margin-bottom: 3em;
    }

    .page__title,
    .page__select {
        display: inline-block;
    }

    .page__select {
        width: auto;
        height: auto;
        font-size: 25px;
    }

    .page__button {
        vertical-align: baseline;
        line-height: 1.6;
        margin-left: 15px;
        padding: 15px 16px;
    }
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
            <section>
                <header class="page__header">
                                <h1 class="page__title">Your Snippets:</h1>
                <select v-model="selectedTag" class="form-control page__select" @change="getSnippetsByTag">
                <option value="*">all</option>
                <option v-for="tag in tags" :value="tag.id">{{ tag.name }}</option>
                </select>
                    <router-link class="btn btn-primary btn-lg page__button" :to="{ name: 'create' }">Add New</router-link>
                </header>
                <main v-show="loaded">
                    <snippet-list :value="snippets"></snippet-list>
                    <p class="text-center" v-if="!snippets.length" v-text="noSnippetsText"></p>
                </main>
            </section>
            </div>
            <loader v-show="!loaded"></loader>
        </div>
    </div>
</template>

<script>
import Loader from './Loader.vue';
import SnippetList from './snippets/SnippetList.vue';

    export default {
        data() {
            return {
                snippets: [],
                tags: [],
                selectedTag: '*',
                error: '',
                loaded: true,
                app: app
            }
        },
        components: {
            Loader,
            SnippetList
        },
        mounted() {
            axios.get('snippets')
                .then(({ data }) => {
                    this.snippets = data;
                    this.$emit('loaded');
                });

            axios.get('tags')
                .then(({ data }) => {
                    this.tags = data;
            });

        },
        methods: {
            getSnippetsByTag() {
                this.loaded = false;
                if (this.selectedTag === "*") {
                    axios.get('snippets')
                    .then(({ data }) => {
                        this.snippets = data;
                        this.loaded = true;
                    });
                    return;
                }

                axios.get('tags/' + this.selectedTag)
                .then(({ data }) => {
                    this.snippets = data.snippets;
                    this.loaded = true;
                });
            }
        },
        computed: {
            noSnippetsText() {
                let tag = this.selectedTag !== "*" ? 'with this tag ' : ' ';
                return 'You don\'t have any snippets ' + tag + 'yet!';
            }
        }
    }
</script>
