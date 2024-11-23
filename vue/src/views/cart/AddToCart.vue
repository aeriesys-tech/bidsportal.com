<template>
<loading v-model:active="isLoading"
                 :can-cancel="false"
                  :z-index="10001"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"/>
    <section class="pt-4">
        <div class="container-fluid" data-sticky-container="">
            <div class="row g-4">
                <!-- Main content START -->
                <div class="col-xl-8">
                    <div class="vstack gap-5">
                       
                        <div class="card border p-4">
                            <!-- Card header -->
                            <div class="card-header border-bottom p-0 pb-1">
                                <h5 class="card-title mb-0">Your Cart</h5>
                            </div>
                                    <!-- test 1 -->
                                <div class="card-body" style="padding:0px" v-if="!cart_items.length" >
                                <!-- Table head -->
                                <div class="p-3 d-none d-sm-block" >
                                      <div class="text-center">
                                    <!-- Item -->
                                    <h6 class="d-inline-block mb-0 py-2 px-4"> Cart Is Empty</h6>
                                    <!-- Item -->
                                <!-- <small class="d-block">    Your Cart contents are stored here for 30+ days so you can return anytime.</small> -->
                                <hr/>
                                </div>
                                </div>

                                <!-- Table data -->
                               </div>
                            <!-- Card body START -->
                            <div class="card-body" v-else>
                                <!-- Table head -->
                                <div class="bg-light rounded p-3 d-none d-sm-block">
                                    <div class="row row-cols-7 g-4">
                                        <div class="col"><h6 class="fw-normal mb-0">Item</h6></div>
                                        <div class="col-4"><h6 class="fw-normal mb-0">Title</h6></div>
                                        <div class="col"><h6 class="fw-normal mb-0">Price</h6></div>
                                        <div class="col"><h6 class="fw-normal mb-0">Quantity</h6></div>
                                        <div class="col"><h6 class="fw-normal mb-0">Subtotal</h6></div>
                                        <div class="col"><h6 class="fw-normal mb-0">Action</h6></div>
                                    </div>
                                </div>

                                <!-- Table data -->
                                 <div class="row row-cols-xl-7 g-4 align-items-sm-center border-bottom px-2 py-2" v-for="(cart_item, key) in cart_items" :key="key">
                                    <!-- Data item -->
                                    <div class="col">
                                        <div class="avatar avatar-sm">
                                            <img class="avatar-img" src="/assets/icons/document-search.png" alt="avatar" />
                                        </div>
                                    </div>

                                    <!-- Data item -->
                                    <div class="col-4" v-if="cart_item.federal_tender_id">
                                        <small class="d-block"> {{cart_item.federal_tender?.title }}</small>
                                        <div class="d-flex">
                                            <small class="me-1">Posted Date:</small>
                                            <small class="mb-0 text-primary">{{ format_date(cart_item.federal_tender?.posted_date) }}</small>
                                        </div>
                                    </div>

                                    <!-- Data item -->
                                    <div class="col" v-if="cart_item.federal_tender_id">
                                        <small class="d-block d-sm-none">Status:</small>
                                        <div class="">${{cart_item.federal_tender.fees }}</div>
                                    </div>
                                    <!-- Data item -->
                                    <div class="col">
                                        <small class="d-block d-sm-none">Status:</small>
                                        <div class="">1</div>
                                    </div>

                                    <!-- Data item -->
                                    <div class="col">
                                        <small class="d-block d-sm-none">Status:</small>
                                        <div class="">${{cart_item.federal_tender?.fees }}</div>
                                       
                                    </div>
                                    <!-- Data item -->
                                    <div class="col">
                                        <a href="javascript:void(0)" @click="removeCart(cart_item)" class="btn btn-light btn-round mb-0"><i class="fa fa-times"></i></a>
                                    </div>
                                    
                                </div>
                          
                              
                             <div class="card-footer p-0 pt-4">
                                <div class="text-center">
                                    <!-- Item -->
                                    <small class="bg-success bg-opacity-10 text-success fw-light rounded-2 d-inline-block mb-0 py-2 px-4"> Your Cart contents are stored here for 30+ days so you can return anytime.</small>
                                    <!-- Item -->
                                <!-- <small class="d-block">    Your Cart contents are stored here for 30+ days so you can return anytime.</small> -->
                                </div>
                            </div>
                            </div>
                              <div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-2">
							<!-- Content -->
							<p class="mb-sm-0 text-center text-sm-start"><a href="javascript:void(0)" class="btn btn-primary mb-0" @click="removeAllCart()">Clear Cart</a></p>
							<!-- Pagination -->
							<nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
								<!-- <a href="javascript:void(0)" class="btn btn-primary mb-0" @click="$router.go(-1)">Select Bids</a> -->
							<router-link to="/bids/state-opportunities" class="btn btn-primary mb-0">Select Bids</router-link>
                            </nav>
						</div>    
                            <!-- Card body END -->
                            
                        </div>
                    </div>
                </div>
                <!-- Main content END -->

                <!-- Sidebar START -->
                <aside class="col-xl-4">
                    <div data-sticky="" data-margin-top="80" data-sticky-for="1199">
                        <div class="card  bg-light p-4">
                            <!-- Title -->
                            <!-- <h6 class="text-danger fw-normal">Order Summary</h6> -->
                              <div class="card-header bg-light border-bottom p-0 pb-1 text-center">
                                <h5 class="card-title  mb-0">Order Summary</h5>
                            </div>

                            <div class="card-body">
                            <!-- List -->
                            <ul class="list-group list-group-borderless mb-0" >
                                <li class="list-group-item d-flex justify-content-between" v-for="(cart_item, key) in cart_items" :key="key">
                                    <span class="h6 fw-light mb-0"> {{ key+1 }}</span>
                                    <span class="h6 fw-light mb-0" v-if="cart_item.federal_tender_id">${{ cart_item.federal_tender?.fees }} </span>
                                    <span class="h6 fw-light mb-0" v-if="cart_item.state_tender_id">${{ cart_item.state_tender?.fees }} </span>
                                   
                                </li>
                            <li class="list-group-item py-0"><hr class="my-0" /></li>
                                <!-- Divider -->
                                <li class="list-group-item d-flex justify-content-between pb-0">
                                    <span class="h5 fw-normal mb-0">Total</span>
                                    <span class="h5 fw-normal mb-0">${{ total }}</span>
                                </li>
                            </ul>

                            <div class="d-grid mt-2 gap-2">
                             
                                <!-- <div class="text-center"><label>Total Due</label></div> -->
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" v-model="payPal.agree" type="checkbox" />
                                    <small class="form-check-label mb-0">I agree with <router-link to="/terms&condition">Terms and conditions</router-link></small>
                                </div>
                                <div class="text-center">
                                    <button type="buton" data-bs-toggle="modal" @click="createOrder()">
                                        <img class="" src="assets/images/svg/paypal.svg" alt="avatar" width="130" height="80"/>
                                    </button>
                                </div> 
                            </div>
                            </div>
                        </div>
                    </div>
                </aside>
                <!-- Sidebar END -->
            </div>
        </div>
    </section>

    <!-- alert login user -->
