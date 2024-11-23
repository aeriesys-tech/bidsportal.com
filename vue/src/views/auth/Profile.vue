<template>
    <loading v-model:active="isLoading" :can-cancel="false" :on-cancel="onCancel" :is-full-page="fullPage" />
    <section class="pt-3" style="padding-bottom:74px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-light w-100">
                        <div class="card-body p-3">
                            <div class="text-center">
                                <div class="text-center">
                                    <h1 class="avatar avatar-xl rounded-circle border border-white border-3 shadow">{{$store.getters.user?.name.substring(0,1)}}</h1>
                                </div>
                                <h6 class="mb-0">{{$store.getters.user?.name}}</h6>
                                <a href="javascript:void(0)" class="text-reset text-primary-hover small">{{$store.getters.user?.email}}</a>
                                <hr />
                            </div>
                            <ul class="nav nav-pills-primary-soft flex-column">
                                <li class="nav-item">
                                    <router-link class="nav-link active" to="/user/profile"><i class="bi bi-person fa-fw me-2"></i>My Profile</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/user/change-password"><i class="bi bi-person fa-fw me-2"></i>Change Password</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/user/subscription"><i class="bi bi-ticket-perforated fa-fw me-2"></i>Subscription Info</router-link>
                                </li>

                                <li class="nav-item" v-if="payment.length !==0">
                                    <router-link class="nav-link" to="/user/single-bidpurchases"><i class="bi bi-people fa-fw me-2"></i> Single Bid Purchases</router-link>
                                </li>

                                <li class="nav-item" v-if="payment.length !==0">
                                    <router-link class="nav-link" to="/user/my-purchasedbids"><i class="bi bi-people fa-fw me-2"></i>My Purchased Bids</router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card border">
                        <div class="card-header border-bottom d-sm-flex justify-content-between align-items-center" style="padding: 10px 22px">
                            <h5 class="card-header-title">Personal Information</h5>
                            <router-link to="/bids/state-opportunities" type="button" class="mb-0 btn btn-sm btn-primary">
                                Back To Bids
                            </router-link>
                        </div>
                        <div class="card-body">
                            <form class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Full Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Enter your full name" :class="{ 'is-invalid': errors.name }" ref="username" v-model="user.name" :disabled="disabled" />
                                    <span v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</span>
                                </div>
                                <!-- position -->
                                <div class="col-md-4">
                                    <label class="form-label">Position/Title<span class="text-danger"></span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.title }" ref="title" v-model="user.title" :disabled="disabled" placeholder="Enter your Position/Title" />
                                    <span v-if="errors.title" class="invalid-feedback">{{ errors.title[0] }}</span>
                                </div>
                                <!-- Email -->
                                <div class="col-md-4">
                                    <label class="form-label">Mailing Address<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-sm" :class="{ 'is-invalid': errors.email }" ref="email" v-model="user.email" :disabled="disabled" placeholder="Enter your email id" />
                                    <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                                </div>

                                <!-- Mobile -->
                                <div class="col-md-4">
                                    <label class="form-label">Mobile number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.phone }" ref="companyname" v-model="user.phone" :disabled="disabled" placeholder="Enter your mobile number" />
                                    <span v-if="errors.phone" class="invalid-feedback">{{ errors.phone[0] }}</span>
                                </div>
                                <!-- Company Name -->
                                <div class="col-md-4">
                                    <label class="form-label">Company Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.company_name }" ref="webaddress" v-model="user.company_name" :disabled="disabled" placeholder="Enter your Company Name" />
                                    <span v-if="errors.company_name" class="invalid-feedback">{{ errors.company_name[0] }}</span>
                                </div>
                                <!-- Website Address -->
                                <div class="col-md-4">
                                    <label class="form-label">Website Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.web_address }" ref="mailaddress" v-model="user.web_address" :disabled="disabled" placeholder="Enter your Website Address" />
                                    <span v-if="errors.web_address" class="invalid-feedback">{{ errors.web_address[0] }}</span>
                                </div>
                                <!-- City -->
                                <div class="col-md-4">
                                    <label class="form-label">City<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.city }" ref="city" v-model="user.city" :disabled="disabled" placeholder="Enter your City" />
                                    <span v-if="errors.city" class="invalid-feedback">{{ errors.city[0] }}</span>
                                </div>
                                <!-- State -->
                                <div class="col-md-4">
                                    <label class="form-label">State<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.state }" ref="state" v-model="user.state" :disabled="disabled" placeholder="Enter your State" />
                                    <span v-if="errors.state" class="invalid-feedback">{{ errors.state[0] }}</span>
                                </div>
                                <!-- Zip Code -->
                                <div class="col-md-4">
                                    <label class="form-label">Zip Code<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.zipcode }" ref="zipcode" v-model="user.zipcode" :disabled="disabled" placeholder="Enter your Zip Code" />
                                    <span v-if="errors.zipcode" class="invalid-feedback">{{ errors.zipcode[0] }}</span>
                                </div>
                                <!-- Nationality -->
                                <!-- <div class="col-md-4">
                                    <label class="form-label">Set Aside<span class="text-danger">*</span></label>
                                    <div class="liststate" id="style-3">
                                        <ul class="list-group checkbox disabled" v-for="setAside in SetAsideStatus" :key="setAside.status_id">
                                            <li class="list-group-item" id="lable">
                                                <label class="containercheckbox">
                                                    <input class="form-check-input check-gov me-1 checkbox12" id="federalcheck" type="checkbox" aria-label="..." :value="setAside.status_id" v-model="regSetAside" />
                                                    <span class="checkmarkcheckbox"></span>{{setAside.status_name}}
                                                </label>
                                            </li>
                                        </ul>
                                    </div>

                                </div> -->

                                <!-- testing -->
                                <div class="col-md-4">
                                    <label for="inputfrequen1" class="form-label head1">Set Aside <span class="text-danger">*</span> </label> <label>{{ regSetAside.length }} of {{ coutsetside.length}} Selected</label>

                                    <div class="">
                                        <button type="button" class="btn form-control bgcolor btnwht10 form-select" data-bs-toggle="dropdown">
                                            <span class="text-center" style="float: left; font-size: 10pt; font-weight: 400; color:#a49da5">Select Set Aside</span>
                                        </button>
                                        <label for="inputfrequen1" class="form-label"> </label>
                                        <ul class="dropdown-menu ">
                                            <li class="dropdown-item fnt">
                                                <div class="">
                                                    <router-link to="" v-model="selectAll" @click="select()" class="" ref="selectState">
                                                        Select All /
                                                    </router-link>
                                                    <router-link to="" v-model="selectAll" @click="Deselect()" class="" ref="selectState">
                                                        Reset all
                                                    </router-link>
                                                    <div class="ss-filter-search scrollaside">
                                                        <input autocomplete="off" class="form-control" type="text" v-model="searchstate" placeholder="Search Set Aside" />
                                                        <div class="liststate " id="style-3">
                                                            <ul class="checkbox pl-0" v-for="setAside in filterSetAside" :key="setAside.status_id">
                                                                <li class="list-group-item">
                                                                    <input class="form-check-input me-1" id="federalcheck" type="checkbox" :value="setAside.status_id" v-model="regSetAside" @change="updateCheckall" aria-label="..." />
                                                                    {{setAside.status_name}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-end">
                                        <button type="button" v-if="buttontogle==0" href="#" class="btn-sm btn btn-primary mb-0 me-2" @click="UpdateUser()">Save Changes</button>
                                        <button type="button" class="btn btn-sm abtn mt-1 btn-secondary secd" @click="enable()">
                                            <span v-if="buttontogle">Edit</span>
                                            <span v-else>Cancel </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    export default {
        components: { Loading },
        data() {
            return {
                searchstate: "",
                buttontogle: 1,
                type: "password",
                type1: "password",
                disabled: true,
                icon: false,
                icon1: false,
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
                isLoading: false,
                fullPage: true,
                coutsetside: 0,
            };
        },
        computed: {
            filterSetAside() {
                return this.SetAsideStatus.filter((aside) => {
                    return aside.status_name.toLowerCase().includes(this.searchstate.toLowerCase());
                });
            },
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                // vm.checklogin();
                // let loader = vm.$loading.show();
                vm.isLoading = true;
                if (vm.$store.getters.user) {
                    vm.user.id = vm.$store.getters.user?.id;
                    vm.$store
                        .dispatch("post", { uri: "showUser", data: vm.user })
                        .then(function (response) {
                            // loader.hide();
                            vm.isLoading = false;
                            vm.user = response.data.data;
                            vm.password.email = vm.user.email;
                            vm.password.user_id = vm.user.user_id;
                            vm.regSetAside = vm.user.socioeconomic_status.split(",");
                        })
                        .catch(function (error) {
                            vm.isLoading = false;
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            });
        },

        mounted() {
            let vm = this;

            // vm.password.email = vm.$store.getters.user.email;
            if (vm.$store.getters.user) {
                vm.getUserSubscriptions();
                vm.getuserbids();
                vm.getSetAsideStatus();
            }
            //
            // vm.$router.push("/bids");
        },
        methods: {
            getSetAsideStatus() {
                let vm = this;

                vm.$store
                    .dispatch("post", { uri: "getSetAsideStatus" })
                    .then(function (response) {
                        vm.SetAsideStatus = response.data.data;
                        vm.coutsetside = vm.SetAsideStatus;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getUserSubscriptions() {
                let vm = this;
                vm.subscriptions.user_id = vm.$store.getters.user.subscription_id;
                vm.$store
                    .dispatch("post", {
                        uri: "getUserSubscriptions",
                        data: vm.subscriptions,
                    })
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

                vm.$store
                    .dispatch("post", {
                        uri: "getUserPayments",
                        data: vm.payment,
                    })
                    .then(function (response) {
                        vm.payment = response.data;
                        // vm.userbids.bids = vm.payment.item_number.toString();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getuserbids() {
                let vm = this;
                vm.$store
                    .dispatch("post", {
                        uri: "getBids",
                        data: vm.userbids,
                    })
                    .then(function (response) {
                        vm.userpayedbids = response.data.data;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            UpdateUser() {
                let vm = this;
                // vm.tdr.tdr_id = vm.$route.params.tdr_id;
                vm.user.id = vm.$store.getters.user.id;
                vm.user.socioeconomic_status = vm.regSetAside.toString();
                vm.isLoading = true;
                // alert(vm.user.id);
                if (vm.buttontogle == 0) {
                    vm.$store
                        .dispatch("post", { uri: "updateUser/" + vm.user.id, data: vm.user })
                        .then(function () {
                            vm.isLoading = false;
                            vm.$store.dispatch("setUser", vm.user);
                            vm.$store.dispatch("success", "User Profile Update is successfully ");
                            vm.disabled = true;
                            vm.errors == [];
                            vm.buttontogle = 1;
                        })
                        .catch(function (error) {
                            vm.isLoading = false;
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                } else {
                    return false;
                }
            },
            // getBids
            UpdatePassword() {
                let vm = this;
                vm.isLoading = true;
                vm.password.id = vm.$store.getters.user.id;
                vm.$store
                    .dispatch("post", {
                        uri: "updatePasswordFromProfile/" + vm.password.id,
                        data: vm.password,
                    })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "User Password Updated successfully ");
                        vm.errors == [];
                        vm.disabled == false;
                        vm.$router.push("/login");
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            enable() {
                let vm = this;
                if (vm.buttontogle == 1) {
                    vm.$refs.username.focus();
                    vm.disabled = false;
                    vm.buttontogle = 0;
                } else {
                    vm.disabled = true;
                    vm.buttontogle = 1;
                    vm.$router.go();
                }
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

            toggle1() {
                let vm = this;

                if (vm.type1 == "password") {
                    vm.type1 = "text";
                    vm.icon1 = true;
                } else {
                    vm.type1 = "password";
                    vm.icon1 = false;
                }
            },

            checkout() {
                let vm = this;
                if (vm.$store.getters.authenticated) {
                    vm.$router.push("/addresses");
                } else {
                    vm.$router.push("/login");
                }
            },
            select() {
                this.regSetAside = [];
                if (!this.selectAll) {
                    for (let i in this.SetAsideStatus) {
                        this.regSetAside.push(this.SetAsideStatus[i].status_id);
                    }
                    this.status_id = this.regSetAside;
                }
            },
            Deselect() {
                this.regSetAside = [];
                this.status_id = [];
            },
            updateCheckall() {
                if (this.SetAsideStatus.length == this.regSetAside.length) {
                    this.selectAll = true;
                    this.status_id = this.regSetAside;
                } else {
                    this.selectAll = false;
                    this.status_id = this.regSetAside;
                }
            },
        },
    };
</script>
<style scoped>
    .circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid #1f1d1d;
        line-height: 50px;
        text-align: center;
        font-size: 30px;
    }
    .liststate {
        max-height: 200px;
        /* margin-bottom: 10px; */
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
         max-width: 260px!important;
    }
    .stripe-1 {
        color: white !important;

        background-image: linear-gradient(45deg, #5f7bed 25%, #3d6f8e 25%, #3d6f8e 50%, #5f7bed 50%, #5f7bed 75%, #3d6f8e 75%, #3d6f8e 100%);
        background-size: 56.57px 56.57px;
        text-align: center !important;
        margin-bottom: 10px;
    }
    .bgcolor {
        background-color: var(--bs-gray-200);
        border-color: #ced4da;
        opacity: 1;
        color: var(--bs-gray-900);
    }
    /* .liststate[data-v-ca123f88] {
    
    max-width: 260px!important;
    } */
     .pl-0{
        padding-left:5px!important;
     }
    .dropdown-item:hover, .dropdown-item:focus {
    color:inherit;
    background-color:transparent;
}
.fnt{
    font-size: 15px;
    font-weight: 400;
}

/* width */
    .scrollaside ::-webkit-scrollbar {
        width: 5px!important;
        height:5px!important;

        cursor: pointer!important;
    }

    /* Track */
    .scrollaside::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px!important;
    }

    /* Handle */
    .scrollaside ::-webkit-scrollbar-thumb {
        background-color: #5143d9!important;
        border-radius: 10px!important;
    }
</style>
