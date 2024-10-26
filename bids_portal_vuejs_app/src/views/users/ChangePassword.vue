<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :on-cancel="onCancel" :is-full-page="fullPage" />

    <section class="pt-3" style="padding-bottom: 77px;">
        <div class="container-fluid">
            <div class="row">
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
                                            <h1 class="avatar avatar-xl rounded-circle border border-white border-3 shadow">
                                                {{ $store.getters.user?.name.substring(0, 1) }}
                                            </h1>
                                        </div>
                                        <h6 class="mb-0">{{ $store.getters.user?.name }}</h6>
                                        <a href="javascript:void(0)" class="text-reset text-primary-hover small">{{ $store.getters.user?.email }}</a>
                                        <hr />
                                    </div>
                                    <!-- Sidebar menu item START -->
                                    <ul class="nav nav-pills-primary-soft flex-column">
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/user/profile"><i class="bi bi-person fa-fw me-2"></i>My Profile</router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link active" to="/user/change-password"><i class="bi bi-person fa-fw me-2"></i>Change Password</router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/user/subscription"><i class="bi bi-ticket-perforated fa-fw me-2"></i>Subscription Info</router-link>
                                        </li>

                                        <li class="nav-item" v-if="payment.length !== 0">
                                            <router-link class="nav-link" to="/user/single-bidpurchases"><i class="bi bi-people fa-fw me-2"></i> Single Bid Purchases</router-link>
                                        </li>

                                        <li class="nav-item" v-if="payment.length !== 0">
                                            <router-link class="nav-link" to="/user/my-purchasedbids"><i class="bi bi-people fa-fw me-2"></i>My Purchased Bids</router-link>
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
                <!-- Sidebar END -->

                <!-- Main content START -->
                <div class="col-md-1"></div>
                <div class="col-lg-6 col-xl-6">
                    <!-- Offcanvas menu button -->
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>

                    <div class="vstack gap-4">
                        <div class="card border">
                            <div class="card-header border-bottom d-sm-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-header-title">Update Password</h5>
                                </div>
                                <router-link to="/bids" type="button" class="mb-0 btn btn-sm btn-primary">
                                    Back To Bids
                                </router-link>
                            </div>

                            <!-- Card body START -->
                            <form class="card-body">
                                <!-- Current password -->
                                <div class="row" style="">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email ID<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" ref="email" v-model="password.email" disabled />
                                            <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                                        </div>
                                        <!-- New password -->
                                        <div class="mb-3">
                                            <label class="form-label"> Enter new password</label>
                                            <div class="input-group">
                                                <input
                                                    class="form-control fakepassword"
                                                    placeholder="Enter New password"
                                                    :type="type"
                                                    id="psw-input"
                                                    :class="{ 'is-invalid': errors.new_password }"
                                                    ref="password"
                                                    v-model="password.new_password"
                                                />
                                                <span class="input-group-text p-0 bg-transparent" @click="toggle">
                                                    <i class="fakepasswordicon fas fa-eye p-2" v-if="icon"></i>
                                                    <i class="fakepasswordicon fas fa-eye-slash p-2" v-else></i>
                                                </span>
                                            </div>
											<span v-if="errors.new_password" class="invalid-feedbacks">{{ errors.new_password[0] }}</span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Confirm new password</label>
                                            <div class="input-group">
                                                <input class="form-control fakepassword" placeholder="Enter password" :type="type1" id="psw-input" :class="{ 'is-invalid': errors.confirm_password }" v-model="password.confirm_password" />
                                                <span class="input-group-text p-0 bg-transparent" @click="toggle1">
                                                    <i class="fakepasswordicon fas fa-eye p-2" v-if="icon1"></i>
                                                    <i class="fakepasswordicon fas fa-eye-slash p-2" v-else></i>
                                                </span>
                                            </div>
											<span v-if="errors.confirm_password" class="invalid-feedbacks">{{ errors.confirm_password[0] }}</span>
                                        </div>

                                        <div class="text-end" style="margin-top: 10px !important; margin-bottom: 36px !important;">
                                            <br />
                                            <a href="javascript:void(0)" class="btn btn-primary mb-0 btn-sm" @click.prevent="UpdatePassword()">Change Password</a>
                                            <br />
                                        </div>
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
                    // current_password: "",
                    new_password: "",
                    confirm_password: "",
                },
                errors: [],
                isLoading: false,
                fullPage: true,
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.isLoading = true;

                vm.user.id = vm.$store.getters.user?.id;
                vm.$store
                    .dispatch("post", { uri: "showUser", data: vm.user })
                    .then(function (response) {
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
            });
        },
        mounted() {
            let vm = this;
            if (vm.$store.getters.user) {
                this.getUserSubscriptions();
                this.getuserbids();
            }
        },
        methods: {
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
                        console.log("userpayedbids");
                        console.log(vm.userpayedbids);
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

                // alert(vm.user.id);
                if (vm.buttontogle == 0) {
                    vm.$store
                        .dispatch("post", { uri: "updateUser/" + vm.user.id, data: vm.user })
                        .then(function () {
                            vm.$store.dispatch("setUser", vm.user);
                            vm.$store.dispatch("success", "User Profile Update is successfully ");
                            vm.disabled = true;
                            vm.errors == [];
                            vm.buttontogle = 1;
                        })
                        .catch(function (error) {
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
                vm.password.id = vm.$store.getters.user.id;
                vm.$store
                    .dispatch("post", {
                        uri: "updatePasswordFromProfile/" + vm.password.id,
                        data: vm.password,
                    })
                    .then(function () {
                        vm.$store.dispatch("success", "User Password Updated successfully ");
                        vm.errors == [];
                        vm.disabled == false;
                        vm.$router.push("/login");
                    })
                    .catch(function (error) {
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
    }

    .stripe-1 {
        color: white !important;

        background-image: linear-gradient(45deg, #5f7bed 25%, #3d6f8e 25%, #3d6f8e 50%, #5f7bed 50%, #5f7bed 75%, #3d6f8e 75%, #3d6f8e 100%);
        background-size: 56.57px 56.57px;
        text-align: center !important;
        margin-bottom: 10px;
    }

	.invalid-feedbacks {
		width: 100%;
		margin-top: 0.25rem;
		font-size: 0.875em;
		color: #dc3545;
	}

    .input-group {
        flex-wrap: wrap!important;
    }
</style>