<teleport to="#modals" :disabled="!userlogin" v-if="userlogin">
        <div class="modal-overlay">
            <div class="" ref="register">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <img src="assets/images/icons/MemberIcon.png" class="imgcol" style="width: 50px; height: 50px;" />
                            <h5 class="modal-title">Login Required</h5>
                            <button type="button" class="btn-close" @click.prevent="closemodal()" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body mbodyaccess">
                            <div class="p-sm-7">
                              <p class="mb-0">New here?<a href="sign-up.html"> Already a Subscriber ?</a></p>

                                <!-- Form START -->
                                <form class="mt-4 text-start">
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label">Enter email id</label>
                                        <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="user.email" ref="email" />
                                        <span v-if="errors.email" class="invalid-feedback">{{errors.email[0]}}</span>
                                    </div>
                                    <!-- Password -->
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Enter password</label>
                                        <input class="form-control fakepassword" type="password" :class="{ 'is-invalid': errors.password }" v-model="user.password" ref="password" id="psw-input" />
                                        <span class="position-absolute top-50 end-0 translate-middle-y p-0 mt-3">
                                            <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i>
                                        </span>
                                        <span v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</span>
                                    </div>
                                    <!-- Remember me -->
                                    <div class="mb-3 d-sm-flex justify-content-between">
                                        <div>
                                            <input type="checkbox" class="form-check-input" id="rememberCheck" />
                                            <label class="form-check-label" for="rememberCheck">Remember me?</label>
                                        </div>
                                        <router-link to="/forgot_password">Forgot password?</router-link>
                                    </div>
                                    <!-- Button -->
                                    <div><button type="button" class="btn btn-primary w-100 mb-0" @click.prevent="login">Login</button></div>

                                    <!-- Divider -->
                                </form>
                                <!-- Form END -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</teleport>
<!-- end login -->
</template>

