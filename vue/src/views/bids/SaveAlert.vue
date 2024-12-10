<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001"  :is-full-page="fullPage" />
    <section class="pt-0">
        <div class="container vstack gap-3">
            <div class="row align-items-center mt-3">
                <div class="col-12">
                    <div class="card border rounded-3">
                        <div class="">
                            <div class="rounded p-3" style="padding: 5px !important;">
                                <div class="d-sm-flex justify-content-between">
                                    <div class="d-sm-flex align-items-center ">
                                        <img class="avatar avatar-md rounded-circle float-start me-3" src="assets/images/bulb.png" alt="tips" />
                                        <div class="align-items-center mt-3">
                                            <p>
                                                <span class="text-body"></span>About Scheduled Emails: Scheduled emails include only opportunites that are new or have been modified since the last scheduled run. You can view all matches
                                                regardless of new/modified status by clicking the Run button on the Email Alert list.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded-3">
                        <div class="card-header border-bottom p-3">
                            <div class="d-sm-flex justify-content-between align-items-center">
                                <h5 class="mb-2 mb-sm-0">Alerts</h5>
                                <div>
                                    <label class="dropdown me-2">
                                        <div class="dd-button">
                                            Add Alert
                                        </div>
                                        <input type="checkbox" class="dd-input" id="test" />
                                        <ul class="dd-menu">
                                            <li>
                                                <router-link class="dropdown-item" :to="'bid-alert/Federal/Create'"> Federal </router-link>
                                            </li>
                                        </ul>
                                    </label>

                                     <a href="javascript:void(0)" @click="backgoBidsPage()" type="button" class="mb-0 btn btn-sm btn-primary" style="border-radius: 4px;padding:5px; font-weight:400;">
                                        Back To Bids
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-2">
                            <div class="table-responsive border-0">
                                <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="border-0 rounded-start">Alert Title</th>
                                            <th scope="col" class="border-0">Region</th>
                                            <th scope="col" class="border-0">Last Run</th>
                                            <th scope="col" class="border-0">Next Scheduled Run</th>
                                            <th scope="col" class="border-0">Schedule</th>
                                            <th scope="col" class="border-0 text-center" >Action</th>
                                            <th scope="col" class="border-0 rounded-end">Set Alert</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">
                                        <tr v-if="alerts.length==0">
                                            <td colspan="8" class="text-center">No records found</td>
                                        </tr>
                                        <tr v-for="alert, key in alerts" :key="key">
                                            <td>
                                                <div class="text-primary">
                                                    <i class="fas fa-caret-right blue-arrow me-2"></i>
                                                     {{ alert.alert_title }}
                                                </div>
                                            </td>
                                            <td>{{ alert.region }}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>{{alert.frequency}}</td>
                                            <td>
                                                <div class="hstack gap-2 mt-3 mt-sm-0 " style="justify-content: center;">
                                                    <a href="#" class="btn btn-xs p-1 mb-0 text-primary" @click.prevent="showTenders(alert)"><i class="fa fa-search" aria-hidden="true"></i></a>
                                                    <a href="#" class="btn btn-xs p-1 mb-0 text-success" @click.prevent="edit(alert)"><i class="bi bi-pencil-square"></i></a>
                                                    <a href="#" class="btn btn-xs p-1 mb-0 text-danger" @click.prevent="deleteAlertpopup(alert)"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch text-center form-check-md mb-0">
                                                    <input class="form-check-input" type="checkbox" v-model="alert.status" :value="alert.status" @change="toggleAlert(alert)" />
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                                <div class="d-sm-flex" style="align-items: center;">
                                <p class="mb-sm-0 text-center text-sm-start">
                                    <select class="form-select formpage flex align-items-sm-center" aria-label="Default select example" v-model="meta.per_page" @change="onPerPageChange">
                                        <option>10</option>
                                        <option>20</option>
                                        <option>30</option>
                                    </select>
                                </p>
                                <span style="margin-left:10px"> showing {{meta.to}} of {{meta.totalRows}}</span>
                                </div>
                                <nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
                                    <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                                </nav>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <teleport to="#modals" :disabled="!erroralertmodal" v-if="erroralertmodal">
        <div class="modal-overlay ">
            <div class="confirm">
                <h1>Are you sure?</h1>
                <p>Do you really want to delete these records? This process cannot be undone.</p>
                <button @click.prevent="closemodal()">Cancel</button>
                <button style="color:red !important" @click.prevent="deleteAlert(delete_alert)">Confirm</button>
            </div>
          
        </div>
    </teleport>
