<template>

<div v-if="$store.getters.user !== null && $store.getters.user.status=='pending'" class="alert alert-warning py-2 m-0 bg-primary border-0 rounded-0 alert-dismissible fade show text-center overflow-hidden" role="alert">
 <span  ><p class="text-white m-0">Your email is not confirmed, please check your inbox or<a class="text-white" href="javascript:void(0);"> resend email</a></p></span>
 <button type="button" class="btn-close btn-close-white opacity-9 p-3" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <!-- Header START -->
    <header class="navbar-light header-sticky">
        <!-- Logo Nav START -->
        <nav class="navbar navbar-expand-xl header-shadow">
            <div class="container-fluid">
                <!-- Logo START -->
                <router-link to="/" class="navbar-brand">
                    <img class="light-mode-item navbar-brand-item" src="@/assets/logo.png" alt="logo" />
                    <img class="dark-mode-item navbar-brand-item" src="@/assets/logo-light.png" alt="logo" />
                </router-link>
                <!-- Logo END -->
                <!-- Responsive navbar toggler -->
                <button class="navbar-toggler ms-auto mx-3 me-md-0 p-0 p-sm-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-animation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- Main navbar START -->
                <div class="navbar-collapse collapse" id="navbarCollapse">
                    <ul class="navbar-nav navbar-nav-scroll">
                        <li v-if="$store.getters.user === null" class="nav-item"><router-link class="nav-link" to="/">Home</router-link></li>
                        <li v-if="$store.getters.user === null"  class="nav-item"><router-link class="nav-link" to="/bids">Bid Search</router-link></li>
                        <li v-if="$store.getters.user === null" class="nav-item"><router-link class="nav-link" to="/plans_pricing">Plans & Pricing</router-link></li>
                        <li v-if="$store.getters.user === null" class="nav-item"><router-link class="nav-link" to="/about_us">About Us</router-link></li>
                       <!-- Nav item Pages -->
                        <li class="nav-item dropdown" v-if="$store.getters.user === null">
                            <a class="nav-link dropdown-toggle" href="#" id="pagesMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contact Us</a>
                            <ul class="dropdown-menu" aria-labelledby="pagesMenu">
                                <li><router-link class="dropdown-item" to="/contact_us">Contact </router-link></li>
                                 <li><router-link class="dropdown-item" to="/feedback">Feedback</router-link></li>
                           </ul>
                        </li>
                        <li v-if="$store.getters.user === null" class="nav-item"><router-link class="nav-link" to="/faq">FAQs</router-link></li>
                    </ul>
                </div>
                <!-- Main navbar END -->

                <!-- Profile and Notification START -->
                <ul class="navbar-nav nav flex-row align-items-center list-unstyled ms-xl-auto">
                     <!-- <li class="nav-item ms-0 ms-md-3" v-if="$store.getters.user?.subscription_id !== 0 || $store.getters.user?.length !==null" >
                        <router-link class="nav-link btn-sm btn btn-light p-2 mb-0" role="button" to="/bids"><i class="fa-solid fa fa-globe me-2"></i>Bids</router-link>
                    </li> -->
               
                    <li class="nav-item ms-0 ms-md-3" >
                     <div v-if="hidecartstatue"><a  href="javascript:void(0)" @click="checkurlbid()"   class="nav-link" >{{urlstring}} Plans & Pricing</a></div>
                    </li>
                    <li class="nav-item ms-0 ms-md-3" >
                     <div v-if="hidepricestatue"><a href="javascript:void(0)" @click="checkurlprice()"  class="nav-link" >{{urlstring}} Bid Search</a></div>
                    </li>
                    <li class="nav-item ms-0 ms-md-3">
                        <a class="nav-link btn-sm btn btn-light p-2 mb-0" role="button" href="javascript:void(0)"><i class="fa-solid fa fa-globe me-2"></i>Call Us:512-487-7757</a>
                    </li>

                    <!-- Notification dropdown START -->
                    <li class="nav-item ms-3 dropdown" v-if="$store.getters.user">
                        <!-- Notification button -->
                        <a class="nav-link nav-notification btn btn-light p-0 mb-0" href="javascript:void(0)" @click.prevent="goto_alert()" role="button" >
                            <i   class="bi bi-bell fa-fw fs-5"></i>
                        </a>
                        <!-- Notification dote -->
                        <span class="notif-badge animation-blink"></span>
                     
                    </li>
                   
                    <li class="nav-item ms-3 dropdown" v-if="$store.getters.user">
                        <!-- Avatar -->
                        <a class="avatar avatar-xs p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar" /> -->
                            <h3 class="avatar-img rounded-circle" style="color:#23cf6b">{{(0,1)}}</h3>
                        </a>

                        <!-- Profile dropdown START -->
                        <ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
                            <!-- Profile info -->
                            <li class="px-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                    <div class="avatar me-3">
                                        <!-- <img class="avatar-img rounded-circle shadow" src="assets/images/avatar/01.jpg" alt="avatar" /> -->
                                     <h3 class=" rounded-circle ">{{$store.getters.user?.name?.substring(0,1)}}</h3>
                                    </div>
                                    <div>
                                        <a class="h6 mt-2 mt-sm-0" href="javascript:void(0)">{{$store.getters.user?.name}}</a>
                                        <p class="small m-0">{{$store.getters.user?.email}}</p>
                                    </div>
                                </div>
                            </li>

                            <!-- Links -->
                            <li><hr class="dropdown-divider" /></li>
                           
                            <li>
                                <router-link class="dropdown-item" to="/user/profile"><i class="bi bi-gear fa-fw me-2"></i>Settings</router-link>
                            </li>
                           
                            <li>
                                <a class="dropdown-item bg-danger-soft-hover" href="javascript:void(0)" @click.prevent="logout()"><i class="bi bi-power fa-fw me-2"></i>Sign Out</a>
                            </li>
                           
                         
                        </ul>
                        <!-- Profile dropdown END -->
                    </li>
                   
                    <li class="nav-item ms-3 d-none d-sm-block" v-if="!$store.getters.user" >
                        <router-link class="btn btn-sm btn-primary-soft mb-0" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item ms-3 d-none d-sm-block" v-if="!$store.getters.user">
                        <router-link class="btn btn-sm btn-primary-soft mb-0" to="/sign_up">Sign up</router-link>
                    </li>
                    <!-- <li class="nav-item ms-3 d-none d-sm-block">
                      <button class="btn btn-xs btn-light mb-0 flex-shrink-0"><img class="avatar avatar-xs img1" src="../assets/icons/addcart.svg"></button>
                    </li> -->
                    <li class="nav-item ms-3 d-none d-sm-block"  v-if="$store.getters.cartItems.length !==0">
                        <router-link class="bidlogoicon nav-link hover1" :to="{ path:'/cart' }">
                        <span><img src="assets/images/addcart.svg" width="30"/></span>
                         <span style="padding:5px">{{ $store.getters.cartItems.length }} Bid(s) - ${{ subTotal }}</span>
                        </router-link>
                    </li>
                     
                </ul>
                <!-- Profile and Notification START -->
            </div>
        </nav>
        <!-- Logo Nav END -->
    </header>
    <!-- Header END -->
     <teleport to="#modals" v-disabled="!alertSubscribe" v-if="alertSubscribe">
        <div class="modal-overlay">
            <div id="popup1" class="confirm">
                <div class="">
                        <h1>Alert</h1>
                        <p> Please SUBSCRIBE !</p>
                        <button @click.prevent="closemodal()">Close</button>
                        <!-- <button autofocus>Confirm</button> -->
                        </div>
                <!-- <a href="#" @click.prevent="closemodal()" class="close remunderline">&times;</a>
             

                <div style="text-center: center;">
                    <h6 style="text-align: center; color: red !important; margin-top: 15px;">
                        Please Subscribe!
                    </h6>
                </div> -->
            </div>
        </div>
    </teleport>
