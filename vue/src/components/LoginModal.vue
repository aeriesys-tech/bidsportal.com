<template>
<loading v-model:active="isLoading"
                 :can-cancel="false"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"/>
    <transition name="fade">
        <transition name="drop-in">
            <div class="">
                <div class="vstack gap-4">
                    <!-- <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center p-0">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h5 class="modal-title" id="exampleModalLabel11">Login</h5>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                        </div>
                    </div> -->
                    <div class="container d-flex px-0 px-sm-4">
            <div class="row justify-content-center align-items-center m-auto">
                <div class="col-12">
                    <div class="bg-mode shadow rounded-3 overflow-hidden">
                        <div class="row g-0">
                           
                            <div class="col-lg-12 order-1">
                                <div class="p-4">
                                    <div class="row gap-8">
                                    
                                    <div class="col-md-5 d-flex text-start">
                                    <router-link to="/">
                                        <img class="h-40px mb-4" src="@/assets/logo.png" alt="logo" />
                                    </router-link>
                                    </div>
                                     <div class="col-md-1 " >  <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" style="float:end" class="btn-close"></button></a></div>
                                    </div>
                                    <h1 class="mb-2 h4">Login Required</h1>
                                    <p class="mb-0">New here?<router-link to="/sign_up"> Create an account</router-link></p>
                                    <form class="mt-4 text-start" autocomplete="off" @submit.prevent="login">
                                        <div class="mb-3">
                                            <label class="form-label">Enter email id</label>
                                            <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" placeholder="Email" ref="email" />
                                            <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Enter password</label>
                                            <input class="form-control" type="password" id="psw-input" :class="{'is-invalid': errors.password}" placeholder="Password" v-model="user.password" />
                                            <span v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</span>
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
                    <!-- <div class="modal-footer pt-3">
                        <button type="button" style="margin:3px" class="btn btn-secondary" @click.prevent="closeModal()" ref="Close">
                            Close
                        </button>
                        <button type="button"  class="btn btn-primary" @click="addAlert()">
                            Save
                        </button>
                    </div> -->
                </div>
            </div>
        </transition>
    </transition>
</template>
<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
export default {
     components: {Loading},
    data(){
        return{
             user:{
                email:'',
                password:'',
            },
            errors:[],
            fullPage: true
        }
    },
   
    methods:{
        closeModal(modal){
            this.$emit("closeModal", modal)
        },
         login() {
            let vm = this;
            vm.isLoading = true;
            // let loader = vm.$loading.show();
            vm.$store.dispatch("auth", { uri:"login", data: vm.user })
            .then(function (response) {
                vm.isLoading = false;
                // loader.hide();
                vm.$store.dispatch('success','Successfuly logged in');
                vm.$store.commit("setUser", response.data.user);
                vm.$store.commit("setToken", response.data.access_token);
               
            //    if(vm.$store.getters.user){
                    vm.$router.push("/bids");
                    vm.$router.go()
            //    }
            //    if(vm.$store.getters.user?.subscription_id === 0){
            //          vm.$router.push("/plans_pricing");
            //    }
                
                vm.closeModal('login_modal');
                
            })
            .catch(function (error) {
                vm.isLoading = false;
                // loader.hide();
                vm.errors = error.response.data.errors;
                vm.$store.dispatch("error", error.response.data.message);
            });
        }
    }
}
</script>
<style scoped>
.fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.5s;
    }
    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
    .drop-in-enter-active,
    .drop-in-leave-active {
        transition: all 0.3s ease-out;
    }
    .drop-in-enter-from,
    .drop-in-leave-to {
        opacity: 0;
        transform: translateY(-50px);
    }
</style>