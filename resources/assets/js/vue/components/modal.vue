<template>
<div class="modal fade delete-confirm" id="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-text='title'></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div v-html="content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-custom-secondary cancel" data-dismiss="modal">CANCEL</button>
        <button v-if="button" type="button" class="btn btn-primary btn-custom confirm" v-text="button" id="trigger"></button>
      </div>
    </div>
  </div>
</div>
</template>
<script>
console.log ('modal.vue');
    export default {
        data: function () {
            return {
                type: 'help'
            }
        },
        props: {
            content: null,
            title: null,
            button: null
        },
        methods: {
            showModal: function (e) {
                /**
                 *  Show the confirmation dialog. If there is a submit button
                 *  trigger form validation before showing the modal
                 */
                if (this.button) {
                    var form = document.querySelector('#mform');
                    if (form.checkValidity()) {
                        e.preventDefault();
                        $('#modal').modal();
                    }
                    return;
                }
                $('#modal').modal();
            },
            submitForm: function () {
                // Submit the main form
                $('#mform').submit();
            }
        },
        mounted () {
            this.type = $('[data-modal]').attr('data-modal');
            $('[data-modal').click(this.showModal);
            $('#trigger').click(this.submitForm);
        }
    }
</script>
