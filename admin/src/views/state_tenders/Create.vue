<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between">
            <h2 class="main-title mb-3">New State Tender</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>Add State Bid</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Region <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" :class="{ 'is-invalid': errors.region }" v-model="tender.region">
                                        <option value="state">State</option>
                                        <option value="federal">Federal</option>
                                        <option value="private">Private/Commercial</option>
                                        <option value="international">International</option>
                                    </select>
                                    <span v-if="errors.region" class="invalid-feedback">{{ errors.region[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Country <span class="text-danger">*</span></label>
                                    <search :class="{ 'is-invalid': errors?.country_id }"
                                        :customClass="{ 'is-invalid': errors?.country_id }" :initialize="tender.country_id" id="country_id"
                                        label="country_name" placeholder="Select Country" :data="countries" @input="country => handleCountryChange(country)">
                                    </search>
                                    <span v-if="errors.country_id" class="invalid-feedback">{{ errors.country_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>State / Location Issued <span class="text-danger">*</span></label>
                                    <search :class="{ 'is-invalid': errors?.state_id }"
                                        :customClass="{ 'is-invalid': errors?.state_id }" :initialize="tender.state_id" id="state_id"
                                        label="state_name" placeholder="Select State" :data="states" @input=" state => tender.state_id = state">
                                    </search>
                                    <span v-if="errors.state_id" class="invalid-feedback">{{ errors.state_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Bid / RFP Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.tender_no }" v-model="tender.tender_no" />
                                    <span v-if="errors.tender_no" class="invalid-feedback">{{ errors.tender_no[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Bid Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.title }" v-model="tender.title" />
                                    <span v-if="errors.title" class="invalid-feedback">{{ errors.title[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Issuing Agency </label>
                                    <search :class="{ 'is-invalid': errors?.state_agency_id }"
                                        :customClass="{ 'is-invalid': errors?.state_agency_id }" :initialize="tender.state_agency_id" id="state_agency_id"
                                        label="state_agency_name" placeholder="Select Agency" :data="agencies" @input=" agency => tender.state_agency_id = agency" @updateAgencies="updateAgencies">
                                    </search>
                                    <span class="invalid-feedback" v-if="errors?.state_agency_id?.length">{{ errors?.state_agency_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Notice </label>
                                    <select class="form-control form-control-sm" :class="{'is-invalid' : errors?.state_notice_id }" v-model="tender.state_notice_id">
                                        <option value="null">Select Notice</option>
                                        <option v-for="notice, notice_key in notices" :key="notice_key" :value="notice.state_notice_id">{{ notice.notice_name }}</option>
                                    </select>
                                    <span class="invalid-feedback" v-if="errors?.state_notice_id?.length">{{ errors?.state_notice_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Opening Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm" :class="{ 'is-invalid': errors.opening_date }" v-model="tender.opening_date" />
                                    <span v-if="errors.opening_date" class="invalid-feedback">{{ errors.opening_date[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Due Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm" :class="{ 'is-invalid': errors.expiry_date }" v-model="tender.expiry_date" />
                                    <span v-if="errors.expiry_date" class="invalid-feedback">{{ errors.expiry_date[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">Place of Performance</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>City </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.place_of_performance?.city_name }" v-model="tender.place_of_performance.city_name" />
                                    <span v-if="errors.place_of_performance?.city_name" class="invalid-feedback">{{ errors.place_of_performance?.city_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>State </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.place_of_performance?.state_name }" v-model="tender.place_of_performance.state_name" />
                                    <span v-if="errors.place_of_performance?.state_name" class="invalid-feedback">{{ errors.place_of_performance?.state_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Country </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.place_of_performance?.country_name }" v-model="tender.place_of_performance.country_name" />
                                    <span v-if="errors.place_of_performance?.country_name" class="invalid-feedback">{{ errors.place_of_performance?.country_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">Contracting Office Address</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>City </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.contracting_office_address?.city }" v-model="tender.contracting_office_address.city" />
                                    <span v-if="errors.contracting_office_address?.city" class="invalid-feedback">{{ errors.contracting_office_address?.city[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>State </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.contracting_office_address?.state }" v-model="tender.contracting_office_address.state" />
                                    <span v-if="errors.contracting_office_address?.state" class="invalid-feedback">{{ errors.contracting_office_address?.state[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Country </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.contracting_office_address?.country }" v-model="tender.contracting_office_address.country" />
                                    <span v-if="errors.contracting_office_address?.country" class="invalid-feedback">{{ errors.contracting_office_address?.country[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Bid Posting Link </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.tender_url }" v-model="tender.tender_url" />
                                    <span v-if="errors.tender_url" class="invalid-feedback">{{ errors.tender_url[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Single Download Fee </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.fees }" v-model="tender.fees" />
                                    <span v-if="errors.fees" class="invalid-feedback">{{ errors.fees[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 margin_top">
                                <div class="form-group">
                                    <label>Category </label>
                                    <search :class="{ 'is-invalid': errors?.category_id }"
                                        :customClass="{ 'is-invalid': errors?.category_id }" :initialize="tender.category_id" id="category_id"
                                        label="category_name" placeholder="Select Category" :data="categories" @input=" category => tender.category_id = category">
                                    </search>
                                    <span class="invalid-feedback" v-if="errors?.category_id?.length">{{ errors?.category_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">
                                <div class="form-group">
                                    <label>Bid Description </label>
                                    <ckeditor :editor="editor" v-model="tender.description"></ckeditor>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">Primary Address</div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.primary_address?.title }" v-model="tender.primary_address.title" />
                                    <span class="invalid-feedback" v-if="errors?.primary_address?.title?.length">{{ errors?.primary_address?.title[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Full Name </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.primary_address?.full_name }" v-model="tender.primary_address.full_name" />
                                    <span class="invalid-feedback" v-if="errors?.primary_address?.full_name?.length">{{ errors?.primary_address?.full_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.primary_address?.email }" v-model="tender.primary_address.email" />
                                    <span class="invalid-feedback" v-if="errors?.primary_address?.email?.length">{{ errors?.primary_address?.email[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Phone </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.primary_address?.phone }" v-model="tender.primary_address.phone" />
                                    <span class="invalid-feedback" v-if="errors?.primary_address?.phone?.length">{{ errors?.primary_address?.phone[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 margin_top">Secodary Address</div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.secondary_address?.title }" v-model="tender.secondary_address.title" />
                                    <span class="invalid-feedback" v-if="errors?.secondary_address?.title?.length">{{ errors?.secondary_address?.title[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Full Name </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.secondary_address?.full_name }" v-model="tender.secondary_address.full_name" />
                                    <span class="invalid-feedback" v-if="errors?.secondary_address?.full_name?.length">{{ errors?.secondary_address?.full_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.secondary_address?.email }" v-model="tender.secondary_address.email" />
                                    <span class="invalid-feedback" v-if="errors?.secondary_address?.email?.length">{{ errors?.secondary_address?.email[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Phone </label>
                                    <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': errors.secondary_address?.phone }" v-model="tender.secondary_address.phone" />
                                    <span class="invalid-feedback" v-if="errors?.secondary_address?.phone?.length">{{ errors?.secondary_address?.phone[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3 margin_top">
                                <div class="form-group">
                                    <label>Attachments </label>
                                    <input type="file" class="form-control form-control-sm" :class="{ 'is-invalid': errors.attachments }" multiple @change="handleFileUpload($event)" />
                                    <span class="invalid-feedback" v-if="errors?.attachments?.length">{{ errors?.attachments[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div style="float:right">
                            <button class="btn btn-warning">Discard</button>
                            <button class="btn btn-primary" style="margin-left:10px" @click="addTender()">Sumbit</button>
                        </div>
                    </div>
                </div>
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
            search
        },
        
        data() {
            return {
                tender:{
                    region : 'state',
                    country_id :'10',
                    state_id : '',
                    tender_no : '',
                    title : '',
                    description: '',
                    state_agency_id : '',
                    state_notice_id : '',
                    opening_date : '',
                    expiry_date : '',
                    tender_url: '',
                    fees: '',
                    category_id : '',
                    place_of_performance: {
                        city_name : '',
                        state_name : '',
                        country_name : ''
                    },
                    contracting_office_address : {
                        city : '',
                        state : '',
                        country : ''
                    },
                    primary_address:{
                        title:'',
                        full_name:'',
                        email:'',
                        phone:''
                    },
                    secondary_address:{
                        title:'',
                        full_name:'',
                        email:'',
                        phone:''
                    },
                    attachments:[]
                },
                countries:[],
                states:[],
                notices:[],
                categories:[],
                agencies:[],
                errors:[],
                editor: ClassicEditor,
            };
        },
        mounted() {
            this.getCountries() 
            if(this.tender.country_id){
                this.getStates()
            }
        },
        methods: {
                                 
            handleFileUpload(event) {
                this.tender.attachments = event.target.files
            },
            addTender() {
                let vm = this;
                let loader = vm.$loading.show();
                const formData = new FormData();
                for (var i = 0; i < vm.tender.attachments.length; i++ ){
                    formData.append('attachments[' + i + ']', vm.tender.attachments[i])
                }
                formData.append('country_id', vm.tender.country_id)
                formData.append('state_id', vm.tender.state_id)
                formData.append('tender_no', vm.tender.tender_no)
                formData.append('title', vm.tender.title)
                formData.append('state_agency_id', vm.tender.state_agency_id)
                formData.append('state_notice_id', vm.tender.state_notice_id)
                formData.append('opening_date', vm.tender.opening_date)
                formData.append('expiry_date', vm.tender.expiry_date)
                formData.append('place_of_performance', JSON.stringify(vm.tender.place_of_performance))
                formData.append('contracting_office_address', JSON.stringify(vm.tender.contracting_office_address))
                formData.append('tender_url', vm.tender.tender_url)
                formData.append('fees', vm.tender.fees)
                formData.append('category_id', vm.tender.category_id)
                formData.append('description', vm.tender.description)
                formData.append('primary_address', JSON.stringify(vm.tender.primary_address))
                formData.append('secondary_address', JSON.stringify(vm.tender.secondary_address))                    

                vm.$store
                    .dispatch("multipart_formdata", { uri: "addStateTender", data: formData })
                    .then(() => {
                        loader.hide();
                        vm.discard()
                        // vm.$router.push('/state_tenders')
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            discard(){
                this.tender.region = 'state',
                this.tender.country_id ='10',
                this.tender.state_id = '',
                this.tender.tender_no = '',
                this.tender.title = '',
                this.tender.description= '',
                this.tender.state_agency_id = '',
                this.tender.state_notice_id = '',
                this.tender.opening_date = '',
                this.tender.expiry_date = '',
                this.tender.tender_url = '',
                this.tender.fees = '',
                this.tender.category_id = '',
                this.tender.place_of_performance = {
                    city_name : '',
                    state_name : '',
                    country_name : ''
                },
                this.tender.contracting_office_address = {
                    city : '',
                    state : '',
                    country : ''
                },
                this.tender.primary_address = {
                    title : '',
                    full_name : '',
                    email : '',
                    phone : ''
                },
                this.tender.secondary_address = {
                    title : '',
                    full_name : '',
                    email : '',
                    phone : ''
                },
                this.tender.attachments = []
            },

            handleCountryChange(country) {
                this.tender.country_id = country
                if(typeof this.tender.country_id === 'number'){
                    this.getStates()
                }
            },                        
            getCountries() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "getCountries" })
                    .then((response) => {
                        loader.hide();
                        vm.countries = response.data
                        vm.getStateNotices()
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
                    .dispatch("post", { uri: "getStates", data:vm.tender })
                    .then((response) => {
                        loader.hide();
                        vm.states = response.data
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getStateNotices() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "getStateNotices", data:{ meta:{region_id:1}} })
                    .then((response) => {
                        loader.hide();
                        vm.notices = response.data
                        vm.getCategories()
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
                        vm.categories = response.data
                        vm.getStateAgencies()
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getStateAgencies() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getStateAgencies" })
                    .then((response) => {
                        vm.agencies = response.data
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
        },
    };
</script>
<style scoped>
    .margin_top{   
        margin-top: 20px;
    }
</style>