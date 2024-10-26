<template>
    <transition name="fade">
        <div class="vue-modal" v-show="open">
            <transition name="drop-in">
                <div class="vue-modal-inner" v-show="open" style="margin: 10rem;">
                    <div class="vue-modal-content">
                        <div class="row" style="padding:10px;margin:0 !important">
                            <div class="modal-header">
                            <h5 class="modal-title">Save Search</h5>
                            <button type="button" class="btn-close" @click.prevent="savecloseModal()" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                          
                        </div>
                        <div class="row" style="padding:10px; margin:0 !important">
                            <div class="col-75" style="justify-content:center">
                                <div class="container">
                                     <form class="card-body">
                                        <!-- Current password -->
                                    <div class="field-wrapper">
                                        <div class="field-placeholder">Label {{savesearch.id }} <span class="text-danger">*</span></div>
                                        <input class="form-control" type="text" placeholder="Name" :class="{'is-invalid': errors.alert_label}" v-model="savesearch.alert_label" ref="alert_label" />
                                        <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                                    </div>
                                <div class="modal-footer pt-3">
                                   <button type="button" style="margin-right:3px" class="btn btn-secondary" @click.prevent="savecloseModal()" ref="saveClose">
                                        Close
                                    </button>
                                    <button type="button"  class="btn btn-primary" @click.prevent="saveSearch()">
                                        Save
                                    </button>
                                
                                </div>
                                    </form>
                                </div>
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
            }
        },
        setup(_, { emit }) {
            const close = () => {
                emit("saveClose");
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
                savesearch: {
                    id: "",
                    saveBids: "",
                    user_id: "",
                    tdr_type: "",
                    tdr_type_of_award: "",
                    region_id: 2,
                    state_id: "",
                    alert_label: "",
                    keywords: "",
                    country_id: 10,
                    naics_id: "",
                    notice_type: "",
                    psc: "",
                    set_aside_status: "",
                    agency_fedral: "",
                    created_on: "",
                    updated_on: "",
                },
                    savedserach: {
                    user_id: "",
                    region_id: "",
                    id: "",
                },
                errors: [],
                status: true
            };
        },

        mounted(){
        },
        methods: {
            savecloseModal() {
                this.discard()
                
                this.errors = []
            },

           saveSearch() {
                let vm = this;
                //    let userdata = JSON.parse(localStorage.getItem("login"));
                vm.savesearch.user_id = vm.$store.getters.user.id;
                vm.savesearch.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savesearch.state_id = vm.searchfilter.tdr_state.toString();
                vm.savesearch.keywords = vm.searchfilter.keywords;
                vm.savesearch.naics_id = vm.searchfilter.tdr_naics.toString();
                vm.savesearch.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savesearch.set_aside_status = vm.searchfilter.tdr_set_aside_status.toString();
                vm.savesearch.agency_fedral = vm.searchfilter.tdr_agency.toString();
                vm.savesearch.tdr_type = vm.searchfilter.tdr_type.toString();
                vm.savesearch.tdr_type_of_award = vm.searchfilter.tdr_type_of_award.toString();
                vm.savesearch.country_id;
                vm.savesearch.region_id;
                vm.savesearch.created_on;
                vm.savesearch.updated_on;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "addSaveBids", data: vm.savesearch })
                    .then(function () {
                        loader.hide();
                        vm.$store.dispatch("success", "Bids Saved successfully");
                        // vm.$refs.Close.click();
                        // vm.getSavedsearch();
                        // window.location.reload();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

           discard(){
             
                this.errors = []
                this.status = true
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
