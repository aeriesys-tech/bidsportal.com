<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">State Agencies</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <form class="card" @submit.prevent="submitForm()">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0" v-if="status"><strong>Add State Agency</strong></h6>
                            <h6 class="card-title mb-0" v-else><strong>Update State Agency</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>State Agency Code </label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        placeholder="State Agency Code"
                                        :class="{ 'is-invalid': errors?.state_agency_code }"
                                        v-model="state_agency.state_agency_code"
                                        ref="state_agency_code"
                                    />
                                    <span v-if="errors?.state_agency_code" class="invalid-feedback">{{ errors?.state_agency_code[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>State Agency Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="State Agency Name" :class="{ 'is-invalid': errors?.state_agency_name }" v-model="state_agency.state_agency_name" />
                                    <span v-if="errors?.state_agency_name" class="invalid-feedback">{{ errors?.state_agency_name[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-warning me-2" @click="discard">Discard</button>
                        <button class="btn btn-primary" type="submit">
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
                            <h6 class="card-title mb-0"><strong>State Agencies</strong></h6>
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
                                        <th @click="sort('state_agency_code')">
                                            State Agency Code
                                            <span>
                                                <i v-if="meta.keyword == 'state_agency_code' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'state_agency_code' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('state_agency_name')">
                                            State Agency Name
                                            <span>
                                                <i v-if="meta.keyword == 'state_agency_name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'state_agency_name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!state_agencies.length">
                                        <td colspan="11" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="state_agency, key in state_agencies" :key="key">
                                        <td class="text-center">{{ meta.from + key }}</td>
                                        <td>{{state_agency.state_agency_code}}</td>
                                        <td>{{state_agency.state_agency_name}}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="text-success me-2" @click="editStateAgency(state_agency)"><i class="ri-pencil-line fs-18 lh-1"></i></a>
                                            <a href="javascript:void(0)" class="text-danger" @click="deleteStateAgency(state_agency)"><i class="ri-delete-bin-6-line fs-18 lh-1"></i></a>
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
                    keyword: "state_agency_id",
                    per_page: 10,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    to: 1,
                    maxPage: 1,
                },
                state_agency: {
                    state_agency_id: "",
                    state_agency_name: "",
                    state_agency_code: "",
                },
                state_agencies: [],
                status: true,
                errors: [],
            };
        },
        mounted() {
            let vm = this;
            vm.index();
            vm.$refs.state_agency_code.focus();
        },
        methods: {
            submitForm() {
                let vm = this;
                if (vm.status) {
                    vm.addStateAgency();
                } else {
                    vm.updateStateAgency();
                }
            },
            index() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "paginateStateAgencies", data: vm.meta })
                    .then((response) => {
                        vm.state_agencies = response.data.data;
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
            addStateAgency() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "addStateAgency", data: vm.state_agency })
                    .then(() => {
                        loader.hide();
                        this.$store.dispatch("success", "State agency created successfully");
                        vm.discard();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            updateStateAgency() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "updateStateAgency", data: vm.state_agency })
                    .then(() => {
                        loader.hide();
                        this.$store.dispatch("success", "State agency updated successfully");
                        vm.discard();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            editStateAgency(state_agency) {
                this.state_agency = state_agency;
                this.status = false;
                this.$refs.state_agency_code.focus();
            },
            discard() {
                let vm = this;
                vm.state_agency = {};
                vm.$refs.state_agency_code.focus();
                vm.errors = [];
                vm.status = true;
                vm.index();
            },
            deleteStateAgency(state_agency) {
                const confirmDelete = confirm("Are you sure you want to delete it ?");
                if (confirmDelete) {
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", { uri: "deleteStateAgency", data: state_agency })
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
