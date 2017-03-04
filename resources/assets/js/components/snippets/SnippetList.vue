<template>
    <ul class="list-unstyled">
        <li v-for="snippet in snippets" class="snippet">
            <snippet :value="snippet" @delete="updateSnippets"></snippet>
        </li>
    </ul>
</template>

<script>
import Snippet from './Snippet.vue';

export default {
    props: ['value'],
    data() {
        return {
            snippets: []
        }
    },
    components: {
        Snippet
    },
    mounted() {
        this.snippets = this.value;
    },
    watch: {
        'value': function(newVal, oldVal) {
            this.snippets = newVal;
        },
    },
    methods: {
        updateSnippets(id) {
            this.snippets = this.snippets.filter(snippet => {
                return snippet.id !== id;
            });
        }
    }
}
</script>