<template>
<loading v-model:active="isLoading"
                 :can-cancel="false"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"/>
    <section>
        <div class="container h-100 d-flex px-0 px-sm-4">
            <div class="row justify-content-center align-items-center m-auto">
                <div class="col-12">
                    <div class="bg-mode shadow rounded-3 overflow-hidden">
                        <div class="row g-0">
                            <!-- Vector Image -->
                            <div class="col-lg-6 d-flex align-items-center order-2 order-lg-1">
                                <div class="p-3 p-lg-5">
                                    <img src="assets/images/element/forgot-pass.svg" alt="" />
                                </div>
                                <!-- Divider -->
                                <div class="vr opacity-1 d-none d-lg-block"></div>
                            </div>

                            <!-- Information -->
                            <div class="col-lg-6 order-1">
                                <div class="p-4 p-sm-7">
                                    <!-- Logo -->
                                     <div v-if="status==1">
                                        <a href="#">
                                            <img class="mb-4 h-50px" src="@/assets/logo.png" alt="logo" />
                                        </a>
                                        <!-- Title -->
                                        <h1 class="mb-2 h3">Please check your INBOX!</h1>
                                        <p class="mb-sm-0">We have sent a email with instructions to reset your Password</p>
                                     </div>
                                    <div v-if="status==0">
                                        <a href="#">
                                            <img class="mb-4 h-50px" src="@/assets/logo.png" alt="logo" />
                                        </a>
                                        <!-- Title -->
                                        <h1 class="mb-2 h3">Forgot password?</h1>
                                        <p class="mb-sm-0">Enter the email address associated with an account.</p>
                                     </div>
                                    <!-- Form START -->
                                    <form class="mt-sm-4 text-start" @submit.prevent="forgotPassword">
                                        <!-- Email -->
                                        <div v-if="status==0">
                                        <div class="mb-3">
                                            <label class="form-label">Enter Email</label>
                                            <input type="email" placeholder="Enter Email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" ref="email" />
                                            <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                                        </div>

                                        <div class="mb-3 text-center">
                                            <p>Back to <router-link to="/login">Sign in</router-link></p>
                                        </div>
                                        </div>
                                        <!-- Button -->
                                        <div class="d-grid"  v-if="status==0"><button type="submit" class="btn btn-primary">Submit</button></div>
                                         <div class="d-grid"  v-if="status==1"><button type="button" @click="resetPassword" class="btn btn-primary">Resend Link</button></div>
                                    </form>
                                    <!-- Form END -->
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
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
    export default {
        components:{Loading},
        data() {
            return {
                user: {
                    email: "",
                    // password:'',
                    // fp_code:'',
                    // confirm_password:''
                },
                status: 0,
                loginstatus: 0,
                errors: [],
            isLoading: false,
            fullPage:true
            };
        },
        methods: {
            forgotPassword() {
                let vm = this;
                vm.isLoading= true;
                // let loader = vm.$loading.show();
                vm.$store
                    .dispatch("auth", { uri: "forgotPassword", data: vm.user })
                    .then(function () {
                         vm.isLoading= false;
                        // loader.hide();
                        vm.$store.dispatch("success", "New Password has been emailed to you.");
                        // vm.$router.push('/login');
                        vm.status = true;
                        vm.errors = [];
                    })
                    .catch(function (error) {
                         vm.isLoading= false;
                        // loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            resetPassword() {
                this.status = 0;
            },

            // resetPassword(){

            //     let vm = this;
            //     let loader = vm.$loading.show();
            //     vm.$store.dispatch('auth',{'uri':'resetPassword','data':vm.user})
            //     .then(function () {
            //         loader.hide();
            //         vm.$store.dispatch('success','Password has been Reset to you, Please check .');
            //       vm.$router.push('/login');
            //       //  vm.status=true;
            //     })
            //     .catch(function (error) {
            //         loader.hide();
            //         vm.errors = error.response.data.errors;
            //         vm.$store.dispatch('error',error.response.data.message);
            //     });

            // }
        },
    };
</script>

<style scoped>
  img {
    max-width: 100%;
    height: auto;
}</style>
