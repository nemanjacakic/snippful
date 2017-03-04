<style>
    .tags__input-group {
        position: relative;
        border: 1px solid;
        display: inline-block;

        margin-bottom: 5px;
        margin-right: 5px;
    }

    .tags__label {
        height: 100%;
        display: inline-block;
        margin-bottom: 0;
        padding: 3px 10px 3px 35px;
    }

    .tags__input {
        display: none;
        color: white;
    }

    .tags__label:before {
        content: "";
        font-family: 'Glyphicons Halflings';
        display: block;
        text-align: center;
        width: 30px;
        height: 100%;
        background: #2579a9;
        color: white;
        position: absolute;
        left: 0;
        top: 0;
        padding: 3px 0;
        transition: all .6s ease;
    }

    .tags__input:checked + .tags__label:before {
        content: "\e013";
    }

</style>

<template>
    <div>
        <div class="form-group" v-if="tags">
        <p><strong>Tags:</strong></p>
        <ul class="list-inline">
        <li class="tags__input-group" v-for="tag in tags" >
  <input class="tags__input" type="checkbox" :name="name + '[]'" :id="'tag' + tag.id" :value="tag.id" v-model="selectedTags" @change="updateSelectedTags">
  <label :for="'tag' + tag.id" class="tags__label">
     {{ tag.name }}
  </label>
</li>
        </ul>
    </div>
        <tag-create @created="updateTagList"></tag-create>
    </div>
</template>

<script>
    import TagCreate from './TagCreate.vue';

    export default {
        props: {
            name: {
                type: String,
                default: 'tag'
            },
            value: {
                default() {
                    return [];
                }
            }
        },
        components: {
            TagCreate
        },
        data() {
            return {
                tags: [],
                selectedTags: []
            };
        },
        created() {
            axios.get('tags')
                .then(({ data }) => {
                    this.tags = data;
                });
        },
        mounted() {
            this.selectedTags = this.value;
        },
        watch: {
            'value': function(newVal, oldVal) {
                this.selectedTags = newVal;
            }
        },
        methods: {
            updateSelectedTags() {
                this.$emit('input', this.selectedTags);
            },
            updateTagList(tag) {
                this.tags.push(tag);
            }
        }
    }
</script>