<script>
    import axios from 'axios'
     import moment from "moment";
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/css/index.css';
    export default {
        components: { Loading },
        data() {

            return {
                  user: {
                    email: "",
                    password: "",
                },
                meta: {
                    search: "",
                    order_by: "asc",
                    field: "",
                    per_page: 10,
                    totalRows: 0,
                    currentPage: 1,
                    lastPage: 1,
                    from: 1,
                    maxPage: 1,
                    to: "",
                },
                 userlogin:false,
                payPal:{
                    paypalID: this.$store?.getters?.paypalID,
                    totalITem:'',
                    item_code:'',
                    item_total:'',
                    currency_code:'USD',
                    loggedInUserID: this.$store?.getters?.user?.id,
                    cancelURL: this.$store?.getters?.cancelURL,
                    successURL:this.$store?.getters?.successURL,
                    agree:''
                },
                errors:[],
                 isLoading: false,
                fullPage: true,
                cart_items:[],
                total:null
            };
        },
        mounted(){
            this.getCartItemsCount()
        },
        methods: {
            getCartItems(){
                let vm = this
                vm.total = 0
                vm.$store
                    .dispatch("post", { uri: "getCartItems" })
                    .then(function (response) {
                        vm.cart_items = response.data.data
                        vm.cart_items.map(function(element){
                            if(element.federal_tender_id){
                                vm.total += element.federal_tender?.fees
                            }
                            if(element.state_tender_id){
                                vm.total += element.state_tender?.fees
                            }
                        })
                    })
                    .catch(function (error) {
                        console.log(error)
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getCartItemsCount(){
                let vm = this
                vm.$store
                    .dispatch("post", { uri: "getCartItemsCount", data:vm.$store.getters.user })
                    .then(function (response) {
                        if(response.data){
                            vm.$store.dispatch('setTenderCart', response.data)
                            vm.getCartItems()
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

             format_date(value) {
                  return moment(String(value)).format('MMMM D, YYYY')
            },
    
            login() {
                let vm = this;
                vm.isLoading = true
                vm.$store
                    .dispatch("auth", { uri: "login", data: vm.user })
                    .then(function (response) {
                        vm.isLoading = false
                        vm.$store.dispatch("success", "Successfuly logged in");
                        vm.$store.dispatch("setUser", response.data);
                        vm.$router.push("/cart");
                   
                        vm.userlogin = false;
                        vm.errors=[]
                        window.location.reload();
                    })
                    .catch(function (error) {
                        vm.isLoading = false
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
             closemodal() {
                let vm = this 
                vm.userlogin = false;
            },
            removeCart(cart_item) {
                let vm = this
                vm.$store
                    .dispatch("post", { uri: "removeCartItem", data:cart_item })
                    .then(function () {
                        vm.$store.dispatch("success", "Item removed from Cart");
                        vm.getCartItemsCount()
                    })
                    .catch(function (error) {
                        console.log(error)
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
          
            removeAllCart() {
                this.$store.commit("setCartProducts",[]);
            },
            createOrder(){
                    let item_code = []
                   
                    this.$store.getters.cartItems.map(function(element){
                        item_code.push(element.tdr_id)
                       
                    });
                    
                if(this.payPal.loggedInUserID){
                    if(this.$store.getters.cartItems.length > 0){
                        this.payPal.totalITem = this.$store.getters.cartItems.length
                        this.payPal.item_code = item_code.toString('@');
                        this.payPal.item_total = this.subTotal
                        let params = '?loggedInUserID='+this.payPal.loggedInUserID+'&totalITem='+this.payPal.totalITem+'&item_code='+this.payPal.item_code+'&item_total='+this.payPal.item_total 
                        if(this.payPal.agree)
                            window.open(this.$store.getters.baseUrl+'callPaypalNoramlPayment'+params,"_self")
                        else
                            this.$store.dispatch("error", "Agree to Terms and Conditions");
                    }else{
                        this.$store.dispatch("error", "Cart is empty");
                    }
                }else{
                    this.userlogin = true;
                    this.$store.dispatch("error", "Please login");
                }
            },
        },
        computed: {
            subTotal: function () {
                return this.$store.getters.cartItems.reduce((prev, cur) => +prev + +cur.tdr_doc_fees, 0).toFixed(2);
            },
        },
    };
</script>


<style scoped>
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
    .modal-content {
        /* font-family: "Fondamento", cursive; */
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        min-height: 200px;
        width: 480px;
        margin: 1rem;
        position: relative;
        min-width: 200px;
        box-shadow: 0 3px 6px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 23%);
        justify-self: center;
        transition: all 5s ease-in-out;
    }
</style>
