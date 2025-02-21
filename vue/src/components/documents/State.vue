<template>
    <div class="card card-body rounded-0 p-2">
        <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#noticetype" role="button" aria-expanded="false" aria-controls="status">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{bluetextclass: meta.state_notices?.length !== 0}">Notice Type</h6>

            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show" v-for="notice in state_notices" :key="notice.notice_id">
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="meta.state_notices" :value="notice.state_notice_id" />
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
                    <input class="form-check-input" type="radio" name="hour3" v-model="meta.response_date" value="2 Days" />
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
        <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#location" role="button" aria-expanded="false" aria-controls="notice">
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass':meta.states?.length !==0}">Categories</h6>
            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-1">
                    <a class="btn btn-link p-0 mb-0 me-2">({{ meta.categories.length }} of {{ categories.length }})</a>
                    <span v-if="meta.categories.length !== sorted_categories.length">
                        <a href="" @click.prevent="selectAllCategories()" class="form-check-label text-primary me-2">| Select All</a></span>
                    <span v-if="meta.categories.length">
                        <a href="" class="form-check-label text-primary me-2" @click.prevent="deselectAllCategories()">| Reset</a>
                    </span>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <form class="position-relative w-100 me-4 mb-2">
                    <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="searchCategories()" v-model="category_keyword" placeholder="Search Category" aria-label="Search" />
                    <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                </form>
            </div>

            <div class="scroll-sidebar hgt-300">
                <div class="d-flex justify-content-between align-items-center" v-for="category in sorted_categories" :key="category.category_id">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" :value="category.category_id" v-model="meta.categories" />
                        <label class="form-check-label"> {{category.category_name}}</label>
                    </div>
                </div>
            </div>
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
                    <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="searchStates()" v-model="state_keyword" placeholder="Search State" aria-label="Search" />
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
            <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': meta.state_agencies?.length !==0}">State Agency</h6>

            <a class="p-0 mb-0">
                <i class="fa-solid fa-angle-down ms-2"></i>
            </a>
        </div>

        <div class="col-12 ml2 multi-collapse collapse show">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-1">
                    <a class="btn btn-link p-0 mb-0 me-2">({{ meta.state_agencies.length }} of {{ state_agencies.length }})</a>
                    <span v-if="meta.state_agencies.length !== sorted_state_agencies.length">
                        <a href="" @click.prevent="selectAllStateAgencies()" class="form-check-label text-primary me-2">| Select All</a>
                    </span>
                    <span v-if="meta.state_agencies.length">
                        <a href="" class="form-check-label text-primary me-2" @click.prevent="deselectAllStateAgencies()" v-if="meta.state_agencies.length !== 0">| Reset</a>
                    </span>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <form class="position-relative w-100 me-4 mb-2">
                    <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="searchStateAgencies()" v-model="state_agency_keword" placeholder="Search Agency" aria-label="Search" />
                    <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                </form>
            </div>

            <div class="scroll-sidebar">
                <div class="d-flex justify-content-between align-items-center" v-for="state_agency in sorted_state_agencies" :key="state_agency.state_agency_id">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" :value="state_agency.state_agency_id" v-model="meta.state_agencies" />
                        <label class="form-check-label"> {{ state_agency.state_agency_name }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import DatePicker from "@jobinsjp/vue3-datepicker";
import "@jobinsjp/vue3-datepicker/index.css";

export default {
    props:{
        'clear_state_filters': {
            type: Boolean,
            requred: true
        }
    },

    emits: ['updateStateFilters'],

    components: { DatePicker },

    data(){
        return{
            state_notices:[],
            categories:[],
            sorted_categories:[],
            states:[],
            sorted_states:[],
            state_agencies:[],
            sorted_state_agencies:[],
            meta:{
                keywords:[],
                state_notices : [],
                response_date:false,
                response_from_date:false,
                response_to_date:false,
                posted_date:false,
                posted_from_date:false,
                posted_to_date:false,
                states:[],
                categories:[],
                state_agencies:[],
                filters:[]
            },
            category_keyword:null,
            state_keyword: null,
            errors:[],
            state_agency_keword:null
        }
    },

    watch:{
        'categories' : function(){
            this.sorted_categories = this.categories
        },
        'states' : function(){
            this.sorted_states = this.states
        },
        'state_agencies' : function(){
            this.sorted_state_agencies = this.state_agencies
        },
        'meta.filters': function(){
            this.updateFilters()
        },
        'meta.state_notices': 'applyFilters',
        'meta.posted_date' : 'applyFilters',
        'meta.response_date': 'applyFilters',
        'meta.categories': 'applyFilters',
        'meta.states': 'applyFilters',
        'meta.state_agencies' : 'applyFilters',
        'clear_state_filters' : 'clearAllFilters'
    },

    mounted(){
        this.getStateNotices()

    },
    methods:{
        updateFilters(){
            this.$emit('updateStateFilters', this.meta)
        },

        clearAllFilters(){
            if(this.clear_state_filters){
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
                this.meta.state_notices = [],
                this.meta.states = [],
                this.meta.federal_agencies = [],
                this.meta.categories = []
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

        applyFilters() {
            let vm = this
            vm.meta.filters = []
            const meta_fields = [
                { meta_field: 'state_notices', data_field: 'state_notices', id_field: 'state_notice_id', name_field: 'notice_name' },
                { meta_field: 'categories', data_field: 'categories', id_field: 'category_id', name_field: 'category_name' },
                { meta_field: 'states', data_field: 'states', id_field: 'state_id', name_field: 'state_name' },
                { meta_field: 'state_agencies', data_field: 'state_agencies', id_field: 'state_agency_id', name_field: 'state_agency_name' }
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
        },

        getStateNotices() {
            let vm = this
            vm.state_notices = vm.$store.getters.state_notices
            if(!vm.state_notices.length){
                vm.$store
                    .dispatch("post", { uri: "getStateNotices" })
                    .then(function (response) {
                        vm.state_notices = response.data
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
            vm.getCategories()
        },
        getCategories() {
            let vm = this
            vm.categories = vm.$store.getters.categories
            if(!vm.categories.length){
                vm.$store
                    .dispatch("post", { uri: "getCategories" })
                    .then(function (response) {
                        vm.categories = response.data
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
            vm.sorted_categories = vm.categories
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
            vm.getStateAgencies()
        },
        getStateAgencies() {
            let vm = this;
            vm.state_agencies = vm.$store.getters.state_agencies
            if(!vm.state_agencies.length){
                let uri = "getStateAgencies";
                vm.$store
                    .dispatch("post", { uri: uri, data: {country_id:1} })
                    .then(function (response) {
                        vm.state_agencies = response.data
                        vm.$store.dispatch('setStateAgencies', vm.state_agencies)
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            }
            vm.sorted_state_agencies = vm.state_agencies
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
    .hgt-300{
        height: 300px;
    }
</style>