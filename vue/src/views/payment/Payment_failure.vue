<template>
    <section class="pt-0">
        <div class="container position-relative">
            <!-- Title and button START -->

            <!-- Title and button END -->

            <!-- Notice board START -->
            <div class="bg-primary bg-opacity-10 rounded-3 overflow-hidden mt-4 p-4">
                <div class="col.md-6  align-items-center">
                    <div class="col-md-12 order-md-2" style="text-align: center;">
                        <!-- Title -->
                     
                        <h4 class ="text-danger"><i  class="fas fa-exclamation-circle text-danger me-2"></i>Payment Unsuccessfull !</h4>
                        <!-- Content -->
                        <p class="mb-2">Your payment has been Failed. Go to cart page Retry again.</p>
                      
                    </div>
                    <hr />
                    <!-- <div class="col-lg-12" style="text-align: center;">
                       
                        <ul class="list-group list-group-borderless mb-0">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="h6 fw-light mb-0">Amount :</span>
                                <span class="h6 fw-light mb-0">$ {{subscriptionPayment.amt}}</span>
                            </li>
                           <li class="list-group-item d-flex justify-content-between">
                                <span class="h6 fw-light mb-0">Payment Type :</span><span class="h6 fw-light mb-0" >Monthly Subscription</span>
                            </li>
                       
                        </ul>
                    </div> -->
                  
                </div>
            </div>
            <!-- Notice board END -->
            <!-- <div class="col-md-12 order-md-2 m-3" style="text-align:center">
                <p class="mb-2">Thank you for your order, ! We've sent a copy of subscription details and payment receipt to your mail address.</p>
            </div> -->
            <div class="col-md- order-md-2 m-3" style="text-align:center">
               <router-link to="/cart" class="btn btn-secondary mb-0 m-3">Back Cart</router-link>
               
            </div>
        </div>
    </section>
</template>
<script>
export default {
    data() {
        return{
            subscriptionPayment:{}
        }
        
    },
     beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.$store.commit("setPage", 'subscription_payment');
				vm.$store.commit("setCartProducts",[]);
               
            });
        },
    mounted(){
        // this.subscriptionPayment = this.$route.query
    },
}
</script>

