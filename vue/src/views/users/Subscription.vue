<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage" />
    <!-- <div v-if="$store.getters.user.subscription_id==0" class="stripe-1">"You are not subscribed"</div> -->
    <section class="pt-3" style="padding-bottom: 77px;">
        <div class="container">
            <div class="row g-2 g-lg-4">
                <ProfileList></ProfileList>
                <div class="col-lg-8 col-xl-9 ps-xl-5">
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>
                    <div class="card border-0 p-5 pt-0 bg-transparent" style="margin-bottom: 125px;">
                        <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between align-items-center">
                            <h5 class="card-header-title">Subscription Info</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-bottom-line nav-responsive nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 active" data-bs-toggle="tab" href="#tab-1"><i class="bi bi-briefcase-fill fa-fw me-1"></i>Current Subscription</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0" data-bs-toggle="tab" href="#tab-2"><i class="bi bi-x-octagon fa-fw me-1"></i>Subscription Purchase History</a>
                                </li>
                            </ul>
                            <div class="tab-content p-2 p-sm-4" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="tab-1">
                                    <div class="card border bg-light mb-4">
                                        <div class="card-body">
                                            <div class="row g-3" v-if="!active_subscription">
                                                <span style="text-align: center;">You have no active subscription</span>
                                            </div>
                                            <div class="row" v-else>
                                                <div class="col-md-12">
                                                    <ul class="list-group list-group-borderless mb-0">
                                                        <li class="list-group-item d-flex row">
                                                            <div class="col-md-4 col-sm-4 text-end">
                                                                <span class="h6 fw-bold mb-0">Subscribed Plan :</span>
                                                            </div>
                                                            <div class="col-md-8 col-sm-8">
                                                                <span class="h6 fw-light mb-0" >{{ active_subscription.subscription_plan?.plan }}</span>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item py-0"></li>
                                                        <li class="list-group-item d-flex row">
                                                            <div class="col-md-4 col-sm-4 text-end">
                                                                <span class="h6 fw-bold mb-0">Subscription Status :</span>
                                                            </div>
                                                            <div class="col-md-8 col-sm-8">
                                                                <span class="h6 fw-light mb-0" v-if="active_subscription.active_status=='active'">
                                                                    <span class="activeclass">{{ active_subscription.active_status }}</span> | Expires on : {{ format_date(active_subscription.valid_to) }}
                                                                </span>
                                                                <span class="h6 fw-light mb-0" v-if="active_subscription.active_status=='inactive'">
                                                                    <span class="inactiveclass">{{ active_subscription.active_status }}</span> | Expired on : {{ format_date(active_subscription.valid_to) }}
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item py-0"></li>
                                                        <li class="list-group-item d-flex row">
                                                            <div class="col-md-4 col-sm-4 text-end">
                                                                <span class="h6 fw-bold mb-0">Associated Account :</span>
                                                            </div>
                                                            <div class="col-md-8 col-sm-8">
                                                                <span class="h6 fw-light mb-0">{{ $store.getters.user.name }} | {{ $store.getters.user.email }}</span>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item py-0"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2">
                                    <div class="card border">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card border rounded-3">
                                                    <div class="card-body">
                                                        <div class="table-responsive border-0">
                                                            <table class="table align-middle p-4 mb-0 table-hover table-shrink">
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
                                                                <tbody class="border-top-0">
                                                                    <tr v-if="subscriptions.length===0">
                                                                        <td colspan="7" class="text-center">No records found</td>
                                                                    </tr>
                                                                    <tr v-for="subscription in subscriptions" :key="subscription.id">
                                                                        <td>
                                                                            <h6 v-if="subscription.active_status=='active'" class="mb-0">{{subscription.active_status}}</h6>
                                                                            <span v-else class="mb-0">{{subscription.active_status}}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="mb-0" v-if="subscription.active_status=='active'">{{ subscription.subscription_plan?.plan }}</span>
                                                                            <span class="mb-0" v-else style="color: #747579;">{{ subscription.subscription_plan?.plan }}</span>
                                                                        </td>
                                                                        <td><span v-if="subscription.payment_gross">${{subscription.payment_gross}}</span>
                                                                        <span class="text-center">-</span></td>
                                                                        <td>{{format_date(subscription.valid_from)}}</td>
                                                                        <td>{{format_date(subscription.valid_to)}}</td>
                                                                        <td class="">{{subscription.txn_id}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import Pagination from "@/components/Pagination.vue";
    import moment from "moment";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    import ProfileList from "@/components/ProfileList.vue";
    export default {
        components: { Pagination, Loading, ProfileList },
        name: "saveAlert",
        data() {
            return {
                subscriptions: {
                    user_id: "",
                },

                active_subscription: null,

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
                vm.user = vm.$store.getters.user;
            });
        },
        mounted() {
            this.getActiveSubscription();
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
            getActiveSubscription() {
                let vm = this;
                vm.$store
                    .dispatch("post", {
                        uri: "getActiveSubscription",
                        data: vm.user,
                    })
                    .then(function (response) {
                        vm.active_subscription = response.data.data
                        vm.getUserSubscriptions();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getUserSubscriptions() {
                let vm = this;
                vm.payment.user_id = vm.$store.getters.user.id;
                let uri = "getUserSubscriptions";
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.user })
                    .then(function (response) {
                        vm.subscriptions = response.data.data
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
    .activeclass {
        /* padding: 3px; */
        padding-left: 6px !important;
        padding-right: 6px !important;
        border-radius: 11px !important;
        background-color: #0fb62c !important;
        color: white;
    }
    .inactiveclass {
        padding-left: 6px !important;
        padding-right: 6px !important;
        border-radius: 11px !important;
        background-color: red !important;
        color: white;
    }
</style>
