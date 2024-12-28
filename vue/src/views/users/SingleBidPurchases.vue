<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage" />
    <!-- <div v-if="$store.getters.user.subscription_id==0"  class="stripe-1">"You are not subscribed" </div> -->
    <section class="pt-3">
        <div class="container">
            <div class="row g-2 g-lg-4">
                <ProfileList></ProfileList>
                <div class="col-lg-8 col-xl-9 ps-xl-5">
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 p-5 pt-0 rounded-3" style="margin-bottom: 195px;">
                                <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between align-items-center">
                                    <h6 class="mb-2 mb-sm-0" v-if="payment.length===0">This section includes the purchase details history of single Bids only - NOT APPLICABLE for subscriptions based user</h6>
                                    <h5 v-else class="mb-2 mb-sm-0">Single Bid Purchases</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive border-0">
                                        <table class="table align-middle p-4 mb-0 table-hover table-shrink">
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
                                            <tbody class="border-top-0">
                                                <tr v-if="payment.length===0">
                                                    <td colspan="7" class="text-center">No records found</td>
                                                </tr>
                                                <tr v-for="userpayment in payment" :key="userpayment.payment_id">
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
                                        </table>
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
                invalidDate: "",
            });
            //  this.checklogin();
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
            getPaymentSubscriptions() {
                let vm = this;
                vm.isLoading = true;
                vm.payment.user_id = vm.$store.getters.user.user_id;
                let uri = "getUserPayments";
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.payment })
                    .then(function (response) {
                        vm.payment = response.data.data;
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
</style>
