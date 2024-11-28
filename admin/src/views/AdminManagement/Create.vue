<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Admin</h2>
            <router-link to="/admins" class="btn btn-primary mb-2">Admins</router-link>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <form class="card" @submit.prevent="submitForm()">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0" v-if="status"><strong>Add Admin</strong></h6>
                            <h6 class="card-title mb-0" v-else><strong>Update Admin</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>First Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="First Name" ref="first_name"
                                        :class="{ 'is-invalid': errors?.first_name }" v-model="admin.first_name" />
                                    <span v-if="errors?.first_name" class="invalid-feedback">{{ errors?.first_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Last Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Last Name"
                                        :class="{ 'is-invalid': errors?.last_name }" v-model="admin.last_name" />
                                    <span v-if="errors?.last_name" class="invalid-feedback">{{ errors?.last_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-sm" placeholder="Email"
                                        :class="{ 'is-invalid': errors?.email }" v-model="admin.email" />
                                    <span v-if="errors?.email" class="invalid-feedback">{{ errors?.email[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Mobile1<span class="text-danger">*</span></label>
                                    <input type="mobile1" class="form-control form-control-sm" placeholder="Mobile1"
                                        :class="{ 'is-invalid': errors?.mobile1 }" v-model="admin.mobile1" />
                                    <span v-if="errors?.mobile1" class="invalid-feedback">{{ errors?.mobile1[0] }}</span>
                                </div>
                            </div>
                             <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Mobile2<span class="text-danger">*</span></label>
                                    <input type="mobile2" class="form-control form-control-sm" placeholder="Mobile2"
                                        :class="{ 'is-invalid': errors?.mobile2 }" v-model="admin.mobile2" />
                                    <span v-if="errors?.mobile2" class="invalid-feedback">{{ errors?.mobile2[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Role <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm"
                                        :class="{ 'is-invalid': errors?.role }" v-model="admin.role">
                                        <option value="">Select Role</option>
                                        <option value="Basic">Basic</option>
                                        <option value="Super">Super</option>
                                    </select>
                                    <span v-if="errors?.role" class="invalid-feedback">{{ errors?.role[0] }}</span>
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
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            status: true,
            admin: {
                admin_id: "",
                first_name: "",
                last_name: "",
                mobile1: "",
                mobile2: "",
                role: "",
                email:"",
            },
            errors: [],
        };
    },
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            if (to.name == "Admins.Create") {
                vm.$refs.first_name.focus();
            } else {
                vm.status = false;
                let uri = { uri: "getAdmin", data: { admin_id: to.params.admin_id } };
                vm.$store
                    .dispatch("post", uri)
                    .then(function (response) {
                        console.log("response-----", response.data.data);
                        vm.admin = response.data.data;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        });
    },
    methods: {
        submitForm() {
            let vm = this;
            if (vm.status) {
                vm.addAdmin();
            } else {
                vm.updateAdmin();
            }
        },
        addAdmin() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "addAdmin", data: vm.admin })
                .then(() => {
                    loader.hide();
                    this.$store.dispatch('success',"Admin created successfully");
                    vm.$router.push("/admins");
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        updateAdmin() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "updateAdmin", data: vm.admin })
                .then(() => {
                    loader.hide();
                    this.$store.dispatch('success',"Admin updated successfully");
                    vm.$router.push("/admins");
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        discard() {
            let vm = this;
            vm.admin.first_name = "";
            vm.admin.last_name = "";
            vm.admin.email = "";
            vm.admin.mobile1 = "";
            vm.admin.mobile2 = "";
            vm.admin.role = "";
            vm.$refs.first_name.focus();
            vm.errors = [];
            vm.status = true;
        },
    },
};
</script>
