<template>
<loading v-model:active="isLoading" :can-cancel="false" :z-index="10001"  :is-full-page="fullPage" />
    <section class="pt-3">
        <div class="container-fluid">
            <div class="row g-2 g-lg-4">
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
                             <!-- Card body START -->
                                <div class="card-body p-3">
                                    <!-- Avatar and content -->
                                     <div class="text-center ">
                                       <div class="text-center">
                                            <h1 class="avatar avatar-xl rounded-circle border border-white border-3 shadow">{{$store.getters.user?.name.substring(0,1)}}</h1>
                                        </div>
                                        <h6 class="mb-0">{{$store.getters.user?.name}}</h6>
                                        <a href="javascript:void(0)" class="text-reset text-primary-hover small">{{$store.getters.user?.email}}</a>
                                        <hr/>
                                    </div>

                                    <!-- Sidebar menu item START -->
                                    <ul class="nav nav-pills-primary-soft flex-column">
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/user/profile"><i class="bi bi-person fa-fw me-2"></i>My Profile</router-link>
                                        </li>
                                         <li class="nav-item">
                                            <router-link class="nav-link" to="/user/change-password"><i class="bi bi-person fa-fw me-2"></i>Change Password</router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/user/subscription"><i class="bi bi-ticket-perforated fa-fw me-2"></i>Subscription Info</router-link>
                                        </li>

                                        <li class="nav-item" v-if="payment.length !==0">
                                            <router-link class="nav-link" to="/user/single-bidpurchases"><i class="bi bi-people fa-fw me-2"></i>Single Bid Purchases</router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link active" to="/user/my-purchasedbids"><i class="bi bi-people fa-fw me-2"></i> My Purchased Bids</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="col-lg-8 col-xl-9 ps-xl-5">
                    <!-- Offcanvas menu button -->
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card border rounded-3">
                                <!-- Card header START -->
                                <div class="card-header border-bottom d-sm-flex justify-content-between align-items-center" >
                                   
                                         <!-- <h6 > This section Lists all of the individual Bids purchased - NOT APPLICABLE for subscriptions based user</h6> -->
                                         <h5 class="mb-2 mb-sm-0">My Purchased Bids</h5>
                                         <router-link to="/bids/state-opportunities" type="button" class="mb-0 btn btn-sm btn-primary">
                                        Back To Bids
                                    </router-link>
                                    
                                </div>
                                 
                                <!-- Card header END -->
                          
                                <div >
                                <div v-for ="userpayment in payment" :key="userpayment.payment_id">
                                    <div class="col-sm-12 col-xl-12" style="padding: 5px;">
                                        <div class="">
                                            <div class="d-flex align-items-center">
                                                <div class="" style="padding: 7px;">
                                                    <h6>Transaction ID : <span style="font-weight: normal;">{{userpayment.txn_id}}</span></h6>
                                                    <h6>Order ID : <span style="font-weight: normal;">{{userpayment.order_id}} </span> <span style="font-weight: normal;"> |</span> Dated : <span style="font-weight: normal;">{{format_date(userpayment.createdtime)}}</span></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card body START -->
                                    <div class="card-body">
                                        <div class="table-responsive border-0">
                                            <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                                <!-- Table head -->
                                                <thead class="table-light">
                                                    <tr>
                                                       
                                                        <th scope="col" class="border-0">Bid No</th>
                                                        <th scope="col" class="border-0">Agency</th>
                                                        <th scope="col" class="border-0">Expiry Date</th>
                                                        <th scope="col" class="border-0">Posted Date</th>
                                                        
                                                    </tr>
                                                </thead>

                                                <!-- Table body START -->
                                                <tbody class="border-top-0" v-if="userpayment.item_number">
                                                    <!-- Table item -->
                                                    <tr  v-for="(value,key) in userpayment?.item_number?.split(',')" :key="key">
                                                      
                                                        <td>
                                                         <a class="remunderline" @click="bidsdetails(value)" href="javascript:void(0)">
                                                        <span class=""> <span class="f-12 col-green pe-1 linkcolor "  >{{value}}</span></span>
                                                        </a>
                                                        </td>
                                                        <td>{{userpayment?.agency?.split(',')[key]}}</td>
                                                        <!-- <td>{{userpayment.tdr_no.split(',')[key]}} -->
                                                        <td>{{format_date(userpayment?.expiry_date?.split(',')[key])}}</td>
                                                        <td><div>{{format_date(userpayment?.posted_date?.split(',')[key])}}</div></td>
                                                        <!-- <td><div class="badge bg-success bg-opacity-10 text-success">Full payment</div></td>
                                                        <td><a href="#" class="btn btn-sm btn-light mb-0">View</a></td> -->
                                                    </tr>
                                                </tbody>
                                                <!-- Table body END -->
                                            </table>
                                        </div>
                                        <!-- Hotel room list END -->
                                    </div>
                                </div>
                                </div>
                                <!-- <div class="card-footer pt-0">
                                   
                                    <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                                      
                                        <p class="mb-sm-0 text-center text-sm-start">Showing 1 to 8 of 20 entries</p>
                                     
                                        <nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
                                            <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                                        </nav>
                                    </div>
                                </div> -->
                               
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main content END -->
            </div>
        </div>
    </section>
