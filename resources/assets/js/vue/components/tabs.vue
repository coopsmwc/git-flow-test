<template>
    <div v-html="view"></div>
</template>
<script>
console.log ('tabs.vue');
    export default {
        data: function () {
            return {
              view: null
            }
        },
        props: {
            data: null
        },
        created () {
            axios.get('/api/company/comp1/admin-tabs')
                .then(function (response) {
                    this.view = response.data;
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                });
            console.log(this.view);
        }
    }
</script>
