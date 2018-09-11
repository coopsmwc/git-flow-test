<template>
        <i v-bind:id="id" class="fas  fa-clipboard" v-bind:class="classes" style="cursor: pointer;" title="Copy to clipboard" v-bind:data-clipboard-target="target" data-toggle="tooltip" data-trigger="hover" data-placement="top"></i>
</template>

<script>
console.log ('clipboard.vue');
    export default {
        data: function () {
            return {
                title: 'Copy to clipboard'
            }
        },
        props: {
            target: null,
            classes: {
                default: ''
            },
            id: {
                default: 'cptc'
            },
        },
        methods: {
            showCopied: function () {
                if (window.getSelection) {
                    window.getSelection().removeAllRanges();
                } else if (document.selection) {
                    document.selection.empty();
                }
                $('#'+this.id).tooltip('dispose');
                $('#'+this.id).attr('title', 'Copied')
                $('#'+this.id).tooltip('update')
                $('#'+this.id).tooltip('show')
                setTimeout(function(){
                        $('#'+this.id).tooltip('dispose');
                        $('#'+this.id).attr('title', 'Copy to clipboard');
                        $('#'+this.id).tooltip('enable');
                    }, 1500
                );
            }
        },
        mounted () {
            var clipboard = new ClipboardJS('#'+this.id);
            clipboard.on('success', this.showCopied);
        }
    }
</script>
