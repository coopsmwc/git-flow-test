<template>
        <div class="container" v-if="ready"> 
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" v-for="(tab, i) in tabs.data">
                <a class="nav-link" v-bind:class="{ active: i===0 }" id="profile-tab" data-toggle="tab" v-bind:href="'#tab'+i" role="tab" aria-controls="profile" aria-selected="false" v-text="tab.name"></a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div v-for="(tab, i) in tabs.data" class="tab-pane fade" v-bind:class="{ active: i===0, show: i===0 }" v-bind:id="'tab'+i" role="tabpanel" aria-labelledby="home-tab">
                <tab-list v-bind:tabdata="tab"></tab-list>
            </div>
        </div>
    </div>
</template>

<script>
console.log ('adminTabs.vue');
    export default {
        data: function () {
            return {
              tabs: null,
              ready: false
            }
        },
        beforeCreate () {
            axios.get('/api/company/comp1/admin-tabs')
                .then(function (response) {
                    this.tabs = response.data;
                    this.ready = true;
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
</script>
