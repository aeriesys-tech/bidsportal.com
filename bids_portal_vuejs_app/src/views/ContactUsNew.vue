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
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-info rounded-circle mb-2"><i class="bi bi-person-fill fs-2"></i></div>
                        <!-- Title -->
                        <b class="text-primary">SALES, ACCOUNTS & BILLING</b>
                        <p class="text-gray">Email us, if you've any questions about billing.</p>
                        <!-- Buttons -->
                        <form class="row g-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-bg-light" placeholder="Name" />
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control form-control-bg-light" placeholder="Phone Number" />
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <input type="email" class="form-control form-control-bg-light" placeholder="Email Address" />
                            </div>
                            <!-- Mobile number -->
                            <div class="col-md-6">
                                <div>
                                    <select class="form-control form-control-bg-light" style="color: #96969a;">
                                        <option value="">Select Option</option>
                                        <option value="Pricing/Sales">Pricing/Sales</option>
                                        <option value="Billing Inquiry">Billing Inquiry</option>
                                        <option value="Subscription Related">Subscription Related</option>
                                        <option value="Marketing/Promotion">Marketing/Promotion</option>
                                        <option value="Partnership">Partnership</option>
                                        <option value="Jobs/Emploment">Jobs/Emploment</option>
                                        <option value="Other Support">Other Support</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Message -->
                            <div class="col-12">
                                <textarea class="form-control form-control-bg-light" rows="3" placeholder="Your Message"></textarea>
                            </div>
                            <!-- Checkbox -->

                            <!-- Button -->
                            <div class="col-12">
                                <button class="btn btn-sm btn-primary mb-0" type="button">Send Message</button>
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
                            <small href="javascript:void(0)" class="text-primary me-2">Live Chat</small>
                            <div class="icon-sm bg-success text-white rounded-circle"><i class="fa-solid fa-chevron-right fs-8"></i></div>
                        </div>
                    
                        <div class="d-flex text-dark mt-2 border-bottom">
                            <div class="ps-3">
                                <b class="mt-2">Have a Question?</b>
                                <p class="">If you've questions, you can contact our support service by calling 512-487-7757.</p>
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
                            <small href="javascript:void(0)" class="text-primary me-2">Discover Now</small>
                            <div class="icon-sm bg-success text-white rounded-circle"><i class="fa-solid fa-chevron-right fs-8"></i></div>
                        </div>
                    </div>
                </div>
                <!-- Contact item END -->
            </div>
        </div>
    </section>
</template>
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
    /* hr {
    margin: 1rem 0!important;
    color: #85878a!important;
    border: 0!important;
    border-top: 1px solid!important;
    opacity: 0.25!important;
} */
</style>
