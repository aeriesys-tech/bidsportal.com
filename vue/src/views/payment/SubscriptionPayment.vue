<template>
    <section class="pt-0">
        <div class="container position-relative">
            <div class="bg-primary bg-opacity-10 rounded-3 overflow-hidden mt-4 p-4">
                <div class="col.md-6 align-items-center">
                    <div class="col-md-12 order-md-2" style="text-align: center;">
                        <!-- Title -->

                        <h4 style="color: #0cbc87;"><i class="bi bi-check-circle-fill text-success me-2"></i>Payment Successfull !</h4>
                        <!-- Content -->
                        <p class="mb-2">Your payment has been processed. Details of transaction are included below.</p>
                    </div>
                    <hr />
                    <div class="col-lg-12" style="text-align: center;">
                        <ul class="list-group list-group-borderless mb-0">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="h6 fw-light mb-0">Amount :</span>
                                <span class="h6 fw-light mb-0">$ {{subscription_payment.amount}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between"><span class="h6 fw-light mb-0">Payment Type :</span><span class="h6 fw-light mb-0">Online</span></li>
                            <li class="list-group-item d-flex justify-content-between"><span class="h6 fw-light mb-0">Valid upto :</span><span class="h6 fw-light mb-0">{{ subscription_payment.valid_upto }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Notice board END -->
            <div class="col-md-12 order-md-2 m-3" style="text-align: center;">
                <p class="mb-2">Thank you for your order, ! We've sent a copy of subscription details and payment receipt to your mail address.</p>
            </div>
            <div class="col-md- order-md-2 m-3" style="text-align: center;">
                <a :href="getUrl()" target="_blank" class="btn btn-secondary mb-0 m-3">Print Receipt</a>
                <router-link to="/user/subscription" class="btn btn-success mb-0 m-3">Subscription Details</router-link>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                subscription_payment: {
                    amount: '',
                    item_number: '',
                    txn_id: '',
                    valid_upto: ''
                },
                user: {}
            
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.subscription_payment.txn_id = to.params.txn_id;
                vm.subscription_payment.valid_upto = to.params.valid_upto;
                vm.user.user_id = vm.$store.getters?.user?.user_id;
                vm.$store.commit("setPage", "subscription_payment");
                vm.$store.commit("setCartProducts", []);
                vm.subscription_payment.amount = to.params.amount;
                let letter = to.params.item_number.charAt(0);
                if ((letter == "A")) {
                    vm.subscription_payment.item_number = "Annual";
                }
                if ((letter == "M")) {
                    vm.subscription_payment.item_number = "Monthly";
                }
                if ((letter == "S")) {
                    vm.subscription_payment.item_number = "Semi-Annual";
                }
                vm.getUser()
            });
        },
        mounted() {
            this.user = this.$store.getters.user
        },
        methods: {
            getUrl(){
            // let url = this.$store.getters.baseUrl+'api/generateSubscriptionPdf/'+this.$store.getters.user.id+'/'+this.subscription_payment.txn_id
            let url = this.$store.getters.baseUrl+'api/generateSubscriptionPdf/'+this.$store.getters.user.user_id
            return url
            },
            getUser() {
                let vm = this;
                vm.$store
                    .dispatch("post", {
                        uri: "getUser", data: vm.user,
                    })
                    .then(function (response) {
                        vm.user = response.data.data
                        vm.$store.dispatch('setUser', vm.user)
                        vm.getUserSubscriptions();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
        },
    };
</script>
