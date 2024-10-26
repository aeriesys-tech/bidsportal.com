<template>
 <loading v-model:active="isLoading"
                 :can-cancel="false"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"/>
    <section class="">
        <div class="container h-100 d-flex px-0 px-sm-4">
            <div class="row justify-content-center align-items-center m-auto">
                <div class="col-12">
                    <div class="bg-mode shadow rounded-3 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 d-flex align-items-center order-2 order-lg-1">
                                <div class="p-3 p-lg-5">
                                    <img src="assets/images/element/forgot-pass.svg" alt="" />
                                </div>
                                <!-- Divider -->
                                <div class="vr opacity-1 d-none d-lg-block"></div>
                            </div>
                            <div class="col-lg-6 order-1">
                                <div class="p-4 p-sm-7">
                                    <a href="#">
                                        <img class="h-50px mb-4" src="@/assets/logo.png" alt="logo" />
                                    </a>
                                    <h1 class="mb-2 h3">Reset Password</h1>
                                    <p class="mb-0">New here?<router-link to="/sign_up"> Create an account</router-link></p>
                                    <h5 style="color:#dc3545"> <span v-if="errors.code" >{{ errors.code[0] }}</span> </h5>
                                    <form class="mt-4 text-start" autocomplete="off" @submit.prevent="resetpassword">
                                       
                                         <div class="mb-3">
                                                <label class="form-label"> New Password</label>
                                                <div class="input-group">
                                                    <input class="form-control fakepassword"  placeholder="Enter password"  :type="type" id="psw-input" :class="{'is-invalid': errors.password}" v-model="user.password" ref="new_password" />
                                                    <span class="input-group-text p-0 bg-transparent" @click="toggle">
                                                         <i class="fakepasswordicon fas fa-eye  p-2" v-if="icon"></i>
                                                        <i class="fakepasswordicon fas fa-eye-slash  p-2" v-else></i>
                                                        <!-- <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i> -->
                                                    </span>
                                                     <!-- <span v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</span> -->
                                                </div>
                                                 <span v-if="errors.password" style="color:#dc3545; margin-top:5px;font-size:0.875em">{{ errors.password[0] }}</span>
                                              
                                            </div>
                                      <div class="mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <div class="input-group">
                                                    <input class="form-control fakepassword"  placeholder="Enter password"  :type="type1" id="psw-input" :class="{'is-invalid': errors.confirm_password}" v-model="user.confirm_password" ref="confirm_password"/>
                                                    <span class="input-group-text p-0 bg-transparent" @click="toggle1">
                                                         <i class="fakepasswordicon fas fa-eye  p-2" v-if="icon1"></i>
                                                        <i class="fakepasswordicon fas fa-eye-slash  p-2" v-else></i>
                                                        <!-- <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i> -->
                                                    </span>
                                                    <!-- <span v-if="errors.confirm_password" class="invalid-feedback">{{ errors.confirm_password[0] }}</span> -->
                                                </div>
                                                  <span v-if="errors.confirm_password" style="color:#dc3545; margin-top:5px;font-size:0.875em">{{ errors.confirm_password[0] }}</span>
                                            </div>
                                        
                                        <div>
                                            <button type="submit" class="btn btn-primary w-100 mb-0">Reset</button>
                                        </div>
                                    </form>
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
                type: "password",
                icon: false,
                 type1: "password",
                icon1: false,
            
           user:{
                    fp_code:'',
                    password:'',
                    confirm_password:'',
                    email:''
                },
              
                user_id:'',
                status:0,
                errors:[],
                 isLoading: false,
                 fullPage:true
        }
    },
    methods:{
         toggle() {
                let vm = this;
                // vm.type="text";
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
                // vm.type="text";
                if (vm.type1 == "password") {
                    vm.type1 = "text";
                    vm.icon1 = true;
                } else {
                    vm.type1 = "password";
                    vm.icon1 = false;
                }
            },
         resetpassword() {
              //alert("hi");
                let vm = this;
                vm.isLoading= true
                // let loader = vm.$loading.show();
                vm.user.fp_code =  vm.$route.params.fp_code;
                vm.user.email = vm.$route.params.email;
                //vm.user_id = vm.$store.getters.user.user_id;
                let uri = {'uri':'resetPassword', data:vm.user};
                vm.$store.dispatch('post',uri)
                .then(function () {
                    vm.isLoading= false
                    // loader.hide();
                    vm.$store.dispatch('success','Password is successfully Reset');
                    vm.$router.push('/login');
                })
                .catch(function (error) {
                    vm.isLoading= false
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch('error',error.response.data.message);
                });
            },
    }
}
</script>
<style scoped>
  img {
    max-width: 100%;
    height: auto;
}</style>