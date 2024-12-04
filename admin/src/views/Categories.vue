<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Categories</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <form class="card" @submit.prevent="submitForm()">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0" v-if="status"><strong>Add Category</strong></h6>
                            <h6 class="card-title mb-0" v-else><strong>Update Category</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Category Name <span class="text-danger"> *</span></label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        placeholder="Category Name"
                                        :class="{ 'is-invalid': errors?.category_name }"
                                        v-model="category.category_name"
                                        ref="category_name"
                                    />
                                    <span v-if="errors?.category_name" class="invalid-feedback">{{ errors?.category_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Sort </label>
                                    <input type="number" class="form-control form-control-sm" placeholder="Sort" v-model="category.sort" />
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
                            <h6 class="card-title mb-0"><strong>Categories</strong></h6>
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
                                        <th @click="sort('category_name')">
                                           Category Name
                                            <span>
                                                <i v-if="meta.keyword == 'category_name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'category_name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('sort')">
                                            Sort
                                            <span>
                                                <i v-if="meta.keyword == 'sort' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'sort' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!categories.length">
                                        <td colspan="11" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="category, key in categories" :key="key">
                                        <td class="text-center">{{ meta.from + key }}</td>
                                        <td>{{category.category_name}}</td>
                                        <td>{{category.sort}}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="text-success me-2" @click="editCategory(category)"><i class="ri-pencil-line fs-18 lh-1"></i></a>
                                            <a href="javascript:void(0)" class="text-danger" @click="deleteCategory(category)"><i class="ri-delete-bin-6-line fs-18 lh-1"></i></a>
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
                    keyword: "category_id",
                    per_page: 10,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    to: 1,
                    maxPage: 1,
                },
                category: {
                    category_id: "",
                    category_name: "",
                    sort: "",
                },
                categories: [],
                status: true,
                errors: [],
            };
        },
        mounted() {
            let vm = this;
            vm.index();
            vm.$refs.category_name.focus();
        },
        methods: {
            submitForm() {
                let vm = this;
                if (vm.status) {
                    vm.addCategory();
                } else {
                    vm.updateCategory();
                }
            },
            index() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "paginateCategories", data: vm.meta })
                    .then((response) => {
                        vm.categories = response.data.data;
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
            addCategory() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "addCategory", data: vm.category })
                    .then(() => {
                        loader.hide();
                        this.$store.dispatch("success", "Category created successfully");
                        vm.discard();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            updateCategory() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "updateCategory", data: vm.category })
                    .then(() => {
                        loader.hide();
                        this.$store.dispatch("success", "Category updated successfully");
                        vm.discard();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            editCategory(category) {
                this.category = category;
                this.status = false;
                this.$refs.category_name.focus();
            },
            discard() {
                let vm = this;
                vm.category = {};
                vm.$refs.category_name.focus();
                vm.errors = [];
                vm.status = true;
                vm.index();
            },
            deleteCategory(category) {
                const confirmDelete = confirm("Are you sure you want to delete it ?");
                if (confirmDelete) {
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", { uri: "deleteCategory", data: category })
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
