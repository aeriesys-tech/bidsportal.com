<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Admin</h2>
            <router-link to="/admin/create" class="btn btn-primary mb-2">Add Admin</router-link>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>Admins</strong></h6>
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
                                        <th @click="sort('first_name')">
                                            First Name
                                            <span>
                                                <i v-if="meta.keyword == 'first_name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'first_name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('last_name')">
                                            Last Name
                                            <span>
                                                <i v-if="meta.keyword == 'last_name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'last_name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('email')">
                                            Email
                                            <span>
                                                <i v-if="meta.keyword == 'email' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'email' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('mobile1')">
                                            Mobile1
                                            <span>
                                                <i v-if="meta.keyword == 'mobile1' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'mobile1' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('mobile2')">
                                            Mobile2
                                            <span>
                                                <i v-if="meta.keyword == 'mobile2' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'mobile2' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('role')">
                                            Role
                                            <span>
                                                <i v-if="meta.keyword == 'role' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'role' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('created_on')">
                                            Created Date
                                            <span>
                                                <i v-if="meta.keyword == 'created_on' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'created_on' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('last_login')">
                                            Last Login
                                            <span>
                                                <i v-if="meta.keyword == 'last_login' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'last_login' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center" @click="sort('status')">
                                            Status
                                            <span>
                                                <i v-if="meta.keyword == 'status' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'status' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th class="text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!admins.length">
                                        <td colspan="11" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="admin, key in admins" :key="key">
                                        <td class="text-center">{{ meta.from + key }}</td>
                                        <td>{{admin.first_name}}</td>
                                        <td>{{admin.last_name}}</td>
                                        <td>{{admin.email}}</td>
                                        <td>{{admin.mobile1}}</td>
                                        <td>{{admin.mobile2}}</td>
                                        <td>{{admin.role}}</td>
                                        <td>{{ admin.created_on }}</td>
                                        <td>{{ admin.last_login }}</td>
                                        <td class="text-center"> 
                                            <a href="javascript:void(0)" class="text-success me-2" @click="toggleAdmin(admin)">
                                                <span :class="['badge', admin.status == 1 ? 'badge-success' : 'badge-warning']">
                                                    {{ admin.status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="text-success me-2" @click="editAdmin(admin)"><i class="ri-pencil-line fs-18 lh-1"></i></a>
                                            <a href="javascript:void(0)" class="text-danger" @click="deleteAdmin(admin)"><i class="ri-delete-bin-6-line fs-18 lh-1"></i></a>
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
                    keyword: "admin_id",
                    per_page: 10,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    to: 1,
                    maxPage: 1,
                    trashed: false,
                },
                admins: [],
                errors: [],
            };
        },
        mounted() {
            let vm = this;
            vm.index();
        },
        methods: {
            toggleAdmin(admin){
                let vm = this;
                let confirm_admin = false
                if(admin.status){
                    confirm_admin = confirm("Are you sure you want to deactivate admin user ?")
                }else{
                    confirm_admin = confirm("Are you sure you want to activate admin user ?")
                }

                if(confirm_admin){
                    vm.$store
                        .dispatch("post", { uri: "toggleAdmin", data: admin })
                        .then((response) => {
                            vm.index()
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },
            index() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "paginateAdmins", data: vm.meta })
                    .then((response) => {
                        vm.admins = response.data.data;
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
            editAdmin(admin) {
                this.$router.push("/admins/" + admin.admin_id + "/edit");
            },
            deleteAdmin(admin) {
                const confirmDelete = confirm("Are you sure you want to delete it ?");
                if (confirmDelete) {
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", {
                            uri: "deleteAdmin",
                            data: admin,
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
            onPerPageChange() {
                this.meta.page = 1;
                this.index();
            },
        },
    };
</script>
<style scoped>
.badge {
  display: inline-block;
  padding: 0.25em 0.6em;
  font-weight: 500;
  line-height: 1;
  color: #fff;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: 0.25rem;
}

/* Variations */
.badge-success {
  background-color: #089c2a; /* Green for success */
}

.badge-warning {
  background-color: #ffc107; /* Yellow for warning */
  color: #212529; /* Dark text for contrast */
}

.badge-danger {
  background-color: #dc3545; /* Red for danger */
}

.badge-info {
  background-color: #17a2b8; /* Cyan for info */
}

.badge-primary {
  background-color: #007bff; /* Blue for primary */
}

.badge-secondary {
  background-color: #6c757d; /* Gray for secondary */
}
</style>