</template>
<script>
export default {
    name:"",
    data() {
        return{
                alertSubscribe:false,
                checkurl:false,
                hidecartstatue:false,
                hidepricestatue:false,
                url_link:""
               
        }
        
    },
    
    mounted(){
      this.checklinks()
      
    
    },
    methods:{
       
    logout() {
      let vm = this;
       vm.$store.dispatch('setUser', null);
       vm.$store.dispatch('setToken', null);
       vm.$store.commit("setCartProducts",[]);
        vm.checklinks()
    
       vm.$router.push("/bids");
    //    vm.$router.go(0)
    },
    checkurlbid(){

                let vm = this;
                if (vm.$store.getters.user?.subscription_id === 0 || vm.$store.getters.user === null) {
                    vm.hidecartstatue = false;
                    vm.hidepricestatue = true;
                    vm.$router.push('/plans_pricing')
                 } 
      
    },
    checkurlprice(){
         this.url_link =  window.location.href
            const pieces = this.url_link.split(/[\s/]+/)
            const last = pieces[pieces.length - 1]
            
          if(this.url_link !== 'bids'){
            this.hidecartstatue = true;
            this.hidepricestatue = false;
         }
        let vm = this;
                if (vm.$store.getters.user?.subscription_id === 0 || vm.$store.getters.user === null ) {
                    vm.hidecartstatue = true;
                    vm.hidepricestatue = false;
                   vm.$router.push('/bids')
                } 
                
    },
    checklinks(){
        let vm = this;
         vm.url_link =  window.location.href
            const pieces = vm.url_link.split(/[\s/]+/)
            const last = pieces[pieces.length - 1]
          
        if(vm.$store.getters.user === null  ){
            vm.hidecartstatue = false;
            vm.hidepricestatue = false;
        }else{

              if(vm.$store.getters.user?.subscription_id ===0 ){
                vm.hidecartstatue = true;
                vm.hidepricestatue = false;
            }
           
            if(last === 'plans_pricing'){
                this.hidecartstatue = false;
                this.hidepricestatue = true;
                }
        

        }
          
    },
    goto_alert(){
     
        let vm = this;
        if(vm.$store.getters.user.subscription_id ==0){
           
                   vm.alertSubscribe= true;
                       setTimeout(() => vm.alertSubscribe = false, 5000)
                }else{
                    vm.$router.push("/bids/save-alert")
         }       
    },
    closemodal() {
                let vm = this;
                   vm.alertSubscribe=false;
                   vm.errors = [];
            },
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
        background: rgba(255, 255, 255, 0.9);
        opacity: 100;
        transition: opacity 0.5s, visibility 0s linear 0.5s;
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