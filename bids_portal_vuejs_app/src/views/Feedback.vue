<template>
<loading v-model:active="isLoading"
                 :can-cancel="false"
                  :z-index="10001"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"/>
    <section class="pt-4 pt-md-5" id="feedback">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="">
                    <h5>Get In Touch</h5>
                    <p class="mb-0">We're here for you tell us what's on your mind.</p>
                    <p>Please review our<router-link to="/faq"> FAQ's </router-link>quite likely your question has already been answered.</p>
                </div>
                <div class="">
                    <table>
                        <!-- <tbody>
                            <tr style="padding: 0px;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><img src="../assets/icons/PlaneGreenIcon.png" class="imgcol" height="40" width="70" /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><img src="../assets/icons/PlaneBlueIcon.png" height="40" width="70" class="imgcol" style="margin-top: -31px;" /></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><img src="../assets/icons/PlaneBlueIcon.png" class="imgcol" height="40" width="70" style="margin-top: -16px;" /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><img src="../assets/icons/PlaneBlueIcon.png" class="imgcol" height="40" width="70" style="margin-top: -28px;" /></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody> -->
                    </table>
                </div>
            </div>

            <!-- Contact info -->
            <div class="row g-4">
                <!-- Contact item START -->
                <div class="col-md-6 col-xl-3">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-info rounded-circle mb-2"><i class="bi bi-headset fs-3"></i></div>
                        <!-- Title -->
                        <h5>Telephone</h5>
                        <!-- <p>Imprudence attachment him his for sympathize. Large above be to means.</p> -->
                        <!-- Buttons -->
                        <div class="d-grid gap-3 d-sm-block">
                           <a  href="javascript:void(0)" class="btn btn-sm btn-primary-soft"><i class="bi bi-phone me-2"></i>(913) 232-2255</a>
                        </div>
                    </div>
                </div>
                <!-- Contact item END -->

                <!-- Contact item START -->
                <div class="col-md-6 col-xl-3">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-danger bg-opacity-10 text-danger rounded-circle mb-2"><i class="bi bi-person fs-3"></i></div>
                        <!-- Title -->
                        <h5>Account Support</h5>

                        <!-- Buttons -->
                         <a href="mailto:support@bidsportal.com" class="btn btn-link text-decoration-underline p-0 mb-0"><i class="bi bi-envelope me-1"></i>support@bidsportal.com</a>
                    </div>
                </div>
                <!-- Contact item END -->
                <div class="col-md-6 col-xl-3">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-orange bg-opacity-10 text-orange rounded-circle mb-2"><i class="bi bi-geo-alt fs-3"></i></div>
                        <!-- Title -->
                        <h5>Physical Address</h5>

                        <a href="javascript:void(0)" class="btn btn-link text-decoration-underline p-0 mb-0"><i class="bi bi-house me-1"></i>3800 N. Lamar Blvd. Suite 200 Austin, Texas 78756</a>
                        <!-- Buttons -->
                        <!-- <ul class="list-inline mb-0">
						<li class="list-inline-item"> <a class="btn btn-sm bg-facebook px-2 mb-0" href="#"><i class="fab fa-fw fa-facebook-f"></i></a> </li>
						<li class="list-inline-item"> <a class="btn btn-sm bg-instagram px-2 mb-0" href="#"><i class="fab fa-fw fa-instagram"></i></a> </li>
						<li class="list-inline-item"> <a class="btn btn-sm bg-twitter px-2 mb-0" href="#"><i class="fab fa-fw fa-twitter"></i></a> </li>
						<li class="list-inline-item"> <a class="btn btn-sm bg-linkedin px-2 mb-0" href="#"><i class="fab fa-fw fa-linkedin-in"></i></a> </li>
					</ul> -->
                    </div>
                </div>

                <!-- Contact item START -->
                <div class="col-xl-3 position-relative">
                    <!-- Svg decoration -->
                    <!-- <figure class="position-absolute top-0 end-0 z-index-1 mt-n4 ms-n7">
                        <svg class="fill-warning" width="77px" height="77px">
                            <path
                                d="M76.997,41.258 L45.173,41.258 L67.676,63.760 L63.763,67.673 L41.261,45.171 L41.261,76.994 L35.728,76.994 L35.728,45.171 L13.226,67.673 L9.313,63.760 L31.816,41.258 L-0.007,41.258 L-0.007,35.725 L31.816,35.725 L9.313,13.223 L13.226,9.311 L35.728,31.813 L35.728,-0.010 L41.261,-0.010 L41.261,31.813 L63.763,9.311 L67.676,13.223 L45.174,35.725 L76.997,35.725 L76.997,41.258 Z"
                            ></path>
                        </svg>
                    </figure> -->

                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-danger bg-opacity-10 text-danger rounded-circle mb-2"><i class="bi bi-chat-right-text fs-3"></i></div>
                        <!-- Title -->
                        <h5>Give Feedback</h5>

                        <!-- Buttons -->
                        <router-link to="/feedback" class="btn btn-link text-decoration-underline p-0 mb-0"><i class="bi bi-star fs-5"></i><i class="bi bi-star fs-5"></i><i class="bi bi-star fs-5"></i><i class="bi bi-star fs-5"></i></router-link>
                    </div>
                </div>
                <!-- Contact item END -->
            </div>
        </div>
    </section>

    <section class="pt-0 pt-lg-5">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-center">
                <!-- Vector image START -->
                <!-- <div class="col-lg-6 text-center">
                    <img src="assets/images/element/contact.svg" alt="" />
                </div> -->
                <!-- Vector image END -->

                <!-- Contact form START -->
                <div class="col-lg-12">
                    <div class="card bg-light p-4">
                        <!-- Svg decoration -->
                        <!-- <figure class="position-absolute end-0 bottom-0 mb-n4 me-n2">
                            <svg class="fill-orange" width="104.2px" height="95.2px">
                                <circle cx="2.6" cy="92.6" r="2.6" />
                                <circle cx="2.6" cy="77.6" r="2.6" />
                                <circle cx="2.6" cy="62.6" r="2.6" />
                                <circle cx="2.6" cy="47.6" r="2.6" />
                                <circle cx="2.6" cy="32.6" r="2.6" />
                                <circle cx="2.6" cy="17.6" r="2.6" />
                                <circle cx="2.6" cy="2.6" r="2.6" />
                                <circle cx="22.4" cy="92.6" r="2.6" />
                                <circle cx="22.4" cy="77.6" r="2.6" />
                                <circle cx="22.4" cy="62.6" r="2.6" />
                                <circle cx="22.4" cy="47.6" r="2.6" />
                                <circle cx="22.4" cy="32.6" r="2.6" />
                                <circle cx="22.4" cy="17.6" r="2.6" />
                                <circle cx="22.4" cy="2.6" r="2.6" />
                                <circle cx="42.2" cy="92.6" r="2.6" />
                                <circle cx="42.2" cy="77.6" r="2.6" />
                                <circle cx="42.2" cy="62.6" r="2.6" />
                                <circle cx="42.2" cy="47.6" r="2.6" />
                                <circle cx="42.2" cy="32.6" r="2.6" />
                                <circle cx="42.2" cy="17.6" r="2.6" />
                                <circle cx="42.2" cy="2.6" r="2.6" />
                                <circle cx="62" cy="92.6" r="2.6" />
                                <circle cx="62" cy="77.6" r="2.6" />
                                <circle cx="62" cy="62.6" r="2.6" />
                                <circle cx="62" cy="47.6" r="2.6" />
                                <circle cx="62" cy="32.6" r="2.6" />
                                <circle cx="62" cy="17.6" r="2.6" />
                                <circle cx="62" cy="2.6" r="2.6" />
                                <circle cx="81.8" cy="92.6" r="2.6" />
                                <circle cx="81.8" cy="77.6" r="2.6" />
                                <circle cx="81.8" cy="62.6" r="2.6" />
                                <circle cx="81.8" cy="47.6" r="2.6" />
                                <circle cx="81.8" cy="32.6" r="2.6" />
                                <circle cx="81.8" cy="17.6" r="2.6" />
                                <circle cx="81.8" cy="2.6" r="2.6" />
                                <circle cx="101.7" cy="92.6" r="2.6" />
                                <circle cx="101.7" cy="77.6" r="2.6" />
                                <circle cx="101.7" cy="62.6" r="2.6" />
                                <circle cx="101.7" cy="47.6" r="2.6" />
                                <circle cx="101.7" cy="32.6" r="2.6" />
                                <circle cx="101.7" cy="17.6" r="2.6" />
                                <circle cx="101.7" cy="2.6" r="2.6" />
                            </svg>
                        </figure> -->

                        <!-- Card header -->
                        <div class="card-header bg-light p-0 pb-3">
                            <h6 class="mb-0">Please complete the form below and a BidsPortal representative will be in touch shortly.</h6>
                        </div>

                        <!-- Card body START -->
                        <div class="card-body p-0">
                            <form class="row g-4" action="" @submit.prevent="addfeedback">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label class="form-label">Your Company Name  </label>
                                    <input type="text" class="form-control" placeholder="Enter Company Name" :class="{'is-invalid': errors.name}" v-model="feedback.name" ref="name"/>
                                    <span v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</span>
                                </div> 
                               
                                <!-- Email -->
                                <div class="col-md-6">
                                    <label class="form-label">Your Email Address </label>
                                    <input type="email" class="form-control" placeholder="email@example.com" :class="{'is-invalid': errors.email}" v-model="feedback.email" ref="email"  />
                                </div>
                                <!-- Mobile number -->
                                  <div class="col-md-12">
                                    <label class="form-label">How did you hear about us</label>
                                    <input type="text" class="form-control" :class="{'is-invalid': errors.how_did_you_hear_about_us}" v-model="feedback.how_did_you_hear_about_us" ref="about_us"  />
                                     <span v-if="errors.how_did_you_hear_about_us" class="invalid-feedback">{{ errors.how_did_you_hear_about_us[0] }}</span>
                                </div>
                                <!-- Message -->
                                <div class="col-12">
                                    <label class="form-label">Your Review</label>
                                    <textarea class="form-control" rows="3" placeholder="Your message to recipient of the email" :class="{'is-invalid': errors.message}" v-model="feedback.message" ref="message" id="feedback_msg"></textarea>
                                     <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0] }}</span>
                                </div>
                               <div class="col-12">
                                    <label class="form-label">Rating</label>
                                  <div class="rating"><input type="radio" name="rating" value="5" id="5" v-model="feedback.rating"><label for="5">☆</label>
                                    <input type="radio" name="rating" id="4" value="4" v-model="feedback.rating"><label for="4">☆</label>
                                    <input type="radio" name="rating" id="3" value="3" v-model="feedback.rating"><label for="3">☆</label>
                                    <input type="radio" name="rating" id="2" value="2" v-model="feedback.rating"><label for="2">☆</label>
                                    <input type="radio" name="rating" id="1" value="1" v-model="feedback.rating"><label for="1">☆</label>
                                  </div>
                                   <span v-if="errors.rating" style="color:#dc3545" >{{ errors.rating[0] }}</span>
                                     
                                </div>
                               
                                <!-- Button -->
                                <div class="col-12">
                                    <button class="btn btn-dark mb-0" type="submit">Send Message</button>
                                </div>
                            </form>
                        </div>
                        <!-- Card body END -->
                    </div>
                </div>
                <!-- Contact form END -->
            </div>

            
        </div>
    </section>

   <section class="pt-0 pt-lg-5">
	<div class="container">
		  <div class="row g-4">
                <!-- Contact item START -->
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-info bg-opacity-10 text-info rounded-circle mb-2"><i class="bi bi-envelope fs-3"></i></div>
                        <!-- Title -->
                        <h5>Have a Question?</h5>
                        <p>If you've questions, you can contact our support service by calling (913) 232-2255.</p>
                        <!-- Buttons -->
                        <div class="d-grid gap-3 d-sm-block">
                            <router-link to="/contact_us" class="btn btn-sm btn-primary-soft"><i class="bi bi-phone me-2"></i>Contact Us</router-link>
                        </div>
                    </div>
                </div>
                <!-- Contact item END -->

                <!-- Contact item START -->
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-danger bg-opacity-10 text-danger rounded-circle mb-2"><i class="bi bi-chat fs-3"></i></div>
                        <!-- Title -->
                        <h5>Need Real-time Assistance?</h5>
                        <p>Our Live Chat operators are always ready to help you.</p>

                        <!-- Buttons -->
                        <button class="btn btn-sm btn-primary-soft"><i class="bi bi-envelope me-1"></i>Live Chat</button>
                    </div>
                </div>
                <!-- Contact item END -->
                <div class="col-md-6 col-xl-4">
                    <div class="card card-body shadow text-center align-items-center h-100">
                        <!-- Icon -->
                        <div class="icon-lg bg-orange bg-opacity-10 text-orange rounded-circle mb-2"><i class="bi bi-star fs-3"></i></div>
                        <!-- Title -->
                        <h5>Our Plans & Prices</h5>
                        <p>Browse through our wide variety of plans and select the one that works the best for you.</p>

                          <router-link to="/plans_pricing" class="btn btn-sm btn-primary-soft"><i class="bi bi-house me-1"></i>Discover Now</router-link>
                      
                    </div>
                </div>

               
            </div>
	</div>
