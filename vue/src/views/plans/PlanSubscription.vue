<template>
    <loading v-model:active="isLoading" :can-cancel="false" :on-cancel="onCancel" :is-full-page="fullPage" />
    <section class="pt-4">
        <div class="container" data-sticky-container="">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h6 class="mb-0">Explore All Regions Covered in Single Plan</h6>
                </div>
            </div>

            <div class="row g-4 g-md-5 justify-content-center">
                <!-- Card item START -->
                <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                    <div class="bg-transparent text-center">
                        <!-- Image -->
                        <img src="assets/icons/state.png" class="icon-lg" alt="" />

                        <h6 class=""><a href="#">State & Local</a></h6>
                        <!-- <span>25 min drive</span> -->
                    </div>
                </div>
                <!-- Card item END -->
                <!-- Card item START -->
                <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                    <div class="bg-transparent text-center">
                        <!-- Image -->
                        <img src="assets/icons/federal.png" class="icon-lg" alt="" />

                        <h6 class=""><a href="#">Federal</a></h6>
                    </div>
                </div>
                <!-- Card item END -->

                <!-- Card item START -->
                <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                    <div class="bg-transparent text-center">
                        <img src="assets/icons/private.png" class="icon-lg" alt="" />

                        <h6 class=""><a href="#">Private</a></h6>
                    </div>
                </div>
                <!-- Card item END -->

                <!-- Card item START -->
                <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                    <div class="bg-transparent text-center">
                        <img src="/assets/icons/international.png" class="icon-lg" alt="" />

                        <h6 class=""><a href="#">International</a></h6>
                    </div>
                </div>
                <!-- Card item END -->
            </div>

            <div class="text-center mb-4"><strong>**ALL PLANS INCLUDE UNLIMITED ACCESS TO OUR SERVICES WITHOUT ANY
                    RESTRICTIONS**</strong></div>

            <div class="row g-4">
                <!-- Main content START -->
                <div class="col-xl-8">
                    <div class="vstack gap-2">
                        <div class="card border">
                            <!-- Card header -->
                            <div class="card-header border-bottom p-3 pb-1">
                                <h5 class="card-title mb-0">Subscription Checkout</h5>
                                <small>Select your desired Plan</small>
                            </div>

                            <!-- Card body START -->
                            <div class="card-body">
                                <!-- Table head -->
                                <div class="bg-light rounded p-3 d-none d-sm-block">
                                    <div class="row g-4">
                                        <div class="col" v-for="plan, key in plans" :key="key">
                                            <h6 class="fw-normal mb-0">{{ plan.plan }} Plan</h6>
                                        </div>
                                        <!-- <div class="col-4"><h6 class="fw-normal mb-0">Semi Annual Plan</h6></div> -->
                                        <!-- <div class="col"><h6 class="fw-normal mb-0">Annual Plan</h6></div> -->
                                    </div>
                                </div>
                                <div class="row g-4 align-items-sm-center border-bottom px-2 py-2">
                                    <div class="col" v-for="plan, key in plans" :key="key">
                                        <small class="d-block">${{ plan.price }} (${{ plan.discount }} Saved)</small>
                                        <small class="me-1">{{ plan.plan }}</small>
                                    </div>
                                </div>
                                <div class="row g-4 align-items-sm-center border-bottom1 px-2 py-2">
                                    <div class="col" v-for="plan, key in plans" :key="key">
                                        <a class="btn btn-xs btn-primary-soft mb-0" href="javascript:void(0)"
                                            @click.prevent="updatePlan(plan)">SELECT</a>
                                    </div>
                                </div>

                                <!-- Table data -->
                                <!-- <div class="row g-4 align-items-sm-center border-bottom px-2 py-2"> -->
                                <!-- Data item -->

                                <!-- Data item -->
                                <!-- <div class="col" v-for="plan in plans" :key="plan.id"> -->
                                <!-- <small class="d-block">${{plan.price}} (${{plan.discount}} Saved)</small>  -->
                                <!-- <div class="d-flex"> -->
                                <!-- <small class="me-1">{{plan.plan}}</small> -->
                                <!-- <small class="mb-0 text-primary"> 02 Dec 2022</small> -->
                                <!-- </div> -->
                                <!-- </div> -->


                            </div>

                            <!-- <div class="row  g-4 align-items-sm-center border-bottom px-2 py-2"> -->
                            <!-- <div class="col" v-for="plan in plans" :key="plan.id"> -->
                            <!-- <button class="btn btn-xs btn-primary-soft mb-0" href="javascript:void(0)" @click.prevent="getPlan(plan)">SELECT</button> -->
                            <!-- </div> -->
                            <!-- <div class="col-4">
                                        <a class="btn btn-xs btn-primary-soft mb-0"  href="javascript:void(0)" @click.prevent="plan(plans[1])">SELECT</a>
                                    </div>
                                   <div class="col-4">
                                        <a class="btn btn-xs btn-primary-soft mb-0" href="javascript:void(0)" @click.prevent="plan(plans[2])">SELECT</a>
                                    </div> -->
                            <!-- </div> -->
                            <!-- </div> -->
                        </div>
                        <p class="mb-0">
                            *For subscription plans comparison <span class="text-primary"><u>click here</u></span>
                        </p>
                        <strong>Note:</strong>
                        <p class="mb-1">
                            Customers have the ability to upgrade or downgrade their subscription plan for the services
                            at any time. With regards to downgrades on subscription, BidsPortal does not issue refunds
                            or credits for partial months
                            of service.
                        </p>
                        <p class="mb-0">
                            You can cancel your subscription at any time from your PayPal account. There is no minimum
                            required duration or contract. You are free to cancel your subscription at any time via your
                            PayPal account from Profile
                            Tab -> My Money -> My Preapproved Payments.
                        </p>
                    </div>
                </div>
                <!-- Main content END -->

                <!-- Sidebar START -->
                <aside class="col-xl-4">
                    <div data-sticky="" data-margin-top="80" data-sticky-for="1199">
                        <div class="card bg-light p-4">
                            <!-- Title -->
                            <!-- <h6 class="text-danger fw-normal">Order Summary</h6> -->
                            <div class="card-header bg-light border-bottom p-0 pb-1 text-center">
                                <h5 class="card-title mb-0">Order Summary</h5>
                            </div>

                            <div class="card-body">
                                <!-- List -->
                                <ul class="list-group list-group-borderless mb-0">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="h6 fw-light mb-0">Package:</span>
                                        <span class="h6 fw-light mb-0">{{ user_plan.plan }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="h6 fw-light mb-0">Price:</span>
                                        <span class="h6 fw-light mb-0">${{ user_plan.price }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="h6 fw-light mb-0">Discount :</span>
                                        <span class="h6 fw-light mb-0">${{ user_plan.discount }}</span>
                                    </li>

                                    <li class="list-group-item py-0">
                                        <hr class="my-0" />
                                    </li>
                                    <!-- Divider -->
                                    <li class="list-group-item d-flex justify-content-between pb-0">
                                        <span class="h5 fw-normal mb-0"></span>
                                        <span class="h5 fw-normal mb-0">${{ (user_plan.price - user_plan.discount)
                                            }}</span>
                                    </li>
                                </ul>

                                <div class="d-grid mt-2 gap-2">
                                    <div class="text-center"><label>Total Due</label></div>
                                    <div class="form-check form-check-inline mb-0">
                                        <input class="form-check-input" v-model="user_plan.agree" type="checkbox" />
                                        <small class="form-check-label mb-0">I agree with <router-link
                                                to="/terms&condition">Terms and conditions</router-link></small>
                                    </div>

                                    <!-- Button -->
                                    <!-- <a href="cab-booking.html" class="btn btn-dark mb-0 mt-2">Pay Now</a> -->
                                    <div class="text-center">
                                        <button class="btn btn-xs btn-primary mb-0"
                                            @click="subcribePlan()">Subscribe</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
                <!-- Sidebar END -->
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            checked: false,
            plans: [],
            user_plan: {
                subscription_plan_id: '',
                loggedInUserID: "",
                paypalURL: "https://www.sandbox.paypal.com/cgi-bin/webscr",
                successURL: "https://hexaqore.com/bids/public/api/paypal_success_common_func",
                cancelURL: "https://www.bidsportal.com/paypal_sandbox/subscriptionCancelpage_func",
                notifyURL: "https://hexaqore.com/bids/public/api/paypal_ipn_common_func",
                currency_code: "USD",
                paypalID: "nazim.merchant@yahoo.com",
                cmd: "_xclick-subscriptions",
                a3: "",
                p3: "",
                item_name: "Member Subscriptions",
                item_number: "MS",
                t3: "M",
                custom: "",
                id: "",
                plan: "",
                price: "",
                days: "",
                month: "",
                month_desc: "",
                discount: "",
                agree: false
            },
            plansuser: {
                id: "",
                plan: "",
                price: "",
                days: "",
                month: "",
                month_desc: "",
                discount: "",
                loggedInUserID: "",
            },
            meta: {
                search: "",
                order_by: "asc",
                field: "equipment_name",
                per_page: 10,
                totalRows: 0,
                currentPage: 1,
                lastPage: 1,
                from: 1,
                maxPage: 1,
            },

        };
    },

    beforeRouteEnter(to, from, next) {
        next((vm) => {
            let user_plan = vm.$store.getters.user_plan
            console.log('before', user_plan)
            vm.user_plan.subscription_plan_id = user_plan.subscription_plan_id
            vm.user_plan.plan = user_plan.plan
            vm.user_plan.price = user_plan.price
            vm.user_plan.discount = user_plan.discount
            // if (to.name == "") {
            //  vm.$refs.tax_name.focus();
            // } else {
            // vm.savealert.id = to.params.id;
            // vm.savealert.user_id = localStorage.getItem("id");
            // vm.user_plan.id = to.params.id;
            // vm.$store
            //     .dispatch("post", { uri: "getSubscriptionPlan", data: vm.user_plan })
            //     .then(function (response) {
            //         vm.user_plan = response.data;
            //     })
            //     .catch(function (error) {
            //         vm.errors = error.response.data.errors;
            //         vm.$store.dispatch("error", error.response.data.message);
            //     });
            // }
        });
    },

    computed: {
        total: function () {

            return this.rows.reduce(function (total, user_plan) {
                return (total = user_plan.price - user_plan.discount);
            }, 0);
        },
    },
    mounted() {
        window.scrollTo(0, 0)
        this.index()
        console.log(this.$store.getters.user_plan)
        // this.checklogin();
        // this.user_plan.item_number = this.user_plan.item_number + localStorage.getItem("id");
        // this.user_plan.loggedInUserID = localStorage.getItem("id");
    },
    methods: {
        checklogin() {
            let vm = this;
            if (vm.$store.getters.user == null) {
                vm.$router.push("/bids/state-opportunities");
            }

        },

        updatePlan(subscription) {
            this.user_plan.subscription_plan_id = subscription.subscription_plan_id
            this.user_plan.plan = subscription.plan
            this.user_plan.price = subscription.price
            this.user_plan.discount = subscription.discount
        },

        subcribePlan() {
            let vm = this
            if (this.user_plan.agree) {
                if (this.user_plan.plan == 'Trial') {
                    if (vm.$store.getters.user) {
                        vm.isLoading = true
                        let uri = "getSubscriptionPlans"
                        vm.$store
                            .dispatch("post", { uri: 'addTrialSubscription', data: vm.$store.getters.user })
                            .then(function (response) {
                                vm.isLoading = false
                                vm.$store.dispatch("success", "Trial Subscription Successfully Activated")
                                vm.$router.push('user/subscription')
                            })
                            .catch(function (error) {
                                vm.isLoading = false
                                vm.errors = error.response.data.errors;
                                vm.$store.dispatch("error", error.response.data.message);
                            });
                    }
                } else {
                    let loggedInUserID = this.$store?.getters?.user?.user_id
                    let itemName = this.user_plan.plan
                    let itemNumber = this.user_plan.subscription_plan_id
                    let paypalAmt = this.user_plan.price - this.user_plan.discount
                    let paypalValid = 1
                    let params = '?loggedInUserID=' + loggedInUserID + '&itemName=' + itemName + '&itemNumber=' + itemNumber + '&paypalAmt=' + paypalAmt + '&paypalValid=' + paypalValid
                    if (paypalAmt > 0) {
                        window.open(this.$store.getters.baseUrl + 'callPaypalSubscripton' + params, "_self")
                    } else {
                        this.$store.dispatch("error", "Amount cannot be less than 0")
                    }
                }
            } else {
                this.$store.dispatch("error", "Agree Terms and Condition")
            }
        },

        index() {
            let vm = this
            let uri = "getSubscriptionPlans"
            vm.$store
                .dispatch("post", { uri: uri })
                .then(function (response) {
                    vm.plans = response.data
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        // index() {
        //     let vm = this;
        //     let uri = "getPricingPlan?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;

        //     vm.$store
        //         .dispatch("post", { uri: uri })
        //         .then(function (response) {
        //             for (let j=0; j< response.data.data.length; j++) {
        //                 console.log("j",response.data.data[j]);
        //                 if(response.data.data[j]["plan"]!='Monthly'){
        //                     vm.plans.push(response.data.data[j]);
        //                 }
        //             }
        //             console.log('plans', vm.plans)
        //             vm.meta.totalRows = response.data.meta.total;
        //             vm.meta.lastPage = response.data.meta.last_page;
        //             vm.meta.from = response.data.meta.from;
        //             vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;

        //         })
        //         .catch(function (error) {
        //             vm.errors = error.response.data.errors;
        //             vm.$store.dispatch("error", error.response.data.message);
        //         });
        // },
        getPlan(plan) {
            let vm = this;
            vm.user_plan = plan
        },
        plan1(plans) {
            let vm = this;
            // this.user_plan.id=plans[0];
            vm.user_plan.id = plans.id;
            vm.user_plan.plan = plans.plan;
            vm.user_plan.price = plans.price;
            vm.user_plan.days = plans.days;
            vm.user_plan.month = plans.month;
            vm.user_plan.month_desc = plans.month_desc;
            vm.user_plan.discount = plans.discount;
            vm.user_plan.a3 = plans.price - plans.discount;
            vm.user_plan.p3 = plans.month;
            vm.user_plan.custom = vm.user_plan.loggedInUserID;

            // v.firstName.concat(v.lastName);

            // vm.user_plan.item_number.concat(vm.user_plan.loggedInUserID)
            // vm.user_plan.item_number=vm.user_plan.item_number  +'.' +  localStorage.getItem('id');
        },

        edit(user_plan) {
            this.$router.push("/Subscription_plan/" + user_plan.id);
        },
        priceActive() {

        }

    },
};
</script>