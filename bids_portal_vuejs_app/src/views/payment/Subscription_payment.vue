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
                                <span class="h6 fw-light mb-0">$ {{subscriptionPayment.amount}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between"><span class="h6 fw-light mb-0">Payment Type :</span><span class="h6 fw-light mb-0">{{subscriptionPayment.item_number}}</span></li>
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
                <a href="javascript:void(0)" @click="getUserData()" class="btn btn-success mb-0 m-3">Subscription Details</a>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                subscriptionPayment: {
                    amount: "",
                    item_number: "",
                    txn_id:""
                },
                user: {
                    id: "",
                },
                users: [],
            
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.subscriptionPayment.txn_id = to.params.txn_id;
                vm.user.id = vm.$store.getters?.user?.id;
                vm.$store.commit("setPage", "subscription_payment");
                vm.$store.commit("setCartProducts", []);
                vm.subscriptionPayment.amount = to.params.amount;
                let letter = to.params.item_number.charAt(0);
                if ((letter == "A")) {
                    vm.subscriptionPayment.item_number = "Annual";
                }
                if ((letter == "M")) {
                    vm.subscriptionPayment.item_number = "Monthly";
                }
                if ((letter == "S")) {
                    vm.subscriptionPayment.item_number = "Semi-Annual";
                }
            });
        },
        mounted() {},
        methods: {
            getUrl(){
            let url = this.$store.getters.baseUrl+'api/generateSubscriptionPdf/'+this.$store.getters.user.id+'/'+this.subscriptionPayment.txn_id
            return url
            },
           getUserData() {
                // showUser
                let vm = this;
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: "showUser", data: vm.user })
                    .then(function (response) {
                        console.log(response.data.data)
                        vm.isLoading = false;
                        vm.$store.commit("setUser", response.data.data);
                        vm.$router.push("/user/subscription");
                        vm.$router.reload(0);
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
        },
    };
</script>
