<template>
    <section class="py-0">
        <div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
            <div class="row">
                <div class="bg-success bg-opacity-10 text-success fw-light rounded-2 p-2" role="alert" v-if="active_status">
                    You account has been Activated Login here
                </div>
                <div class="col-lg-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="card overflow-hidden h-400px h-sm-600px rounded-0" style="background-image: url(assets/images/home/slide-1.jpg); background-position: center left; background-size: cover;">
                                    <div class="bg-overlay bg-dark opacity-3"></div>
                                    <div class="card-img-overlay d-flex align-items-center">
                                        <div class="container">
                                            <div class="row justify-content-center">
                                                <div class="col-11 col-lg-7">
                                                    <h1 class="text-white display-6">Who We Are</h1>
                                                    <h6 class="text-white fw-normal mb-2">
                                                        We at BidsPortal provide Federal, Military & Defense, Municipalities, K12 & Higher Education, Transit & Utilities, US State & Local Government, Canada and International Solicitations,
                                                        RFPs, RFQs, RFIs, Bids, and Procurement Notice details.
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="card overflow-hidden h-400px h-sm-600px bg-parallax text-center rounded-0" style="background-image: url(assets/images/home/slide-2.jpg); background-position: center left; background-size: cover;">
                                    <div class="bg-overlay bg-dark opacity-3"></div>

                                    <div class="card-img-overlay d-flex align-items-center">
                                        <div class="container w-100 my-auto">
                                            <div class="row justify-content-center">
                                                <div class="col-11 col-lg-7">
                                                    <h1 class="text-white display-6">Cost Effective Service</h1>
                                                    <h6 class="text-white fw-normal mb-2">
                                                        BidsPortal subscription fee include access to bids posted for across countries, states, regions, agencies, categories, NAICS and unlimited searching, emailing, downloading available
                                                        documents and customizable bid alert notifications at no hidden cost.
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="card overflow-hidden h-400px h-sm-600px bg-parallax text-center rounded-0" style="background-image: url(assets/images/home/slide-3.jpg); background-position: center left; background-size: cover;">
                                    <div class="bg-overlay bg-dark opacity-3"></div>
                                    <div class="card-img-overlay d-flex align-items-center">
                                        <div class="container w-100 my-auto">
                                            <div class="row justify-content-center">
                                                <div class="col-11 col-lg-7">
                                                    <h1 class="text-white display-6">Unlimited Searching</h1>
                                                    <h6 class="text-white fw-normal mb-2">
                                                        Take advantage on our expertise to define an ulimited number of custom search profiles that will provide exact match to the text in requests for proposals and attachments.
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container pt-4 pt-md-5">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="mb-2">OUR SERVICES</h2>
                    <strong>We help you generate high-quality online sales leads by implementing highly structured, persuasive Internet marketing campaigns.</strong>
                </div>
            </div>

            <!-- Contact info -->
            <div class="row g-4">
                <!-- Contact item START -->
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-info rounded-circle mb-2"><img class="fs-5" src="../assets/icons/bid-alerts.png" alt="" /></div>
                        <!-- Title -->
                        <h5>Bid Alerts</h5>
                        <p>Set custom Bid Alerts by Country/Sector, Agency, Categories, NAICS and Keywords etc. With our Bid Alerts service, finding opportunities to win contracts couldn’t be easier.</p>
                    </div>
                </div>
                <!-- Contact item END -->

                <!-- Contact item START -->
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-danger rounded-circle mb-2"><img class="fs-5" src="../assets/icons/daily-email.png" alt="" /></div>
                        <!-- Title -->
                        <h5>Daily Email</h5>
                        <p>Based on the Bid Alerts profile preferences, we’ll send the most relevant matching opportunities straight to your inbox as soon as they become available on a daily basis</p>
                    </div>
                </div>
                <!-- Contact item END -->

                <!-- Contact item START -->
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-danger rounded-circle mb-2"><img class="fs-5" src="../assets/icons/largest-database.png" alt="" /></div>
                        <!-- Title -->
                        <h5>Comprehensive Database</h5>
                        <p>Updated daily with thousands of procurements notices retrieved from Federal, State, Multilateral Funding agencies, Utilities sector, Hospitals, Schools, Ports, NGO's, and Defense Forces etc.</p>
                    </div>
                </div>
                <!-- Contact item END -->

                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-danger rounded-circle mb-2"><img class="fs-5" src="../assets/icons/search-filters.png" alt="" /></div>
                        <!-- Title -->
                        <h5>Advanced Search Filters ©</h5>
                        <p>Search options to narrow down to the most important opportunities by County, State, Posted Date, Agency, Category, NAICS, Region, Contract Type, Set Aside and Keywords.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-danger rounded-circle mb-2"><img class="fs-5" src="../assets/icons/document-search.png" alt="" /></div>
                        <!-- Title -->
                        <h5>Document Search ©</h5>
                        <p>Our unique algorithm lets you search and retrieve procurement documents instantly. Files are easily retrieved with matching keywords used in the file naming along with applied Advanced Filters.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-danger rounded-circle mb-2"><img class="fs-5" src="../assets/icons/growth-business.png" alt="" /></div>
                        <!-- Title -->
                        <h5>Growth</h5>
                        <p>We help your business grow by saving time and money and expand your teams knowledge about market to make smarter decisions and increase your success in procurement bidding.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 pt-md-5">
            <div class="row">
                <div class="col-12">
                    <div class="rounded-3 position-relative overflow-hidden p-4 p-xl-5">
                        <div class="row g-4 align-items-center">
                            <!-- Content -->
                            <div class="col-lg-6 text-center col-md-12 ps-10">
                                <img src="assets/images/intuitive-bids-search.png" alt="" class="rounded-3 position-relative" style="width: 100%;" />
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <!-- Title -->
                                <h2 class="mb-3 fs-2">Intuitive Design</h2>
                                <p>
                                    The only benefit from any application is when the user is successful in using it and that success comes from intuitive design that anticipates user needs - successful user experience and design provide a
                                    competitive advantage. Foreseeing this need, we’ve spent time with the people using similar procurement services in order to understand their challenges, frustrations, goals, and motivations.
                                </p>
                                <p>
                                    We’ve build an enterprise application that’s beautiful and intuitive, more people will want to use it, and more importantly, keep using it. Our Bid/Document search and Custom Alerts user-friendly
                                    interface ensures your team’s efficiency is just a few clicks away. Improve opportunity research times from day one, with no special training required.
                                </p>
                                <p class="mb-3">Great application UI/UX is more than just effective product design - it’s good business.</p>
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary mb-0">Search Bids<i class="bi bi-arrow-right fa-fw ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Row END -->
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 pt-md-5" style="padding-right: 0px; padding-left: 0px;">
            <!-- Background image -->
            <div
                class="p-3 p-sm-5 h-200px h-sm-600px my-auto align-items-center"
                style="background-image: url(assets/images/Sources-we-monitor.png); background-position: center center; background-repeat: no-repeat; background-size: cover;"
            >
                <!-- Banner title -->
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h2 class="text-white mb-5 fw-100">Sources We Monitor</h2>
                    </div>
                </div>
                <div class="row g-4">
                    <!-- Contact item START -->
                    <div class="col-md-6 col-xl-3">
                        <div class="text-center align-items-center h-100">
                            <!-- Icon -->
                            <div class="icon-xl bg-mode bg-opacity-10 text-info rounded-circle mb-2 mx-auto"><img class="fs-5" src="../assets/icons/federal-government.png" alt="" /></div>
                            <!-- Title -->
                            <h5 class="text-white fw-100">Federal Government</h5>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="text-center align-items-center h-100">
                            <!-- Icon -->
                            <div class="icon-xl bg-mode bg-opacity-10 text-info rounded-circle mb-2 mx-auto"><img class="fs-5" src="../assets/icons/state-and-county-websites.png" alt="" /></div>
                            <!-- Title -->
                            <h5 class="text-white fw-100">State & County Websites</h5>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="text-center align-items-center h-100">
                            <!-- Icon -->
                            <div class="icon-xl bg-mode bg-opacity-10 text-info rounded-circle mb-2 mx-auto"><img class="fs-5" src="../assets/icons/private-vendor-portal.png" alt="" /></div>
                            <!-- Title -->
                            <h5 class="text-white fw-100">Private Vendor Portal</h5>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="text-center align-items-center h-100">
                            <!-- Icon -->
                            <div class="icon-xl bg-mode bg-opacity-10 text-info rounded-circle mb-2 mx-auto"><img class="fs-5" src="../assets/icons/funding-agencies.png" alt="" /></div>
                            <!-- Title -->
                            <h5 class="text-white fw-100">Multilateral Funding Agencies</h5>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="text-center align-items-center h-100">
                            <!-- Icon -->
                            <div class="icon-xl bg-mode bg-opacity-10 text-info rounded-circle mb-2 mx-auto"><img class="fs-5" src="../assets/icons/partner-companies.png" alt="" /></div>
                            <!-- Title -->
                            <h5 class="text-white fw-100">Partner Companies</h5>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="text-center align-items-center h-100">
                            <!-- Icon -->
                            <div class="icon-xl bg-mode bg-opacity-10 text-info rounded-circle mb-2 mx-auto"><img class="fs-5" src="../assets/icons/daily-news.png" alt="" /></div>
                            <!-- Title -->
                            <h5 class="text-white fw-100">Daily News</h5>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="text-center align-items-center h-100">
                            <!-- Icon -->
                            <div class="icon-xl bg-mode bg-opacity-10 text-info rounded-circle mb-2 mx-auto"><img class="fs-5" src="../assets/icons/classifieds-adds.png" alt="" /></div>
                            <!-- Title -->
                            <h5 class="text-white fw-100">Classifieds Ads</h5>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="text-center align-items-center h-100">
                            <!-- Icon -->
                            <div class="icon-xl bg-mode bg-opacity-10 text-info rounded-circle mb-2 mx-auto"><img class="fs-5" src="../assets/icons/3rd-party.png" alt="" /></div>
                            <!-- Title -->
                            <h5 class="text-white fw-100">3rd Party Sources</h5>
                        </div>
                    </div>
                    <!-- Contact item END -->
                </div>
            </div>
        </div>

        <div class="container pt-4 pt-md-5">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="mb-5">Industries We Cover</h2>
                </div>
            </div>

            <div class="row g-4 mb-5 justify-content-center">
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/IT-and-Telecom.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">IT & Telecoms</a></h6>
                    </div>
                </div>
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/Professional-Services.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">Professional Consulting</a></h6>
                    </div>
                </div>
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/Business-Services.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">Business & Finance</a></h6>
                    </div>
                </div>
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/Helath-and-Education.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">Health & Education</a></h6>
                    </div>
                </div>
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/Safety-and-Security.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">Security & Safety</a></h6>
                    </div>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/Water-and-Energy.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">Water & Energy</a></h6>
                    </div>
                </div>
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/Janitorial-and-HVAC.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">Janitorial & HVAC</a></h6>
                    </div>
                </div>
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/Agriculture-and-Minerals.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">Agriculture & Minerals</a></h6>
                    </div>
                </div>
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/Automotive-and-Industries.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">Automative & Industry</a></h6>
                    </div>
                </div>
                <div class="col-md-6 col-xl-2">
                    <div class="card card-body bg-light text-center align-items-center abc">
                        <!-- Icon -->
                        <div class="icon-xxl bg-mode rounded-circle mb-3">
                            <img src="../assets/icons/AE-and-Construction.png" class="card-img" alt="" />
                        </div>
                        <h6 class="mb-0"><a href="#" class="stretched-link">A/E & Construction</a></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 pt-md-5" style="padding-right: 0px; padding-left: 0px;">
            <!-- Background image -->
            <div class="p-3 p-sm-5" style="background-image: url(assets/images/talk-to-us-bg.jpg); background-position: center center; background-repeat: no-repeat; background-size: cover;">
                <!-- Banner title -->
                <div class="row my-2 my-xl-5 justify-content-center">
                    <div class="col-md-12 mx-auto">
                        <h2 class="text-center text-white fw-100">TALK TO US</h2>
                        <h5 class="text-center text-white fw-100">
                            For all enquiries please call <i class="fa-solid greenicon fa-phone me-1"></i>(913) 232-2255 or email us at <i class="fa-solid greenicon fa-envelope me-1"></i> support@bidsportal.com
                        </h5>
                        <div class="d-grid-sm text-center mt-5">
                            <button class="btn btn-dark mb-0">GET IN TOUCH <i class="fa-solid greenicon fa-arrow-right me-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                user: {
                    user_id:null,
                    email: "",
                    password: "",
                },
                active_status:false
            };
        },
        mounted() {
            if(this.$store.getters.user){
                let user = this.$store.getters.user
                let vm = this
                let header_menu = {
                    show_pricing : false,
                    show_upgrade : false,
                    show_bidsearch : false
                }
                if(user){
                    if(user.user_subscription){
                        let valid_to = user.user_subscription.valid_to
                        const today = moment().startOf('day')
                        const validToDate = moment(valid_to)
                        header_menu.show_pricing = false
                        if(validToDate.isSameOrAfter(today)){
                            header_menu.show_upgrade = false
                        }else{
                            header_menu.show_upgrade = true
                        }
                    }else{
                        header_menu.show_pricing = true
                    }
                }
                vm.$store.dispatch('setHeaderMenu', header_menu)
                this.$router.push('/bids/state-opportunities')
            }
            // this.getPsces();
            // this.getNaicses();
        },

        beforeRouteEnter(to, from, next) {
            next((vm) => {
                if (to.name == "UserActivation") {
                    vm.user.user_id = atob(vm.$route.params.id)
                    alert(vm.user.user_id)
                    let uri = "activateUser";
                    vm.$store
                        .dispatch("post", { uri: uri, data: vm.user })
                        .then(function (response) {
                            vm.user = response.data
                            vm.active_status = true
                            vm.$store.dispatch("success", "You account has been Activated Please Login");
                            vm.$router.push('/bids/state-opportunities')
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                } else {
                    
                }
            });
        },

        methods: {
            getPsces() {
                let vm = this;
                if (!vm.$store.getters.psces.length) {
                    vm.$store
                        .dispatch("post", { uri: "getPscs" })
                        .then(function (response) {
                            vm.$store.dispatch("setPsces", response.data.data);
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },
            getNaicses() {
                let vm = this;
                if (!vm.$store.getters.naicses.length) {
                    vm.$store
                        .dispatch("post", { uri: "getNaics" })
                        .then(function (response) {
                            vm.$store.dispatch("setNaics", response.data.data);
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },
        },
    };
</script>
<style scoped>
    .greenicon {
        color: greenyellow !important;
    }
    .fw-100 {
        font-weight: 100;
    }
    .abc {
        /* width: 400px;
  height: 250px;
  background: #fd9;
  margin: 30px auto 0;
  box-shadow: 0px 3px 15px rgba(0,0,0,0.2); */
        transition: 0.3s;
    }
    .abc:hover {
        box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.4);
        transform: scale(1.05, 1.05);
    }
</style>
