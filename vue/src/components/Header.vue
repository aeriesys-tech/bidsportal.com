<template>
<div v-if="$store.getters.user !== null && $store.getters.user.status=='pending'" class="alert alert-warning py-2 m-0 bg-primary border-0 rounded-0 alert-dismissible fade show text-center overflow-hidden" role="alert">
 <span  ><p class="text-white m-0">Your email is not confirmed, please check your inbox or<a class="text-white" href="javascript:void(0);" style="font-weight:600;text-decoration: underline;" @click.prevent="resendEmail"> resend email</a></p></span>
 <button type="button" class="btn-close btn-close-white opacity-9 p-3" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <header class="navbar-light header-sticky">
        <nav class="navbar navbar-expand-xl header-shadow">
            <div class="container-fluid">
                <router-link to="/bids/federal-opportunities" class="navbar-brand">
                    <img class="light-mode-item navbar-brand-item" src="@/assets/logo.png" alt="logo" />
                    <img class="dark-mode-item navbar-brand-item" src="@/assets/logo-light.png" alt="logo" />
                </router-link>
                <button class="navbar-toggler ms-auto mx-3 me-md-0 p-0 p-sm-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-animation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <div class="navbar-collapse collapse" id="navbarCollapse">
                    <ul class="navbar-nav navbar-nav-scroll" v-if="!$store.getters.user">
                        <li class="nav-item"><router-link class="nav-link" to="/">Home</router-link></li>
                        <li  class="nav-item"><router-link class="nav-link" to="/bids/state-opportunities">Bid Search</router-link></li>
                        <li class="nav-item"><router-link class="nav-link" to="/subscription_plans">Pricing</router-link></li>
                        <li class="nav-item"><router-link class="nav-link" to="/about_us">About Us</router-link></li>
                       <li class="nav-item"><router-link class="nav-link" to="/contact_us">Contact Us</router-link></li>
                    </ul>
                </div>
                <ul class="navbar-nav nav flex-row align-items-center list-unstyled ms-xl-auto">
                    <!-- <li class="nav-item ms-0 ms-md-3" v-if="verifyPlan()" >
                     <div><a href="javascript:void(0)" @click="checkurlbid()"   class="nav-link" > Upgrade</a></div>
                    </li> -->
                    <li class="nav-item" v-if="$store.getters.header_menu?.show_pricing">
                        <router-link class="nav-link" to="/subscription_plans">Pricing</router-link>
                    </li>
                    <li class="nav-item" v-if="$store.getters.header_menu?.show_upgrade">
                        <router-link class="nav-link" to="/subscription_plans">Upgrade</router-link>
                    </li>
                    <li class="nav-item ms-0 ms-md-3" v-if="$store.getters.header_menu?.show_bidsearch">
                     <div><a href="javascript:void(0)" @click="checkurlprice()"  class="nav-link" > Bid Search</a></div>
                    </li>
                    <li class="nav-item ms-0 ms-md-3">
                        
                        <span class="text-dark  mb-0"><i class="fa-solid fa fa-globe me-1"></i> Call Us: &nbsp;(913) 232-2255</span>
                    </li>
                    <li class="nav-item ms-3 dropdown" v-if="$store.getters.user">
                        <a class="nav-link nav-notification btn btn-light p-0 mb-0" href="javascript:void(0)" @click.prevent="goto_alert()" role="button" >
                            <i   class="bi bi-bell fa-fw fs-5"></i>
                        </a>
                        <span class="notif-badge animation-blink"></span>
                     
                    </li>
                   
                    <li class="nav-item ms-3 dropdown" v-if="$store.getters.user">
                        <a class="avatar avatar-xs p-0" href="javascript:void(0)" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                            <h3 class="avatar-img rounded-circle" style="color:#23cf6b">{{$store.getters.user?.name?.substring(0,1)}}</h3>
                        </a>
                        <ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
                            <li class="px-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                     <h3 class=" rounded-circle ">{{$store.getters.user?.name?.substring(0,1)}}</h3>
                                    </div>
                                    <div>
                                        <a class="h6 mt-2 mt-sm-0" href="javascript:void(0)">{{$store.getters.user?.name}}</a>
                                        <p class="small m-0">{{$store.getters.user?.email}}</p>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider" /></li>
                           
                            <li>
                                <router-link  class="dropdown-item" to="/user/profile"><i class="bi bi-gear fa-fw me-2"></i>Settings</router-link>
                            </li>
                           
                            <li>
                                <a class="dropdown-item bg-danger-soft-hover" href="javascript:void(0)" @click.prevent="logout()"><i class="bi bi-power fa-fw me-2"></i>Sign Out</a>
                            </li>
                        </ul>
                    </li>
                   
                    <li class="nav-item ms-3 d-none d-sm-block" v-if="!$store.getters.user" >
                        <router-link  class="btn btn-sm btn-primary-soft mb-0" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item ms-3 d-none d-sm-block" v-if="!$store.getters.user">
                        <router-link class="btn btn-sm btn-primary-soft mb-0" to="/sign_up">Sign up</router-link>
                    </li>
                    <li class="nav-item ms-3 d-none d-sm-block"  v-if="$store.getters.tender_cart.items">
                        <router-link class="bidlogoicon nav-link hover1" :to="{ path:'/cart' }">
                        <span><img src="assets/images/addcart.svg" width="30"/></span>
                         <span style="padding:5px">{{ $store.getters.tender_cart.items }} Bid(s) - ${{ $store.getters.tender_cart.total }}</span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
     <teleport to="#modals" v-disabled="!alertSubscribe" v-if="alertSubscribe">
        <div class="modal-overlay">
            <div id="popup1" class="confirm" style="background-color:white !important">
                <div class="" >
                        <h1>Alert</h1>
                        <p> Please SUBSCRIBE !</p>
                        <button @click.prevent="closemodal()" style="background-color:white !important">Close</button>
                </div>
            </div>
        </div>
    </teleport>
     <teleport to="#modals" v-disabled="!resendemail" v-if="resendemail">
        <div class="modal-overlay">
            <div id="popup1" class="overlay">
                <div class="popup">
                    <h5 style=" margin-top: 0;color: #333;" class="text-center">Resend Email</h5>
                    <a class="close" @click.prevent="closemodal()" href="javascript:void(0)">&times;</a>
                    <div class="content text-center p-3">
                        <button type="button" @click.prevent="sendConfirmeMail()" class="btn btn-secondary" data-bs-dismiss="modal">Resend</button>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>
