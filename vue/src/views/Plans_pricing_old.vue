<template>
<loading v-model:active="isLoading"
                 :can-cancel="false"
                 :z-index="10001"
                 :is-full-page="fullPage"/>
    <section class="pt-4 pt-md-5 pb-0" id="plans_pricing">
        <div class="container">
            <div class="d-flex justify-content-between mb-4">
                <div class="text-center">
                    <h6>Register for BidsPortal today and take 20% off on new, Annual Subscription Plan. Enjoy a better way to connect with Buyers through BidsPortal service at an affordable fee for any size budget.</h6>
                </div>
            </div>

            <!-- Contact info -->
            <div class="row g-4">
                <!-- Contact item START -->
                <div class="col-md-6 col-xl-3">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-xxl bg-info bg-opacity-10 text-info rounded-circle mb-4">
                            <!-- <i class="bi bi-headset fs-3"></i> -->
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
                        <div class="icon-xxl bg-danger bg-opacity-10 text-danger rounded-circle mb-4">
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
                        <div class="icon-xxl bg-orange bg-opacity-10 text-orange rounded-circle mb-4">
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
                        <div class="icon-xxl bg-danger bg-opacity-10 text-danger rounded-circle mb-4">
                            <img src="../assets/icons/OutlineIcon.png" class="card-img fs-3" alt="" />
                        </div>
                        <!-- Title -->
                        <p>Unlimited access to all the bids posted under different Regions, categories and NAICS Codes and lets you setup unlimited Alert Profiles for email notifications powered by BidsPortal.</p>
                    </div>
                </div>
                <!-- Contact item END -->
            </div>
        </div>

        <div class="container pt-4 pt-md-5">
            <div class="row g-4">
                <div class="col-lg-9 col-sm-12 d-md-flex">
                    <div class="table-responsive shadow1">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td colspan="3" class="plans_td bg-primary bg-opacity-10"><strong>Get the Most Comprehensive Plan for your Business</strong></td>
                                </tr>
                                <tr>
                                    <th style="border-top: 1px solid #eee;"></th>
                                    <th class="db-bk-color-one text-white">
                                        Monthly<br />
                                        <span class="font_discount"> Flat Rate </span>
                                    </th>
                                    <th class="db-bk-color-two text-white">
                                        12% <span class="font_discount">discounted</span> Semi-Annual<br />
                                        <span class="font_discount"><i>($27.00 saved)</i> </span>
                                    </th>
                                    <th class="db-bk-color-three text-white">
                                        20% <span class="font_discount">discounted </span>Annual<br />
                                        <span class="font_discount"> <i>($73.00 saved)</i> </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="plans_tbody_td">
                                <tr>
                                    <td class="db-width-perticular">Overall Access to BidsPortal</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Federal, State &amp; Local Bids</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">International Bids</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Commercial &amp; Private Sector Bids</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">All States &amp; Territories Covered</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Access to Bid Documents</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Customizable Bid Alerts</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Daily Email Notifications</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Share Bids via Email</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Advance Search Filters ®</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Search Bid Documents Only Filters ®</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Search &amp; Access Active Bids</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Search &amp; Access Expired Bids</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">Support via LiveChat and Telephone</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular">No Hidden Extras &amp; No Limits</td>
                                    <td class="tdborder"><i class="fa fa-check-circle circle_grey_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_blue_td"></i></td>
                                    <td class="tabbody"><i class="fa fa-check-circle circle_green_td" style=""></i></td>
                                </tr>
                                <tr>
                                    <td class="db-width-perticular"><b>Final Payable Amount</b></td>

                                    <td class="tdborder plans_amt_td" v-for="plan in plans" :key="plan.id">
                                        <span class="plans_amt_span_td">${{plan.price}}</span><br />
                                        <span class="plans_amt_txt_td">{{plan.plan}}</span>
                                    </td>
                                  
                                </tr>
                            </tbody>

                            <tbody>
                                <tr>
                                    <td></td>
                                    <td><button :disabled="$store.getters.user?.subscription_id !==0" class="btn btn-primary mt-2" @click.prevent="getplan(plans[0])">SUBSCRIBE</button></td>
                                    <td><button :disabled="$store.getters.user?.subscription_id !==0" class="btn btn-primary mt-2" @click.prevent="getplan(plans[1])">SUBSCRIBE</button></td>
                                    <td><button :disabled="$store.getters.user?.subscription_id !==0" class="btn btn-primary mt-2" @click.prevent="getplan(plans[2])">SUBSCRIBE</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 d-md-flex">
                    <div class="table-responsive" style="">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td><h3></h3></td>
                                </tr>
                                <tr>
                                    <th class="bg-primary text-white">Single Bid</th>
                                </tr>
                            </thead>
                        </table>

                        <div class="">
                            <ul class="list-group list-group-border border-radius small mb-0">
                                <li class="list-group-item d-flex p-2"><i class="fa fa-check-circle circle_grey_td me-4"></i>Access to Single Bid Details Only</li>
                                <li class="list-group-item d-flex p-2"><i class="fa fa-check-circle circle_grey_td me-4"></i>Includes Posting Agnecy Name, Location, Description & Web-Link.</li>
                                <li class="list-group-item d-flex p-2"><i class="fa fa-check-circle circle_grey_td me-4"></i>Related Bid Documents</li>
                                <li class="list-group-item d-flex p-2"><i class="fa fa-check-circle circle_grey_td me-4"></i>Details for Opted Bid Accessible Only After Successfull Payment</li>
                            </ul>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><a href="javascript:void(0)" class="btn btn-primary plan_btn_td">SELECT BID</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid position-relative pt-4 pt-md-5" style="padding-right: 0px; padding-left: 0px;">
            <!-- Notice board START -->
            <div class="bg-primary bg-opacity-10 rounded-3 overflow-hidden mt-4 p-4">
                <div class="row g-4 align-items-center">
                    <!-- Image -->
                    <div class="col-sm-6 col-xl-4 text-center">
                        <!-- <img src="assets/images/element/11.svg" class="mb-n5" alt=""> -->
                        <h6>Need help in selecting a Subscription Package?</h6>
                        <h6>Call us on (913) 232-2255 or email: support@bidsportal.com or</h6>
                        <h6>Contact our representative via LiveChat for realtime vitual support</h6>
                    </div>

                    <!-- Content -->
                    <div class="col-sm-6 col-xl-4 text-center">
                        <img src="../assets/icons/VisaIcon.png" class="ps-2" alt="" />
                        <img src="../assets/icons/MastercardIcon.png" class="ps-2" alt="" />
                        <img src="../assets/icons/AmericanExpressIcon.png" class="ps-2" alt="" />
                        <img src="../assets/icons/DiscoveryNetworkIcon.png" class="ps-2" alt="" />
                        <!-- Title -->
                    </div>

                    <!-- Image -->
                    <div class="col-sm-6 col-xl-4 text-center">
                        <img src="../assets/icons/McafeeIcon.png" class="ps-2" alt="" />
                    </div>
                </div>
            </div>
            <!-- Notice board END -->
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
                                <div class="bg-success bg-opacity-10 text-success fw-light rounded-2 p-2"  role="alert" v-if="activeStatus">
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
                                                    <input class="form-control fakepassword"  placeholder="Enter password"  :type="type" id="psw-input" :class="{'is-invalid': errors.password}" ref="password" v-model="user.password" />
                                                    
                                                    <span :class="{'errorclass':errors.password}" class="input-group-text p-0 bg-transparent" @click.prevent="toggle">
                                                         <i class="fakepasswordicon fa fa-eye  p-2" v-if="icon"></i>
                                                        <i class="fakepasswordicon fa fa-eye-slash  p-2" v-else></i>
                                                       
                                                    </span>
                                                </div>
                                                 <span v-if="errors.password"  style="color:#dc3545;font-size:0.875em">{{ errors.password[0] }}</span>
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
  import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
