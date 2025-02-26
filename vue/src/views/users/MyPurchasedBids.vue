<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage" />
    <section class="pt-3" style="background-color: #fafafa;">
        <div class="container">
            <div class="row g-2 g-lg-4">
                <ProfileList></ProfileList>
                <div class="col-lg-8 col-xl-9 ps-xl-5">
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 p-3 pt-0 rounded-3">
                                <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between align-items-center">
                                    <h5 class="mb-2 mb-sm-0 fw-500">My Purchased Bids</h5>
                                </div>
                                <div>
                                    <div v-for="userpayment, key in payment" :key="key">
                                        <div class="col-sm-12 col-xl-12" style="padding: 5px;">
                                            <div class="">
                                                <div class="d-flex align-items-center">
                                                    <div class="" style="padding: 7px;">
                                                        <h6 class="fw-500">Transaction ID : <span style="font-weight: normal;">{{userpayment?.txn_id}}</span></h6>
                                                        <h6 class="fw-500">
                                                            Order ID : <span style="font-weight: normal;">{{userpayment?.order_id}} </span> <span style="font-weight: normal;"> |</span> Dated :
                                                            <span style="font-weight: normal;">{{format_date(userpayment?.payment_date)}}</span>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive border-0">
                                                <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col" class="border-0">Bid No</th>
                                                            <th scope="col" class="border-0">Title</th>
                                                            <th scope="col" class="border-0">Expiry Date</th>
                                                            <th scope="col" class="border-0">Posted Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border-top-0">
                                                        <tr v-for="(purchase_item,key) in userpayment?.purchase_items" :key="key">
                                                            <td v-if="purchase_item.state_tender_id">
                                                                <a class="remunderline" @click="showStateTender(purchase_item.state_tender)" href="javascript:void(0)">
                                                                    <span class=""> <span class="f-12 col-green pe-1 linkcolor">{{purchase_item.state_tender.tender_no}}</span></span>
                                                                </a>
                                                            </td>
                                                            <td v-if="purchase_item.federal_tender_id">
                                                                <a class="remunderline" @click="showFederalTender(purchase_item.federal_tender)" href="javascript:void(0)">
                                                                    <span class=""> <span class="f-12 col-green pe-1 linkcolor">{{purchase_item.federal_tender.tender_no}}</span></span>
                                                                </a>
                                                            </td>
                                                            <td v-if="purchase_item.state_tender_id">{{ purchase_item.state_tender.title }}</td>
                                                            <td v-if="purchase_item.federal_tender_id">{{ purchase_item.federal_tender.title }}</td>
                                                            <td v-if="purchase_item.state_tender_id">{{format_date(purchase_item.state_tender.expiry_date)}}</td>
                                                            <td v-if="purchase_item.federal_tender_id">{{format_date(purchase_item.federal_tender.expiry_date)}}</td>
                                                            <td v-if="purchase_item.state_tender_id"><div>{{format_date(purchase_item.state_tender.posted_date)}}</div></td>
                                                            <td v-if="purchase_item.federal_tender_id"><div>{{format_date(purchase_item.federal_tender.posted_date)}}</div></td>
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
                userbid: {
                    tdr_id: "",
                },
                biddetail: [],
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
            if (this.$store.getters.user) {
                this.getPaymentSubscriptions();
            }
        },
        methods: {
            showStateTender(state_tender) {
                let tender = {
                    title: state_tender.title,
                    tender_no: state_tender.tender_no,
                };
                this.$store.dispatch("setStateTender", tender);
                this.$router.push("/bids/state-opportunities");
            },
            showFederalTender(federal_tender) {
                let tender = {
                    title: federal_tender.title,
                    tender_no: federal_tender.tender_no,
                };
                this.$store.dispatch("setFederalTender", tender);
                this.$router.push("/bids/federal-opportunities");
            },
            bidsdetails(value) {
                this.userbid.tdr_id = value;
                this.getbids();
            },
            getbids() {
                let vm = this;

                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: "getBid", data: vm.userbid })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.biddetail = response.data.data;
                        vm.$store.commit("setBidsDetails", vm.biddetail);
                        let tdr_title = vm.$store.getters.bidsdetails?.tdr_title;
                        let region_id = vm.$store.getters.bidsdetails?.region?.region_id;
                        let tdr_no = vm.$store.getters.bidsdetails.tdr_no;
                        let region_name = "";
                        if (region_id == 2) {
                            region_name = "federal-opportunities";
                        }
                        if (region_id == 1) {
                            region_name = "state-opportunities";
                        }
                        if (region_id == 4) {
                            region_name = "international-opportunities";
                        }
                        if (region_id == 3) {
                            region_name = "private-commercial-opportunities";
                        }
                        vm.$router.push("/bids/" + region_name + "/" + tdr_title + "-" + tdr_no);
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            format_date(value) {
                return moment(String(value)).format("MMMM D, YYYY");
            },
            getPaymentSubscriptions() {
                let vm = this;
                //  vm.isLoading = true;
                vm.payment.user_id = vm.$store.getters.user.user_id;
                vm.$store
                    .dispatch("post", {
                        uri: "getUserPayments",
                        data: vm.payment,
                    })
                    .then(function (response) {
                        vm.payment = response.data.data;
                        // vm.isLoading = false;

                        // vm.userbids.bids = vm.payment.item_number.toString();
                    })
                    .catch(function (error) {
                        // vm.isLoading = false;
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
     .fw-500{
        font-weight: 500;
    }
</style>
