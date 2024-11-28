<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">State Tender</h2>
            <router-link to="/add_state_tender" class="btn btn-primary mb-2">Add State Bid</router-link>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>State Tenders</strong></h6>
                            <div class="d-flex">
                                <button class="btn btn-danger btn-sm" v-if="tender_delete.delete_tenders.length"
                                    style="margin-right:10px" @click="deleteTenders()">Delete</button>
                                <span class="badge bg-primary rounded-pill" v-if="state_tenders_count.total_bids"
                                    style="font-size: 10pt;">Total Bids: {{ state_tenders_count?.total_bids }}</span>
                                <span class="badge bg-success rounded-pill" v-if="state_tenders_count.active"
                                    style="font-size: 10pt;margin-left: 10px;">Active: {{ state_tenders_count?.active
                                    }}</span>
                                <span class="badge bg-danger rounded-pill" v-if="state_tenders_count.inactive"
                                    style="margin-left: 10px;font-size: 10pt;">Pending: {{ state_tenders_count?.inactive
                                    }}</span>

                                <select class="form-control" v-model="meta.status" @change="search">
                                    <option value="">Select Status</option>
                                    <option value="All">All</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-2 d-flex">
                            <input class="form-control form-control-sm" type="text"
                                placeholder="Type keyword and press enter key" v-model="meta.search"
                                @keypress.enter="search()" />
                        </div>
                        <div class="table-responsive table-responsive-sm"
                            style="max-height: 400px; overflow-y: auto; overflow-x: auto;">
                            <table class="table table-striped table-sm text-wrap table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="1%">#</th>
                                        <th @click="sort('tdr_no')" width="5%">
                                            Tender No
                                            <span>
                                                <i v-if="meta.keyword == 'tdr_no' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'tdr_no' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('tdr_opening_date')" width="5%">
                                            Publish Date
                                            <span>
                                                <i v-if="meta.keyword == 'tdr_opening_date' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'tdr_opening_date' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('tdr_title')" width="10%">
                                            Tender Title
                                            <span>
                                                <i v-if="meta.keyword == 'tdr_title' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'tdr_title' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('tender_type')" width="7%">
                                            Notice
                                            <span>
                                                <i v-if="meta.keyword == 'tender_type' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'tender_type' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center" width="10%">Notices</th>
                                        <th @click="sort('category')">
                                            Category
                                            <span>
                                                <i v-if="meta.keyword == 'category' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'category' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center" width="10%">Categories</th>
                                        <th @click="sort('category')">
                                            Issuing Agency
                                            <span>
                                                <i v-if="meta.keyword == 'issuing_agency' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'issuing_agency' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center" width="10%">Agencies</th>
                                        <th class="text-center" width="10%">States</th>
                                        <th class="text-center" width="5%">Bid Link</th>
                                        <th class="text-center" width="3%">
                                            Action
                                        </th>
                                        <th class="text-center" width="3%">
                                            <input type="checkbox" title="Select All" class="form control"
                                                v-model="tender_delete.select_all" @click="toggleSelectAll()">
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
                                        <td>{{ tender.opening_date }}</td>
                                        <td class="wrap-text ">{{ tender.title }}</td>
                                        <td>{{ tender.notice_name }}</td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                :class="{ 'is-invalid': tender.errors?.state_notice_id }"
                                                v-model="tender.state_notice_id">
                                                <option value="null">Select Notice</option>
                                                <option v-for="notice, notice_key in notices" :key="notice_key"
                                                    :value="notice.state_notice_id">{{ notice.notice_name }}</option>
                                            </select>
                                            <span class="invalid-feedback"
                                                v-if="tender.errors?.state_notice_id?.length">{{
                                                    tender.errors?.state_notice_id[0] }}</span>
                                        </td>
                                        <td>{{ tender.category_name }}</td>
                                        <td>
                                            <category_search :class="{ 'is-invalid': tender.errors?.category_id }"
                                                :customClass="{ 'is-invalid': tender.errors?.category_id }"
                                                :initialize="tender.category_id" id="category_id" label="category_name"
                                                placeholder="Select Category" :data="categories"
                                                @input="category => tender.category_id = category">
                                            </category_search>
                                            <span class="invalid-feedback" v-if="tender.errors?.category_id?.length">{{
                                                tender.errors?.category_id[0] }}</span>
                                        </td>
                                        <td>{{ tender.agency_name }}</td>
                                        <td>
                                            <agency_search :class="{ 'is-invalid': tender.errors?.state_agency_id }"
                                                :customClass="{ 'is-invalid': tender.errors?.state_agency_id }"
                                                :initialize="tender.state_agency_id" id="state_agency_id"
                                                label="state_agency_name" placeholder="Select Agency" :data="agencies"
                                                @input="agency => tender.state_agency_id = agency"
                                                @updateAgencies="updateAgencies">
                                            </agency_search>
                                            <span class="invalid-feedback"
                                                v-if="tender.errors?.state_agency_id?.length">{{
                                                    tender.errors?.state_agency_id[0] }}</span>
                                        </td>
                                        <td>
                                            <state_search :class="{ 'is-invalid': tender.errors?.state_id }"
                                                :customClass="{ 'is-invalid': tender.errors?.state_id }"
                                                :initialize="tender.state_id" id="state_id" label="state_name"
                                                placeholder="Select State" :data="states"
                                                @input="state => tender.state_id = state">
                                            </state_search>
                                            <span class="invalid-feedback" v-if="tender.errors?.state_id?.length">{{
                                                tender.errors?.state_id[0] }}</span>
                                        </td>
                                        <td class="text-center"><a :href="tender.tender_url" target="_blank">Click
                                                here</a></td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" title="Update" class="text-success me-2"
                                                @click="updateStateTender(tender)"><i
                                                    class="ri-refresh-line icon_ht"></i></a>

                                            <a href="javascript:void(0)" class="text-success me-2"
                                                @click="editState(tender)"><i class="ri-pencil-line fs-18 lh-1"></i></a>
                                            <a href="javascript:void(0)" class="text-danger"
                                                @click="deleteState(tender)"><i
                                                    class="ri-delete-bin-6-line fs-18 lh-1"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" title="Delete" class="form control"
                                                v-model="tender_delete.delete_tenders" :value="tender.state_tender_id">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <select class="form-select from-select-sm width-75" v-model="meta.per_page"
                                @change="onPerPageChange">
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                            </select>
                            <span>Showing {{ meta.from }} to {{ meta.to }} of {{ meta.totalRows }} entries</span>
                            <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.page"
                                @pagechanged="onPageChange" />
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
export default {
    components: {
        Pagination,
        category_search,
        agency_search,
        state_search
    },
    data() {
        return {
            meta: {
                search: "",
                order_by: "desc",
                keyword: "tdr_id",
                per_page: 10,
                totalRows: 0,
                page: 1,
                lastPage: 1,
                from: 1,
                to: 1,
                maxPage: 1,
                trashed: false,
                status: 'Inactive',
            },
            role: {
                role_id: "",
                role: "",
            },
            country: {
                country_id: ''
            },
            notices: [],
            categories: [],
            agencies: [],
            state_tenders_count: {
                active: null,
                inactive: null,
                total_bids: null
            },
            status: true,
            tenders: [],
            errors: [],
            tender_delete: {
                select_all: false,
                delete_tenders: []
            },
            states: [],
            agency: {
                agency_name: ''
            }
        };
    },
    mounted() {
        let vm = this;
        vm.getStateNotices();
    },

    watch: {
        'tender_delete.delete_tenders'() {
            if (this.tender_delete.delete_tenders.length > 0 && this.tender_delete.delete_tenders.length == this.tenders.length) {
                this.tender_delete.select_all = true
            } else {
                this.tender_delete.select_all = false
            }

        }
    },

    methods: {
        editState(tender) {
            this.$router.push("/state_tenders/" + tender.state_tender_id + "/edit");
        },
        updateAgencies(value) {
            let vm = this
            vm.agency.agency_name = value
            vm.$store
                .dispatch("post", { uri: "getAgency" })
                .then((response) => {
                    vm.agencies = response.data.data
                })
                .catch(function (error) {
                    console.log(error)
                });
        },

        toggleSelectAll() {
            this.tender_delete.select_all = !this.tender_delete.select_all
            console.log(this.tender_delete.select_all)
            if (this.tender_delete.select_all) {
                this.tender_delete.delete_tenders = this.tenders.map(tender => tender.state_tender_id)
            } else {
                this.tender_delete.delete_tenders = []
            }

        },

        deleteTenders() {
            let vm = this;
            if (confirm("Are you sure you want to delete?")) {
                vm.$store
                    .dispatch("post", { uri: "deleteStateTenders", data: vm.tender_delete })
                    .then(() => {
                        vm.tender_delete.delete_tenders = []
                        vm.$store.dispatch("success", "Selected tenders deleted successfully ");
                        vm.index()
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            } else {
                vm.tender_delete.select_all = false
                vm.tender_delete.delete_tenders = []
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
        stateTenders() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "stateTenders" })
                .then((response) => {
                    vm.state_tenders_count = response.data
                })
                .catch(function (error) {
                    console.log(error)
                });
        },
        index() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "paginateStateTenders", data: vm.meta })
                .then((response) => {
                    vm.tenders = response.data.data
                    vm.meta.totalRows = response.data.meta.total
                    vm.meta.lastPage = response.data.meta.last_page
                    vm.meta.from = response.data.meta.from
                    vm.meta.to = response.data.meta.to
                    vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage
                    if (vm.tenders.length) {
                        vm.country.country_id = vm.tenders[0].tdr_country_id
                        vm.getStates()
                    }
                    // vm.stateTenders()
                })
                .catch(function (error) {
                    console.log(error)
                });
        },
        getStateNotices() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "getStateNotices", data: { meta: { region_id: 1 } } })
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
                    vm.index()
                })
                .catch(function (error) {
                    console.log(error)
                });
        },

        getStates() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getStates", data: { country_id: 10 } })
                .then((response) => {
                    vm.states = response.data
                })
                .catch(function (error) {
                    console.log(error)
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
                    console.log(error)
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
</style>