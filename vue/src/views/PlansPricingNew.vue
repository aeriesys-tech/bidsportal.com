<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage" />
    <section class="pt-4 pt-md-5 pb-0" id="plans_pricing">
        <div class="container fs-18">
            <div class="position-absolute top-0 start-0 z-index-9" style="margin-top: 3rem;">
                <img src="assets/images/bids_pricing2.png" class="position-relative" alt="" />
            </div>

            <div class="d-flex justify-content-end align-items-center text-start me-0 me-sm-4 mb-5">
                <i class="bi bi-person-workspace icon-lg fa-fw text-dark me-1"></i>
                <div>
                    <p class="mb-0">Contact us more informations</p>
                    <span class="h6">Support@bidsportal.com</span>
                </div>
            </div>
            <div class="mx-auto text-center">
                <h4 class="mb-2">Choose your plan</h4>
                <p class="mb-0 text-dark">We believe pricing should be straightforward, fair and affordable for all businesses.</p>
            </div>
            <div class="row justify-content-center my-5">
                <div class="col-md-5 col-lg-5" v-for="plan in plans" :key="plan.id">
                    <div v-if="plan.plan!='Semi-Annual'" class="card bg-light">
                        <div class="card-header bg-light text-center pb-0">
                            <h5 class="mb-0 text-success text-center">Yearly Subscription</h5>
                        </div>
                        <div class="card-body p-4">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between align-items-center p-4 pt-0">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h6 class="fw-bold mb-3 me-1">${{plan.price}}/Year</h6>
                                </div>
                                <a href="#" class="badge bg-purple mb-2" :disabled="$store.getters.user?.subscription_id !==0" @click.prevent="getplan(plan.id)">SUBSCRIBE NOW</a>
                            </div>
                            <div v-if="plan.plan!='Semi-Annual'" class="position-absolute top-100 start-100 z-index-9" style="margin-left: -8rem; margin-top: -6rem;">
                                <img src="assets/images/price.svg" class="position-relative" alt="" />
                                <span class="h2 text-white position-absolute top-65 start-50 translate-middle" style="-webkit-text-stroke: 1px #279b61; display: flex;">
                                    <span>{{discount1 }}</span>
                                    <h6 class="text-white" style="-webkit-text-stroke: 0.5px #279b61; display: grid;">
                                        <span class="" style="margin-top: 10px;"> %</span>
                                        <span>OFF</span>
                                    </h6>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="card">
                        <div class="card-header text-center pb-0">
                            <h5 class="mb-0 text-success text-center">{{plan.plan}} Subscription</h5>
                        </div>
                        <div class="card-body p-4">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center p-4 pt-0">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h6 class="fw-bold mb-3 me-1">${{plan.price}}/{{plan.plan}}</h6>
                                </div>
                                <a href="#" class="badge bg-purple mb-2" :disabled="$store.getters.user?.subscription_id !==0" @click.prevent="getplan(plan.id)">SUBSCRIBE NOW</a>
                            </div>
                            <div v-if="plan.plan!='Semi-Annual'" class="position-absolute top-100 start-100 z-index-9" style="margin-left: -8rem; margin-top: -6rem;">
                                <img src="assets/images/price.svg" class="position-relative" alt="" />
                                <span class="h2 text-white position-absolute top-65 start-50 translate-middle" style="-webkit-text-stroke: 1px #279b61; display: flex;">
                                    <span>15</span>
                                    <h6 class="text-white" style="-webkit-text-stroke: 0.5px #279b61; display: grid;">
                                        <span class="" style="margin-top: 10px;"> %</span>
                                        <span>OFF</span>
                                    </h6>
                                </span>
                            </div>
                        </div>
                    </div>
                    <p v-if="plan.plan!='Semi-Annual'" class="text-end text-secondary">Save {{discount1}}% by paying yearly</p>
                </div>

                <!-- <div class="col-md-4 col-lg-4">
                    <div class="card bg-light" >
                        <div class="card-header text-center pb-0 bg-light">
                            <h6 class="mb-0 text-success text-center">Yearly Subscription</h6>
                        </div>
                        <div class="card-body p-4">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center p-4 pt-0 bg-light">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h6 class="fw-bold mb-3 me-1">$550/year</h6>
                                </div>
                                <a href="#" class="badge bg-purple mb-2">SUBSCRIBE NOW</a>
                            </div>
                            <div class="position-absolute top-100 start-100 z-index-9" style="margin-left: -8rem; margin-top: -6rem;">
                                <img src="assets/images/price.svg" class="position-relative" alt="" />
                                <span class="h2 text-white position-absolute top-65 start-50 translate-middle " style="-webkit-text-stroke: 1px #279b61; display: flex;">
                                    <span>15</span>
                                    <h6 class="text-white " style="-webkit-text-stroke: 0.5px #279b61; display: grid;">
                                        <span class="" style="margin-top: 10px;"> %</span>
                                        <span>OFF</span>
                                    </h6>
                                </span>
                            </div>
                        </div>
                        
                    </div>
                    <p class="text-end text-secondary">Save 15% by paying yearly</p>
                </div>  -->
            </div>
            <div class="row g-4 justify-content-center my-5">
                <div class="col-12">
                    <div class="position-absolute top-34 start-100 z-index-9" style="margin-left: -8rem; margin-top: -6rem;">
                        <img src="assets/images/pricing2.svg" class="position-relative" alt="" />
                    </div>
                </div>
            </div>
            <div class="border-bottom mb-5">
                <div class="mx-auto text-center mb-5">
                    <h4 class="mb-4">All Plan Include:</h4>
                </div>
                <div class="mb-5">
                    <ul class="list-group list-group-borderless mb-0">
                        <div class="d-flex justify-content-space-around">
                            <div class="">
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Overall Access to BidsPortal
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Federal,State & Local Bids
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    International Bids
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Commerical & Private Sector Bids
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Interested Vendors List
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    All States and Territories Covered
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Links to Bids Posting Website
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Save Searches for Instant Access
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Modify Email Alerts and More
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Get Bid Docs for All Matches in Email
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Customizable Bids View(List & Tabular)
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    LiveChat Support
                                </li>
                            </div>
                            <div class="border-right"></div>
                            <div class="">
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Access to Bid Documents
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Customizable Bids Alerts
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Daily Email Notifications
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Share Bids via Email
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Advance Search Filters <sup>©</sup>
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Search Bid Documents Only Filters <sup>©</sup>
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Save your Search as Email Alert
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Run Save Search with One-Click
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Run "Saved Email Alert" as Instant Search
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Instant Download Bids Docs from Email Link
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Select and Share Bids with Team via Email
                                </li>
                                <li class="list-group-item d-flex mb-2">
                                    <div class="icon-sm bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle me-2"><i class="fa fa-check"></i></div>
                                    Email & Phone Support
                                </li>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="row g-4">
                <h6>Find a better way to connect with Buyers through BidsPortal service</h6>
                <p class="mt-0">Delivering optimal opportunities instantly with a single click in real-time.</p>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-xl bg-info bg-opacity-10 text-info rounded-circle mb-4">
                            <img src="../assets/icons/SubscribeIcon.png" class="card-img fs-3" alt="" />
                        </div>
                        <!-- Title -->
                        <p>Subscribe to BidsPortal and gain access to thousands of Federal, State, Local, Private and International sector opportunities. Simply select the opportunity that interest you and bid.</p>
                    </div>
                </div>
                <!-- Contact item END -->

                <!-- Contact item START -->
                <div class="col-md-6 col-xl-3">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-xl bg-danger bg-opacity-10 text-danger rounded-circle mb-4">
                            <img src="../assets/icons/NotificationIcon.png" class="card-img fs-3" alt="" />
                        </div>
                        <!-- Title -->
                        <p>Daily email notifications of bids matching your business requirements; Our unique algorithm sorts Bids using keywords, categories / NAICS for specific Alerts set-in your profile.</p>
                    </div>
                </div>
                <!-- Contact item END -->
                <div class="col-md-6 col-xl-3">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-xl bg-orange bg-opacity-10 text-orange rounded-circle mb-4">
                            <img src="../assets/icons/SearchIcon.png" class="card-img fs-3" alt="" />
                        </div>
                        <!-- Title -->
                        <p>Search all active and expired bids / documents; you can search through bid number, keyword, Region, Category, NAICS Codes, date range, set-aside etc.</p>
                    </div>
                </div>

                <!-- Contact item START -->
                <div class="col-md-6 col-xl-3 position-relative">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-xl bg-danger bg-opacity-10 text-danger rounded-circle mb-4">
                            <img src="../assets/icons/OutlineIcon.png" class="card-img fs-3" alt="" />
                        </div>
                        <!-- Title -->
                        <p>Unlimited access to all the bids posted under different Regions, categories and NAICS Codes and lets you setup unlimited Alert Profiles for email notifications powered by BidsPortal.</p>
                    </div>
                </div>
                <!-- Contact item END -->
                <div class="text-center text-dark p-5">
                    <strong>Need a custom plan? <router-link class="text-info" to="/contact_us">Contact our team</router-link> for more details</strong>
                </div>
            </div>
        </div>
    </section>
    <teleport to="#modals" :disabled="!modal2" v-if="modal2">
        <div class="modal-overlay">
            <div class="" ref="register">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- <img src="@/assets/logo.png" class="imgcol" style="width: 50px; height: 50px;" /> -->

                            <h5 class="modal-title">Login Required</h5>
                            <button type="button" class="btn-close" @click.prevent="closemodal()" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body mbodyaccess">
                            <div class="p-sm-2">
                                <p class="mb-0">New here?<a href="sign-up.html"> Already a Subscriber ?</a></p>
                                <div class="bg-success bg-opacity-10 text-success fw-light rounded-2 p-2" role="alert" v-if="activeStatus">
                                    You account has been Activated Login here
                                </div>
                                <!-- Form START -->
                                <form class="mt-3 text-start">
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label">Enter email id</label>
                                        <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="user.email" ref="email" />
                                        <span v-if="errors.email" class="invalid-feedback">{{errors.email[0]}}</span>
                                    </div>
                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label class="form-label"> Enter password</label>
                                        <div class="input-group">
                                            <input class="form-control fakepassword" placeholder="Enter password" :type="type" id="psw-input" :class="{'is-invalid': errors.password}" ref="password" v-model="user.password" />

                                            <span :class="{'errorclass':errors.password}" class="input-group-text p-0 bg-transparent" @click.prevent="toggle">
                                                <i class="fakepasswordicon fa fa-eye p-2" v-if="icon"></i>
                                                <i class="fakepasswordicon fa fa-eye-slash p-2" v-else></i>
                                            </span>
                                        </div>
                                        <span v-if="errors.password" style="color: #dc3545; font-size: 0.875em;">{{ errors.password[0] }}</span>
                                        <!-- <span v-if="errors.password" style="color:#dc3545">{{ errors.password[0] }}</span> -->
                                    </div>

                                    <!-- Remember me -->
                                    <div class="mb-3 d-sm-flex justify-content-between">
                                        <div>
                                            <input type="checkbox" class="form-check-input me-2" id="rememberCheck" />
                                            <label class="form-check-label" for="rememberCheck">Remember me?</label>
                                        </div>
                                        <router-link to="/forgot_password">Forgot password?</router-link>
                                    </div>
                                    <!-- Button -->
                                    <div><button type="submit" class="btn btn-primary w-100 mb-0" @click.prevent="login">Login</button></div>

                                    <!-- Divider -->
                                </form>
                                <!-- Form END -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </teleport>

    <!-- test modal -->
