<style>
    .code-editor {
        text-align: right;
    }

    .code-editor .CodeMirror {
        font-family: "Fira Mono", monospace;
    }

    .code-editor__input {
        text-align: left;
        border: 1px solid #ccd0d2;
    }

    .code-editor__mode-select {
        margin-top: 1em;
        width: auto;
        display: inline-block;
    }
</style>

<template>
<div class="code-editor">

    <div class="code-editor__input">
        <codemirror ref="myEditor" v-model="code" @input="codeChange" :options="editorOption"></codemirror>
    </div>

    <select v-if="!readOnly" class="form-control code-editor__mode-select" @change="updateLang" v-model="selectedMode">
        <option v-for="mode in modes" :value="mode.mode">{{ mode.name }}</option>
    </select>
    </div>
</template>

<script>
    import { codemirror, CodeMirror } from 'vue-codemirror';

    import CodeMirrorMetas from 'vue-codemirror/metas.js';

    export default {
        props: {
            mode: String,
            value: String,
            readOnly:  {
               type: Boolean,
               default: false
            }
        },
        data() {
            return {
                code: '',
                modes: CodeMirrorMetas.modeInfo,
                selectedMode: this.mode || 'htmlmixed',
                editorOption: {
                    readOnly: this.readOnly,
                    tabSize: 4,
                    lineNumbers: true,
                    line: true,
                    keyMap: "sublime",
                    extraKeys: { "Ctrl": "autocomplete" },
                    foldGutter: true,
                    gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
                    styleSelectedText: true,
                    highlightSelectionMatches: { showToken: /\w/, annotateScrollbar: true },
                }
            }
        },
        mounted() {
            this.code = this.value;
            this.updateLang();
        },
        watch: {
            'value': function(newVal, oldVal) {
                this.code = newVal;
            },
            'mode': function(newVal, oldVal) {
                if (newVal !== '') {
                    this.selectedMode = newVal;
                    this.updateLang();
                }
            }
        },
        components: {
            codemirror
        },
        methods: {
            updateLang() {
                let language = this.selectedMode;
                require('codemirror/mode/' + language + '/' + language + '.js');
                this.$refs.myEditor.editor.setOption('mode', language);
                this.$emit('modeChange', this.selectedMode);
            },
            codeChange() {
                this.$emit('input', this.code);
            }
        }
    }
</script>