<template>
    <transition name="fade">
        <div class="vue-modal" v-show="open">
            <transition name="drop-in">
                <div class="vue-modal-inner" v-show="open" style="margin: auto;">
                    <div class="vue-modal-content">
                        <div class="row" style="padding: 10px; margin: 0 !important;">
                            <div class="modal-header">
                                <h5 class="modal-title">Login Required</h5>
                                <button type="button" class="btn-close" @click.prevent="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="p-4 p-sm-7">
                                <a href="index.html"><img class="h-50px mb-4" src="/img/logo.d846a551.png" alt="logo" /></a>
                                <h1 class="mb-2 h3">Welcome back</h1>
                                <p class="mb-0">New here?<a href="#/sign_up" class=""> Create an account</a></p>
                                <form class="mt-4 text-start" autocomplete="off">
                                    <div class="mb-3">
                                        <label class="form-label">Enter email id</label><input type="email" class="form-control" placeholder="Email" />
                                        <!--v-if-->
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Enter password</label><input class="form-control" type="password" id="psw-input" placeholder="Password" />
                                        <!--v-if-->
                                    </div>
                                    <div class="mb-3 d-sm-flex justify-content-between">
                                        <div><input type="checkbox" class="form-check-input" id="rememberCheck" /><label class="form-check-label" for="rememberCheck"> Remember me?</label></div>
                                        <a href="#/forgot_password" class="">Forgot password?</a>
                                    </div>
                                    <div><button type="submit" class="btn btn-primary w-100 mb-0">Login</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>
<script>
    import { onMounted, onUnmounted } from "vue";
    export default {
        name: "Product.images",
        props: {
            open: {
                type: Boolean,
                require: true,
            },
        },
        setup(_, { emit }) {
            const close = () => {
                emit("close");
            };
            const handleKeyup = (event) => {
                if (event.keyCode === 27) {
                    close();
                }
            };
            onMounted(() => document.addEventListener("keyup", handleKeyup));
            onUnmounted(() => document.removeEventListener("keyup", handleKeyup));
            return { close };
        },
        data() {
            return {
                user: {
                    email: "",
                    password: "",
                },

                errors: [],
                status: true,
            };
        },

        mounted() {},
        methods: {
            closeModal() {
                this.discard();
                this.user.email = "";
                this.user.password = "";
                this.errors = [];
            },

            login() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("auth", { uri: "login", data: vm.user })
                    .then(function (response) {
                        loader.hide();
                        vm.$store.dispatch("success", "Successfuly logged in");
                        vm.$store.dispatch("setUser", response.data);
                        vm.$router.push("/bids/state-opportunities");
                        vm.closeModal();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            discard() {
                this.user.email = "";
                this.user.password = "";
                this.errors = [];
                this.status = true;
                this.$parent.close();
            },
        },
    };
</script>

<style scoped>
    *,
    ::before,
    ::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .vue-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 9999;
    }
    .vue-modal-inner {
        max-width: max-content;
        /* margin: 2rem auto; */
    }
    .vue-modal-content {
        position: relative;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.3);
        background-clip: padding-box;
        border-radius: 0.3rem;
        padding: 1rem;
    }

    .input_text {
        margin: auto;
        background-color: white;
        padding-left: 10px;
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.5s;
    }
    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
    .drop-in-enter-active,
    .drop-in-leave-active {
        transition: all 0.3s ease-out;
    }
    .drop-in-enter-from,
    .drop-in-leave-to {
        opacity: 0;
        transform: translateY(-50px);
    }
    * {
        box-sizing: border-box;
    }
    .invalid-feedback {
        color: red;
    }
    .is-invalid {
        border-color: red;
    }

    .row {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
        margin: 0 -16px;
    }

    .col-25 {
        -ms-flex: 25%; /* IE10 */
        flex: 25%;
    }

    .col-50 {
        -ms-flex: 50%; /* IE10 */
        flex: 50%;
    }

    .col-75 {
        -ms-flex: 75%; /* IE10 */
        flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
        padding: 0 16px;
    }

    .container {
        background-color: #f2f2f2;
        padding: 5px 20px 15px 20px;
        border: 1px solid lightgrey;
        border-radius: 3px;
    }

    /* input[type="text"] {
        width: 100%;
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
        background-color: white;
    } */

    label {
        margin-bottom: 10px;
        display: block;
    }

    .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
    }

    /* .btn {
        background-color: #04aa6d;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
    }

    .btn:hover {
        background-color: #45a049;
    } */

    a {
        color: #2196f3;
    }

    hr {
        border: 1px solid lightgrey;
    }

    span.price {
        float: right;
        color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
        .row {
            flex-direction: column-reverse;
        }
        .col-25 {
            margin-bottom: 20px;
        }
    }
    .top_margin {
        margin-top: 10px;
    }
    .custom-checkbox + label:before {
        border: 1px solid #683838;
    }

    .form-control{
        padding: 0.5rem 1rem;
    }
</style>
