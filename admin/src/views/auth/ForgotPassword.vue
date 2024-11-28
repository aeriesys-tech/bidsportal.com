<template>
    <div class="page-auth">
        <div class="content">
            <div class="container">
                <div class="card card-auth">
                    <div class="card-body text-center">
                        <div class="text-center">
                            <img src="../../assets/bidsportal_logo.png" class="img" width="100" />
                        </div>
                        <div class="text-center">
                            <div class="title-wrapper">
                                <span style="font-size: 28px;"><strong>PROODOS</strong></span>
                            </div>
                            <div class="sub-title-wrapper">
                                <small class="sub_title" style="color: #333;">Project & Budget Mgmt System</small>
                            </div>
                        </div>
                        <h3 class="card-title">Reset your password</h3>
                        <p class="card-text mb-5">Enter your username or email address and we will send you a link to reset
                            your password.</p>
                        <form @submit.prevent="forgotPassword">
                            <div class="row g-2">
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter email address"
                                        :class="{ 'is-invalid': errors.email }" v-model="user.email" ref="email" />
                                    <span v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</span>
                                </div>
                                <div class="col-sm-4"><button href="#" method="submit"
                                        class="btn btn-primary">Reset</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "Forgotpassword",
    data() {
        return {
            user: {
                email: "",
            },
            errors: [],
        };
    },
    mounted() {
        this.$refs.email.focus();
    },
    methods: {
        forgotPassword() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("auth", { uri: "forgotPassword", data: { email: vm.user.email } })
                .then((response) => {
                    loader.hide();
                    alert(response.data.message);
                    vm.$router.push("/");
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
    },
};
</script>
