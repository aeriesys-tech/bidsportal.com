<template>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="fullPage" />
    <section class="">
        <div class="container-fluid h-100 d-flex px-7">
            <div class="row justify-content-center">
                <div class="col-lg-8 pb-5">
                    <div class="bg-mode shadow rounded-3 overflow-hidden">
                        <div class="row g-0" style="justify-content: center;">
                            <!-- Information -->
                            <div class="col-lg-9 order-1" style="text-align: center;">
                                <div class="p-4 p-sm-6">
                                    <h1 class="mb-2 h4">Create New Account</h1>
                                    <p class="mb-0">Sign Up. Get started with a new account in no time.<router-link
                                            to="/login"></router-link></p>

                                    <!-- Form START -->
                                    <form class="mt-4 text-start row g-3" @submit.prevent="register" autocomplete="nope"
                                        novalidate="novalidate">
                                        <div class="col-md-6">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.name" :class="{ 'is-invalid': errors.name }" />
                                                <label class="did-floating-label">Full Name<span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.name" class="invalid-feedback">{{ errors.name[0]
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.position" :class="{ 'is-invalid': errors.position }" />
                                                <label class="did-floating-label">Title/Position <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.position" class="invalid-feedback">{{
                                                    errors.position[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.company_name"
                                                    :class="{ 'is-invalid': errors.company_name }" />
                                                <label class="did-floating-label">Company Name <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.company_name" class="invalid-feedback">{{
                                                    errors.company_name[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.phone" :class="{ 'is-invalid': errors.phone }"
                                                    @input="changePhoneFormat()" />
                                                <label class="did-floating-label">Phone Number <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.phone" class="invalid-feedback">{{ errors.phone[0]
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.web_address"
                                                    :class="{ 'is-invalid': errors.web_address }" />
                                                <label class="did-floating-label">Web Address <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.web_address" class="invalid-feedback">{{
                                                    errors.web_address[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.mailing_address"
                                                    :class="{ 'is-invalid': errors.mailing_address }" />
                                                <label class="did-floating-label">Mailing Address <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.mailing_address" class="invalid-feedback">{{
                                                    errors.mailing_address[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.city" :class="{ 'is-invalid': errors.city }" />
                                                <label class="did-floating-label">City <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.city" class="invalid-feedback">{{ errors.city[0]
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.state" :class="{ 'is-invalid': errors.state }" />
                                                <label class="did-floating-label">State <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.state" class="invalid-feedback">{{ errors.state[0]
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.zipcode" :class="{ 'is-invalid': errors.zipcode }" />
                                                <label class="did-floating-label">Zip Code <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.zipcode" class="invalid-feedback">{{
                                                    errors.zipcode[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="did-floating-label-content">
                                                <input class="did-floating-input" type="text" placeholder=" "
                                                    v-model="user.email" :class="{ 'is-invalid': errors.email }" />
                                                <label class="did-floating-label">Enter email id <span
                                                        class="text-danger">*</span></label>
                                                <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0]
                                                    }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="did-floating-label-content input-group mb-0">
                                                <input class="did-floating-input" :type="type"
                                                    :class="{ 'is-invalid': errors.password }" ref="password"
                                                    v-model="user.password" />

                                                <label class="did-floating-label">Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-prepend">
                                                        <div class="input-group-text"
                                                            :class="{ 'is-passinvalid': errors.password }">
                                                            <span class="" @click="toggle">
                                                                <i class="fakepasswordicon fas fa-eye p-2"
                                                                    v-if="icon"></i>
                                                                <i class="fakepasswordicon fas fa-eye-slash p-2"
                                                                    v-else></i>
                                                            </span>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <span v-if="errors.password" style="color: #dc3545;font-size:0.875em">{{
                                                errors.password[0] }}</span>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="did-floating-label-content input-group mb-0">
                                                <input class="did-floating-input" :type="type1"
                                                    :class="{ 'is-invalid': errors.confirm_password }"
                                                    v-model="user.confirm_password" />

                                                <label class="did-floating-label">Confirm Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-prepend">
                                                        <div class="input-group-text"
                                                            :class="{ 'is-passinvalid': errors.confirm_password }">
                                                            <span class="" @click="toggle1">
                                                                <i class="fakepasswordicon fas fa-eye p-2"
                                                                    v-if="icon1"></i>
                                                                <i class="fakepasswordicon fas fa-eye-slash p-2"
                                                                    v-else></i>
                                                            </span>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <span v-if="errors.confirm_password"
                                                style="color: #dc3545;font-size:0.875em">{{ errors.confirm_password[0]
                                                }}</span>
                                        </div>
                                        <p class="small bg-mode mb-0 mt-1">Use 8 or more characters with a mix of small
                                            letters, capital letters and numbers</p>
                                        <!-- set aside -->
                                        <div class="col-md-12">
                                            <label for="inputfrequen1" class="form-label head1">Set Aside <span
                                                    class="text-danger">*</span> </label> <label>{{ user.set_asides.length
                                                }} of {{ set_asides.length }} Selected</label>
                                            <div class="">
                                                <button type="button" style="border: 1px solid #3d85d8;"
                                                    class="btn btnwht10 form-select" data-bs-toggle="dropdown">
                                                    <span class="text-center"
                                                        style="float: left; color: #1e4c82; font-size: 16px; font-weight: 400;">Select
                                                        Set Aside</span>
                                                </button>
                                                <label for="inputfrequen1" class="form-label"> </label>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown-item">
                                                        <div class="">
                                                            {{ user.set_asides.length }} of {{ set_asides.length }}
                                                            <!-- <input type="checkbox" v-model="this.selectAll" @click="select" class="hidden"/> Select all -->
                                                            <router-link to="" @click="selectAllSetAsides()"
                                                                class="" ref="selectState">
                                                                Select All /
                                                            </router-link>
                                                            <router-link to="" @click="deselectSetAsides()"
                                                                class="" ref="selectState">
                                                                Reset all
                                                            </router-link>
                                                            <div class="ss-filter-search scrollaside">
                                                                <input autocomplete="off" class="form-control"
                                                                    type="text" v-model="set_aside_keyword"
                                                                    placeholder="Search Set Aside" @keyup="sortSetAside()" />
                                                                <div class="liststate" id="style-3">
                                                                    <ul class="checkbox pl-0">
                                                                        <li class="list-group-item fnt">
                                                                            <input type="checkbox" :value="'nosetaside'"
                                                                                v-model="user.set_asides"
                                                                                class="form-check-input me-2"
                                                                                @click="noSetAside('nosetaside')"
                                                                                ref="rolesSelected" />No Set Aside
                                                                        </li>
                                                                        <li class="list-group-item fnt"
                                                                            v-for="set_aside, key in set_aside_sorted"
                                                                            :key="key">
                                                                            <input class="form-check-input me-1"
                                                                                type="checkbox"
                                                                                :value="set_aside.set_aside_id"
                                                                                v-model="user.set_asides"
                                                                                @change="updateCheckall"
                                                                                aria-label="..." />

                                                                            {{ set_aside.set_aside_name }}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <span v-if="errors.set_asides"
                                                style="color:#dc3545; margin-top:5px;font-size:0.875em">{{
                                                errors.set_asides[0] }}</span>
                                        </div>
                                        <!-- <div class="col-md-12">
                                            <input type="checkbox"  class="form-check-input me-2" @click="noSetAside()"  ref="rolesSelected" />
                                            <label>No Set Aside</label>
                                        </div> -->
                                        <div class="col-md-12">
                                            <input type="checkbox" v-model="user.terms" @click="checkboxtext()"
                                                class="form-check-input me-2" id="rememberCheck" ref="rolesSelected" />
                                            <span class="form-check-label" for="rememberCheck"
                                                style="color: grey;font-size: 14px;">
                                                By signing up you agree to our <router-link to="/terms&condition"> Terms
                                                    & Conditions </router-link> and <router-link to="/privacy_policy">
                                                    Privacy Policy </router-link>.
                                            </span>
                                        </div>
                                        <span v-if="errors.terms"
                                            style="color: #dc3545; margin-top:5px;font-size:0.875em">{{
                                                errors.terms[0] ?'Accept the Terms & Conditions to Proceed':'' }}</span>
                                        <div style="text-align: center;"><button type="submit"
                                                class="btn btn-primary mb-0">Sign up</button></div>
                                    </form>
                                    <!-- Form END -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card box">
                        <div class="recommendation-component">
                            <div class="ng-binding baner-title"><b>WHY BIDSPORTAL</b></div>
                            <p class="spacing-bottom ng-binding">Registered vendors receive complete access to
                                pre-solicitation, solicitations, RFPs, bids, quotes, addenda & awards posted by buyers.
                            </p>

                            <div class="row recommendation-row">
                                <div class="col-md-12 col-sm-4 ng-scope">
                                    <div class="recommendation-panel cursor-pointer" title="">
                                        <div class="recommendation-header">
                                            <h3 class="ng-binding baner-title">Targeted Bids</h3>
                                            <img src="@/assets/signup/signup-email.svg" width="24"
                                                style="height: 24px !important;" alt="Emails" />
                                        </div>

                                        <div class="recommendation-details baner-text ng-binding">
                                            Precisely matched government opportunities
                                            <span class="ng-binding"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4 ng-scope">
                                    <div class="recommendation-panel cursor-pointer" title="Add to cart">
                                        <div class="recommendation-header">
                                            <h3 class="ng-binding baner-title">Auto Email Notifications</h3>
                                            <img src="@/assets/signup/signup-bell.svg" width="24"
                                                style="height: 24px !important;" alt="Web Push" />
                                        </div>

                                        <div class="recommendation-details ng-binding baner-text">
                                            We'll send the most relevant matching opportunities straight to your inbox
                                            as soon as they become available
                                            <span class="ng-binding"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4 ng-scope">
                                    <div class="recommendation-panel cursor-pointer" title="Add to cart">
                                        <div class="recommendation-header">
                                            <h3 class="ng-binding baner-title">Select Bids by State</h3>
                                            <img src="@/assets/signup/signup-select.svg" width="24"
                                                style="height: 24px !important;" alt="Transactional" />
                                        </div>

                                        <div class="recommendation-details ng-binding baner-text">
                                            Government bids and RFPs by region sirectly to your inbox. With our Bid
                                            Alert service, finding opportunities to win contracts couldn't be easier.
                                            <span class="ng-binding"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4 ng-scope">
                                    <div class="recommendation-panel cursor-pointer" title="Add to cart">
                                        <div class="recommendation-header">
                                            <h3 class="ng-binding baner-title">Easy to use</h3>
                                            <img src="@/assets/signup/signup-easy.svg" width="24"
                                                style="height: 24px !important;" alt="Chat-bots" />
                                        </div>

                                        <div class="recommendation-details ng-binding baner-text">
                                            Our bid search and custom alert user-friendly interface ensures your team's
                                            efficiency is just a few clicks away.
                                            <span class="ng-binding"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4 ng-scope">
                                    <div class="recommendation-panel cursor-pointer" title="Add to cart">
                                        <div class="recommendation-header">
                                            <h3 class="ng-binding baner-title">Document Search</h3>
                                            <img src="@/assets/signup/signup-document.svg" width="24"
                                                style="height: 24px !important;" alt="Sites" />
                                        </div>

                                        <div class="recommendation-details ng-binding baner-text">
                                            Our unique algorithm lets you search and retrieve procurement documents
                                            instantly.
                                            <span class="ng-binding"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4 ng-scope">
                                    <div class="recommendation-panel cursor-pointer" title="Add to cart">
                                        <div class="recommendation-header">
                                            <h3 class="ng-binding baner-title">Comprehensive Database</h3>
                                            <img src="@/assets/signup/signup-comprehensive.svg" width="24"
                                                style="height: 24px !important;" alt="Emails" />
                                        </div>

                                        <div class="recommendation-details ng-binding baner-text">
                                            Updated daily with thousands of procurement notices retrieved from Federal,
                                            State, Funding Agencies, Schools and Hospitals etc.
                                            <span class="ng-binding"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
export default {
    components: { Loading },
    data() {
        return {
            // no_Set_Aside: false,
            set_aside_keyword:'',
            searcFederal: [],
            checkmsg: "",
            type: "password",
            icon: false,
            type1: "password",
            icon1: false,
            male: "Male",
            female: "Female",
            set_asides: [],
            set_aside_sorted: [],
            selectedFederal: [],
            state_country: [],
            selectAll: false,
            selectAllFederal: false,
            agencyFederal: [],
            regSetAside: [],
            searchstate: "",
            user: {
                terms: false,
                name: '',
                email: '',
                password: '',
                confirm_password: '',
                position: '',
                gender: '',
                phone: '',
                country: '',
                city: '',
                company_name: '',
                address: '',
                mailing_address: '',
                web_address: '',
                zipcode: '',
                state: '',
                socioeconomic_status: '',
                set_asides: []
            },
            // user: {
            //     terms: false,
            //     name: "Bharatesh Shanawad",
            //     email: "bharatesh@aeriesys.com",
            //     password: "Bharatesh12345%",
            //     confirm_password: "Bharatesh12345%",
            //     title: "Mr.",
            //     gender: "",
            //     phone: "9535342875",
            //     country: "",
            //     city: "Belgaum",
            //     company_name: "Aeriesys tech",
            //     address: "",
            //     mailing_address: "bharatesh@aeriesys.com",
            //     web_address: "https://aeriesys.com",
            //     zipcode: "590001",
            //     state: "Karnataka",
            //     status: "pending",
            //     socioeconomic_status: "",
            // },
            showPass: false,
            registeruser: [],
            terms: false,
            errors: [],
            coutsetside: 0,
            isLoading: false,
            fullPage: true,
        };
    },
    mounted() {
        this.getSetAsides();
    },
    computed: {
    },
    methods: {
        sortSetAside(){
            this.set_aside_sorted = []
            this.set_aside_sorted = this.set_asides.filter((set_aside) => {
                return set_aside.set_aside_name.toLowerCase().includes(this.set_aside_keyword.toLowerCase());
            });
        },

        getSetAsides() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getSetAsides" })
                .then(function (response) {
                    vm.set_asides = response.data
                    vm.set_aside_sorted = vm.set_asides
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        checkboxtext() {
            let vm = this;
            if (vm.$refs.rolesSelected.terms !== false) {
                vm.checkmsg = "";
            } else {
                vm.checkmsg = "";
            }
        },
        register() {
            let vm = this;
            if (vm.user.set_asides.length) {
                vm.user.socioeconomic_status = true
            } else {
                vm.user.socioeconomic_status = null
            }
            vm.user.phone = vm.user.phone.replace(/-/g, "");
            vm.isLoading = true;
            vm.$store
                .dispatch("auth", { uri: "register", data: vm.user })
                .then(function (response) {
                    vm.isLoading = false;
                    vm.$store.dispatch("success", "Thank you for registering with us");
                    vm.$router.push("/login");
                })
                .catch(function (error) {
                    console.error("error", error);
                    vm.isLoading = false;
                    vm.errors = error.response?.data?.errors;
                });
        },
        toggle() {
            let vm = this;

            if (vm.type == "password") {
                vm.type = "text";
                vm.icon = true;
            } else {
                vm.type = "password";
                vm.icon = false;
            }
        },
        toggle1() {
            let vm = this;

            if (vm.type1 == "password") {
                vm.type1 = "text";
                vm.icon1 = true;
            } else {
                vm.type1 = "password";
                vm.icon1 = false;
            }
        },

        selectAllSetAsides() {
            let vm = this
            this.set_aside_sorted.map(function (element) {
                vm.user.set_asides.push(element.set_aside_id)
            })
        },
        deselectSetAsides() {
            this.set_aside_sorted = this.set_asides
            this.user.set_asides = [];
        },
        updateCheckall() {
            if (this.regSetAside.length > 0) {
                if (this.regSetAside[0] == 'nosetaside') {
                    this.regSetAside.splice(0, 1);
                }
            }
            if (this.set_asides.length == this.regSetAside.length) {
                // this.no_Set_Aside=false;
                this.selectAll = true;
                this.status_id = this.regSetAside;
            } else {
                this.selectAll = false;
                this.status_id = this.regSetAside;
            }
        },
        noSetAside(data) {
            let vm = this;
            vm.regSetAside = [];
            vm.regSetAside.push(data);
        },
        changePhoneFormat() {
            var x = this.user.phone.replace(/\D/g, "").match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            this.user.phone = !x[2] ? x[1] : x[1] + "-" + x[2] + (x[3] ? "-" + x[3] : "");
            console.log(this.user.phone)
        },
    },
};
</script>
<style scoped>
.textinput {
    border-radius: 0 !important;
}

.liststate {
    max-height: 200px;
    /* margin-bottom: 10px; */
    overflow-y: scroll;
    -webkit-overflow-scrolling: touch;
}

.list-group-item:first-child {
    border-top-left-radius: none !important;
    border-top-right-radius: none !important;
}

/* floating label */

.did-floating-label-content {
    position: relative;
    margin-bottom: 20px;
}

.did-floating-label {
    color: #1e4c82;
    font-size: 16px;
    font-weight: normal;
    position: absolute;
    pointer-events: none;
    left: 15px;
    top: 11px;
    padding: 0 5px;
    background: #fff;
    transition: 0.2s ease all;
    -moz-transition: 0.2s ease all;
    -webkit-transition: 0.2s ease all;
}

.did-floating-input,
.did-floating-select {
    font-size: 16px;
    display: block;
    width: 100%;
    height: 52px;
    padding: 0 20px;
    background: #fff;
    color: #323840;
    border: 1px solid #3d85d8;
    border-radius: 4px;
    box-sizing: border-box;
}

.did-floating-input:focus,
.did-floating-select:focus {
    outline: none;
}

.did-floating-input:focus~.did-floating-label,
.did-floating-select:focus~.did-floating-label {
    top: -8px;
    font-size: 13px;
}

select.did-floating-select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

select.did-floating-select::-ms-expand {
    display: none;
}

.did-floating-input:not(:placeholder-shown)~.did-floating-label {
    top: -8px;
    font-size: 13px;
}

.did-floating-select:not([value=""]):valid~.did-floating-label {
    top: -8px;
    font-size: 13px;
}

.did-floating-select[value=""]:focus~.did-floating-label {
    top: 11px;
    font-size: 13px;
}

.did-floating-select:not([multiple]):not([size]) {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='6' viewBox='0 0 8 6'%3E%3Cpath id='Path_1' data-name='Path 1' d='M371,294l4,6,4-6Z' transform='translate(-371 -294)' fill='%23003d71'/%3E%3C/svg%3E%0A");
    background-position: right 15px top 50%;
    background-repeat: no-repeat;
}

.did-error-input .did-floating-input,
.did-error-input .did-floating-select {
    border: 2px solid #9d3b3b;
    color: #9d3b3b;
}

.did-error-input .did-floating-label {
    font-weight: 600;
    color: #9d3b3b;
}

.did-error-input .did-floating-select:not([multiple]):not([size]) {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='6' viewBox='0 0 8 6'%3E%3Cpath id='Path_1' data-name='Path 1' d='M371,294l4,6,4-6Z' transform='translate(-371 -294)' fill='%239d3b3b'/%3E%3C/svg%3E%0A");
}

.input-group {
    /* display: flex; */
    flex-wrap: none !important;
}

.input-group .did-floating-input {
    border-radius: 0 4px 4px 0;
    border-right: none !important;
    padding-left: none;
}

.input-group-append {
    display: flex;
    align-items: center;
}

/* margin-left:-1px;
 */
.input-group-text {
    display: flex;
    align-items: center;
    font-weight: 400;
    height: 52px;
    color: #323840;
    padding: 0 5px 0 20px;
    font-size: 16px;
    text-align: center;
    white-space: nowrap;
    border: 1px solid #3d85d8;
    border-radius: 4px 0 0 4px;
    border-left: none;
}

.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url(data:image/svg+xml,%3csvg xmlns=http://www.w3.org/2000/svg viewBox=0 0 12 12 width=12 height=12 fill=none stroke=%23dc3545%3e%3ccircle cx=6 cy=6 r=4.5/%3e%3cpath stroke-linejoin=round d=M5.8 3.6h.4L6 6.5z/%3e%3ccircle cx=6 cy=8.2 r=.6 fill=%23dc3545 stroke=none/%3e%3c/svg%3e);
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.is-passinvalid {
    border-color: #dc3545;
}

.btnwht10 {
    background-color: white !important;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.btnwht10:hover {
    background-color: white !important;
}

.dropdown-item:hover,
.dropdown-item:focus {
    color: inherit;
    background-color: transparent;
}

.fnt {
    font-size: 15px;
    font-weight: 400;
}

.pl-0 {
    padding-left: 5px !important;
}

.scrollaside ::-webkit-scrollbar {
    width: 5px !important;
    height: 5px !important;

    cursor: pointer !important;
}

/* Track */
.scrollaside::-webkit-scrollbar-track {
    border-radius: 10px !important;
}

/* Handle */
.scrollaside ::-webkit-scrollbar-thumb {
    background-color: #5143d9 !important;
    border-radius: 10px !important;
}
</style>