</section>
</template>

<script>
  import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
export default{
    components:{Loading},
    data(){
        return{
            feedback:{
                    name:'',
                    rating:'',
                    email:'',
                    how_did_you_hear_about_us:'',
                    message:'',
                },
         
            errors:[],
            isLoading: false,
            fullPage: true

        }
    },
     methods:{
            addfeedback() {
                let vm = this;
               vm.isLoading = true
                vm.$store.dispatch('auth',{'uri':'addFeedback','data':vm.feedback})
                .then(function () {
                    vm.isLoading = false
                    vm.$store.dispatch('success','FeedBack send Successfuly .');
                   // vm.$router.push('/login');
                   // vm.status=true;
                   vm.reset();
                    vm.errors=[];
                })
                .catch(function (error) {
                    vm.isLoading = false
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch('error',error.response.data.message);
                });
            },
              reset(){
             let vm = this;
                vm.feedback.name = "";
                vm.feedback.rating = "";
                vm.feedback.email="";
                vm.feedback.how_did_you_hear_about_us="";
                vm.feedback.message="";
                vm.$refs.name.focus();
                         
        }
           
        }
}
</script>
<style scoped>

.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: left;
}

.rating>input {
    display: none
}

.rating>label {
    position: relative;
    width: 1em;
    font-size: 35px;
    font-weight: 300;
    color: #fbcf3a;
    cursor: pointer;
    margin-top:-10px;
}

.rating>label::before {
    content: "\2605";
    position: absolute;
    opacity: 0
}

.rating>label:hover:before,
.rating>label:hover~label:before {
    opacity: 1 !important
}

.rating>input:checked~label:before {
    opacity: 1
}

.rating:hover>input:checked~label:before {
    opacity: 0.4
}


  /* .rate {
    float: left;
    height: 46px;
    padding: 0px;
  } */
  
  .rate:not(:checked)>input {
    position: absolute;
    top: -9999px;
  }
  
  .rate:not(:checked)>label {
    float: right;
    width: 1em;
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    font-size: 30px;
    color: #ccc;
  }
  
  .rate:not(:checked)>label:before {
    content: '★ ';
  }
  
  .rate>input:checked~label {
    color: #ffc700;
  }
  
  .rate:not(:checked)>label:hover,
  .rate:not(:checked)>label:hover~label {
    color: #fbcf3a;
  }
  
  .rate>input:checked+label:hover,
  .rate>input:checked+label:hover~label,
  .rate>input:checked~label:hover,
  .rate>input:checked~label:hover~label,
  .rate>label:hover~input:checked~label {
    color: #fbcf3a;
  }
  
</style>
