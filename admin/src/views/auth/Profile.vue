<template>
    <div class="">
        <h2 class="main-title mb-3">User Details</h2>
        <div class="row g-3">
            <div class="col-md-8">
                <form @submit.prevent="updateProfile">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Update Avatar</strong>
                                </div>
                                <div class="card-body">
                                    <div class="text-center" v-if="user.avatar">
                                        <img width="200" :src="user.avatar?user.avatar:'@/assets/deafult_user_image.png'" alt="user image" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="customFile">Choose file</label>
                                        <input type="file" class="form-control" id="customFile" :class="{'is-invalid': errors.avatar}" @change="onImageChange($event)" accept="image/*" />
                                    </div>
                                    <span v-if="errors.avatar" class="invalid-feedback">{{ errors.avatar[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Profile Details</strong>
                                </div>
                                <div class="card-body mb-3">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label">Name</label><span class="text-danger"> *</span>
                                            <input type="text" placeholder="Name" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" ref="name" />
                                            <span v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">Email</label><span class="text-danger"> *</span>
                                            <input type="email" placeholder="Email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" />
                                            <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">Role</label>
                                            <input type="text" placeholder="Role" class="form-control" :class="{'is-invalid': errors.role_name}" v-model="user.role.role_name" readonly />
                                            <span v-if="errors.role_name" class="invalid-feedback">{{ errors.role_name[0] }}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">Mobile No.</label>
                                            <input type="text" placeholder="Mobile No." class="form-control" :class="{'is-invalid': errors.mobile_no}" v-model="user.mobile_no" />
                                            <span v-if="errors.mobile_no" class="invalid-feedback">{{ errors.mobile_no[0] }}</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label">Address</label>
                                            <textarea type="text" placeholder="Address" class="form-control" :class="{'is-invalid': errors.address}" v-model="user.address"></textarea>
                                            <span v-if="errors.address" class="invalid-feedback">{{ errors.address[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary"><i class="ri-save-line icon_hgt"></i> Update</button>
                                    <!-- <button type="submit" class="btn btn-danger">Discard</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <form @submit.prevent="updatePassword">
                        <div class="card-header">
                            <strong>Change Password</strong>
                        </div>
                        <div class="card-body mb-3">
                            <!-- <h5>New Area</h5> -->
                            <div class="row g-3">
                                <div class="col-sm-12">
                                    <label class="form-label">Current Password</label><span class="text-danger"> *</span>
                                    <input type="password" placeholder="Current Password" class="form-control" :class="{'is-invalid': errors.current_password}" v-model="user.current_password" @keyup="test(user.current_password,'current_password')" />
                                    <span v-if="errors.current_password" class="invalid-feedback">{{ errors.current_password[0] }}</span>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">New Password</label><span class="text-danger"> *</span>
                                    <input type="password" placeholder="New Password" class="form-control" :class="{'is-invalid': errors.new_password}" v-model="user.new_password" @keyup="test(user.new_password,'new_password')" />
                                    <span v-if="errors.new_password" class="invalid-feedback">{{ errors.new_password[0] }}</span>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">Confirm Password</label><span class="text-danger"> *</span>
                                    <input type="password" placeholder="Confirm Password" class="form-control" :class="{'is-invalid': errors.confirm_password}" v-model="user.confirm_password" @keyup="test(user.confirm_password,'confirm_password')"/>
                                    <span v-if="errors.confirm_password" class="invalid-feedback">{{ errors.confirm_password[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="ri-save-line icon_hgt"></i> Update</button>
                            <!-- <button type="submit" class="btn btn-danger">Discard</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- card -->
    </div>
    <!-- container -->
</template>
<script>
    export default {
        name: "Profile",
        data() {
            return {
                status: true,
                user: {
                    user_id: "",
                    name: "",
                    email: "",
                    role: {
                        role_name: "",
                    },
                    mobile_no: "",
                    address: "",
                    current_password: "",
                    new_password: "",
                    confirm_password: "",
                },
                roles: [],
                users: [],
                errors: [],
            };
        },

        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.user.user_id = vm.$store.getters.user?.user_id;
                let loader = vm.$loading.show();
                let uri = { uri: "me", data: vm.user };
                vm.$store
                    .dispatch("post", uri)
                    .then(function (response) {
                        loader.hide();
                        vm.user = response.data.data;
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            });
        },
        methods: {
            test( password,field_name){
                console.log("key", password,field_name)
                let vm = this;
                if(field_name=="current_password"){
                    vm.errors.current_password="";
                }

                if(field_name=="new_password"){
                    vm.errors.new_password="";
                }
               
                if(field_name=="confirm_password"){
                    vm.errors.confirm_password="";
                }
                
            },
            updateProfile() {
                let vm = this;
                let loader = vm.$loading.show();
                let data = new FormData();
                data.append("name", this.user.name);
                data.append("email", this.user.email);
                data.append("mobile_no", this.user.mobile_no);
                data.append("avatar", this.image);
                data.append("role_id", this.user.role_id);
                data.append("address", this.user.address);

                vm.$store
                    .dispatch("post", { uri: "updateProfile", data: data })
                    .then(function (response) {
                        console.log(response.data);
                        loader.hide();
                        vm.$store.dispatch("success", "Profile is successfully updated");
                        vm.$store.dispatch("setUser", response.data.data);
                        vm.errors = [];
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            updatePassword() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "updatePassword", data: vm.user })
                    .then(function () {
                        loader.hide();
                        vm.$store.dispatch("success", "Password is successfully updated");
                        // vm.$router.push('/');
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            onImageChange(e) {
                // e.preventDefault();
                let vm = this;
                vm.image = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(vm.image);
                reader.onload = (e) => {
                    vm.user.avatar = e.target.result;
                };
            },
           
        },
    };
</script>