</template>
<script>
    import Pagination from "@/components/Pagination.vue";
    import moment from "moment";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    export default {
        components: { Pagination,Loading },
        name: "singlebidpurchases",
        data() {
            return {
               
                userbid:{
                    tdr_id:''
                },
                biddetail:[],
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
                    current_password: "",
                    new_password: "",
                    confirm_password: "",
                },
                errors: [],
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
            };
        },
         mounted() {
            
               if (this.$store.getters.user){ 
                   
                    this.getPaymentSubscriptions();
            }
                    
        },
        methods:{
            bidsdetails(value){
                    this.userbid.tdr_id = value
                    this.getbids()    
                   
            },
             getbids() {
                let vm = this;
                       
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: "getBid", data: vm.userbid })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.biddetail = response.data.data;
                        vm.$store.commit("setBidsDetails", vm.biddetail);
                        let tdr_title = vm.$store.getters.bidsdetails?.tdr_title;
                        let region_id = vm.$store.getters.bidsdetails?.region?.region_id;
                        let tdr_no = vm.$store.getters.bidsdetails.tdr_no
                    let region_name ="";
                        if(region_id ==2){
                            region_name = "federal-opportunities";
                        }
                         if(region_id ==1){
                            region_name = "state-opportunities";
                        }
                        if(region_id ==4){
                            region_name = "international-opportunities";
                        }
                         if(region_id ==3){
                            region_name = "private-commercial-opportunities";
                        }
                     vm.$router.push("/bids/" + region_name + "/" + tdr_title + "-" + tdr_no);
                                
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            format_date(value) {
                  return moment(String(value)).format('MMMM D, YYYY')
            },
             getPaymentSubscriptions() {
                let vm = this;
                 vm.isLoading = true;
                vm.payment.user_id = vm.$store.getters.user.id
             vm.$store
                    .dispatch("post", {
                        uri: "getUserPayments",
                        data: vm.payment,
                    })
                    .then(function (response) {
                        vm.payment = response.data;
                        vm.isLoading = false;
                     
                        // vm.userbids.bids = vm.payment.item_number.toString();
                     })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            format_date(value){
                   
                    return moment(String(value)).format('MMMM D, YYYY')
                    
                },
        }
    };
</script>
<style scoped>
.stripe-1 {
  color: white !important;
 background-image: linear-gradient(45deg, #5f7bed 25%, #3D6F8E 25%, #3D6F8E 50%, #5f7bed 50%, #5f7bed 75%, #3D6F8E 75%, #3D6F8E 100%);
background-size: 56.57px 56.57px;
   text-align: center !important;
    margin-bottom: 10px;
}

</style>
