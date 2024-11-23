<template>
<loading v-model:active="isLoading" :can-cancel="false" :z-index="10001"  :is-full-page="fullPage" />
<!-- <div v-if="$store.getters.user.subscription_id==0"  class="stripe-1">"You are not subscribed" </div> -->
    <section class="pt-3">
        <div class="container-fluid">
            <div class="row g-2 g-lg-4">
                <!-- Sidebar START -->
                <div class="col-lg-4 col-xl-3">
                    <!-- Responsive offcanvas body START -->
                    <div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasSidebar">
                        <!-- Offcanvas header -->
                        <div class="offcanvas-header justify-content-end pb-2">
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
                        </div>
                        <!-- Offcanvas body -->
                        <div class="offcanvas-body p-3 p-lg-0">
                            <div class="card bg-light w-100">
                                <!-- Edit profile button -->
                              <div class="card-body p-3">
                                    <!-- Avatar and content -->
                                    <div class="text-center ">
                                       <div class="text-center">
                                            <h1 class="avatar avatar-xl rounded-circle border border-white border-3 shadow">{{$store.getters.user.name.substring(0,1)}}</h1>
                                        </div>
                                        <h6 class="mb-0">{{$store.getters.user.name}}</h6>
                                        <a href="javascript:void(0)" class="text-reset text-primary-hover small">{{$store.getters.user.email}}</a>
                                        <hr/>
                                    </div>

                                    <!-- Sidebar menu item START -->
                                    <ul class="nav nav-pills-primary-soft flex-column">
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/user/profile"><i class="bi bi-person fa-fw me-2"></i>My Profile</router-link>
                                        </li>
                                         <li class="nav-item">
                                            <router-link class="nav-link" to="/user/change-password"><i class="bi bi-person fa-fw me-2"></i>Change Password</router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/user/subscription"><i class="bi bi-ticket-perforated fa-fw me-2"></i>Subscription Info</router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link active" to="/user/single-bidpurchases"><i class="bi bi-people fa-fw me-2"></i>Single Bid Purchases</router-link>
                                        </li>
                                        <li class="nav-item" v-if="payment.length !==0">
                                            <router-link class="nav-link" to="/user/my-purchasedbids"><i class="bi bi-people fa-fw me-2"></i> My Purchased Bids</router-link>
                                        </li>
                                    </ul>
                                    <!-- Sidebar menu item END -->
                                </div>
                                <!-- Card body END -->
                            </div>
                        </div>
                    </div>
                    <!-- Responsive offcanvas body END -->
                </div>
                <!-- Sidebar END -->

                <!-- Main content START -->
                <div class="col-lg-8 col-xl-9 ps-xl-5">
                    <!-- Offcanvas menu button -->
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card border rounded-3" style="margin-bottom:195px">
                                <!-- Card header START -->
                                <div class="card-header border-bottom d-sm-flex justify-content-between align-items-center">
                                    
                                       <h6 class="mb-2 mb-sm-0"  v-if="payment.length===0"> This section includes the purchase details history of single Bids only - NOT APPLICABLE for subscriptions based user</h6>
                                        <h5 v-else class="mb-2 mb-sm-0">Single Bid Purchases</h5>
                                         <router-link to="/bids/state-opportunities" type="button" class="mb-0 btn btn-sm btn-primary">
                                        Back To Bids
                                    </router-link>
                                       
                                    
                                </div>
                                <!-- Card header END -->

                                <!-- Card body START -->
                                
                                <div class="card-body" >
                                    <div class="table-responsive border-0" >
                                        <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                            <!-- Table head -->
                                            <thead class="table-light">
                                                <tr>
                                                   <th scope="col" class="border-0">DATE</th>
                                                    <th scope="col" class="border-0">ORDER ID</th>
                                                    <th scope="col" class="border-0">TRANSACTION</th>
                                                    <th scope="col" class="border-0">AMOUNT</th>
                                                    <th scope="col" class="border-0">TYPE</th>
                                                    <th scope="col" class="border-0 rounded-end">DESCRIPTION</th>
                                                </tr>
                                            </thead>

                                            <!-- Table body START -->
                                            <tbody class="border-top-0">
                                                <!-- Table item -->
                                                 <tr v-if="payment.length===0">
                                                    <td  colspan="7" class="text-center">No records found</td>
                                                </tr>
                                                <tr  v-for="userpayment in payment" :key="userpayment.payment_id">
                                                   
                                                    <td>
                                                        <h6 class="mb-0">{{format_date(userpayment.payment_date)}}</h6>
                                                    </td>
                                                    <td>{{userpayment.order_id}}</td>
                                                    <td>{{userpayment.txn_id}}</td>
                                                    <td><div>{{userpayment.payment_amount}}</div></td>
                                                    <td><div>{{userpayment.payment_status}}</div></td>
                                                    <td><div>{{userpayment.payment_status}}</div></td>
                                                   
                                                </tr>
                                            </tbody>
                                            <!-- Table body END -->
                                        </table>
                                    </div>
                                    <!-- Hotel room list END -->
                                </div>
                                <!-- Card body END -->

                                <!-- Card footer START -->
                                <!-- <div class="card-footer pt-0">
                                   
                                    <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                                      
                                        <p class="mb-sm-0 text-center text-sm-start">Showing {{ meta.to }} of {{ meta.totalRows }} entries</p>
                                       
                                        <nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
                                            <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                                        </nav>
                                    </div>
                                </div> -->
                                <!-- Card footer END -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main content END -->
            </div>
        </div>
    </section>
