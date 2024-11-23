<template>
    <div class="page-sign d-block py-0">
        <div class="row g-0">
            <div class="col-md-7 col-lg-5 col-xl-4 col-wrapper">
                <div class="card card-sign">
                    <div class="card-header">
                        <div class="text-center">
                            <img src="../../assets/bidsportal_logo.png" class="img" width="100" />
                        </div>
                        <div class="text-center">
                            <a href="#" class="text-center header-logo mb-3 mt-2">PMS & BATS</a>
                        </div>
                        <h3 class="card-title">Sign In</h3>
                        <p class="card-text">Welcome back! Please signin to continue.</p>
                    </div>
                    <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label">Email address</label>
                                <input type="text" class="form-control" placeholder="Enter your email address"
                                    :class="{ 'is-invalid': errors.email }" v-model="user.email" ref="email" />
                                <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                            </div>
                            <div class="mb-4" v-show="otp_field">
                                <label class="form-label d-flex justify-content-between">OTP
                                        <a href="javascript:void(0)" @click="regenerateOtp()">Regenerate OTP?</a>
                                </label>
                                        
                                <!-- <input type="password" class="form-control" placeholder="Enter your password"
                                    :class="{ 'is-invalid': errors.password }" v-model="user.password" />  -->
                                <input type="password" class="form-control" placeholder="Enter OTP"
                                    :class="{ 'is-invalid': errors.otp }" v-model="user.otp" />
                                <span v-if="errors.otp" class="invalid-feedback">{{ errors.otp[0] }}</span>
                                <button class="btn btn-primary btn-sign mt-3" @click="otpLogin()">Sign In</button>
                            </div>
                            <button v-show="!otp_field" class="btn btn-primary btn-sign" @click="generateOtp()">Verify</button>
                    </div>
                </div>
            </div>
            <div class="col d-none d-lg-block"><img src="assets/img/bg1.jpg" class="auth-img" alt="" /></div>
        </div>
    </div>
</template>
<script>
export default {
    name: "Login",
    data() {
        return {
            user: {
                email: "shraddha.thakur@adityabirla.com",
                // password: "1qaz2wsx",
                otp: "",
                regenerate_otp: false
            },
            errors: [],
            otp_field: false
        };
    },
    mounted() {
        this.$refs.email.focus();
    },
    methods: {
        login() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("auth", { uri: "login", data: vm.user })
                .then(function (response) {
                    loader.hide();
                    vm.$store.dispatch("setUser", response.data.user);
                    vm.$store.dispatch("setToken", response.data.token);
                    vm.getPermissions();
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        
        otpLogin() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("auth", { uri: "verifyOtp", data: vm.user })
                .then(function (response) {
                    loader.hide();
                    vm.$store.dispatch("setUser", response.data.user);
                    vm.$store.dispatch("setToken", response.data.token);
                    vm.getPermissions();
                })
                .catch(function (error) {
                    console.log(error.response.data.errors);
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getPermissions() {
            let vm = this;
            let uri = {
                uri: 'getPermissions',
                data: {
                    role_id: this.$store.getters.user.role_id
                }
            };
            let loader = vm.$loading.show();
            this.$store.dispatch('post', uri)
            .then(response => {
                loader.hide();
                console.log('permissions', response.data);
                vm.$store.dispatch('setPermissions', response.data);
                if(vm.$store.getters.user.user_type=='BATS') {
                    vm.$router.push("/dashboard/bats");
                }else if(vm.$store.getters.user.user_id == 18){
                    vm.$router.push("/projects");
                }
                else {
                    vm.$router.push("/project_dashboard");
                }
            })
            .catch(error => {
                loader.hide();
                vm.errors = error.response.data.errors;
                vm.$store.dispatch("error", error.response.data.message);
            })
        },

        generateOtp(){
            let vm = this;
            let loader = this.$loading.show();
            this.$store.dispatch('post',{uri:'generateOtp',data:this.user})
            .then(response => {
                console.log(response);
                loader.hide();
                this.otp_field = true;
                this.$store.dispatch('success',response.data.message);                
            })
            .catch(error => {
                loader.hide();
                vm.errors = error.response.data.errors;
                vm.$store.dispatch("error", error.response.data.message);
            })
        },

        regenerateOtp(){
            this.user.regenerate_otp = true;
            this.generateOtp();
        }
    },
};
</script>
