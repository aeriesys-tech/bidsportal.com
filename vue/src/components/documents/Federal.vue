<template>
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#noticetype" role="button" aria-expanded="false" aria-controls="status">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{bluetextclass: meta.federal_notices?.length !== 0}">Notice Type</h6>

            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show" v-for="notice in federal_notices" :key="notice.notice_id">
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="meta.federal_notices" :value="notice.federal_notice_id" />
                    <label class="form-check-label">{{ notice.notice_name }}</label>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#posted" role="button" aria-expanded="false" aria-controls="response">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': meta.posted_date}">Posted Date</h6>
            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show">
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hour7" v-model="meta.posted_date" value="24 Hours" />
                    <label class="form-check-label" for="hour7">24 Hours</label>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hour7" v-model="meta.posted_date" value="2 Days" />
                    <label class="form-check-label" for="hour8">2 Days</label>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hour7" v-model="meta.posted_date" value="7 Days" />
                    <label class="form-check-label" for="hour9">7 Days</label>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hour7" v-model="meta.posted_date" value="21 Days" />
                    <label class="form-check-label" for="hour10">21 Days</label>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <input class="form-check-input" type="radio" name="hour12" v-model="meta.posted_date" value="custom" />
                    <label class="form-check-label" for="custom12"> &nbsp; Custom</label>
                    <div class="row" v-if="meta.posted_date=='custom'" style="margin-left: 0px;">
                        <div class="col-sm-6">
                            <label class="form-label">Start Date<span class="text-danger">*</span></label>
                            <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD" v-model:value="meta.posted_from_date" :clearable="false" ></date-picker>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">End Date<span class="text-danger">*</span></label>
                            <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD" v-model:value="meta.posted_to_date" :clearable="false" ></date-picker>
                        </div>
                    </div>

                    <span style="color: #dc3545;">{{ errors?.post_error }}</span>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#response" role="button" aria-expanded="false" aria-controls="response">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': meta.response_date}">Response Date</h6>

            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show">
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hour" v-model="meta.response_date" value="24 Hours" />
                    <label class="form-check-label" for="hour1">24 Hours</label>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio"  name="hour3" v-model="meta.response_date" value="2 Days" />
                    <label class="form-check-label" for="hour2">2 Days</label>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hour2" v-model="meta.response_date" value="7 Days" />
                    <label class="form-check-label" for="hour3">7 Days</label>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hour11" v-model="meta.response_date" value="21 Days" />
                    <label class="form-check-label" for="hour4">21 Days</label>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <input class="form-check-input" type="radio" name="hour" v-model="meta.response_date" value="custom" />
                    <label class="form-check-label" for="custom1"> &nbsp; Custom</label>
                    <div class="row" v-if="meta.response_date=='custom'" style="margin-left: 0px !important;">
                        <div class="col-sm-6">
                            <label class="form-label">Start Date<span class="text-danger">*</span></label>
                            <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD" v-model:value="meta.response_from_date" :clearable="false" ></date-picker>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">End Date<span class="text-danger">*</span></label>
                            <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD" v-model:value="meta.response_to_date" :clearable="false"></date-picker>
                        </div>
                    </div>
                    <span style="color: #dc3545;">{{ errors?.response_error }}</span>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more d-flex justify-content-between align-items-center" href="" role="button" aria-expanded="false" aria-controls="notice">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': meta.naics?.length}">Primary NAICS Code</h6>

            <a class="p-0 mb-0">
                <a class="gryy1" data-bs-toggle="modal" data-bs-target="#flightdetail" role="button" aria-expanded="true" aria-controls="collapseExample5">
                    <i class="fa fa-filter"></i>
                </a>
            </a>
        </div>
    </div>

    <hr class="my-0" />
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more d-flex justify-content-between align-items-center" href="" role="button" aria-expanded="false" aria-controls="notice">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': meta.pscs?.length}">Product & Service Code</h6>

            <a class="p-0 mb-0">
                <a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModal">
                    <i class="fa fa-filter"></i>
                </a>
            </a>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#location" role="button" aria-expanded="false" aria-controls="notice">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass':meta.states?.length !==0}">Location (Place of Performance)</h6>
            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-1">
                    <a class="btn btn-link p-0 mb-0 me-2">({{ meta.states.length }} of {{ states.length }})</a>
                    <span v-if="meta.states.length !== sorted_states.length"> 
                        <a href="" @click.prevent="selectAllStates()" class="form-check-label text-primary me-2">| Select All</a></span>
                    <span v-if="meta.states.length">
                        <a href="" class="form-check-label text-primary me-2" @click.prevent="deselectAllStates()">| Reset</a>
                    </span>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <form class="position-relative w-100 me-4 mb-2">
                    <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="searchStates()" v-model="federal_keyword" placeholder="Search State" aria-label="Search" />
                    <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                </form>
            </div>

            <div class="scroll-sidebar">
                <div class="d-flex justify-content-between align-items-center" v-for="state in sorted_states" :key="state.state_id">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" :value="state.state_id" v-model="meta.states" />
                        <label class="form-check-label"> {{state.state_name}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#federalagency" role="button" aria-expanded="false" aria-controls="notice">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': meta.federal_agencies?.length !==0}">Federal Agency</h6>

            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-1">
                    <a class="btn btn-link p-0 mb-0 me-2">({{ meta.federal_agencies.length }} of {{ federal_agencies.length }})</a>
                    <span v-if="meta.federal_agencies.length !== sorted_federal_agencies.length">
                        <a href="" @click.prevent="selectAllStateAgencies()" class="form-check-label text-primary me-2">| Select All</a>
                    </span>
                    <span v-if="meta.federal_agencies.length">
                        <a href="" class="form-check-label text-primary me-2" @click.prevent="deselectAllStateAgencies()" v-if="meta.federal_agencies.length !== 0">| Reset</a>
                    </span>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <form class="position-relative w-100 me-4 mb-2">
                    <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="searchStateAgencies()" v-model="federal_agency_keword" placeholder="Search Agency" aria-label="Search" />
                    <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                </form>
            </div>

            <div class="scroll-sidebar">
                <div class="d-flex justify-content-between align-items-center" v-for="federal_agency in sorted_federal_agencies" :key="federal_agency.federal_agency_id">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" :value="federal_agency.federal_agency_id" v-model="meta.federal_agencies" />
                        <label class="form-check-label"> {{ federal_agency.agency_name }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#federalagency" role="button" aria-expanded="false" aria-controls="notice">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': meta.federal_agencies?.length !==0}">Competition (Set-Aside)</h6>

            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show">
            <div class="scroll-sidebar">
                <div class="d-flex justify-content-between align-items-center" v-for="set_aside in set_asides" :key="set_aside.set_aside_id">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" :value="set_aside.set_aside_id" v-model="meta.set_asides" />
                        <label class="form-check-label"> {{ set_aside.set_aside_name }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="flightdetail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-header pt-0 d-sm-flex justify-content-sm-between align-items-center">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <h6 class="fw-normal mb-0">NAICS CODES</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <a class="btn btn-sm btn-primary px-2" style="padding: 5px; font-weight: 400;" href="javascript:void(0)" data-bs-dismiss="modal" @click="applyFilterNaics()">Apply Filter</a>
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="tab-content mb-0" id="flight-pills-tabContent ">
                        <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                            <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                <div class="col-md-8 small">
                                    <form class="position-relative">
                                        <input class="form-control form-control-sm pe-5 myinput" type="search" placeholder="Search in Naics Codes" aria-label="Search"  @keypress.enter="getNaicsesBackend()" />
                                        <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="getNaicsesBackend()"><i class="fas fa-search fs-6"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-4 small d-flex">
                                    <div><a class="my-auto dotted" style="color: #40a4f1;" href="javascript:void(0)" @click="deselectNaics()">Deselect All</a></div>
                                </div>
                            </div>
                            <div class="vl-parent">
                                <div class="card" style="overflow: scroll; height: 300px;">
                                    <div class="card-body p-0">
                                        <ul class="list-style-none pl-8">
                                            <li>
                                                <ul id="demo" style="padding: 0px;">
                                                    <TreeItem class="item" :item="naics_codes" :tdr_naics="meta.naics" :clear_all_naics="clear_all_naics"> </TreeItem>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="detailModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-header pt-0 d-sm-flex justify-content-sm-between align-items-center">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <h6 class="fw-normal mb-0">SERVICE CODES</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <a class="btn btn-sm btn-primary px-2" style="padding: 5px; font-weight: 400;" href="javascript:void(0)" data-bs-dismiss="modal" @click="applyFilterPsc()">Apply Filter</a>
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="tab-content mb-0" id="flight-pills-tabContent">
                        <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                            <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                <div class="col-md-8 small">
                                    <form class="position-relative">
                                        <input class="form-control form-control-sm pe-5 myinput" type="search" placeholder="Search in Serive Codes" aria-label="Search"  @keypress.enter="getPscesBackend()" />
                                        <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="getPscesBackend()"><i class="fas fa-search fs-6"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-4 small d-flex">
                                    <div><a class="my-auto dotted" href="javascript:void(0)" @click="deselectPsc()">Deselect All</a></div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="vl-parent">
                                    <div class="card-body p-0" style="overflow: scroll; height: 300px;">
                                        <ul class="list-style-none pl-8">
                                            <li>
                                                <ul id="demo" style="padding: 0px;">
                                                    <PscTree class="item" :item="service_codes" :tdr_psc="meta.pscs" :clear_all_psc="clear_all_psc"> </PscTree>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TreeItem from "@/components/TreeItem.vue";
import PscTree from "@/components/PscTree.vue";
import DatePicker from "@jobinsjp/vue3-datepicker";
import "@jobinsjp/vue3-datepicker/index.css";

export default {
    components: { TreeItem, PscTree, DatePicker},
    props:{
        'naics_codes':{
            type: Object,
            requred: true
        },

        'service_codes': {
            type: Object,
            requred: true
        },
        'clear_federal_filters': {
            type: Boolean,
            requred: true
        }
    },

    emits: ['updateFederalFilters'],

    data(){
        return{
            federal_notices:[],
            states:[],
            sorted_states:[],
            federal_agencies:[],
            sorted_federal_agencies:[],
            set_asides:[],
            tree_data:'',
            clear_all_naics: false,
            clear_all_psc: false,
            meta:{
                keywords:[],
                federal_notices : [],
                response_date:false,
                response_from_date:false,
                response_to_date:false,
                posted_date:false,
                posted_from_date:false,
                posted_to_date:false,
                naics:[],
                pscs:[],
                categories:[],
                states:[],
                federal_agencies:[],
                set_asides:[],
                filters:[],
            },
            federal_agency_keword: null,
            federal_keyword: null,
            errors: [],
        }
    },

    watch:{
        'categories' : function(){
            this.sorted_categories = this.categories
        },
        'states' : function(){
            this.sorted_states = this.states
        },
        'federal_agencies' : function(){
            this.sorted_federal_agencies = this.federal_agencies
        },
        'meta.filters': function(){
            this.updateFilters()
        },
        'meta.federal_notices': 'applyFilters',
        'meta.posted_date' : 'applyFilters',
        'meta.response_date': 'applyFilters',
        'meta.states': 'applyFilters',
        'meta.federal_agencies' : 'applyFilters',
        'meta.set_asides' : 'applyFilters',
        'clear_federal_filters' : 'clearAllFilters'
    },

    mounted(){
        // console.log('states')
        this.getFederalNotices()
        
    },
    methods:{
        getFederalNotices() {
            let vm = this
            vm.federal_notices = vm.$store.getters.federal_notices
            if(!vm.federal_notices.length){
                vm.$store
                    .dispatch("post", { uri: "getFederalNotices" })
                    .then(function (response) {
                        vm.federal_notices = response.data
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
            vm.getStates()
        },
        getStates() {
            let vm = this;
            vm.states = vm.$store.getters.states
            if(!vm.states.length){
                let uri = "getStates";
                vm.$store
                    .dispatch("post", { uri: uri, data: {country_id:1} })
                    .then(function (response) {
                        vm.states = response.data
                        vm.$store.dispatch('setStates', vm.states)
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            }
            vm.sorted_states = vm.states
            vm.getFederalAgencies()
        },
        getFederalAgencies() {
            let vm = this;
            vm.federal_agencies = vm.$store.getters.federal_agencies
            if(!vm.federal_agencies.length){
                let uri = "getFederalAgencies";
                vm.$store
                    .dispatch("post", { uri: uri, data: {country_id:1} })
                    .then(function (response) {
                        vm.federal_agencies = response.data
                        vm.$store.dispatch('setStateAgencies', vm.federal_agencies)
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            }
            vm.sorted_federal_agencies = vm.federal_agencies
            vm.getSetAsides()
        },

        getSetAsides() {
            let vm = this;
            vm.set_asides = vm.$store.getters.set_asides
            if(!vm.set_asides){
                let uri = "getSetAsides";
                vm.$store
                    .dispatch("post", { uri: uri, data: {country_id:1} })
                    .then(function (response) {
                        vm.set_asides = response.data
                        vm.$store.dispatch('setStateAgencies', vm.set_asides)
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            }
        },

        removeFilter(filter){
            if(filter.id == 'status' || filter.id == 'date'){
                this.meta[filter.module] = false
            }else if (typeof filter.id === 'number') {
                if(Array.isArray(this.meta[filter.module])){
                    this.meta[filter.module] = this.meta[filter.module].filter(function(ele){
                        return filter.id !== ele
                    })
                }else{
                    this.meta[filter.module] = null
                }
            }else{
                this.meta[filter.module] = []
            }
        },

        updateFilters(){
            this.$emit('updateFederalFilters', this.meta)
        },
        applyFilters() {
            let vm = this
            vm.meta.filters = []
            const meta_fields = [
                { meta_field: 'federal_notices', data_field: 'federal_notices', id_field: 'federal_notice_id', name_field: 'notice_name' },
                { meta_field: 'categories', data_field: 'categories', id_field: 'category_id', name_field: 'category_name' },
                { meta_field: 'states', data_field: 'states', id_field: 'state_id', name_field: 'state_name' },
                { meta_field: 'federal_agencies', data_field: 'federal_agencies', id_field: 'federal_agency_id', name_field: 'agency_name' },
                { meta_field: 'set_asides', data_field: 'set_asides', id_field: 'set_aside_id', name_field: 'set_aside_name' },
            ];

            if(vm.meta.keywords.length){
                vm.meta.filters.push({
                    name: 'keywords',
                    id: 'keywords',
                    module:'keywords'
                })
            }

            meta_fields.forEach(field => {
                if (vm.meta[field.meta_field].length) {
                    vm.meta[field.meta_field].map(function(ele) {
                        let matched_item = vm[field.data_field].filter(function(item) {
                            return item[field.id_field] == ele;
                        });

                        if (matched_item.length) {
                            vm.meta.filters.push({
                                name: matched_item[0][field.name_field],
                                id: matched_item[0][field.id_field],
                                module: field.meta_field
                            });
                        }
                    });
                }
            });

            if(vm.meta.posted_date){
                vm.meta.filters.push({
                    name:vm.meta.posted_date,
                    id:'date',
                    module:'posted_date'
                })
            }

            if(vm.meta.response_date){
                vm.meta.filters.push({
                    name:vm.meta.response_date,
                    id:'date',
                    module:'response_date'
                })
            }
            if(vm.meta.naics.length){
                vm.meta.filters.push({
                    name: 'naics:'+vm.meta.naics.length,
                    id:vm.meta.naics,
                    module:'naics'
                })
            }
            if(vm.meta.pscs.length){
                vm.meta.filters.push({
                    name: 'psc:'+vm.meta.pscs.length,
                    id:vm.meta.pscs,
                    module:'pscs'
                })
            }
        },

        clearAllFilters(){
            if(this.clear_federal_filters){
                this.auto_call = false
                this.meta.response_date = false,
                this.meta.response_from_date = false,
                this.meta.response_to_date = false,
                this.meta.posted_date = false,
                this.meta.posted_from_date = false,
                this.meta.posted_to_date = false,
                this.meta.active = false,
                this.meta.expired = false,
                this.meta.keywords = [],
                this.tags = [],
                this.meta.federal_notices = [],
                this.meta.naics = [],
                this.meta.pscs = [],
                this.meta.set_asides = [],
                this.meta.states = [],
                this.meta.federal_agencies = []
            }
        },

        applyFilterNaics() {
            this.meta.naics = this.$store.getters.selected_naics
            this.applyFilters()
            // this.paginateFederalTenders()
        },
        applyFilterPsc() {
            this.meta.pscs = this.$store.getters.selected_pscs
            this.applyFilters()
            // this.paginateFederalTenders()
        },
    }
}
</script>
<style scoped>
    .scroll1 ::-webkit-scrollbar {
        width: 5px;
        cursor: pointer;
    }

    .scroll1 ::-webkit-scrollbar-track {
        border-radius: 10px;
    }
    .scroll1 ::-webkit-scrollbar-thumb {
        background-color: #5143d9;
        border-radius: 10px;
    }
    .scroll-sidebar {
        height: 250px;
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: scroll;
    }
    .bluetextclass {
        color: #47b1ee;
    }
</style>