</template>
<script>
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    // import Login from "@/components/Login.vue";
    export default {
        components: { Loading },
        data() {
            return {
                type: "password",
                icon: false,
                user: {
                    email: "",
                    password: "",
                },
                modal2: false,
                activeStatus: false,
                decodedid: "",
                userid: "",
                plans: [],
                plans_details: {
                    id: "",
                },
                discount1: "",
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
                },
                showNotification: false,
                errors: [],
                emailactive: [],
                useremail: {
                    id: "",
                },
                id: "",
                isLoading: false,
                fullPage: true,
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.$store.commit("setPage", "plans");
                if (to.name == "PlanAcitve") {
                    vm.id = atob(vm.$route.params.id);
                    vm.useremail.id = vm.id;
                    let uri = "activate";
                    vm.$store
                        .dispatch("post", { uri: uri, data: vm.useremail })
                        .then(function (response) {
                            // vm.state_country = response.data.data;
                            vm.emailactive = response.data;
                            vm.modal2 = true;
                            vm.activeStatus = true;
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                } else {
                    vm.activeStatus = false;
                    vm.index();
                }
            });
        },
        mounted() {
            window.scrollTo(0, 0);
        },
        methods: {
            index() {
                let vm = this;
                let uri = "getPricingPlan";

                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        for (let j = 0; j < response.data.data.length; j++) {
                            console.log("j", response.data.data[j]);
                            if (response.data.data[j]["plan"] != "Monthly") {
                                vm.plans.push(response.data.data[j]);
                            }
                            if (response.data.data[j]["plan"] == "Annual") {
                                vm.discount1 = (response.data.data[j]["discount"] * 100) / response.data.data[j]["price"];
                                console.log("Discount", vm.discount1);
                            }
                        }

                        vm.meta.totalRows = response.data.meta.total;
                        vm.meta.lastPage = response.data.meta.last_page;
                        vm.meta.from = response.data.meta.from;
                        vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            closemodal() {
                let vm = this;

                vm.modal2 = false;
                vm.errors = [];
            },
            getplan(plan) {
                console.log("plans", plan);
                let vm = this;
                if (vm.$store.getters.user == null) {
                    vm.modal2 = true;
                } else {
                    vm.plans_details.id = plan;
                    vm.$router.push("/plan_subscription/" + vm.plans_details.id);
                }
            },

            onPageChange(page) {
                this.meta.currentPage = page;
                this.index();
            },

            onPerPageChange() {
                this.meta.currentPage = 1;
                this.index();
            },
            login() {
                let vm = this;
                vm.isLoading = true;
                vm.$store
                    .dispatch("auth", { uri: "login", data: vm.user })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Successfuly logged in");
                        vm.$store.commit("setUser", response.data);
                        vm.$store.commit("setToken", response.data.token);
                        vm.$router.push("/plans_pricing");
                        vm.closemodal();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            toggle() {
                let vm = this;
                if (vm.type == "password") {
                    vm.type = "text";
                    vm.icon = true;
                } else {
                    vm.type = "password";
                    vm.icon = false;
                }
            },
        },
    };
</script>
<style scoped>
    .popup {
        position: fixed;
        padding: 10px;
        border-radius: 10px;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.5s ease-in-out;
        transition: background 0.3s ease-in;
        background: rgba(255, 255, 255, 0.9);
        opacity: 100;
        transition: opacity 0.5s, visibility 0s linear 0.5s;
        z-index: 9999;
    }
    .popup .close {
        position: absolute;
        right: 5px;
        top: 5px;
        padding: 5px;
        color: #000;
        transition: color 0.3s;
        font-size: 2em;
        line-height: 0.6em;
        font-weight: bold;
    }
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
    .modal-content {
        /* font-family: "Fondamento", cursive; */
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        min-height: 200px;
        /* width: 480px; */
        margin: 1rem;
        position: relative;
        min-width: 200px;
        box-shadow: 0 3px 6px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 23%);
        justify-self: center;
        transition: all 5s ease-in-out;
    }

    .table {
        text-align: center;
        margin-bottom: 0px;
        border-color: transparent;
    }
    .table > tbody > tr > td {
        border-top: none;
    }

    .table > tbody + tbody {
        border-top: 2px solid #ddd;
    }
    .tabbody {
        border-left: 1px solid #eee;
        border-bottom: 1px solid #fff;
        padding: 8px;
    }
    .plans_tbody_td {
        box-shadow: 0 1px 4px rgb(41 51 57 / 50%);
        background-color: #fff;
    }
    .plans_td {
        background-color: #fff;
        color: #4599dc;
        font-size: 12px;
        font-weight: 700;
    }
    .db-bk-color-two {
        background-color: #4599dc;
        font-size: 14px;
        font-weight: 800;
    }
    .db-bk-color-three {
        background-color: #67ce00;
        font-size: 14px;
        font-weight: 800;
    }
    .db-pricing-nine thead tr th {
        font-weight: normal;
        font-weight: normal;
        height: 72px;
        vertical-align: middle;
        text-align: center;
        color: #fff;
    }
    .db-bk-color-one {
        background-color: #c6c7c9;
        font-size: 14px;
        font-weight: 900;
    }
    .circle_grey_td {
        color: #c6c7c9;
        font-size: 20px;
    }
    .circle_blue_td {
        color: #4599dc;
        font-size: 20px;
    }
    .circle_green_td {
        color: #67ce00;
        font-size: 20px;
    }
    .circle_grey_padd_td {
        color: #c6c7c9;
        font-size: 20px;
        padding: 5px;
    }
    .db-button-color-one,
    .db-button-color-two,
    .db-button-color-three {
        border: none;
        background-color: #67ce00;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
    }

    .shadow1 {
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }
    .border-radius {
        border-radius: 0px;
    }
    .errorclass {
        border-color: #dc3545;
    }
    .disabled-link {
        pointer-events: none;
    }

    .bg-purple {
        background-color: #7d3be1 !important;
    }
    .icon-sm {
        font-size: 80%;
    }
    .border-right {
        border-right: 1px solid #ececec;
    }
    .mt-15px {
        margin-top: 18px;
    }
    .top-65 {
        top: 65% !important;
    }
    .top-30 {
        top: 30%;
    }
    .top-34 {
        top: 34%;
    }
    .float-right {
        float: right;
    }
    sup {
        top: 0.5em;
    }
    .justify-content-space-around {
        justify-content: space-around;
    }
    .fs-18 {
        font-size: 18px;
    }
</style>
