<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Users</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>Users</strong></h6>
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
                                        <th class="text-center">Signup Date</th>
                                        <th @click="sort('name')">
                                            Name
                                            <span>
                                                <i v-if="meta.keyword == 'name' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'name' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
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
                                        <th @click="sort('company')">
                                            Company Name
                                            <span>
                                                <i v-if="meta.keyword == 'company' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'company' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('position')">
                                            Position
                                            <span>
                                                <i v-if="meta.keyword == 'position' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'position' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('phone')">
                                            Phone
                                            <span>
                                                <i v-if="meta.keyword == 'phone' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'phone' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('web_address')">
                                            Web Address
                                            <span>
                                                <i v-if="meta.keyword == 'web_address' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'web_address' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('mailing_address')">
                                            Mailing Address
                                            <span>
                                                <i v-if="meta.keyword == 'mailing_address' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'mailing_address' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('city')">
                                            City
                                            <span>
                                                <i v-if="meta.keyword == 'city' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'city' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('state')">
                                            State
                                            <span>
                                                <i v-if="meta.keyword == 'state' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'state' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('pin_code')">
                                            Zipcode
                                            <span>
                                                <i v-if="meta.keyword == 'pin_code' && meta.order_by == 'asc'" class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'pin_code' && meta.order_by == 'desc'" class="ri-arrow-down-line"></i>
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
<<<<<<< HEAD
                                        <th class="text-center">Confirm Email</th>
                                        <th class="text-center">Delete User</th>
=======
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!users.length">
                                        <td colspan="5" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="user, key in users" :key="key">
                                        <td class="text-center">{{ meta.from + key }}</td>
                                        <td class="text-center">{{ user.created_at }}</td>
                                        <td class="wrap-text">{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.company_name }}</td>
                                        <td>{{ user.position }}</td>
                                        <td>{{ user.phone }}</td>
                                        <td>{{ user.web_address }}</td>
                                        <td>{{ user.mailing_address }}</td>
                                        <td>{{ user.city }}</td>
                                        <td>{{ user.state }}</td>
                                        <td>{{ user.pin_code }}</td>
                                        <td class="text-center">
<<<<<<< HEAD
                                            <a href="#" class="text-success me-2" @click.prevent="toggleUser(user)"> 
=======
                                            <a href="javascript:void(0)" class="text-success me-2" @click="toggleUser(user)"> 
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
                                                <span :class="['badge', user.status == 1 ? 'badge-success' : 'badge-warning']">
                                                    {{ user.status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </a>
                                        </td>
<<<<<<< HEAD
                                        <td class="text-center">
                                            <span v-if="user.confirm_email">
                                                {{ user.confirm_email }}
                                            </span>
                                            <span v-else>
                                                <a href="#" class="text-success me-2" @click.prevent="confirmEmail(user)"><i class="ri-mail-check-line fs-18 lh-1"></i></a>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="text-danger" @click.prevent="deleteUser(user)"><i class="ri-delete-bin-6-line fs-18 lh-1"></i></a>
                                        </td>
=======
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
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
                    keyword: "user_id",
                    per_page: 10,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    to: 1,
                    maxPage: 1,
                    trashed: false,
                },
                users: [],
            };
        },
        mounted() {
            let vm = this;
            vm.index();
        },
        methods: {
            toggleUser(user){
                let vm = this;
                let confirm_user = false
                if(user.status){
                    confirm_user = confirm("Are you sure you want to deactivate user ?")
                }else{
                    confirm_user = confirm("Are you sure you want to activate user ?")
                }

                if(confirm_user){
<<<<<<< HEAD
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", { uri: "toggleUser", data: user })
                        .then((response) => {
                            loader.hide()
                            vm.index()
                        })
                        .catch(function (error) {
                            loader.hide()
=======
                    vm.$store
                        .dispatch("post", { uri: "toggleUser", data: user })
                        .then((response) => {
                            vm.index()
                        })
                        .catch(function (error) {
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },

            index() {
                let vm = this;
<<<<<<< HEAD
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "paginateActiveUsers", data: vm.meta })
                    .then((response) => {
                        loader.hide()
=======
                vm.$store
                    .dispatch("post", { uri: "paginateActiveUsers", data: vm.meta })
                    .then((response) => {
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
                        vm.users = response.data.data;
                        vm.meta.totalRows = response.data.meta.total;
                        vm.meta.lastPage = response.data.meta.last_page;
                        vm.meta.from = response.data.meta.from;
                        vm.meta.to = response.data.meta.to;
                        vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                    })
                    .catch(function (error) {
<<<<<<< HEAD
                        loader.hide()
=======
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
<<<<<<< HEAD

            confirmEmail(user) {
                if(confirm('Are you sure you want to Confirm Email ?')){
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", { uri: "confirmEmail", data: user })
                        .then((response) => {
                            loader.hide()
                            vm.index()
                            vm.$store.dispatch("success", response.data.message);
                        })
                        .catch(function (error) {
                            loader.hide()
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },

            deleteUser(user) {
                if(confirm('Are you sure you want to delete User ?')){
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.$store
                        .dispatch("post", { uri: "deleteUser", data: user })
                        .then((response) => {
                            loader.hide()
                            vm.index()
                            vm.$store.dispatch("success", response.data.message);
                        })
                        .catch(function (error) {
                            loader.hide()
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },

=======
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
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
  background-color: #28a745; /* Green for success */
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
