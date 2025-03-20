<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Duplicate State Tenders</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>Duplicate State Tenders</strong></h6>
                            <div class="d-flex">
                                <button class="btn btn-danger btn-sm" v-if="tender_delete.delete_tenders.length"
                                    style="margin-right:10px" @click="deleteTenders()">Delete</button>
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
                                        <th @click="sort('tdr_no')">
                                            Tender No
                                            <span>
                                                <i v-if="meta.keyword == 'tdr_no' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'tdr_no' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('posted_date')" >
                                            Posted Date
                                            <span>
                                                <i v-if="meta.keyword == 'posted_date' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'posted_date' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('tdr_title')">
                                            Tender Title
                                            <span>
                                                <i v-if="meta.keyword == 'tdr_title' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'tdr_title' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center">Tender Link</th>
                                        <th class="text-center">
                                            Action
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
                                        <td>{{ tender.posted_date }}</td>
                                        <td class="wrap-text ">{{ tender.title }}</td>
                                        <td class="text-center"><a :href="tender.tender_url" target="_blank">Click
                                                here</a></td>
                                        <td class="text-center">
                                            <input type="checkbox" title="Delete" class="form control"
                                                v-model="tender_delete.delete_tenders" :value="tender.duplicate_state_tender_id">
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
                                <option>50</option>
                                <option>100</option>
                                <option>200</option>
                                <option>500</option>
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
                keyword: "duplicate_state_tender_id",
                per_page: 100,
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
        vm.index();
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
        toggleSelectAll() {
            this.tender_delete.select_all = !this.tender_delete.select_all
            console.log(this.tender_delete.select_all)
            if (this.tender_delete.select_all) {
                this.tender_delete.delete_tenders = this.tenders.map(tender => tender.duplicate_state_tender_id)
            } else {
                this.tender_delete.delete_tenders = []
            }
        },

        deleteTenders() {
            let vm = this;
            if (confirm("Are you sure you want to delete?")) {
                vm.$store
                    .dispatch("post", { uri: "deleteDuplicatePrivateTenders", data: vm.tender_delete })
                    .then(() => {
                        vm.tender_delete.delete_tenders = []
                        vm.$store.dispatch("success", "Selected Duplicate Private Tenders deleted successfully ");
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
       
        index() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "paginateDuplicatePrivateTenders", data: vm.meta })
                .then((response) => {
                    vm.tenders = response.data.data
                    vm.meta.totalRows = response.data.meta.total
                    vm.meta.lastPage = response.data.meta.last_page
                    vm.meta.from = response.data.meta.from
                    vm.meta.to = response.data.meta.to
                    vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage
                    if (vm.tenders.length) {
                        vm.country.country_id = vm.tenders[0].tdr_country_id
                    }
                    // vm.stateTenders()
                })
                .catch(function (error) {
                    console.log(error)
                });
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
.no-wrap {
    white-space: nowrap;
}
</style>