<template>
    <div class="page-sign d-block py-0">
        <div class="row g-0">
            <div class="col-md-7 col-lg-5 col-xl-4 col-wrapper">
                <form class="card card-sign" @submit.prevent="login">
                    <div class="card-header">
                        <a href="javascript:void(0)" class="mb-3"><img src="../../assets/bidsportal_logo.png" width="200"></a>
                        <h3 class="card-title mt-2">Sign In</h3>
                        <p class="card-text">Welcome! Please signin to continue.</p>
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" placeholder="Enter your email" :class="{'is-invalid': errors.email}" v-model="user.email" ref="email" />
                            <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                        </div>
                        <div class="mb-4">
                            <label class="form-label d-flex justify-content-between">Password</label>
                            <div class="input-group">
                                <input :type="type" class="form-control" placeholder="Enter your password" :class="{'is-invalid': errors.password}" v-model="user.password">
                                <span class="input-group-text" :class="{'is-invalid': errors.password}" @click.prevent="toggle">
                                    <i class="ri-eye-line icon_hgt" v-if="icon"></i>
                                    <i class="ri-eye-off-line icon_hgt" v-else></i>
                                </span>
                                <span v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</span>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sign" type="submit">Sign In</button>
                    </div>
                </form>
            </div>
            <div class="col d-none d-lg-block"><img src="../../assets/bg.jpg" class="auth-img" alt="" /></div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Login",
        data() {
            return {
                type: "password",
                icon: false,
                user: {
                    email: "",
                    password: "",
                },
                errors: [],
            };
        },
        mounted() {
            this.$refs.email.focus();
        },
        methods: {
            login() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("auth", { uri: "adminLogin", data: vm.user })
                    .then(function (response) {
                        loader.hide();
                        vm.$store.dispatch("setUser", response.data.admin);
                        vm.$store.dispatch("setToken", response.data.token);
                        vm.$router.push("/dashboard");
                       
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            toggle() {
                let vm = this;
                if (vm.type == "password") {
                    vm.type = "text";
                    vm.icon = true;
                } else {
                    vm.type = "password";
                    vm.icon = false;
                }
            },
        },
    };
</script>
<style scoped>
.input-group-text.is-invalid
{
border-color: #dc3545;
border-top-right-radius: 0.25rem!important;
border-bottom-right-radius: 0.25rem!important;
}
</style>