</template>
<script>
    import Pagination from "@/components/Pagination.vue";
    import moment from "moment";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    export default {
        components: { Pagination,Loading },
        name: "singlebidpurchases",
        data() {
            return {
                userbids: {
                    bids: [1000, 1001],
                },

                subscriptions: {
                    user_id: "",
                },

                payment: {
                    user_id: "",
                    item_number: [],
                },

                userpayedbids: [],
                regSetAside: [],
                SetAsideStatus: [],
                user: {
                    title: "",
                    name: "",
                    id: "",
                    email: "",
                    role: "",
                    mobile_number: "",
                    avatar: "",
                    phone: "",
                    company_name: "",
                    web_address: "",
                    mail_address: "",
                    city: "",
                    state: "",
                    zipcode: "",
                    sub_details: {},
                    socioeconomic_status: "",
                },
                password: {
                    id: "",
                    email: "",
                    current_password: "",
                    new_password: "",
                    confirm_password: "",
                },
                errors: [],
               meta: {
                    search: "",
                    order_by: "asc",
                    field: "",
                    per_page: 10,
                    totalRows: 0,
                    currentPage: 1,
                    lastPage: 1,
                    from: 1,
                    maxPage: 1,
                    to: "",
                },
            };
        },
        mounted() {
             this.getPaymentSubscriptions(); 
             moment.updateLocale("language_code", {
                invalidDate: ""
            });
            //  this.checklogin();    
        },
        methods:{
             checklogin() {
                let vm = this;
                if (vm.$store.getters.user == null) {
                    vm.$router.push("/bids/state-opportunities");
                    
                }},
              format_date(value){
                     return moment(String(value)).format('MMMM D, YYYY');
                },
             getPaymentSubscriptions() {
                let vm = this;
                 vm.isLoading = true;
                vm.payment.user_id = vm.$store.getters.user.id
               let uri = "getUserPayments"
                vm.$store
                    .dispatch("post", {uri: uri,data: vm.payment})
                    .then(function (response) {

                        vm.payment = response.data;
                        vm.isLoading = false;
                     
                     })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            //  onPageChange(page) {
            //     this.meta.currentPage = page;
            //     this.getPaymentSubscriptions();
            // },
            // onPerPageChange() {
            //     this.meta.currentPage = 1;
            //     this.getPaymentSubscriptions();
            // },
        }
    };
</script>
<style scoped>
.stripe-1 {
  color: white !important;
 
 background-image: linear-gradient(45deg, #5f7bed 25%, #3D6F8E 25%, #3D6F8E 50%, #5f7bed 50%, #5f7bed 75%, #3D6F8E 75%, #3D6F8E 100%);
background-size: 56.57px 56.57px;
   text-align: center !important;
    margin-bottom: 10px;
}

</style>
