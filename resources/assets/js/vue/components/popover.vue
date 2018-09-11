<template>
        <i tabindex="0" class="far  fa-question-circle fa-lg" style="cursor: pointer; margin-top:10px; outline: none; color: #ec7c22"  role="button" data-toggle="popover" data-trigger="focus" v-bind:title="title" v-bind:data-content="text"></i>
</template>

<script>
console.log ('popover.vue');
    export default {
        data: function () {
            return {
            }
        },
        props: {
            title: null,
            text: null
        },
        methods: {
        },
        mounted () {
        }
    }
</script>
