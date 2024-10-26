<template>
    <section class="pt-4 pt-md-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-xl-12 text-center">
                    <h4>Contact Us</h4>
                    <p class="lead mb-0">Please get in touch if you have any questions about Sales, Billing, or Technical Support</p>
                </div>
            </div>

            <!-- Contact info -->
            <div class="row g-4">
                <!-- Contact item START -->
                <div class="col-md-8 col-xl-8">
                    <div class="card card-body shadow align-items-center h-100">
                        <!-- Icon -->
                        <!-- <div class="icon-lg bg-info bg-opacity-10 text-info rounded-circle mb-2"><i class="bi bi-person-fill fs-2"></i></div> -->
                        <div class="icon-lg bg-opacity-10 bg-purple rounded-circle mb-2"><i class="bi bi-person-fill fs-2"></i></div>
                        <!-- Title -->
                        <b class="text-purple">SALES, ACCOUNTS & BILLING</b>
                        <p class="text-gray">Email us, if you've any questions about billing.</p>
                        <!-- Buttons -->
                        <form class="row g-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-bg-light" placeholder="Name" :class="{'is-invalid': errors.name}" v-model="message.name" />
                                <span v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-bg-light" placeholder="Phone Number" :class="{'is-invalid': errors.phone}" v-model="phone_no" @input="changePhoneFormat()" />
                                <span v-if="errors.phone" class="invalid-feedback">{{ errors.phone[0] }}</span>
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <input type="email" class="form-control form-control-bg-light" placeholder="Email Address" :class="{'is-invalid': errors.email}" v-model="message.email" />
                                <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                            </div>
                            <!-- Mobile number -->
                            <div class="col-md-6">
                                <div>
                                    <select class="form-control form-control-bg-light" style="color: #96969a;" :class="{'is-invalid': errors.service}" v-model="message.service">
                                        <option value="">Select Option</option>
                                        <option value="Pricing/Sales">Pricing/Sales</option>
                                        <option value="Billing Inquiry">Billing Inquiry</option>
                                        <option value="Subscription Related">Subscription Related</option>
                                        <option value="Marketing/Promotion">Marketing/Promotion</option>
                                        <option value="Partnership">Partnership</option>
                                        <option value="Jobs/Emploment">Jobs/Emploment</option>
                                        <option value="Other Support">Other Support</option>
                                    </select>
                                    <span v-if="errors.service" class="invalid-feedback">{{ errors.service[0] }}</span>
                                </div>
                            </div>
                            <!-- Message -->
                            <div class="col-12">
                                <textarea class="form-control form-control-bg-light" rows="3" placeholder="Your Message" :class="{'is-invalid': errors.Message}" v-model="message.Message"></textarea>
                                <span v-if="errors.Message" class="invalid-feedback">{{ errors.Message[0] }}</span>
                            </div>
                            <!-- Checkbox -->

                            <!-- Button -->
                            <div class="col-12 text-center">
                                <button class="btn btn-sm btn-primary mb-0" type="button" @click="sendMessage()">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4 col-xl-4">
                    <div class="card card-body shadow align-items-center h-100">
                        <div class="icon-lg bg-opacity-10 text-primary mb-2"><i class="bi bi-tools fs-2"></i></div>
                        <p class="font-bold text-primary">INSTANT SUPPORT</p>
                        <div class="d-flex text-dark border-bottom">
                            <div class="ps-3">
                                <b class="mt-2">Need Real-time Assistance?</b>
                                <p class="">Our Live Chat operators are always ready to help you.</p>
                            </div>
                            <div class="icon-lg bg-success bg-opacity-10 flex-shrink-0 text-success rounded-circle"><i class="bi bi-chat-right-dots fs-4"></i></div>
                        </div>

                        <div class="mr-auto ps-3 d-flex mt-2">
                            <a href="javascript:void(0)" class="small text-primary me-2">Live Chat</a>
                            <div class="icon-sm bg-success text-white rounded-circle"><i class="fa-solid fa-chevron-right fs-8"></i></div>
                        </div>

                        <div class="d-flex text-dark mt-2 border-bottom">
                            <div class="ps-3">
                                <b class="mt-2">Have a Question?</b>
                                <p class="">If you've questions, you can contact our support service by calling (913) 232-2255.</p>
                            </div>
                            <div class="icon-lg bg-info bg-opacity-10 flex-shrink-0 text-info rounded-circle"><i class="bi bi-envelope fs-4"></i></div>
                        </div>

                        <div class="d-flex text-dark mt-2">
                            <div class="ps-3">
                                <b class="mt-2">Our Plan & Prices</b>
                                <p class="">Prowse through our wide variety of plans and select the one that works the best for you.</p>
                            </div>
                            <div class="icon-lg bg-danger bg-opacity-10 flex-shrink-0 text-danger rounded-circle"><i class="bi bi-star fs-4"></i></div>
                        </div>
                        <div class="mr-auto ps-3 d-flex mt-2">
                            <router-link to="/plans_pricing" class="small text-primary me-2">Discover Now</router-link>
                            <div class="icon-sm bg-success text-white rounded-circle"><i class="fa-solid fa-chevron-right fs-8"></i></div>
                        </div>
                    </div>
                </div>
                <!-- Contact item END -->
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                message: {
                    name: "",
                    email: "",
                    phone: "",
                    service: "",
                    Message: "",
                },
                phone_no:"",
                errors: [],
            };
        },
        mounted() {
            window.scrollTo(0, 0);
        },
        methods: {
            sendMessage() {
                let vm = this;
                let phone_no=vm.phone_no.replace("-","").replace("-","");
                vm.message.phone = phone_no;
                vm.$store
                    .dispatch("post", { uri: "addContact", data: vm.message })
                    .then(function () {
                        vm.$store.dispatch("success", "Message sent successfully");
                        vm.discard();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        // if(vm.message.phone ==""){
                   
                        //     vm.errors.phone_no = ["The Phone number "]
                        //     console.log("error: " + vm.errors)
                        // }
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            discard() {
                this.message.name = "";
                this.message.email = "";
                this.message.phone = "";
                this.phone_no = "";
                this.message.service = "";
                this.message.Message = "";
                this.errors = [];
            },
            changePhoneFormat() {
                var x = this.phone_no.replace(/\D/g, "").match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                this.phone_no = !x[2] ? x[1] : x[1] + "-" + x[2] + (x[3] ? "-" + x[3] : "");
            },
        },
    };
</script>

<style>
    .form-control-bg-light {
        color: var(--bs-gray-900);
        border: 1px solid var(--bs-light);
        background-color: var(--bs-light) !important;
    }

    /* .form-fs-md {
    font-weight: 500;
    font-size: 1rem;
} */
    .mr-auto {
        margin-right: auto;
    }
    .bg-purple {
        color: #a020f0;
        background-color: #cface4;
    }
    .text-purple {
        color: #a020f0;
    }
</style>
