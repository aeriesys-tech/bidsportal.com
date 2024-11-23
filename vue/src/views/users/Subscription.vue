<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001"  :is-full-page="fullPage" />
    <!-- <div v-if="$store.getters.user.subscription_id==0" class="stripe-1">"You are not subscribed"</div> -->
    <section class="pt-3" style="padding-bottom:77px">
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
                                <div class="card-body p-3">
                                    <!-- Avatar and content -->
                                    <div class="text-center">
                                        <div class="text-center">
                                            <h1 class="avatar avatar-xl rounded-circle border border-white border-3 shadow">{{$store.getters.user.name.substring(0,1)}}</h1>
                                        </div>
                                        <h6 class="mb-0">{{$store.getters.user.name}}</h6>
                                        <a href="javascript:void(0)" class="text-reset text-primary-hover small">{{$store.getters.user.email}}</a>
                                        <hr />
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
                                            <router-link class="nav-link active" to="/user/subscription"><i class="bi bi-ticket-perforated fa-fw me-2"></i>Subscription Info</router-link>
                                        </li>
                                        <li class="nav-item" v-if="payment.length !==0">
                                            <router-link class="nav-link" to="/user/single-bidpurchases"><i class="bi bi-people fa-fw me-2"></i>Single Bid Purchases</router-link>
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

                <div class="col-lg-8 col-xl-9 ps-xl-5">
                    <!-- Offcanvas menu button -->
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>

                    <div class="card border bg-transparent" style="margin-bottom:125px;">
                        <!-- Card header -->
                        <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between align-items-center">
                            <h5 class="card-header-title">Subscription Info</h5>
                               <router-link to="/bids/state-opportunities" type="button" class="mb-0 btn btn-sm btn-primary">
                                        Back To Bids
                                    </router-link>
                        </div>

                        <!-- Card body START -->
                        <div class="card-body p-0">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs nav-bottom-line nav-responsive nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 active" data-bs-toggle="tab" href="#tab-1"><i class="bi bi-briefcase-fill fa-fw me-1"></i>Current Subscription</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0" data-bs-toggle="tab" href="#tab-2"><i class="bi bi-x-octagon fa-fw me-1"></i>Subscription Purchase History</a>
                                </li>
                            </ul>

                            <!-- Tabs content START -->
                            <div class="tab-content p-2 p-sm-4" id="nav-tabContent">
                                <!-- Tab content item START -->
                                <div class="tab-pane fade show active" id="tab-1">
                                    <div class="card border bg-light mb-4">
                                        <div class="card-body">
                                            <div class="row g-3" v-if="!$store.getters.user.subscription_id">
                                                <span style="text-align: center;">You have no active subscription</span>
                                            </div>

                                           
                                                <div class="row"  v-else>
                                                  <div class="col-md-9">
                                                        <ul class="list-group list-group-borderless mb-0">
                                                            <li class="list-group-item d-flex row">
                                                                <div class="col-md-4 col-sm-4">
                                                                <span class="h6 fw-bold mb-0 ">Subscribed Plan :</span>
                                                                </div>
                                                                 <div class="col-md-8 col-sm-8">
                                                                <!-- <span class="h6 fw-light mb-0">$260</span> -->
                                                                <span class="h6 fw-light mb-0" v-if="user?.sub_details?.validity ==12">Yearly Subscription</span>
                                                                <span class="h6 fw-light mb-0" v-if="user?.sub_details?.validity ==6">6 Month Subscription</span>
                                                                <span class="h6 fw-light mb-0" v-if="user?.sub_details?.validity ==1">Monthly Subscription</span>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item py-0"></li>
                                                            <li class="list-group-item d-flex row">
                                                                 <div class="col-md-4 col-sm-4">
                                                                <span class="h6 fw-bold mb-0">Subscription Status :</span>
                                                                </div>
                                                                <div class="col-md-8 col-sm-8">
                                                                <!-- <span class="h6 fw-light mb-0">
                                                                    <span :class="user.sub_details?.active_status?'activeclass':'text-danger alert'">{{ user.sub_details?.active_status }}</span> | Expires on : {{
                                                                    format_date(user.sub_details?.valid_to) }}
                                                                </span> -->

                                                                <!-- try  -->
                                                                <span class="h6 fw-light mb-0" v-if="user.sub_details?.active_status=='active'">
                                                                    <span class="activeclass">{{ user.sub_details?.active_status }}</span> | Expires on : {{
                                                                    format_date(user.sub_details?.valid_to) }}
                                                                </span>
                                                                <span class="h6 fw-light mb-0" v-if="user.sub_details?.active_status=='inactive'">
                                                                    <span class="inactiveclass" >{{ user.sub_details?.active_status }}</span> | Expired on : {{
                                                                    format_date(user.sub_details?.valid_to) }}
                                                                </span>


                                                                <!--  -->

                                                                <!-- ends -->
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item py-0"></li>
                                                            <li class="list-group-item d-flex row">
                                                                 <div class="col-md-4 col-sm-4">
                                                                <span class="h6 fw-bold mb-0">Associated Account :</span>
                                                                 </div>
                                                                  <div class="col-md-8 col-sm-8">
                                                                <span class="h6 fw-light mb-0">{{ $store.getters.user.name }} | {{ $store.getters.user.email }}</span>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item py-0"></li>

                                                            <!-- Divider -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2">
                                    <!-- <h6>Subscription Purchase History</h6> -->

                                    <!-- Card item START -->
                                    <div class="card border">
                                        <!-- Card header -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card border rounded-3">
                                                    <!-- Card body START -->
                                                    <div class="card-body">
                                                        <div class="table-responsive border-0">
                                                            <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                                                <!-- Table head -->
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th scope="col" class="border-0">Status</th>
                                                                        <th scope="col" class="border-0">Subscription Type</th>
                                                                        <th scope="col" class="border-0">Price</th>
                                                                        <th scope="col" class="border-0">Purchase Date</th>
                                                                        <th scope="col" class="border-0">End Date</th>
                                                                        <th scope="col" class="border-0 rounded-end">Invoice ID</th>
                                                                    </tr>
                                                                </thead>

                                                                <!-- Table body START -->
                                                                <tbody class="border-top-0">
                                                                    <!-- Table item -->
                                                                    <tr v-if="subscriptions.length===0">
                                                                        <td colspan="7" class="text-center">No records found</td>
                                                                    </tr>
                                                                    <tr v-for="subscription in subscriptions" :key="subscription.id">
                                                                        <td>
                                                                            <h6 v-if="subscription.active_status=='active'" class="mb-0">{{subscription.active_status}}</h6>
                                                                            <span v-else class="mb-0">{{subscription.active_status}}</span>
                                                                        </td>
                                                                        <td>
                                                                            <h6 class="mb-0" v-if="subscription.active_status=='active'">
                                                                                <a href="javascript:void(0)">
                                                                                    <span v-if="subscription.validity == 12">Annual</span>
                                                                                    <span v-if="subscription.validity == 6">6 Months</span>
                                                                                    <span v-if="subscription.validity==1">1 Months</span>
                                                                                </a>
                                                                            </h6>
                                                                            <span class="mb-0" v-else>
                                                                                <a href="javascript:void(0)" style="color:#747579;">
                                                                                    <span v-if="subscription.validity == 12">Annual</span>
                                                                                    <span v-if="subscription.validity == 6">6 Months</span>
                                                                                    <span v-if="subscription.validity==1">1 Months</span>
                                                                                </a>
                                                                            </span>
                                                                        </td>
                                                                        <td>${{subscription.payment_gross}}</td>
                                                                        <td>{{format_date(subscription.valid_from)}}</td>
                                                                        <td>{{format_date(subscription.valid_to)}}</td>
                                                                        <td class="">{{subscription.txn_id}}</td>
                                                                    </tr>
                                                                </tbody>
                                                                <!-- Table body END -->
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="card-footer pt-0">
                                                      
                                                        <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                                                          

                                                            <p class="mb-sm-0 text-center text-sm-start">
                                                                <select class="form-select js-choice formpage flex align-items-sm-center" aria-label="Default select example" v-model="meta.per_page" @change="onPerPageChange">
                                                                    <option>10</option>
                                                                    <option>20</option>
                                                                    <option>30</option>
                                                                </select>
                                                                Showing 1 to 8 of 20 entries
                                                            </p>
                                                         
                                                            <nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
                                                                <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                                                            </nav>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card item END -->
                                </div>
                            </div>
                        </div>
                        <!-- Card body END -->
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
        components: { Pagination, Loading },
        name: "saveAlert",
        data() {
            return {
               
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
                isLoading: false,
                fullPage: true,
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.isLoading = true;

                vm.user.id = vm.$store.getters.user.id;
                vm.$store
                    .dispatch("post", { uri: "showUser", data: vm.user })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.user = response.data.data;
                                             
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            });
        },
        mounted() {
            this.getUserSubscriptions();
            // this.checklogin();
        },
        methods: {
            checklogin() {
                let vm = this;
                if (vm.$store.getters.user == null) {
                    vm.$router.push("/bids/state-opportunities");
                }
            },
            format_date(value) {
                return moment(String(value)).format("MMMM D, YYYY");
            },
            getUserSubscriptions() {
                let vm = this;
                vm.subscriptions.user_id = vm.$store.getters.user.id;
                vm.$store
                    .dispatch("post", { uri: "getUserSubscriptions", data: vm.subscriptions })
                    .then(function (response) {
                        vm.subscriptions = response.data.data;
                        vm.getPaymentSubscriptions();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getPaymentSubscriptions() {
                let vm = this;
                vm.payment.user_id = vm.$store.getters.user.id;
                let uri = "getUserPayments";
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.payment })
                    .then(function (response) {
                        vm.payment = response.data;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            format_date(value) {
                return moment(String(value)).format("MMMM D, YYYY");
            },
        },
    };
</script>
<style scoped>
    .stripe-1 {
        color: white !important;

        background-image: linear-gradient(45deg, #5f7bed 25%, #3d6f8e 25%, #3d6f8e 50%, #5f7bed 50%, #5f7bed 75%, #3d6f8e 75%, #3d6f8e 100%);
        background-size: 56.57px 56.57px;
        text-align: center !important;
        margin-bottom: 10px;
    }
    .activeclass{
            /* padding: 3px; */
    padding-left: 6px !important;
    padding-right: 6px !important;
    border-radius: 11px !important;
    background-color: #0fb62c !important;
    color: white;
    }
    .inactiveclass{
        padding-left: 6px !important;
    padding-right: 6px !important;
    border-radius: 11px !important;
    background-color: red !important;
    color: white;
    }
</style>
