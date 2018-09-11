<template>
    <div class="modal" id="admin-confirm" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New admin user confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div v-if="exists" class="modal-body">
                <p>This user has previously accessed the system and has a password. You have successfully added them as a new admin user for your organisation. Please give them the following access URL. They can then log in with their existing password.</p>
            </div>
            <div v-else class="modal-body">
                <p id="title">New admin user "{{ email }}" added. Please give them the following information:</p>
                <p>
                    <div id="addets" style="padding-right:20px;">
                        <span>Access URL: {{ url }}</span><br>
                        <span>Password: {{ password }}</span>
                    </div>
                    <div class="mt-2">
                        <span>Copy to clipboard</span> <clipboard v-bind:id="'mdl1'" v-bind:target="'#addets'"></clipboard>
                    </div>
                </p>
           </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
console.log ('modalConfirmAdmin.vue');
    export default {
        data: function () {
            return {
              view: null
            }
        },
        props: {
            email: null,
            password: null,
            url: null,
            exists : null
        },
        mounted () {
        }
    }
</script>
