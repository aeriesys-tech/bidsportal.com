<template>
    <loading v-model:active="isLoading" :can-cancel="false" :on-cancel="onCancel" :is-full-page="fullPage" />
    <section class="pt-3" style="padding-bottom: 74px;">
        <div class="container">
            <div class="row">
                <ProfileList></ProfileList>
                <div class="col-lg-8 col-xl-9 ps-xl-5">
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>
                    <div class="card border-0 p-5 pt-0">
                        <div class="card-header bg-transparent border-bottom d-sm-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-header-title">Profile</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- <div class="d-flex align-items-center text-start me-0 me-sm-4 mb-3">
                                <div class="icon-md bg-primary bg-opacity-10 flex-shrink-0 text-primary rounded-circle me-2"><i class="fa fa-user"></i></div>
                                <div>
                                    <p class="h6 fw-normal mb-0">Basic info</p>
                                    <p class="mb-0 small">Your personal information here</p>
                                </div>
                            </div> -->
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Full Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter your full name" :class="{ 'is-invalid': errors.name }" ref="username" v-model="user.name" />
                                    <span v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</span>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Mailing Address<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" :class="{ 'is-invalid': errors.mailing_address }" ref="email" v-model="user.mailing_address" placeholder="Enter your email id" />
                                    <span v-if="errors.mailing_address" class="invalid-feedback">{{ errors.mailing_address[0] }}</span>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Mobile number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" :class="{ 'is-invalid': errors.phone }" ref="companyname" v-model="user.phone" placeholder="Enter your mobile number" />
                                    <span v-if="errors.phone" class="invalid-feedback">{{ errors.phone[0] }}</span>
                                </div>
                                  <div class="col-md-12">
                                    <label class="form-label">Company Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" :class="{ 'is-invalid': errors.company_name }" ref="webaddress" v-model="user.company_name" placeholder="Enter your Company Name" />
                                    <span v-if="errors.company_name" class="invalid-feedback">{{ errors.company_name[0] }}</span>
                                </div>
                                <!-- Website Address -->
                                <div class="col-md-12">
                                    <label class="form-label">Website Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" :class="{ 'is-invalid': errors.web_address }" ref="mailaddress" v-model="user.web_address" placeholder="Enter your Website Address" />
                                    <span v-if="errors.web_address" class="invalid-feedback">{{ errors.web_address[0] }}</span>
                                </div>
                                <!-- <div class="col-md-12">
                                    <label class="form-label">Company Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.company }" ref="webaddress" v-model="user.company" placeholder="Enter your Company Name" />
                                    <span v-if="errors.company" class="invalid-feedback">{{ errors.company[0] }}</span>
                                </div> -->
                                  <!-- <div class="col-md-12">
                                    <label class="form-label">City<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.city }" ref="city" v-model="user.city" :disabled="disabled" placeholder="Enter your City" />
                                    <span v-if="errors.city" class="invalid-feedback">{{ errors.city[0] }}</span>
                                </div> -->
                                <!-- State -->
                                <!-- <div class="col-md-12">
                                    <label class="form-label">State<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.state }" ref="state" v-model="user.state" :disabled="disabled" placeholder="Enter your State" />
                                    <span v-if="errors.state" class="invalid-feedback">{{ errors.state[0] }}</span>
                                </div> -->
                                <!-- Zip Code -->
                                <!-- <div class="col-md-12">
                                    <label class="form-label">Zip Code<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.pin_code }" ref="pin_code" v-model="user.pin_code" :disabled="disabled" placeholder="Enter your Zip Code" />
                                    <span v-if="errors.pin_code" class="invalid-feedback">{{ errors.pin_code[0] }}</span>
                                </div> -->

                                <!-- try starts -->
                                   <div class="col-md-12">
                                        <label for="inputfrequen1" class="form-label head1">Set Aside <span
                                                class="text-danger">*</span> </label> <label>{{ user.set_asides?.length
                                            }} of {{ set_asides.length }} Selected</label>
                                        <div class="">
                                            <button type="button" style="border: 1px solid #3d85d8;"
                                                class="btn btnwht10 form-select" data-bs-toggle="dropdown">
                                                <span class="text-center"
                                                    style="float: left; color: #1e4c82; font-size: 16px; font-weight: 400;">Select
                                                    Set Aside</span>
                                            </button>
                                            <label for="inputfrequen1" class="form-label"> </label>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-item">
                                                    <div class="">
                                                        {{ user.set_asides?.length }} of {{ set_asides.length }}
                                                        <router-link to="" @click="selectAllSetAsides()"
                                                            class="" ref="selectState">
                                                            Select All /
                                                        </router-link>
                                                        <router-link to="" @click="deselectSetAsides()"
                                                            class="" ref="selectState">
                                                            Reset all
                                                        </router-link>
                                                        <div class="ss-filter-search scrollaside">
                                                            <input autocomplete="off" class="form-control"
                                                                type="text" v-model="set_aside_keyword"
                                                                placeholder="Search Set Aside" @keyup="sortSetAside()" />
                                                            <div class="liststate" id="style-3">
                                                                <ul class="checkbox pl-0">
                                                                    <li class="list-group-item fnt">
                                                                        <input type="checkbox" :value="'nosetaside'"
                                                                            v-model="user.set_asides"
                                                                            class="form-check-input me-2"
                                                                            @click="noSetAside('nosetaside')"
                                                                            ref="rolesSelected" />No Set Aside
                                                                    </li>
                                                                    <li class="list-group-item fnt"
                                                                        v-for="set_aside, key in set_aside_sorted"
                                                                        :key="key">
                                                                        <input class="form-check-input me-1"
                                                                            type="checkbox"
                                                                            :value="set_aside.set_aside_id"
                                                                            v-model="user.set_asides"
                                                                            @change="updateCheckall"
                                                                            aria-label="..." />

                                                                        {{ set_aside.set_aside_name }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <span v-if="errors.set_asides"
                                            style="color:#dc3545; margin-top:5px;font-size:0.875em">{{
                                            errors.set_asides[0] }}</span>
                                    </div>




                                    <!-- try emds -->


                                <div class="col-md-12">
                                    <div class="text-end">
                                        <button type="button" href="#" class="btn-sm btn btn-primary mb-0 me-2" @click="UpdateUser()">Save Changes</button>
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
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    import ProfileList from "@/components/ProfileList.vue";
    export default {
        components: { Loading, ProfileList },
        data() {
            return {
                searchstate: "",
                buttontogle: 1,
                type: "password",
                type1: "password",
                disabled: true,
                icon: false,
                icon1: false,
                set_asides: [],
            set_aside_sorted: [],
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
                    mobile_number: "",
                    avatar: "",
                    phone: "",
                    company_name: "",
                    web_address: "",
                    mailing_address: "",
                    socioeconomic_status: "",
                    set_asides: []
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
                set_aside_keyword: null
            };
        },
        computed: {
            filterSetAside() {
                // return this.SetAsideStatus.filter((aside) => {
                //     return aside.status_name.toLowerCase().includes(this.searchstate.toLowerCase());
                // });
            },
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.isLoading = true;
                if (vm.$store.getters.user) {
                    vm.user = vm.$store.getters.user;
                    vm.$store
                        .dispatch("post", { uri: "getSetAsides" })
                        .then(function (response) {
                            // loader.hide();
                            vm.isLoading = false;
                            vm.set_asides = response.data;
                            vm.set_aside_sorted = vm.set_asides
                            console.log("set-aside---",vm.set_asides)
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
            let header_menu = this.$store.getters.header_menu;
            header_menu.show_bidsearch = true;
            this.$store.dispatch("setHeaderMenu", header_menu);
        },
    methods: {
            onCancel(){

            },
            sortSetAside(){
                this.set_aside_sorted = []
                this.set_aside_sorted = this.set_asides.filter((set_aside) => {
                    return set_aside.set_aside_name.toLowerCase().includes(this.set_aside_keyword.toLowerCase());
                });
            },
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
                vm.isLoading = true
                vm.$store
                    .dispatch("post", { uri: "updateUser", data: vm.user })
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
            selectAllSetAsides() {
            let vm = this
                this.set_aside_sorted.map(function (element) {
                console.log("elemm--",element)
                vm.user.set_asides.push(element.set_aside_id)
            })
        },
        deselectSetAsides() {
            this.set_aside_sorted = this.set_asides
            this.user.set_asides = [];
        },
        updateCheckall() {
            if (this.regSetAside.length > 0) {
                if (this.regSetAside[0] == 'nosetaside') {
                    this.regSetAside.splice(0, 1);
                }
            }
            if (this.set_asides.length == this.regSetAside.length) {
                // this.no_Set_Aside=false;
                this.selectAll = true;
                this.status_id = this.regSetAside;
            } else {
                this.selectAll = false;
                this.status_id = this.regSetAside;
            }
        },
        noSetAside(data) {
            let vm = this;
            vm.regSetAside = [];
            vm.regSetAside.push(data);
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
        max-width: 260px !important;
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
    .pl-0 {
        padding-left: 5px !important;
    }
    .dropdown-item:hover,
    .dropdown-item:focus {
        color: inherit;
        background-color: transparent;
    }
    .fnt {
        font-size: 15px;
        font-weight: 400;
    }

    /* width */
    .scrollaside ::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;

        cursor: pointer !important;
    }

    /* Track */
    .scrollaside::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px !important;
    }

    /* Handle */
    .scrollaside ::-webkit-scrollbar-thumb {
        background-color: #5143d9 !important;
        border-radius: 10px !important;
    }
</style>