// import Login from "@/components/Login.vue";
    export default {
         components: {Loading},
        data() {
            return {
                 type: "password",
                icon: false,
                user: {
                    email: "",
                    password: "",
                },
                modal2: false,
                activeStatus:false,
                decodedid: "",
                userid: "",
                plans: [],
                plans_details: {
                    id: "",
                },
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
                vm.$store.commit("setPage", 'plans');
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
                            vm.activeStatus= true;
                            
                            
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });

                } else {
                        vm.activeStatus= false;
                        vm.index();
                       
                }
            });
        },
        mounted(){
           
           
            window.scrollTo(0, 0)
        },
        methods: {
            index() {
                let vm = this;
                let uri = "getPricingPlan";

                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.plans = response.data.data;
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
            getplan(plans) {
                let vm = this;
                if (vm.$store.getters.user == null) {
                    vm.modal2 = true;
                } else {
                    vm.plans_details.id = plans.id;
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
               vm.isLoading = true
                vm.$store
                    .dispatch("auth", { uri: "login", data: vm.user })
                    .then(function (response) {
                       vm.isLoading = false
                        vm.$store.dispatch("success", "Successfuly logged in");
                        vm.$store.commit("setUser", response.data);
                        vm.$store.commit("setToken", response.data.token);
                        vm.$router.push("/plans_pricing");
                        vm.closemodal();
                    })
                    .catch(function (error) {
                       vm.isLoading = false
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
     .errorclass{
        border-color: #dc3545; }
   .disabled-link {
  pointer-events: none;
}
</style>
