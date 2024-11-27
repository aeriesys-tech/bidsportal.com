<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between">
            <h2 class="main-title mb-2 align-items-center">Alerts</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>Alerts</strong></h6>
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
                                        <th @click="sort('user_id')">
                                            User
                                            <span>
                                                <i v-if="meta.keyword == 'user_id' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'user_id' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('alert_title')">
                                            Alert Title
                                            <span>
                                                <i v-if="meta.keyword == 'alert_title' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'alert_title' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('frequency')">
                                            Frequency
                                            <span>
                                                <i v-if="meta.keyword == 'frequency' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'frequency' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('region')">
                                            Region
                                            <span>
                                                <i v-if="meta.keyword == 'region' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'region' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!alerts.length">
                                        <td colspan="5" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="alert, key in alerts" :key="key">
                                        <td class="text-center">{{ meta.from + key }}</td>
                                        <td class="wrap-text">{{ alert.user?.name }}</td>
                                        <td>{{ alert.alert_title }}</td>
                                        <td>{{ alert.frequency }}</td>
                                        <td>{{ alert.region }}</td>
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
                    keyword: "alert_id",
                    per_page: 10,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    to: 1,
                    maxPage: 1,
                },
                alerts: [],
            };
        },
        mounted() {
            let vm = this;
            vm.index();
        },
        methods: {
            index() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "paginateAllAlerts", data: vm.meta })
                    .then((response) => {
                        vm.alerts = response.data.data;
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
