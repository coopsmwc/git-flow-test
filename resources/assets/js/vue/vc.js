Vue.component('company-admin-form', require('./components/companyAdminForm.vue'));
Vue.component('modal', require('./components/modal.vue'));
Vue.component('popover', require('./components/popover.vue'));
Vue.component('clipboard', require('./components/clipboard.vue'));

var vm = new Vue({
    el: '#app',
    data: {
        currentFormComponent: null
    },
    methods: {
        getFormJson: function (_s) {
            var jsonObj = {};
            $.map(_s, function( n, i ) {
                jsonObj[n.name] = n.value;
            });
            return jsonObj;
        }
    },
    mounted() {
        $('[data-toggle="popover"]').popover();
    }
});