<script>
    import moment from 'moment';
export default {
    name:"",
 
    data() {
        return{
            login_url:false,
            alertSubscribe:false,
            currentUrl:'',
            resendemail:false,
            sendmail:{
                id:'',
                email:'',
            },
            user_subscription: null,
            show_pricing: false,
            show_upgrade: false,
            show_bidsearch: false,
            current_page: null,
            tender_pages : ['state_opportunities', 'federal_opportunities', 'private_opportunities', 'international_opportunities']
               
        }
        
    },

    methods:{

        verifyBid(){
            if(this.$store.getters.user && this.$store.getters.page=='plans' )
                return true
            if(this.$store.getters.user && this.$store.getters.page=='normal-payment')
                return true
            if(this.$store.getters.user && this.$store.getters.page=='subscription_payment')
                return true
            if(this.$store.getters.user && this.$store.getters.page=='subscription')
                return true
        },
        checkurlbid(){
            let vm = this;
            vm.$router.push('/plans_pricing')
        },
        checkurlprice(){
            let vm= this;
            vm.$router.push('/bids/state-opportunities')
        },
        logout() {
            let vm = this;
            vm.$store.dispatch('setUser', null)
            vm.$store.dispatch('setToken', null)
            vm.$store.commit("setCartProducts",[])
            localStorage.removeItem("user")
            localStorage.removeItem("token")
            localStorage.removeItem("cartItems")
            localStorage.removeItem("alert")
            localStorage.removeItem("bidsdetails")
            localStorage.removeItem("naicses")
            localStorage.removeItem("psces")
            vm.$router.push("/login")
        },
        checkurl(){
            if(this.$store.getters.user.subscription_id==0){
                this.hidecartstatue=true;
                this.hidepricestatue=false;
            }
        },
   
        checklinks(){
            let vm = this;
            if(vm.$store.getters.user === null  ){
                vm.hidecartstatue = false;
                vm.hidepricestatue = false;
            }
            if(vm.$store.getters?.user?.subscription_id ==0){
                vm.hidecartstatue = false;
                vm.hidepricestatue = true;
            }
            
        },

        goto_alert(){
        
            let vm = this;
            if(vm.$store.getters.user?.subscription_id ==0){           
                    vm.alertSubscribe= true;
                        setTimeout(() => vm.alertSubscribe = false, 5000)
                    }else{
                        vm.$router.push("/bids/save-alert")
            }       
        },
        closemodal() {
            let vm = this;
            vm.alertSubscribe=false;
            vm.resendemail= false;
            vm.errors = [];
        },
        resendEmail(){
                let vm = this;
                vm.resendemail=true;  
        },
        sendConfirmeMail(){
            let vm = this;
            vm.resendemail = false;
            vm.sendmail.id = vm.$store.getters.user?.id;
            vm.sendmail.email = vm.$store.getters.user?.email;
            vm.$store
            .dispatch("post", { uri: "resend_email", data: vm.sendmail })
            .then(function () {
                vm.$store.dispatch("success", "Confirmation link resent to your registered email address");
            })
            .catch(function (error) {
                vm.errors = error.response.data.errors;
                vm.$store.dispatch("error", error.response.data.message);
            });
        }
    },
    computed: {
        subTotal: function () {
            return this.$store.getters.cartItems
            .reduce((prev, cur) => +prev + +cur.tdr_doc_fees, 0)
            .toFixed(2);
        },
    }
}
</script>
<style scoped>
.header-shadow{
box-shadow: 0px 5px 8px -5px;
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
 .popup {
        position: fixed;
        padding: 10px;
        width: 350px;
        max-width: 500px;
        border-radius: 10px;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.5s ease-in-out;
        transition: background 0.3s ease-in;
        background: white;
        opacity: 100;
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
    
    @keyframes fade {
  from {
    opacity: 1;
    transform: translate(-50%, -50%) scale(0.8);
  }
  to {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
  }
}
.confirm {
  position:fixed;
  /* top: 50%;
  left: 50%; */
    top: 20%;
    left: 50%;
  transform: translate(-50%, -50%);
  width: 80%;
  min-width: 280px;
  max-width: 500px;
  height: auto;
  background: #f5f2f2;
  border-radius: 10px;
  padding: 0;
  margin: 0;
  border-top: 1px solid white;
  animation: fade 0.3s ease 1 forwards;
  z-index: 99999;
}
.confirm h1 {
  text-align: left;
  font-size: 1.2rem;
  margin: 1.5rem 1rem 0.5rem;
}
.confirm p {
  text-align: center;
  font-size: 1rem;
  margin: 0 2rem 4.5rem;
  color:red
}
.confirm button {
  /* background: transparent; */
  border: none;
  color: #1678E5;
  height: 3rem;
  font-size: 1rem;
  width: 100%;
  position: absolute;
  bottom: 0;
  cursor: pointer;
}
.confirm button:nth-of-type(1) {
  border-top: 1px solid #B4B4B4;
  border-right: 1px solid #B4B4B4;
  left: 0;
  border-radius: 0 0 0 10px;
}
.confirm button:nth-of-type(2) {
  border-top: 1px solid #B4B4B4;
  right: 0;
  border-radius: 0 0 10px 0;
}
.confirm button:focus,
.confirm button:hover {
  font-weight: bold;
  background: #EFEFEF;
}
.confirm button:active {
  background: #D6D6D6;
}

</style>