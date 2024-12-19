<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Private Tender</h2>
            <router-link to="/private_tenders" class="btn btn-primary mb-2">Private Bids</router-link>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <form class="card" @submit.prevent="submitForm()">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0" v-if="status"><strong>Add Private Bid</strong></h6>
                            <h6 class="card-title mb-0" v-else><strong>Update Private Bid</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Region <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm"
                                        :class="{ 'is-invalid': errors?.region }" v-model="tender.region">
                                        <option value="state">State</option>
                                        <option value="federal">Federal</option>
                                        <option value="private">Private/Commercial</option>
                                        <option value="international">International</option>
                                    </select>
                                    <span v-if="errors?.region" class="invalid-feedback">{{ errors?.region[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Country <span class="text-danger">*</span></label>
                                    <search :class="{ 'is-invalid': errors?.country_id }"
                                        :customClass="{ 'is-invalid': errors?.country_id }"
                                        :initialize="tender.country_id" id="country_id" label="country_name"
                                        placeholder="Select Country" :data="countries"
                                        @input="country => handleCountryChange(country)">
                                    </search>
                                    <span v-if="errors?.country_id" class="invalid-feedback">{{ errors?.country_id[0]
                                        }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>State / Location Issued <span class="text-danger">*</span></label>
                                    <search :class="{ 'is-invalid': errors?.state_id }"
                                        :customClass="{ 'is-invalid': errors?.state_id }" :initialize="tender.state_id"
                                        id="state_id" label="state_name" placeholder="Select State" :data="states"
                                        @input="state => tender.state_id = state">
                                    </search>
                                    <span v-if="errors?.state_id" class="invalid-feedback">{{ errors?.state_id[0]
                                        }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Bid / RFP Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Bid / RFP Number" :class="{ 'is-invalid': errors?.tender_no }"
                                        v-model="tender.tender_no" />
                                    <span v-if="errors?.tender_no" class="invalid-feedback">{{ errors?.tender_no[0]
                                        }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Bid Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Bid Title"
                                        :class="{ 'is-invalid': errors?.title }" v-model="tender.title" />
                                    <span v-if="errors?.title" class="invalid-feedback">{{ errors?.title[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Issuing Agency </label>
                                    <search :class="{ 'is-invalid': errors?.private_agency_id }"
                                        :customClass="{ 'is-invalid': errors?.private_agency_id }"
                                        :initialize="tender.private_agency_id" id="private_agency_id"
                                        label="private_agency_name" placeholder="Select Agency" :data="agencies"
                                        @input="agency => tender.private_agency_id = agency"
                                        @updateAgencies="updateAgencies">
                                    </search>
                                    <span class="invalid-feedback" v-if="errors?.private_agency_id?.length">{{
                                        errors?.private_agency_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Notice </label>
                                    <select class="form-control form-control-sm"
                                        :class="{ 'is-invalid': errors?.private_notice_id }"
                                        v-model="tender.private_notice_id">
                                        <option value="">Select Notice</option>
                                        <option v-for="notice, notice_key in notices" :key="notice_key"
                                            :value="notice.private_notice_id">{{ notice.private_notice_name }}</option>
                                    </select>
                                    <span class="invalid-feedback" v-if="errors?.private_notice_id?.length">{{
                                        errors?.private_notice_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Opening Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm" placeholder="Opening Date"
                                        :class="{ 'is-invalid': errors?.opening_date }" v-model="tender.opening_date" />
                                    <span v-if="errors?.opening_date" class="invalid-feedback">{{
                                        errors?.opening_date[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Due Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm" placeholder="Due Date"
                                        :class="{ 'is-invalid': errors?.expiry_date }" v-model="tender.expiry_date" />
                                    <span v-if="errors?.expiry_date" class="invalid-feedback">{{ errors?.expiry_date[0]
                                        }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">Contracting Office Address</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>City </label>
                                    <input type="text" class="form-control form-control-sm" placeholder="City"
                                        :class="{ 'is-invalid': errors?.private_office_address?.city }"
                                        v-model="tender.private_office_address.city" />
                                    <span v-if="errors.private_office_address?.city" class="invalid-feedback">{{
                                        errors?.private_office_address?.city[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>State </label>
                                    <input type="text" class="form-control form-control-sm"
                                        :class="{ 'is-invalid': errors.private_office_address?.state }"
                                        placeholder="State" v-model="tender.private_office_address.state" />
                                    <span v-if="errors.private_office_address?.state" class="invalid-feedback">{{
                                        errors.private_office_address?.state[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Country </label>
                                    <input type="text" class="form-control form-control-sm"
                                        :class="{ 'is-invalid': errors.private_office_address?.country }"
                                        placeholder="Country" v-model="tender.private_office_address.country" />
                                    <span v-if="errors.private_office_address?.country" class="invalid-feedback">{{
                                        errors.private_office_address?.country[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Bid Posting Link </label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Bid Posting Link" :class="{ 'is-invalid': errors.tender_url }"
                                        v-model="tender.tender_url" />
                                    <span v-if="errors.tender_url" class="invalid-feedback">{{ errors.tender_url[0]
                                        }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Single Download Fee </label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Single Download Fee" :class="{ 'is-invalid': errors.fees }"
                                        v-model="tender.fees" />
                                    <span v-if="errors.fees" class="invalid-feedback">{{ errors.fees[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Category </label>
                                    <search :class="{ 'is-invalid': errors?.category_id }"
                                        :customClass="{ 'is-invalid': errors?.category_id }"
                                        :initialize="tender.category_id" id="category_id" label="category_name"
                                        placeholder="Select Category" :data="categories"
                                        @input="category => tender.category_id = category">
                                    </search>
                                    <span class="invalid-feedback" v-if="errors?.category_id?.length">{{
                                        errors?.category_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">
                                <div class="form-group">
                                    <label>Bid Description <span class="text-danger">*</span></label>
                                    <ckeditor :editor="editor" v-model="tender.description"
                                        :class="{ 'is-invalid': errors?.description }"></ckeditor>
                                    <span class="invalid-feedback" v-if="errors?.description?.length">{{
                                        errors?.description[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">Primary Address</div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Title"
                                        :class="{ 'is-invalid': errors.primary_address?.title }"
                                        v-model="tender.primary_address.title" />
                                    <span class="invalid-feedback" v-if="errors?.primary_address?.title?.length">{{
                                        errors?.primary_address?.title[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Full Name </label>
                                    <input type="text" class="form-control form-control-sm"
                                        :class="{ 'is-invalid': errors.primary_address?.full_name }"
                                        placeholder="Full Name" v-model="tender.primary_address.full_name" />
                                    <span class="invalid-feedback" v-if="errors?.primary_address?.full_name?.length">{{
                                        errors?.primary_address?.full_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Email"
                                        :class="{ 'is-invalid': errors.primary_address?.email }"
                                        v-model="tender.primary_address.email" />
                                    <span class="invalid-feedback" v-if="errors?.primary_address?.email?.length">{{
                                        errors?.primary_address?.email[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Phone </label>
                                    <input type="text" class="form-control form-control-sm"
                                        :class="{ 'is-invalid': errors.primary_address?.phone }" placeholder="Phone"
                                        v-model="tender.primary_address.phone" />
                                    <span class="invalid-feedback" v-if="errors?.primary_address?.phone?.length">{{
                                        errors?.primary_address?.phone[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">Secodary Address</div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Title"
                                        :class="{ 'is-invalid': errors.secondary_address?.title }"
                                        v-model="tender.secondary_address.title" />
                                    <span class="invalid-feedback" v-if="errors?.secondary_address?.title?.length">{{
                                        errors?.secondary_address?.title[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Full Name </label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Full Name"
                                        :class="{ 'is-invalid': errors.secondary_address?.full_name }"
                                        v-model="tender.secondary_address.full_name" />
                                    <span class="invalid-feedback"
                                        v-if="errors?.secondary_address?.full_name?.length">{{
                                            errors?.secondary_address?.full_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Email"
                                        :class="{ 'is-invalid': errors.secondary_address?.email }"
                                        v-model="tender.secondary_address.email" />
                                    <span class="invalid-feedback" v-if="errors?.secondary_address?.email?.length">{{
                                        errors?.secondary_address?.email[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Phone </label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Phone"
                                        :class="{ 'is-invalid': errors.secondary_address?.phone }"
                                        v-model="tender.secondary_address.phone" />
                                    <span class="invalid-feedback" v-if="errors?.secondary_address?.phone?.length">{{
                                        errors?.secondary_address?.phone[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3 margin_top">
                                <div class="form-group">
                                    <label>Attachments </label>
                                    <input type="file" class="form-control form-control-sm"
                                        :class="{ 'is-invalid': errors.attachments }" multiple
                                        @change="handleFileUpload($event)" />
                                    <span class="invalid-feedback" v-if="errors?.attachments?.length">{{
                                        errors?.attachments[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-warning me-2" type="button" @click="discard()">Discard</button>
                        <button class="btn btn-primary " type="submit">
                            <span v-if="status">Submit </span>
                            <span v-else>Update </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import search from "@/components/Search.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
    components: {
        // Pagination,
        search,
    },

    data() {
        return {
            status: true,
            tender: {
                private_tender_id: "",
                region: "private",
                country_id: "10",
                state_id: "",
                tender_no: "",
                title: "",
                description: "",
                private_agency_id: "",
                private_notice_id: "",
                opening_date: "",
                expiry_date: "",
                tender_url: "",
                fees: "",
                category_id: "",
                // place_of_performance: {
                //     city_name: '',
                //     state_name: '',
                //     country_name: ''
                // },
                private_office_address: {
                    city: "",
                    state: "",
                    country: "",
                },
                primary_address: {
                    title: "",
                    full_name: "",
                    email: "",
                    phone: "",
                },
                secondary_address: {
                    title: "",
                    full_name: "",
                    email: "",
                    phone: "",
                },
                attachments: [],
            },
            countries: [],
            states: [],
            notices: [],
            categories: [],
            agencies: [],
            errors: [],
            editor: ClassicEditor,
        };
    },
    // mounted() {
    //     this.getCountries()
    //     if (this.tender.country_id) {
    //         this.getStates()
    //     }
    // },
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            vm.getCountries();
            if (vm.tender.country_id) {
                vm.getStates();
            }
            // vm.getRoles();
            if (to.name == "AddPrivateTender") {
                // vm.$refs.name.focus();
            } else {
                vm.status = false;
                let uri = { uri: "getPrivateTender", data: { private_tender_id: to.params.private_tender_id } };
                vm.$store
                    .dispatch("post", uri)
                    .then(function (response) {
                        console.log("response-----", response.data.data);
                        vm.tender = response.data.data;
                    })
                    .catch(function (error) {
                        console.log("ERRr", error)
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        });
    },
    methods: {
        handleFileUpload(event) {
            this.tender.attachments = event.target.files;
        },
        submitForm() {
            let vm = this;
            if (vm.status) {
                vm.addTender();
            } else {
                vm.updateTender();
            }
        },
        addTender() {
            let vm = this;
            let loader = vm.$loading.show();
            const formData = new FormData();
            for (var i = 0; i < vm.tender?.attachments?.length; i++) {
                formData.append("attachments[" + i + "]", vm.tender.attachments[i]);
            }
            formData.append("country_id", vm.tender.country_id);
            formData.append("state_id", vm.tender.state_id);
            formData.append("tender_no", vm.tender.tender_no);
            formData.append("title", vm.tender.title);
            formData.append("private_agency_id", vm.tender.private_agency_id);
            formData.append("private_notice_id", vm.tender.private_notice_id);
            formData.append("opening_date", vm.tender.opening_date);
            formData.append("expiry_date", vm.tender.expiry_date);
            formData.append("place_of_performance", JSON.stringify(vm.tender.place_of_performance));
            formData.append("private_office_address", JSON.stringify(vm.tender.private_office_address));
            formData.append("tender_url", vm.tender.tender_url);
            formData.append("fees", vm.tender.fees);
            formData.append("category_id", vm.tender.category_id);
            formData.append("description", vm.tender.description);
            formData.append("primary_address", JSON.stringify(vm.tender.primary_address));
            formData.append("secondary_address", JSON.stringify(vm.tender.secondary_address));

            vm.$store
                .dispatch("multipart_formdata", { uri: "addPrivateTender", data: formData })
                .then(() => {
                    loader.hide();
                    vm.discard();
                    vm.$router.push("/private_tenders");
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        updateTender() {
            let vm = this;
            let loader = vm.$loading.show();
            const formData = new FormData();
            for (var i = 0; i < vm.tender?.attachments?.length; i++) {
                formData.append("attachments[" + i + "]", vm.tender.attachments[i]);
            }
            formData.append("private_tender_id", vm.tender.private_tender_id);
            formData.append("country_id", vm.tender.country_id);
            formData.append("state_id", vm.tender.state_id);
            formData.append("tender_no", vm.tender.tender_no);
            formData.append("title", vm.tender.title);
            formData.append("private_agency_id", vm.tender.private_agency_id);
            formData.append("private_notice_id", vm.tender.private_notice_id);
            formData.append("opening_date", vm.tender.opening_date);
            formData.append("expiry_date", vm.tender.expiry_date);
            formData.append("place_of_performance", JSON.stringify(vm.tender.place_of_performance));
            formData.append("private_office_address", JSON.stringify(vm.tender.private_office_address));
            formData.append("tender_url", vm.tender.tender_url);
            formData.append("fees", vm.tender.fees);
            formData.append("category_id", vm.tender.category_id);
            formData.append("description", vm.tender.description);
            formData.append("primary_address", JSON.stringify(vm.tender.primary_address));
            formData.append("secondary_address", JSON.stringify(vm.tender.secondary_address));
            vm.$store
                .dispatch("multipart_formdata", { uri: "updateTenderPrivate", data: formData })
                .then(() => {
                    loader.hide();
                    vm.discard();
                    vm.$router.push("/private_tenders");
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        discard() {
            (this.tender.region = "private"),
                (this.tender.country_id = "10"),
                (this.tender.state_id = ""),
                (this.tender.tender_no = ""),
                (this.tender.title = ""),
                (this.tender.description = ""),
                (this.tender.private_agency_id = ""),
                (this.tender.private_notice_id = ""),
                (this.tender.opening_date = ""),
                (this.tender.expiry_date = ""),
                (this.tender.tender_url = ""),
                (this.tender.fees = ""),
                (this.tender.category_id = ""),
                (this.tender.place_of_performance = {
                    city_name: "",
                    state_name: "",
                    country_name: "",
                }),
                (this.tender.private_office_address = {
                    city: "",
                    state: "",
                    country: "",
                }),
                (this.tender.primary_address = {
                    title: "",
                    full_name: "",
                    email: "",
                    phone: "",
                }),
                (this.tender.secondary_address = {
                    title: "",
                    full_name: "",
                    email: "",
                    phone: "",
                }),
                (this.tender.attachments = []);
        },

        handleCountryChange(country) {
            this.tender.country_id = country;
            if (typeof this.tender.country_id === "number") {
                this.getStates();
            }
        },
        getCountries() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "getCountries" })
                .then((response) => {
                    loader.hide();
                    vm.countries = response.data;
                    vm.getPrivateNotices();
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getStates() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "getStates", data: vm.tender })
                .then((response) => {
                    loader.hide();
                    vm.states = response.data;
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getPrivateNotices() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "getPrivateNotices", data: { meta: { region_id: 1 } } })
                .then((response) => {
                    loader.hide();
                    vm.notices = response.data.data;
                    vm.getCategories();
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getCategories() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "getCategories" })
                .then((response) => {
                    loader.hide();
                    vm.categories = response.data;
                    vm.getPrivateAgencies();
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getPrivateAgencies() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getPrivateAgencies" })
                .then((response) => {
                    vm.agencies = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
};
</script>
<style scoped>
.margin_top {
    margin-top: 20px;
}
</style>