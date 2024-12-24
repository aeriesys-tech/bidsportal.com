<template>
        <div class="container-fluid pb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="main-title mb-2">Subscription Plans</h2>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <form class="card" @submit.prevent="submitForm()">
                        <div class="card-header">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <h6 class="card-title mb-0" v-if="status"><strong>Add Subscription Plan</strong></h6>
                                <h6 class="card-title mb-0" v-else><strong>Update Subscription Plan</strong></h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Plan<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Plan" :class="{ 'is-invalid': errors?.plan }" v-model="subscription_plan.plan" ref="plan" />
                                        <span v-if="errors?.plan" class="invalid-feedback">{{ errors?.plan[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Price<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" placeholder="Price" :class="{ 'is-invalid': errors?.price }" v-model="subscription_plan.price" />
                                        <span v-if="errors?.price" class="invalid-feedback">{{ errors?.price[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Days<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" placeholder="Days" :class="{ 'is-invalid': errors?.days }" v-model="subscription_plan.days" />
                                        <span v-if="errors?.days" class="invalid-feedback">{{ errors?.days[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Month<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" placeholder="Month" :class="{ 'is-invalid': errors?.month }" v-model="subscription_plan.month" />
                                        <span v-if="errors?.month" class="invalid-feedback">{{ errors?.month[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Description<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Description" :class="{ 'is-invalid': errors?.description }" v-model="subscription_plan.description" />
                                        <span v-if="errors?.description" class="invalid-feedback">{{ errors?.description[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Discount<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm" placeholder="Discount" :class="{ 'is-invalid': errors?.discount }" v-model="subscription_plan.discount" />
                                        <span v-if="errors?.discount" class="invalid-feedback">{{ errors?.discount[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Is Default<span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm" :class="{ 'is-invalid': errors?.is_default }" v-model="subscription_plan.is_default">
                                            <option value="">Select Is Default</option>
                                            <option :value="true">Active</option>
                                            <option :value="false">Inactive</option>
                                        </select>
                                        <span v-if="errors?.is_default" class="invalid-feedback">{{ errors?.is_default[0] }}</span>
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
                                <h6 class="card-title mb-0"><strong>Subscription Plans</strong></h6>
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
                                            <th @click="sort('plan')">
                                                Plan
                                                <span>
                                                    <i v-if="meta.keyword == 'plan' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                    <i v-else-if="meta.keyword == 'plan' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                    <i v-else class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th @click="sort('sort')">
                                                Price
                                                <span>
                                                    <i v-if="meta.keyword == 'price' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                    <i v-else-if="meta.keyword == 'price' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                    <i v-else class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th @click="sort('days')">
                                                Days
                                                <span>
                                                    <i v-if="meta.keyword == 'days' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                    <i v-else-if="meta.keyword == 'days' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                    <i v-else class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th @click="sort('month')">
                                                Month
                                                <span>
                                                    <i v-if="meta.keyword == 'month' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                    <i v-else-if="meta.keyword == 'month' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                    <i v-else class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th @click="sort('description')">
                                                Description
                                                <span>
                                                    <i v-if="meta.keyword == 'month' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                    <i v-else-if="meta.keyword == 'month' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                    <i v-else class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th @click="sort('discount')">
                                                Discount
                                                <span>
                                                    <i v-if="meta.keyword == 'discount' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                    <i v-else-if="meta.keyword == 'discount' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                    <i v-else class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th @click="sort('is_default')">
                                                Is Default
                                                <span>
                                                    <i v-if="meta.keyword == 'is_default' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                    <i v-else-if="meta.keyword == 'is_default' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                    <i v-else class="fas fa-sort"></i>
                                                </span>
                                            </th>
                                            <th class="text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="!subscription_plans.length">
                                            <td colspan="11" class="text-center">No records found</td>
                                        </tr>
                                        <tr v-for="plan, key in subscription_plans" :key="key">
                                            <td class="text-center">{{ meta.from + key }}</td>
                                            <td>{{plan.plan}}</td>
                                            <td>{{plan.price}}</td>
                                            <td>{{plan.days}}</td>
                                            <td>{{plan.month}}</td>
                                            <td>{{plan.description}}</td>
                                            <td>{{plan.discount}}</td>
                                            <td>{{ plan.is_default ? 'Active' : 'Inactive' }}</td>
    
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="text-success me-2" @click="editSubscriptionPlan(plan)"><i class="ri-pencil-line fs-18 lh-1"></i></a>
                                                <a href="javascript:void(0)" class="text-danger" @click="deleteSubscriptionPlan(plan)"><i class="ri-delete-bin-6-line fs-18 lh-1"></i></a>
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
                        keyword: "subscription_plan_id ",
                        per_page: 10,
                        totalRows: 0,
                        page: 1,
                        lastPage: 1,
                        from: 1,
                        to: 1,
                        maxPage: 1,
                    },
                    subscription_plan: {
                        subscription_plan_id: "",
                        plan: "",
                        price: "",
                        days: "",
                        month: "",
                        description: "",
                        discount: "",
                        is_default: "",
                    },
                    subscription_plans: [],
                    status: true,
                    errors: [],
                };
            },
            mounted() {
                let vm = this;
                vm.index();
                vm.$refs.plan.focus();
            },
            methods: {
                submitForm() {
                    let vm = this;
                    if (vm.status) {
                        vm.addSubscriptionPlan();
                    } else {
                        vm.updateSubscriptionPlan();
                    }
                },
                index() {
                    let vm = this;
                    vm.$store
                        .dispatch("post", { uri: "paginateSubscriptionPlans", data: vm.meta })
                        .then((response) => {
                            vm.subscription_plans = response.data.data;
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
                addSubscriptionPlan() {
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", { uri: "addSubscriptionPlan", data: vm.subscription_plan })
                        .then(() => {
                            loader.hide();
                            this.$store.dispatch("success", "Subscription Plan created successfully");
                            vm.discard();
                        })
                        .catch(function (error) {
                            loader.hide();
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                },
                updateSubscriptionPlan() {
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", { uri: "updateSubscriptionPlan", data: vm.subscription_plan })
                        .then(() => {
                            loader.hide();
                            this.$store.dispatch("success", "Subscription Plan updated successfully");
                            vm.discard();
                        })
                        .catch(function (error) {
                            loader.hide();
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                },
                editSubscriptionPlan(subscription_plan) {
                        console.log("subscription_plan",subscription_plan)
                    this.subscription_plan = subscription_plan;
                    this.status = false;
                    this.$refs.plan.focus();
                },
                discard() {
                    let vm = this;
                    vm.subscription_plan = {};
                    vm.$refs.plan.focus();
                    vm.errors = [];
                //     vm.status = true;
                    vm.index();
                },
                deleteSubscriptionPlan(subscription_plan) {
                    const confirmDelete = confirm("Are you sure you want to delete it ?");
                    if (confirmDelete) {
                        let vm = this;
                        let loader = vm.$loading.show();
                        vm.$store
                            .dispatch("post", { uri: "deleteSubscriptionPlan", data: subscription_plan })
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
    