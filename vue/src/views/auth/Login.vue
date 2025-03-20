<template>
<div>
    <loading v-model="isLoading"
                 :can-cancel="false"
                 :is-full-page="fullPage"/>
    <section>
        <div class="container h-100 d-flex px-0 px-sm-4">
            <div class="row justify-content-center align-items-center m-auto">
                <div class="col-12">
                    <div class="bg-mode shadow rounded-3 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 d-flex align-items-center order-2 order-lg-1">
                                <div class="p-3 p-lg-5">
                                    <img src="assets/images/element/signin.png" alt="" />
                                </div>
                                <div class="vr opacity-1 d-none d-lg-block"></div>
                            </div>
                            <div class="col-lg-6 order-1">
                                <div class="p-4 p-sm-7">
                                    <a href="index.html">
                                        <img class="h-50px mb-4" src="@/assets/logo.png" alt="logo" />
                                    </a>
                                    <h1 class="mb-2 h3">Welcome back</h1>
                                    <p class="mb-0">New here?<router-link to="/sign_up"> Create an account</router-link></p>
                                    <form class="mt-4 text-start"  @submit.prevent="login">
                                        <div class="mb-3">
                                            <label class="form-label">Enter Email</label>
                                            <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" placeholder="Enter Email" ref="email" />
                                            <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                                        </div>
                                         <div class="mb-3">
                                                <label class="form-label"> Enter Password</label>
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
                                      
                                        <div class="mb-3 d-sm-flex justify-content-between">
                                            <div>
                                                <input type="checkbox" class="form-check-input me-2" id="rememberCheck" />
                                                <label class="form-check-label" for="rememberCheck"> Remember me?</label>
                                            </div>
                                            <router-link to="/forgot_password">Forgot password?</router-link>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary w-100 mb-0">Login</button>
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
</div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import moment from 'moment';

export default {
    components:{Loading},
    data() {
        return {
             type: "password",
                icon: false,
            user:{
                email:'',
                password:'',
            },
            errors:[],
            isLoading: false,
            fullPage:true
        }
    },
    mounted(){
        // this.$router.go()
       
    },
    methods:{
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
        
        login() {
            let vm = this;
            vm.isLoading=true
            vm.$store.dispatch("auth", { uri:"login", data: vm.user })
            .then(function (response) {
                vm.isLoading=false
                let user = response.data.user
                vm.$store.dispatch('success','Successfully logged in');
                vm.$store.commit("setUser", response.data.user);
                vm.$store.commit("setToken", response.data.access_token);
                localStorage.setItem("login_date_time", moment());
                vm.$router.push("/bids/state-opportunities")
            })
            .catch(function (error) {
                console.log(error)
                vm.isLoading=false
                vm.errors = error.response.data.errors;
                vm.$store.dispatch("error", error.response.data.message);
               
            });
        }
    }
}
</script>
<style scoped>
    .errorclass{
        border-color: #dc3545; }

    img {
    max-width: 100%;
    height: auto;
}
</style>
