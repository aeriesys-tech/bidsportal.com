<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Subscriptions</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>Subscriptions</strong></h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-2 d-flex justify-content-between align-items-center">
                            <div class="form-group" style="flex: 9">
                                <label class="label_1">Search</label>
                                <input class="form-control form-control-sm" type="text" placeholder="Type keyword and press enter key" 
                                v-model="meta.search" @keypress.enter="search()" />
                            </div>
                            <div class="form-group" style="flex-1">
                                <label class="label_9">Status</label>
                                <select class="form-select form-select-sm ms-2" v-model="meta.status" @change="filterBystatus()">
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Expiring">Expiring (15 Days)</option>
                                    <option value="Expired/Suspended">Expired/Suspended</option>
                                </select>
                            </div>
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
                                        <th @click="sort('user_id')">
                                            Email
                                            <span>
                                                <i v-if="meta.keyword == 'user_id' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'user_id' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('payment_date')">
                                            Purchase Date
                                            <span>
                                                <i v-if="meta.keyword == 'payment_date' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'payment_date' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('valid_to')">
                                            Expiry Date
                                            <span>
                                                <i v-if="meta.keyword == 'valid_to' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'valid_to' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('valid_to')">
                                            Plan
                                            <span>
                                                <i v-if="meta.keyword == 'valid_to' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'valid_to' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('valid_to')">
                                            Time Left
                                            <span>
                                                <i v-if="meta.keyword == 'valid_to' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'valid_to' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!subscriptions.length">
                                        <td colspan="7" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="subscription, key in subscriptions" :key="key">
                                        <td class="text-center">{{ meta.from + key }}</td>
                                        <td class="wrap-text">{{ subscription.user?.name }}</td>
                                        <td>{{ subscription.user?.email }}</td>
                                        <td>{{ subscription.valid_from }}</td>
                                        <td>{{ subscription.valid_to }}</td>
                                        <td>{{ subscription.subscription_plan?.plan }}</td>
                                        <td>{{ subscription.time_left }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm me-2">
                                                <i class="ri-pause-circle-line"></i> Suspend
                                            </button>
                                            <button class="btn btn-info btn-sm">
                                                <i class="ri-file-text-line"></i> View Invoice
                                            </button>
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
                    keyword: "user_subscription_id",
                    per_page: 10,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    to: 1,
                    maxPage: 1,
                },
                subscriptions: [],
            };
        },
        mounted() {
            let vm = this;
            vm.index();
        },
        methods: {
            filterBystatus(){

            },
            
            index() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "paginateUserSubscriptions", data: vm.meta })
                    .then((response) => {
                        vm.subscriptions = response.data.data;
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
<style scoped>
.label_1{
    margin-left: 1px;
}
.label_9{
    margin-left: 9px;
}

</style>
