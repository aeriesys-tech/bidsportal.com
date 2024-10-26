<template>

    <section class="pt-4">
        <div class="container-fluid" data-sticky-container="">
            <div class="row g-4" style="justify-content:center">
                <!-- Main content START -->
                <div class="col-xl-8">
                    <div class="vstack gap-5">
                       
                        <div class="card border p-4">
                            <!-- Card header -->
                            <div class="card-header border-bottom p-0 pb-1">
                                <h5 class="card-title mb-0">Your Cart</h5>
                            </div>
                                    <!-- test 1 -->
                                <div class="card-body" style="padding:0px" v-if="$store.getters.cartItems.length === 0" >
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
                                 <div class="row row-cols-xl-7 g-4 align-items-sm-center border-bottom px-2 py-2" v-for="(item, key) in $store.getters.cartItems" :key="key">
                                    <!-- Data item -->
                                    <div class="col">
                                        <div class="avatar avatar-sm">
                                            <img class="avatar-img" src="/assets/icons/document-search.png" alt="avatar" />
                                        </div>
                                    </div>

                                    <!-- Data item -->
                                    <div class="col-4">
                                        <small class="d-block"> {{item.tdr_title }}</small>
                                        <div class="d-flex">
                                            <small class="me-1">Posted Date:</small>
                                            <small class="mb-0 text-primary">{{ item.tdr_posted_date }}</small>
                                        </div>
                                    </div>

                                    <!-- Data item -->
                                    <div class="col">
                                        <small class="d-block d-sm-none">Status:</small>
                                        <div class="">${{item.tdr_doc_fees }}</div>
                                    </div>
                                    <!-- Data item -->
                                    <div class="col">
                                        <small class="d-block d-sm-none">Status:</small>
                                        <div class="">1</div>
                                    </div>

                                    <!-- Data item -->
                                    <div class="col">
                                        <small class="d-block d-sm-none">Status:</small>
                                        <div class="">${{item.tdr_doc_fees }}</div>
                                    </div>
                                    <!-- Data item -->
                                    <div class="col">
                                        <a href="javascript:void(0)" @click="removeCart(item)" class="btn btn-light btn-round mb-0"><i class="fa fa-times"></i></a>
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
								<a href="javascript:void(0)" class="btn btn-primary mb-0" @click="$router.go(-1)">Select Bids</a>
							</nav>
						</div>    
                            <!-- Card body END -->
                            
                        </div>
                    </div>
                </div>
                <!-- Main content END -->
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        
        data() {
            return {
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
        methods: {
            removeCart(item) {
                this.$store.commit("removeFromCart", item);
            },
          
            removeAllCart() {
                this.$store.commit("setCartProducts",[]);
            },
            createOrder(){
                this.$router.push('/checkout')
            },
        },
        computed: {
            subTotal: function () {
                return this.$store.getters.cartItems.reduce((prev, cur) => +prev + +cur.tdr_doc_fees, 0).toFixed(2);
            },
        },
    };
</script>