</template>
<script>
    import Pagination from "@/components/Pagination.vue";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    export default {
        components: { Pagination, Loading },
        name: "saveAlert",
        data() {
            return {
                alerts:[],
                 naics_code: {
                    search: "",
                    alert_id:''
                },
                service_code: {
                    search: "",
                     alert_id:''
                },
                erroralertmodal: false,
                status: 0,
                alertmodal: false,
                interstedUser: {
                    user_id: "",
                },
                region: [],
                userintersted: [],
                delete_alert:"",
                meta: {
                    search: "",
                    order_by: "DESC",
                    field: "federal_alert_id",
                    per_page: 10,
                    totalRows: 0,
                    currentPage: 1,
                    lastPage: 1,
                    from: 1,
                    maxPage: 1,
                    to: "",
                },
                isLoading: false,
                fullPage: true,
            };
        },
        mounted() {
            this.index()
            // vm.interstedUser.user_id = vm.$store.getters.user.id;
            // vm.getInterstedUser();
            // vm.getRegion();
            // vm.checklogin();
        },

        methods: {
            index(){
                let vm = this
                if(vm.$store.getters.user){
                    vm.meta.user_id = vm.$store.getters.user.user_id
                    vm.$store
                        .dispatch("post", { uri: "paginateAlerts", data:vm.meta })
                        .then(function (response) {
                            // vm.isLoading = false
                            vm.alerts = response.data.data
                            vm.meta.totalRows = response.data.meta.total;
                            vm.meta.lastPage = response.data.meta.last_page;
                            vm.meta.from = response.data.meta.from;
                            vm.meta.to = response.data.to;
                            vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                        })
                }
            },

            deleteAlertpopup(alert){
                this.erroralertmodal = true
                this.delete_alert = alert;
            },
            deleteAlert() {
                let vm = this;
                    vm.isLoading = true;
                    vm.$store
                        .dispatch("post", {uri: "deleteAlert", data:vm.delete_alert})
                        .then(function () {
                            vm.isLoading = false;
                            vm.$store.dispatch("success", "BidsAlert is successfully deleted");
                            vm.erroralertmodal = false
                            vm.index();

                        })
                        .catch(function (error) {
                            vm.isLoading = false;
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
              
                // if (confirm("Do you want to delete this entry ?")) {
                   
                // }
            },

            showTenders(alert) {
                this.$store.commit("setAlert", alert);
                if(alert.region == 'Federal'){
                    this.$router.push('/bids/federal-opportunities')
                }
            },

            backgoBidsPage(){
                 this.$store.commit("setAlert", null);
                 this.$router.push('/bids/state-opportunities')
            },
             closemodal() {
                let vm = this;
                vm.erroralertmodal = false;
            },
             checklogin() {
                let vm = this;
                if (vm.$store.getters.user == null) {
                    vm.$router.push("/bids/state-opportunities");
                }
            },

            search(alert) {
                vm.$store.commit("setAlert", alert);
                this.$router.push("/bids/state-opportunities");
            },

            edit(alert) {
                console.log(alert)
                
		path:'/bids/bid-alert/:region/:alert_id/edit',
                // this.$store.commit("setSelectedNaics",intersted.naics_id ? intersted.naics_id.split(","):[]);
                // this.$store.commit("setSelectedPsces",intersted.psc ? intersted.psc.split(","):[]);
                this.$router.push("/bids/bid-alert/Federal/" + alert.alert_id +'/edit' );
            },

            getInterstedUser() {
                let vm = this;

                let uri = "getAlerts?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.interstedUser })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.userintersted = response.data.data;
                        vm.meta.totalRows = response.data.meta.total;
                        vm.meta.lastPage = response.data.meta.last_page;
                        vm.meta.from = response.data.meta.from;
                        vm.meta.to = response.data.meta.to;
                        vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;

                        // alert(vm.meta.to);
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getRegion() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getRegion" })
                    .then(function (response) {
                        vm.region = response.data.data;
                        //  alert(vm.search_notice);
                        console.log(vm.region);
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            toggleAlert(alert) {
                let vm = this;
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", {
                        uri: "toggleAlert", data: alert,
                    })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Alert is successfully updated");
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            onPageChange(page) {
                this.meta.currentPage = page;
                this.getInterstedUser();
            },
            onPerPageChange() {
                this.meta.currentPage = 1;
                this.getInterstedUser();
            },
        },
    };
</script>
<style scoped>
    /* Dropdown */

    .dropdown {
        display: inline-block;
        position: relative;
    }

    .dd-button {
        display: inline-block;
        border: 1px solid #5143d9;
        border-radius: 4px;
        padding: 5px 30px 5px 5px;
        background-color: #5143d9;
        color: #fff;
        cursor: pointer;
        white-space: nowrap;
        z-index: 99999;
    }
    .dd-button:hover {
        border: 1px solid #5143d9 !important;

        background-color: #5143d9 !important;
        color: #fff !important;
    }

    .dd-button:after {
        content: "";
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid white;
        z-index: 99999;
    }

    .dd-button:hover {
        background-color: #eeeeee;
    }

    .dd-input {
        display: none;
    }

    .dd-menu {
        position: absolute;
        top: 100%;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 0;
        margin: 2px 0 0 0;
        box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        list-style-type: none;
        z-index: 99999;
    }

    .dd-input + .dd-menu {
        display: none;
    }

    .dd-input:checked + .dd-menu {
        display: block;
    }

    .dd-menu li {
        padding: 10px 20px;
        cursor: pointer;
        white-space: nowrap;
    }

    .dd-menu li:hover {
        background-color: #f6f6f6;
    }

    .dd-menu li a {
        display: block;
        margin: -10px -20px;
        padding: 10px 20px;
    }

    .dd-menu li.divider {
        padding: 0;
        border-bottom: 1px solid #cccccc;
    }
    .table > :not(caption) > * > * {
    padding: 0.7rem 0.5rem!important;
    }


    /* alert modal */
       /* bids*/
        /* bids*/
   
    /* popup modal */

    .modal-overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        z-index: 9999;
        left: 0;
        right: 0;
        display: grid;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.3);
    }

    .w-15px {
        width: 15px;
    }

    /* width */
    .scroll1 ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    /* Track */
    .scroll1 ::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px;
    }

    /* Handle */
    .scroll1 ::-webkit-scrollbar-thumb {
        background-color: #5143d9;
        border-radius: 10px;
    }

    .bluetextclass {
        color: #47b1ee;
    }

    .scroll-sidebar {
        height: 550px;
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: scroll;
    }

    .nav.nav-divider .nav-item + .nav-item:before {
        content: "";
        color: inherit;
        padding-left: 0.65rem;
        padding-right: 0.75rem;
        opacity: 0.8;
    }
    .w-15px {
        width: 15px;
    }

    /* width */
    .scroll1 ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    /* Track */
    .scroll1 ::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px;
    }

    /* Handle */
    .scroll1 ::-webkit-scrollbar-thumb {
        background-color: #5143d9;
        border-radius: 10px;
    }

    .bluetextclass {
        color: #47b1ee;
    }

    .scroll-sidebar {
        height: 550px;
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: scroll;
    }

    .nav.nav-divider .nav-item + .nav-item:before {
        content: "";
        color: inherit;
        padding-left: 0.65rem;
        padding-right: 0.75rem;
        opacity: 0.8;
    }

    .scroll1 {
        position: relative;
        height: 150px;
        overflow: hidden;
        overflow-y: scroll;
    }
    .scroll2 {
        position: relative;
        height: 80px;
        overflow: hidden;
        overflow-y: scroll;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background-color: #5143d9;
        border-radius: 10px;
    }

    .bluetextclass {
        color: #47b1ee;
    }

    .scroll-sidebar {
        height: 550px;
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: scroll;
    }
    .limited-text {
        display: -webkit-box;
        overflow: hidden;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    
    

    .col-red {
        color: red;
    }

    /* tree css */

    .dotted {
        border-bottom: 1px dotted;
    }
    .dotted:hover {
        border-bottom: 0px;
    }
    .search-left1 {
        box-shadow: 5px 2px 4px -5px rgb(0 0 0 / 20%);
        border-right: 1px solid lightgray;
    }

    .tree .nav-item1:before {
        content: "+";
        color: inherit;
        padding-left: 0rem;
        padding-right: 0.5rem;
        opacity: 0.8;
    }
    /* .tree .nav-item1:after {
        content: "-";
        color: inherit;
        padding-left: 0rem;
        padding-right: 0.5rem;
        opacity: 0.8;
    }  */

    .tree:hover .item3 {
        opacity: 1;
    }
    .item3 {
        opacity: 0;
        transition-property: opacity;
        transition-duration: 0.3s;
        flex-shrink: 0;
    }
    .list-style-none {
        list-style: none;
    }

    /* saved serach drop down css */
    .dropitem1 {
        display: flex !important;
        cursor: pointer;
    }
    .dropitem1:hover {
        background-color: white;
    }
    .dropitem2:hover {
        background-color: white;
    }
    .cursor {
        cursor: pointer;
    }
    .v3ti--focus {
        /* border:0px solid gray  */
        box-shadow: 0 0 0 0px #000000;
        border-color: #9ca3af;
    }
    /*  */
    /* .modal-overlay1 {
        position: fixed;
        top: 0;
        bottom: 0;
        z-index: 9999;
        left: 0;
        right: 0;
        display: grid;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.3);
    }
 .modal-content1 {
        /* font-family: "Fondamento", cursive; */
    /* padding: 20px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        min-height: 200px;
        width: 480px;
        margin: 1rem;
        position: relative;
        min-width: 200px; */
    /* box-shadow: 0 3px 6px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 23%);
        justify-self: center;
        transition: all 5s ease-in-out; */
    /* }  */
    .highlight {
        color: yellow;
    }

    .v3ti .v3ti-tag {
        background: #f56c6c;
        /*border: 1px solid #222222;*/
        /*border-radius: 0;*/
    }

    .v3ti .v3ti-tag .v3ti-remove-tag {
        color: #000000;
        transition: color 0.3s;
    }

    .v3ti .v3ti-tag .v3ti-remove-tag:hover {
        color: #ffffff;
    }
    .gaplist{
        display: flex;
  flex-direction: column;
  gap: 2px;
    } 
   
    .btn-close{
        color:white
    }
    .v3ti .v3ti-tag {
  background: #F56C6C !important;
  /*border: 1px solid #222222;*/
  /*border-radius: 0;*/
}


 




    /* alert box */

   @keyframes fade {
  from {
    opacity:1;
    transform: translate(-50%, -50%) scale(0.8);
  }
  to {
    opacity:1;
    transform: translate(-50%, -50%) scale(1);
  }
}
.confirm {
  position: absolute;
  top: 30%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 80%;
  min-width: 280px;
  max-width: 500px;
  height: auto;
  background: #E2E2E2;
  border-radius: 10px;
  padding: 0;
  margin: 0;
  border-top: 1px solid white;
  animation: fade 0.3s ease 1 forwards;
}
.confirm h1 {
  text-align: center;
  font-size: 1.2rem;
  margin: 1.5rem 1rem 0.5rem;
}
.confirm p {
  text-align: center;
  font-size: 1rem;
  margin: 0 2rem 4.5rem;
  color:black
}
.confirm button {
  /* background: transparent; */
  border: none;
  color: #2a85ec;
  height: 3rem;
  font-size: 1rem;
  width: 50%;
  position: absolute;
  bottom: 0;
  cursor: pointer;
}
.confirm button:nth-of-type(1) {
  border-top: 1px solid #B4B4B4;
  border-right: 1px solid #B4B4B4;
  left: 0;
  border-radius: 0 0 0 10px;
}
.confirm button:nth-of-type(2) {
  border-top: 1px solid #B4B4B4;
  right: 0;
  border-radius: 0 0 10px 0;
}
.confirm button:focus,
.confirm button:hover {
  font-weight: bold;
  background: #EFEFEF;
}
.confirm button:active {
  background: #D6D6D6;
}
 



 
</style>
