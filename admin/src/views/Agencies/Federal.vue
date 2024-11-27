<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Federal Agencies</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <form class="card" @submit.prevent="submitForm()">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0" v-if="status"><strong>Add Federal Agency</strong></h6>
                            <h6 class="card-title mb-0" v-else><strong>Update Federal Agency</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Federal Agency Code<span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        placeholder="Federal Agency Code"
                                        :class="{ 'is-invalid': errors?.agency_code }"
                                        v-model="federal_agency.agency_code"
                                        ref="agency_code"
                                    />
                                    <span v-if="errors?.agency_code" class="invalid-feedback">{{ errors?.agency_code[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Federal Agency Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Federal Agency Name" :class="{ 'is-invalid': errors?.agency_name }" v-model="federal_agency.agency_name" />
                                    <span v-if="errors?.agency_name" class="invalid-feedback">{{ errors?.agency_name[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                            <button type="button" class="btn btn-warning me-2" @click="discard">Discard</button>
                            <button class="btn btn-primary" type="submit" >
                                <span v-if="status">Submit </span>
                                <span v-else>Update </span>
                            </button>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>Federal Agencies</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-2 d-flex">
                            <input class="form-control form-control-sm" type="text" placeholder="Type keyword and press enter key" v-model="meta.search" @keypress.enter="search()" />
                        </div>
                        <div class="table-responsive table-responsive-sm">
                            <table class="table table-striped table-sm text-wrap table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th @click="sort('agency_code')">
                                            Federal Agency Code
                                            <span>
                                                <i v-if="meta.keyword == 'agency_code' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'agency_code' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('agency_name')">
                                            Federal Agency Name
                                            <span>
                                                <i v-if="meta.keyword == 'agency_name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'agency_name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!federal_agencies.length">
                                        <td colspan="11" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="federal_agency, key in federal_agencies" :key="key">
                                        <td class="text-center">{{ meta.from + key }}</td>
                                        <td>{{federal_agency.agency_code}}</td>
                                        <td>{{federal_agency.agency_name}}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="text-success me-2" @click="editFederalAgency(federal_agency)"><i class="ri-pencil-line fs-18 lh-1"></i></a>
                                            <a href="javascript:void(0)" class="text-danger" @click="deleteFederalAgency(federal_agency)"><i class="ri-delete-bin-6-line fs-18 lh-1"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <select class="form-select from-select-sm width-75" v-model="meta.per_page" @change="onPerPageChange">
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                            </select>
                            <span>Showing {{ meta.from }} to {{ meta.to }} of {{ meta.totalRows }} entries</span>
                            <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.page" @pagechanged="onPageChange" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Pagination from "@/components/Pagination.vue";
    export default {
        components: {
            Pagination,
        },
        data() {
            return {
                meta: {
                    search: "",
                    order_by: "desc",
                    keyword: "federal_agency_id",
                    per_page: 10,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    to: 1,
                    maxPage: 1,
                },
                federal_agency: {
                    federal_agency_id: "",
                    agency_name: "",
                    agency_code: "",
                },
                federal_agencies: [],
                status: true,
                errors: [],
            };
        },
        mounted() {
            let vm = this;
            vm.index();
            vm.$refs.agency_code.focus();
        },
        methods: {
            submitForm() {
                let vm = this;
                if (vm.status) {
                    vm.addFederalAgency();
                } else {
                    vm.updateFederalAgency();
                }
            },
            index() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "paginateFederalAgencies", data: vm.meta })
                    .then((response) => {
                        vm.federal_agencies = response.data.data;
                        vm.meta.totalRows = response.data.meta.total;
                        vm.meta.lastPage = response.data.meta.last_page;
                        vm.meta.from = response.data.meta.from;
                        vm.meta.to = response.data.meta.to;
                        vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            addFederalAgency() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "addFederalAgency", data: vm.federal_agency })
                    .then(() => {
                        loader.hide();
                        this.$store.dispatch("success", "Federal agency created successfully");
                        vm.discard();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            updateFederalAgency() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "updateFederalAgency", data: vm.federal_agency })
                    .then(() => {
                        loader.hide();
                        this.$store.dispatch("success", "Federal agency updated successfully");
                        vm.discard();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            editFederalAgency(federal_agency) {
                this.federal_agency = federal_agency;
                this.status = false;
                this.$refs.agency_code.focus();
            },
            discard() {
                let vm = this;
                vm.federal_agency = {};
                vm.$refs.agency_code.focus();
                vm.errors = [];
                vm.status = true;
                vm.index();
            },
            deleteFederalAgency(federal_agency) {
                const confirmDelete = confirm("Are you sure you want to delete it ?");
                if (confirmDelete) {
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", { uri: "deleteFederalAgency", data: federal_agency })
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
            onPerPageChange() {
                this.meta.page = 1;
                this.index();
            },
        },
    };
</script>
