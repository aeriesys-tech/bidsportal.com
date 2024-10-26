<template>
    <div class="bg-body rounded p-3 mt-3">
        <ul class="list-inline hstack flex-wrap gap-2 mb-0" style="justify-content: center;">
            <li class="list-inline-item h6 fw-normal mb-0"><span>Transaction ID : {{payment?.txn_id}} |</span></li>
            <li class="list-inline-item h6 fw-normal mb-0"><span>Order ID : {{payment?.order_id}} | </span></li>
            <li class="list-inline-item h6 fw-normal mb-0"><span>Date : {{format_date (payment?.payment_date)}} </span></li>
        </ul>
    </div>
    <section class="pt-0">
        <div class="container-fluid vstack gap-4">
            <!-- Title START -->

            <!-- Title END -->

            <!-- Counter START -->
            <div class="row g-3">
                <!-- Counter item -->
                <div class="col-sm-6 col-xl-5">
                    <div class="">
                        <div class="d-flex align-items-center">
                            <div class="mb-4 d-sm-flex border p-3 rounded">
                                <!-- Title and content -->
                                <h2 class="fs-1 mb-0 me-3"><img class="" src="assets/images/CheckIcon.png" width="80" height="35" /></h2>
                                <div>
                                    <h5 class="mb-1">Thank you for your order, {{payment.first_name}}</h5>
                                    <p class="mb-1 small">We have sent a copy of bid documents and payment receipt to your registered email address.</p>
                                    <!-- Button -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Counter item -->
                <div class="col-sm-6 col-xl-5">
                    <div class="">
                        <div class="d-flex align-items-center">
                            <div class="mb-4 d-sm-flex border p-3 rounded">
                                <!-- Title and content -->
                                <h2 class="fs-1 mb-0 me-3"><img class="" src="assets/images/pin.png" width="80" height="35" /></h2>
                                <div>
                                    <h5 class="mb-1">Current Order Pinned to Account!</h5>
                                    <p class="mb-1 small">We have added the current purchase to your account. Easily access by navigating to Profile Settings > My Downloads.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Counter item -->
                <div class="col-sm-4 col-xl-2">
                    <div class="">
                        <div class="d-flex align-items-center">
                            <div class="mb-4 d-sm-flex border p-3 rounded">
                                <!-- Title and content -->
                                <a :href="getUrl()" target="_blank"><h2 class="fs-1 mb-0 me-3"><img class="" src="assets/images/print.png" width="70" height="35" /></h2></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Counter END -->

            <!-- Graph START -->
            <div class="row g-4">
                <!-- Booking Chart START -->
                <div class="col-lg-7 col-xl-8">
                    <!-- Chart START -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border rounded-3">
                                <!-- Card header START -->
                                <div class="card-header border-bottom">
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <h5 class="mb-2 mb-sm-0"><img src="assets/images/CartIcon.png" class="imgcol img_top_mar" height="24" width="24" />Your Ordered Items</h5>
                                    </div>
                                </div>
                                <!-- Card header END -->

                                <!-- Card body START -->
                                <div class="card-body">
                                    <!-- Search and select END -->

                                    <!-- Hotel room list START -->
                                    <div class="table-responsive border-0">
                                        <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                            <!-- Table head -->
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col" class="border-0">RFP/SOL Number</th>
                                                    <th scope="col" class="border-0">Opportunity Title</th>
                                                    <th scope="col" class="border-0"></th>
                                                    <th scope="col" class="border-0"></th>
                                                    <th scope="col" class="border-0">Summary</th>
                                                </tr>
                                            </thead>
                                            <tbody class="border-top-0">
                                                <!-- Table item -->
                                                <tr v-if="normalPayment.length==0">
                                                    <td colspan="8" class="text-center">No records found</td>
                                                </tr>
                                                <tr v-for="normal in normalPayment" :key="normal.tdr_id">
                                                    <td>
                                                        {{normal.tdr_id}}
                                                    </td>

                                                    <td>{{normal.tdr_title}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align: center;">${{normal.tdr_doc_fees}}</td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr class="back-bid-bor hover1">
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text_right_td fftrr">Incl Tax</td>
                                                    <td class="text_right_td text-center">=</td>

                                                    <td class="text_center_td text-center">${{total_amount}}</td>
                                                </tr>
                                                <tr class="hover1">
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text_right_td fftrr">Total Paid</td>
                                                    <td class="text_right_td text-center">=</td>

                                                    <td class="text_center_td text-center">${{total_amount}}</td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td style="border-style: none;" class="back-bid"><router-link to="/bids" class="btn btn-primary"> Back to Bid Search</router-link></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Card footer END -->
                            </div>
                        </div>
                    </div>
                    <!-- Chart END -->
                </div>
                <!-- Booking Chart END -->

                <!-- Booking graph START -->
                <div class="col-lg-4">
                    <div class="card border">
                        <div class="row g-4">
                            <div class="col-md-6 col-xl-12">
                                <div class="card card-body bg-light p-4">
                                    <!-- Title -->

                                    <ul class="list-group list-group-borderless" style="border-top: none;">
                                        <!-- Divider -->
                                        <li class="list-group-item py-1">
                                            <span class="fw-light me-1 mb-0">Need Help with Order Contact :</span>
                                        </li>

                                        <li class="list-group-item py-1">
                                            <span href="#" class="mb-0">
                                                <i class="fa-solid fa-fw fa-star text-warning fs-6"></i>
                                                ffff
                                            </span>
                                        </li>
                                        <li class="list-group-item py-1">
                                            <span class="mb-0 fs-6">
                                                <!-- <i class="fa-solid fa-fw fa-envelope text-warning fs-6" ></i> -->
                                                +1 913-232-2255
                                            </span>
                                        </li>

                                        <li class="list-group-item py-1">
                                            <span href="#" class="mb-0">
                                                <i class="fa-solid fa-fw fa-envelope text-warning fs-6"></i>
                                                Account Support
                                            </span>
                                        </li>
                                        <li class="list-group-item py-1">
                                            <span class="mb-0 fs-6">
                                                <!-- <i class="fa-solid fa-fw fa-envelope text-warning fs-6" ></i> -->
                                                support@bidsportal.com
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Book now item START -->

                            <!-- Book now item END -->
                        </div>
                    </div>
                </div>
                <!-- Booking graph END -->
            </div>
        </div>
    </section>
</template>

<script>
    import moment from "moment";
    export default {
        data() {
            return {
                payment: {
                    txn_id: "",
                    order_id: "",
                    payment_date: "",
                    total_amount: "",
                },
                normalPayment: [],

                item_code: {
                    bids: [],
                },
                total_amount: "",
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.payment.txn_id = to.params.txn_id;
                vm.payment.order_id = to.params.order_id;
                vm.payment.payment_date = to.params.payment_date;
                vm.payment.first_name = to.params.first_name;
                vm.payment.payment_amount = to.params.payment_amount;
                vm.total_amount = to.params.payment_amount;
                vm.item_code.bids = to.params.item_code.split(",");
                vm.$store.commit("setPage", "normal-payment");
                vm.$store.commit("setCartProducts", []);
                vm.getbids();
            });
        },

        methods: {
            getUrl(){
            let url = this.$store.getters.baseUrl+'api/generateBidsPdf/'+this.$store.getters.user.id+'/'+this.item_code.bids
                return url
            },
            getbids() {
                let vm = this;
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: "getBids", data: vm.item_code })
                    .then(function (response) {
                        vm.normalPayment = response.data.data;
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
        },
    };
</script>
