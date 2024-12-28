<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :on-cancel="onCancel" :is-full-page="fullPage" />

    <section class="pt-3" style="padding-bottom: 77px;">
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
                                <h5 class="card-header-title">Account details</h5>
                            </div>
                        </div>
                        <form class="card-body">
                            <div class="row" style="">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email ID<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" ref="email" v-model="user.email" disabled />
                                        <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Current password</label>
                                        <div class="input-group">
                                            <input class="form-control fakepassword" placeholder="Current password" :type="current_password_type" :class="{ 'is-invalid': errors.current_password }" v-model="password.current_password" />
                                            <span class="input-group-text p-0 bg-transparent" @click="togglePassword('current_password_type', 'current_password_icon')">
                                                <i class="fakepasswordicon fas fa-eye p-2" v-if="current_password_icon"></i>
                                                <i class="fakepasswordicon fas fa-eye-slash p-2" v-else></i>
                                            </span>
                                        </div>
                                        <span v-if="errors.current_password" class="invalid-feedbacks">{{ errors.current_password[0] }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"> Enter new password</label>
                                        <div class="input-group">
                                            <input class="form-control fakepassword" placeholder="Enter New password" :type="new_password_type" :class="{ 'is-invalid': errors.new_password }" ref="password" v-model="password.new_password" />
                                            <span class="input-group-text p-0 bg-transparent" @click="togglePassword('new_password_type', 'new_password_icon')">
                                                <i class="fakepasswordicon fas fa-eye p-2" v-if="new_password_icon"></i>
                                                <i class="fakepasswordicon fas fa-eye-slash p-2" v-else></i>
                                            </span>
                                        </div>
                                        <span v-if="errors.new_password" class="invalid-feedbacks">{{ errors.new_password[0] }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm new password</label>
                                        <div class="input-group">
                                            <input
                                                class="form-control fakepassword"
                                                placeholder="Retype password"
                                                :type="confirm_password_type"
                                                :class="{ 'is-invalid': errors.new_password_confirmation }"
                                                v-model="password.new_password_confirmation"
                                            />
                                            <span class="input-group-text p-0 bg-transparent" @click="togglePassword('confirm_password_type', 'confirm_password_icon')">
                                                <i class="fakepasswordicon fas fa-eye p-2" v-if="confirm_password_icon"></i>
                                                <i class="fakepasswordicon fas fa-eye-slash p-2" v-else></i>
                                            </span>
                                        </div>
                                        <span v-if="errors.new_password_confirmation" class="invalid-feedbacks">{{ errors.new_password_confirmation[0] }}</span>
                                    </div>

                                    <div class="text-end" style="margin-top: 10px !important; margin-bottom: 36px !important;">
                                        <br />
                                        <a href="javascript:void(0)" class="btn btn-primary mb-0 btn-sm" @click.prevent="changePassword()">Change Password</a>
                                        <br />
                                    </div>
                                </div>
                            </div>
                        </form>
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
                    email: "",
                    current_password: "",
                    new_password: "",
                    new_password_confirmation: "",
                },
                errors: [],
                isLoading: false,
                fullPage: true,
                current_password_type: "password",
                new_password_type: "password",
                confirm_password_type: "password",
                current_password_icon: false,
                new_password_icon: false,
                confirm_password_icon: false,
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.user = vm.$store.getters.user;
                // vm.$store
                //     .dispatch("post", { uri: "showUser", data: vm.user })
                //     .then(function (response) {
                //         vm.isLoading = false;
                //         vm.user = response.data.data;
                //         vm.password.email = vm.user.email;
                //         vm.password.user_id = vm.user.user_id;
                //         vm.regSetAside = vm.user.socioeconomic_status.split(",");
                //     })
                //     .catch(function (error) {
                //         vm.isLoading = false;
                //         vm.errors = error.response.data.errors;
                //         vm.$store.dispatch("error", error.response.data.message);
                //     });
            });
        },
        mounted() {
            let vm = this;
            if (vm.$store.getters.user) {
                // this.getUserSubscriptions();
                // this.getuserbids();
            }
        },
        methods: {
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
            changePassword() {
                let vm = this;
                vm.password.email = vm.user.email;
                vm.password.user_id = vm.user.user_id;
                vm.$store
                    .dispatch("post", {
                        uri: "changePassword",
                        data: vm.password,
                    })
                    .then(function () {
                        vm.$store.dispatch("success", "User Password Updated successfully ");
                        vm.errors == [];
                        vm.disabled == false;
                        vm.$store.dispatch("setUser", null);
                        vm.$store.dispatch("setToken", null);
                        vm.$store.commit("setCartProducts", []);
                        localStorage.removeItem("user");
                        localStorage.removeItem("token");
                        localStorage.removeItem("cartItems");
                        localStorage.removeItem("alert");
                        localStorage.removeItem("bidsdetails");
                        localStorage.removeItem("naicses");
                        localStorage.removeItem("psces");
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

            togglePassword(field, icon) {
                if (this[field] == "password") {
                    this[field] = "text";
                    this[icon] = true;
                } else {
                    this[field] = "password";
                    this[icon] = false;
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
        flex-wrap: wrap !important;
    }
</style>
