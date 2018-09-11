<template>
<div class="table-reponsive">
    <table class="table table-hover" id="table-list-domain">
        <thead>
            <tr>
                <th v-for="(value, key) in tabdata.columns" v-text="value"></th>
                <th class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in tabdata.data">
                <td v-for="(value, key) in tabdata.columns" v-text="row[key]"></td>
                <td class="table-icons  text-right">
                    <form method="GET" action="">
                        <button type="submit" class="edit-icons"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                    </form>                    
                    <button type="submit" class="table-submit" data-toggle="modal" data-target="#delete-confirm-"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
console.log ('tabList.vue');
    export default {
        data: function () {
            return {
              ready: false
            }
        },
        props: {
            tabdata: null
        }        
    }
</script>
