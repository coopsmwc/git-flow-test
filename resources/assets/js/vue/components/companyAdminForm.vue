<template>
    <div>
        <input type="hidden" name="type" value="2">
        <input type="hidden" name="exists" v-model="exists">
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right required">Email Address</label>
            <div class="col-md-6">
                <input @input="checkEmail()" id="email" type="email" class="form-control" v-bind:class="{ 'is-invalid' : getError('email') }" name="email" v-model="email" required autofocus>
                <span v-if="getError('email')" class="invalid-feedback">
                    <strong v-text="getError('email')"></strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right required">Name</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" v-bind:class="{ 'is-invalid' : getError('name') }" name="name" v-model="name" required autofocus>
                <span v-if="getError('name')" class="invalid-feedback">
                    <strong v-text="getError('name')"></strong>
                </span>
            </div>
        </div>
        <div v-if="action === 'update'" class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
                <input id="password" type="text" class="form-control" v-bind:class="{ 'is-invalid' : getError('password'),  }" name="password" v-model="password" autofocus autocomplete="new-password">
                <input type="hidden" name="wpwd"  value="1">                
                <span v-if="getError('password')" class="invalid-feedback">
                    <strong v-text="getError('password')"></strong>
                </span>
            </div>
        </div>
        <div v-else class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right required">Password</label>
            <div class="col-md-6">
                <input id="password" type="text" class="form-control" v-bind:class="{ 'is-invalid' : getError('password'),  }" name="password" v-model="password" required autofocus autocomplete="new-password">
                <input type="hidden" name="wpwd"  value="1">                
                <span v-if="getError('password')" class="invalid-feedback">
                    <strong v-text="getError('password')"></strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="notes" class="col-md-4 col-form-label text-md-right">Description</label>
            <div class="col-md-6">
                <textarea id="notes" class="form-control" v-bind:class="{ 'is-invalid' : getError('notes') }" name="notes" v-model="notes" autofocus></textarea>
                <span v-if="getError('notes')" class="invalid-feedback">
                    <strong v-text="getError('notes')"></strong>
                </span>
            </div>
        </div>
        <modal-confirm-admin v-bind:email="email" v-bind:password="password" v-bind:url="getUrl()" v-bind:exists="exists"></modal-confirm-admin>
    </div>
</template>

<script>
console.log ('company-admin-form.vue');

import modalConfirmAdmin from './modalConfirmAdmin.vue';
export default {
    components: {
        'modal-confirm-admin': modalConfirmAdmin,
    },
    props: {
        errors: {},
        obj: {},
        old: {},
        stub: null,
        action: {
            default: 'create'
        },
        redirect: null,
        
    },
    data: function () {
        return {
            fields: ['password', 'name', 'note'],
            exists: 0,
            id: false,
            email: '',
            name: '',
            password: '',
            notes: '',
            formerrors: {},
        }
    },
    methods: {
        getUrl: function () {
            return location.protocol+'//'+location.hostname+'/'+this.stub;
        },
        getError: function (_name) {
            if (this.formerrors.hasOwnProperty(_name)) {
                return this.formerrors[_name][0];
            }
            return false;
        },
        checkEmail: function (_event) {
            // If it's edit and the email address has not changed don't do user check
            if (this.action === 'update' && this.email === this.obj.user.email) {
                this.formerrors = {};
                return;
            }
            // Only check if it is a whole email address
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(event.currentTarget.value)) {
                axios.post('/api/'+this.stub+'/admins', {
                    email: event.currentTarget.value
                })
                  .then(function (response) {
                    if (! response.data.success) {
                        this.formerrors = response.data.message;
                        this.id = false;
                        this.clearForm();
                        return false;
                    }
                    if (response.data.hasOwnProperty('data')) {
                        this.id = response.data.data.user_id;
                        this.exists = 1;
                        return;
                    }
                    this.exists = 0;
                    this.formerrors = {};
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        clearForm: function () {
            ['password', 'name', 'note'].forEach(function(element) {
                this[element] = '';
            }.bind(this));
            this.exists = 0;
        },
        submitForm: function (_event) {
            _event.preventDefault();
            var values = this.$parent.getFormJson(JSON.parse(JSON.stringify($('form#create, form#update').serializeArray())));
            if (this.id) {
                values['id'] = this.id;
            }
            // Post the form data
            axios.post(this.endpoint, values)
              .then(function (response) {
                if (! response.data.success) {
                    this.formerrors = response.data.message;
                    return false;
                }
                this.showConfirm();
            }.bind(this))
              .catch(function (error) {
                console.log(error);
            });
        },
        showConfirm: function () {
            // Show the confirmation dialog with copy to clipboard
            $('#admin-confirm').modal({
                 keyboard: false,
                 backdrop: 'static'
            });
        },
        goToList: function () {
            location.href = this.redirect;
        }
    },
    mounted() {
        $('form#create, form#update').submit(this.submitForm);
        $('#admin-confirm').on('hidden.bs.modal', this.goToList);
        if (this.action === 'update') {
            this.endpoint = '/api/'+this.stub+'/administrator/'+this.obj.id;
            return;
        }
        this.endpoint = '/api/'+this.stub+'/administrator/'+this.action;
    },
    created: function() {
        this.formerrors = this.errors;
        let obj = this.action === 'update' ? this.obj : this.old;
        if (this.action === 'update') {
            this.exists = 1;
            this.email = obj.user.email;
            this.name = obj.name;
            this.notes = obj.notes;
        }
    }
}
</script>
