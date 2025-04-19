<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">State Tender</h2>
<<<<<<< HEAD
            <!-- <div class="col-md-3">
                <input type="file" class="form-control form-control-sm" :class="{'is-invalid': upload_excel.errors?.file}" @change="getExcelFile($event)" ref="excel_file" />
                <button class="btn btn-secondary btn-sm mb-2 me-2 mt-2" @click="uploadExcelFile()">Upload Excel</button>
            </div> -->
=======
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
            <div>
                <button v-if="tender_delete.delete_tenders.length" class="btn btn-danger mb-2 me-2" @click="deleteTenders()">Delete Bid</button>
                <router-link to="/add_state_tender" class="btn btn-primary mb-2">Add State Bid</router-link>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <h6 class="card-title mb-2 mb-md-0"><strong>State Tenders</strong></h6>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge bg-primary rounded-pill">Total Bids: {{ state_tenders_count?.total_bids }}</span>
                                <span class="badge bg-success rounded-pill">Active: {{ state_tenders_count?.active }}</span>
                                <span class="badge bg-warning rounded-pill">Auto Approved Today: {{ state_tenders_count?.auto_approved_today }}</span>
                                <span class="badge bg-warning rounded-pill">Manual Approved Today: {{ state_tenders_count?.manual_approved_today }}</span>
                                <span class="badge bg-danger rounded-pill">Pending: {{ state_tenders_count?.pending }}</span>
                                <select class="form-control form-select" v-model="meta.status" @change="search" style="width: 105px;">
                                    <option value="">Select Status</option>
                                    <option value="All">All</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Today">Today</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input 
                                    class="form-control form-control-sm" 
                                    type="text" 
                                    placeholder="Type keyword and press enter key" 
                                    v-model="meta.search" 
                                    @keypress.enter="search()" 
                                />
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input 
                                        type="date" 
                                        class="form-control form-control-sm" 
                                        :class="{ 'is-invalid': errors.from_date }" 
                                        v-model="meta.from_date" 
                                    />
                                    <span v-if="errors?.from_date" class="invalid-feedback d-block">
                                        {{ errors?.from_date[0] }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group d-flex align-items-center">
                                    <input 
                                        type="date" 
                                        class="form-control form-control-sm me-2" 
                                        :class="{ 'is-invalid': errors.to_date }" 
                                        v-model="meta.to_date" 
                                    />
                                    <button class="btn btn-primary btn-sm" @click="index()">Search</button>
                                </div>
                                <span v-if="errors?.to_date" class="invalid-feedback d-block">
                                    {{ errors?.to_date[0] }}
                                </span>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-sm" style="max-height: 400px; width:auto; overflow-y: auto; overflow-x: auto;">
                            <table class="table table-striped table-sm text-wrap table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th @click="sort('tender_no')">
                                            Tender No
                                            <span>
                                                <i v-if="meta.keyword == 'tender_no' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'tender_no' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('posted_date')">
                                            Publish Date
                                            <span>
                                                <i v-if="meta.keyword == 'posted_date' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'posted_date' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('opening_date')">
                                            Opening Date
                                            <span>
                                                <i v-if="meta.keyword == 'opening_date' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'opening_date' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('expiry_date')">
                                            Expiry Date
                                            <span>
                                                <i v-if="meta.keyword == 'expiry_date' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'expiry_date' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('title')">
                                            Tender Title
                                            <span>
                                                <i v-if="meta.keyword == 'title' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'title' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('notice_name')">
                                            Notice
                                            <span>
                                                <i v-if="meta.keyword == 'notice_name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'notice_name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center" width="15%">Notices</th>
                                        <th @click="sort('category_name')">
                                            Category
                                            <span>
                                                <i v-if="meta.keyword == 'category_name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'category_name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center" width="15%">Categories</th>
                                        <th @click="sort('agency_name')">
                                            Issuing Agency
                                            <span>
                                                <i v-if="meta.keyword == 'agency_name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'agency_name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center" width="15%">Agencies</th>
                                        <th class="text-center" width="15%">States</th>
                                        <th class="text-center">Bid Link</th>
                                        <th class="text-center">
                                            Action
                                        </th>
                                        <th class="text-center" width="3%">
                                            <input type="checkbox" title="Select All" class="form control" v-model="tender_delete.select_all" @click="toggleSelectAll()" />
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!tenders.length">
                                        <td colspan="14" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="tender, key in tenders" :key="key">
                                        <td class="text-center">{{ meta.from + key }}</td>
                                        <td class="wrap-text">{{ tender.tender_no }}</td>
                                        <td>{{ tender.posted_date }}
                                            <!-- <input type="datetime-local" class="form-control form-control-sm" :class="{ 'is-invalid': tender.errors?.posted_date }" v-model="postedDate" readonly />
                                            <span class="invalid-feedback" v-if="tender.errors?.posted_date">{{ tender.errors?.posted_date[0] }}</span> -->
                                        </td>
                                        <td>
                                            <input type="date" class="form-control form-control-sm" :class="{ 'is-invalid': tender.errors?.opening_date }" v-model="tender.opening_date" />
                                            <span class="invalid-feedback" v-if="tender.errors?.opening_date">{{ tender.errors?.opening_date[0] }}</span>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control form-control-sm" :class="{ 'is-invalid': tender.errors?.expiry_date }" v-model="tender.expiry_date" />
                                            <span class="invalid-feedback" v-if="tender.errors?.expiry_date">{{ tender.errors?.expiry_date[0] }}</span>
                                        </td>
                                        <td class="wrap-text">{{ tender.title }}</td>
                                        <td>{{ tender.notice_name }}</td>
                                        <td>
                                            <select class="form-control form-control-sm notice_dropdown_expand" :class="{ 'is-invalid': tender.errors?.state_notice_id }" v-model="tender.state_notice_id" @change="updateStateNoticeName(tender, tender.state_notice_id)">
                                                <option value="null">Select Notice</option>
                                                <option v-for="notice, notice_key in notices" :key="notice_key" :value="notice.state_notice_id">{{ notice.notice_name }}</option>
                                            </select>
                                            <span>{{ tender?.state_notice?.notice_name }}</span>
                                            <span class="invalid-feedback" v-if="tender.errors?.state_notice_id?.length">{{ tender.errors?.state_notice_id[0] }}</span>
                                        </td>
                                        <td>{{ tender.category_name }}</td>
                                        <td>
                                            <category_search
                                                class="notice_dropdown_expand"
                                                :class="{ 'is-invalid': tender.errors?.category_id }"
                                                :customClass="{ 'is-invalid': tender.errors?.category_id }"
                                                :initialize="tender.category_id"
                                                id="category_id"
                                                label="category_name"
                                                placeholder="Select Category"
                                                :data="categories"
                                                @input="category => updateCategory(category, tender)"
                                            >
                                            </category_search>
                                            <span>{{ tender?.category?.category_name }}</span>
                                            <span class="invalid-feedback" v-if="tender.errors?.category_id?.length">{{ tender.errors?.category_id[0] }}</span>
                                        </td>
                                        <td>{{ tender.agency_name }}</td>
                                        <td>
                                            <agency_search
                                                class="agency_dropdown_expand"
                                                :class="{ 'is-invalid': tender.errors?.state_agency_id }"
                                                :customClass="{ 'is-invalid': tender.errors?.state_agency_id }"
                                                :initialize="tender.state_agency_id"
                                                id="state_agency_id"
                                                label="state_agency_name"
                                                placeholder="Select Agency"
                                                :data="agencies"
                                                @input="agency_id => updateAgencyName(agency_id, tender)"
                                                @updateAgencies="updateAgencies"
                                            >
                                            </agency_search>
                                            <span>{{ tender?.state_agency?.state_agency_name }}</span>
                                            <span class="invalid-feedback" v-if="tender.errors?.state_agency_id?.length && !tender?.state_agency?.state_agency_name">{{ tender.errors?.state_agency_id[0] }}</span>
                                        </td>
                                        <td>
                                            <state_search
                                                class="state_dropdown_expand"
                                                :class="{ 'is-invalid': tender.errors?.state_id }"
                                                :customClass="{ 'is-invalid': tender.errors?.state_id }"
                                                :initialize="tender.state_id"
                                                id="state_id"
                                                label="state_name"
                                                placeholder="Select State"
                                                :data="states"
                                                @input="state => tender.state_id = state"
                                            >
                                            </state_search>
                                            <span class="invalid-feedback" v-if="tender.errors?.state_id?.length">{{ tender.errors?.state_id[0] }}</span>
                                        </td>
                                        <td class="text-center"><a :href="tender.tender_url" target="_blank">Click here</a></td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" title="Update" class="text-success me-2" @click="updateStateTender(tender)"><i class="ri-refresh-line icon_ht"></i></a>

                                            <router-link :to="'/state_tenders/'+tender.state_tender_id+'/nt'" class="text-success me-2" @click.prevent="editState(tender)"><i class="ri-pencil-line fs-18 lh-1"></i></router-link>
                                            <a href="javascript:void(0)" class="text-danger" @click="deleteState(tender)"><i class="ri-delete-bin-6-line fs-18 lh-1"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" title="Delete" class="form control" v-model="tender_delete.delete_tenders" :value="tender.state_tender_id" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2">
                            <select class="form-select form-select-sm w-auto" v-model="meta.per_page" @change="onPerPageChange">
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                                <option>50</option>
                                <option>100</option>
                                <option>200</option>
                                <option>500</option>
                            </select>
                            <span>Showing {{ meta.from }} to {{ meta.to }} of {{ meta.totalRows }} entries</span>
                            <div class="d-flex justify-content-center">
                                <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.page" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Pagination from "@/components/Pagination.vue";
    // import search from "@/components/Search.vue";
    import category_search from "@/components/CategorySearch.vue";
    import agency_search from "@/components/AgencySearch.vue";
    import state_search from "@/components/StateSearch.vue";
    import moment from 'moment'
    export default {
        components: {
            Pagination,
            category_search,
            agency_search,
            state_search,
        },
        data() {
            return {
                meta: {
                    search: "",
                    order_by: "desc",
                    keyword: "state_tender_id",
                    per_page: 100,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    to: 1,
                    maxPage: 1,
                    trashed: false,
                    status: "Inactive",
                    role: "admin",
                    from_date:'',
                    to_date:''
                },
                role: {
                    role_id: "",
                    role: "",
                },
                country: {
                    country_id: "",
                },
                notices: [],
                categories: [],
                agencies: [],
                state_tenders_count: {
                    active: null,
                    pending: null,
                    total_bids: null,
                    auto_approved_today: null,
                    manual_approved_today:null
                },
                status: true,
                tenders: [],
                errors: [],
                tender_delete: {
                    select_all: false,
                    delete_tenders: [],
                },
                states: [],
                agency: {
                    agency_name: "",
                },
<<<<<<< HEAD
                errors:[],
                upload_excel: {
                    file: "",
                    errors: [],
                },
=======
                errors:[]
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
            };
        },
        computed:{
            postedDate(){
                return moment().format("YYYY-MM-DDTHH:mm")                           
            }                                
        },
        mounted() {
            let vm = this;
            vm.getStateNotices()
        },

        watch: {
            "tender_delete.delete_tenders"() {
                if (this.tender_delete.delete_tenders.length > 0 && this.tender_delete.delete_tenders.length == this.tenders.length) {
                    this.tender_delete.select_all = true;
                } else {
                    this.tender_delete.select_all = false;
                }
            },
        },

        methods: {
<<<<<<< HEAD
            getExcelFile(e) {
                let vm = this;
                vm.upload_excel.file = e.target.files[0];
            },
=======
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
            updateAgencyName(agency_id, tender){
                tender.state_agency_id = agency_id
                let vm = this
                let state_agency = vm.agencies.filter(function(element){
                    return element.state_agency_id == agency_id
                })
                console.log(state_agency)
                if(state_agency.length){
                    if(tender.state_agency){
                        tender.state_agency.state_agency_name = state_agency[0].state_agency_name                    
                    }else{
                        tender.state_agency = {
                             state_agency_name : state_agency[0].state_agency_name 
                        }
                    }
                                           
                }

            },
            updateCategory(category_id, tender){
                let vm = this
                tender.category_id = category_id
                let category = vm.categories.filter(function(cat){
                    return cat.category_id == category_id
                })
                if(category.length){
                    tender.category.category_name = category[0].category_name
                }
            },

            updateStateNoticeName(tender, state_notice_id){
                let vm = this
                let notice = vm.notices.filter(function(notice){
                    return notice.state_notice_id == state_notice_id                            
                })
                if(notice.length){
                    tender.state_notice.notice_name = notice[0].notice_name                            
                }                                 
            },                                 

            search() {
                let vm = this;
                vm.meta.page = 1;
                vm.index();
            },
            editState(tender) {
                this.$router.push("/state_tenders/" + tender.state_tender_id + "/edit");
            },
            updateAgencies(value) {
                window.location.reload()
                // let vm = this;
                // vm.agency.agency_name = value;
                // vm.$store
                //     .dispatch("post", { uri: "getStateAgencies" })
                //     .then((response) => {
                //         vm.agencies = response.data.data;
                //     })
                //     .catch(function (error) {
                //         console.log(error);
                //     });
            },

            toggleSelectAll() {
                this.tender_delete.select_all = !this.tender_delete.select_all;
                console.log(this.tender_delete.select_all);
                if (this.tender_delete.select_all) {
                    this.tender_delete.delete_tenders = this.tenders.map((tender) => tender.state_tender_id);
                } else {
                    this.tender_delete.delete_tenders = [];
                }
            },

<<<<<<< HEAD
            uploadExcelFile(){
                let vm = this;
                let loader = vm.$loading.show();
                vm.upload_excel.errors = [];
                const formData = new FormData();
                formData.append("file", vm.upload_excel.file);
                vm.$store
                    .dispatch("post", { uri: "uploadStateExcelFile", data: formData })
                    .then(() => {
                        loader.hide();
                        vm.$refs.excel_file.value = "";
                        vm.upload_excel.file = "";
                        vm.showS3BucketFiles();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.$refs.excel_file.value = "";
                        vm.upload_excel.file = "";
                        vm.upload_excel.errors = error.response.data.errors;
                    });
            },

=======
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
            deleteTenders() {
                let vm = this;
                if (confirm("Are you sure you want to delete?")) {
                    vm.$store
                        .dispatch("post", { uri: "deleteStateTenders", data: vm.tender_delete })
                        .then(() => {
                            vm.tender_delete.delete_tenders = [];
                            vm.$store.dispatch("success", "Selected tenders deleted successfully ");
                            vm.index();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    vm.tender_delete.select_all = false;
                    vm.tender_delete.delete_tenders = [];
                }
            },
            submitForm() {
                let vm = this;
                if (vm.status) {
                    vm.addRole();
                } else {
                    vm.updateRole();
                }
            },
            getTotalCount() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getTotalCount" })
                    .then((response) => {
                        vm.state_tenders_count = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            index() {
                let vm = this
                let loader = vm.$loading.show()
                vm.$store
                    .dispatch("post", { uri: "paginateStateTenders", data: vm.meta })
                    .then((response) => {
                        loader.hide()
                        vm.tenders = response.data.data;
                        vm.meta.totalRows = response.data.meta.total;
                        vm.meta.lastPage = response.data.meta.last_page;
                        vm.meta.from = response.data.meta.from;
                        vm.meta.to = response.data.meta.to;
                        vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                        if (vm.tenders.length) {
                            vm.country.country_id = vm.tenders[0].tdr_country_id;
                            vm.getStates();
                        }
                        vm.getTotalCount();
                        vm.errors = []
                    })
                    .catch(function (error) {
                        loader.hide()
                        vm.errors = error.response.data.errors
                    });
            },
            getStateNotices() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "getStateNotices", data: { meta: { region_id: 1 } } })
                    .then((response) => {
                        loader.hide();
                        vm.notices = response.data;
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
                        vm.getStateAgencies();
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
                        vm.agencies = response.data;
                        vm.index();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            getStates() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getStates", data: { country_id: 10 } })
                    .then((response) => {
                        vm.states = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            updateStateTender(tender) {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "updateStateTender", data: tender })
                    .then(() => {
                        loader.hide();
                        vm.$store.dispatch("success", "Tender is successfully updated");
                        vm.index();
                    })
                    .catch(function (error) {
                        loader.hide();
                        console.log(error);
                        tender.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            deleteState(tender) {
                const confirmDelete = confirm("Are you sure you want to delete it ?");
                if (confirmDelete) {
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", {
                            uri: "deleteStateTender",
                            data: tender,
                        })
                        .then((response) => {
                            loader.hide();
                            vm.$store.dispatch("success", response.data.message);
                            vm.index();
                        })
                        .catch(function (error) {
                            loader.hide();
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },

            search() {
                let vm = this;
                vm.meta.page = 1;
                vm.index();
            },

            onPageChange(page) {
                let vm = this;
                vm.meta.page = page;
                vm.index();
            },
            sort(field) {
                let vm = this;
                vm.meta.keyword = field;
                vm.meta.order_by = vm.meta.order_by == "asc" ? "desc" : "asc";
                vm.index();
            },
            discard() {
                let vm = this;
                vm.role.role = "";
                vm.$refs.role.focus();
                vm.errors = [];
                vm.status = true;
                vm.index();
            },
            onPerPageChange() {
                this.meta.page = 1;
                this.index();
            },
        },
    };
</script>
<style scoped>
    .icon_ht {
        font-size: 14pt;
    }

    .table {
        min-width: 2000px;
        /* Or adjust to your needs */
        min-height: 250px;
    }

    .wrap-text {
        white-space: normal;
        /* Allow text to wrap */
        word-wrap: break-word;
        /* Ensure long words break */
        overflow-wrap: break-word;
        /* Compatibility for various browsers */
    }

    /* Optionally, keep other columns from wrapping if needed */
    .no-wrap {
        white-space: nowrap;
        /* Disable text wrapping */
    }

    .table thead  {
        position: sticky;
        top: -1px;
        background: transparent; /* Ensure visibility */
        z-index: 10;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
    }







    .table {
    width: 100%;
    border-collapse: collapse; /* Remove double borders */
}

.table thead th {
    position: sticky;
    top: -1;
    background-color: #ffffff; /* Ensure visibility */
    z-index: 10; /* Keep above table body */
    padding: 8px;
    border: 1px solid #e2e5ec; /* Define border for visibility */
    text-align: left;
}

.table tbody td {
    padding: 8px;
    border: 1px solid #e2e5ec;
}

.table thead th:first-child,
.table tbody td:first-child {
    position: sticky;
    left: 0;
    background-color: white;
    z-index: 5;
}



   
</style>
