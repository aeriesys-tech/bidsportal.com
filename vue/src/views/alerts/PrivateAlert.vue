<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage" />
    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i
                                class="fas fa-sliders-h"></i> Menu</button>
                    </div>

                    <div class="vstack gap-4">
                        <div class="card border00 " style="border: 1px solid #bbc2c9;">
                            <div
                                class="card-header bg-light-green border-bottom d-sm-flex justify-content-between align-items-center p-3">
                                <h5 class="card-header-title title-green fw-500" v-if="status">
                                    Create Private Alert
                                </h5>
                                <h5 class="card-header-title title-green fw-500" v-else>Update Private Alert</h5>

                                <span class="">
                                    <a href="javascript:void(0)" class="btn fw-400 btn-sm btn-success me-2" @click="backSaveAlert()">Back</a>
                                    <router-link to="/bids/state-opportunities" class="btn fw-400 btn-sm btn-outline-secondary ">Back To Bids</router-link>
                                </span>
                            </div>
                            <div class="card-body">
                                <form class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Alert Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            :class="{ 'is-invalid': errors.alert_title }" v-model="alert.alert_title"
                                            placeholder="Alert Title" />
                                        <span v-if="errors.alert_title" class="invalid-feedback">{{
                                            errors.alert_title[0] }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Frequency <span class="text-danger">*</span></label>
                                        <select class="form-select" style="color: var(--bs-gray-500);"
                                            v-model="alert.frequency" :class="{ 'is-invalid': errors.frequency }">
                                            <option selected="" value="">Select your Frequency</option>
                                            <option value:daily>Daily</option>
                                            <option value:weekly>Weekly</option>
                                        </select>
                                        <span v-if="errors.frequency" class="invalid-feedback">{{ errors.frequency[0]
                                            }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputfrequen1" class="form-label head1">State <span
                                                class="text-danger">*</span> </label> <label class="form-label">{{
                                                    alert.states.length }} of {{ sorted_states.length }} Selected</label>
                                        <div class="">
                                            <button type="button" class="btn btnwht10 form-select"
                                                data-bs-toggle="dropdown" :style="state_border_red">
                                                <span class="text-center"
                                                    style="float: left;color: var(--bs-gray-500); font-weight: 400;">Select
                                                    State</span>
                                            </button>
                                            <span v-if="errors.states" style="color: #dc3545;font-size:11pt;">{{
                                                errors.states[0] }}</span>
                                            <label for="inputfrequen1" class="form-label"> </label>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-item">
                                                    <div class="">
                                                        {{ alert.states?.length }} of {{ sorted_states?.length }}
                                                        <span v-if="alert.states?.length !== sorted_states?.length">
                                                            <a href="javascript:void(0)" @click="selectAllStates()"
                                                                class="" ref="selectState">
                                                                Select All /
                                                            </a>
                                                        </span>
                                                        <span>
                                                            <a href="javascript:void(0)" @click="deselectAllStates()"
                                                                class="" ref="selectState">
                                                                Reset all
                                                            </a>
                                                        </span>
                                                        <div class="ss-filter-search">
                                                            <input autocomplete="off" class="form-control" type="text"
                                                                v-model="state_keyword" placeholder="Search state"
                                                                @keyup="sortStates()" />
                                                            <div class="liststate" id="style-3">
                                                                <ul class="checkbox" style="padding-left: 10px;"
                                                                    v-for="state in sorted_states"
                                                                    :key="state.state_id">
                                                                    <li class="list-group-item">
                                                                        <input class="form-check-input me-1"
                                                                            id="federalcheck" type="checkbox"
                                                                            :value="state.state_id"
                                                                            v-model="alert.states"
                                                                            @click="updateStates(state, $event)" />
                                                                        {{ state.state_name }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr />
                                    <label class="form-label" style="font-size: 20px; font-weight: 600;">Notice type
                                        <span class="text-danger">*</span></label>
                                    <span v-if="errors.state_notices" style="color: #dc3545;margin-top:-10px">{{
                                        errors.private_notices[0] }}</span>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-4 col-xl-4" v-for="notice in private_notices"
                                            :key="notice.notice_id">
                                            <ul class="list-group list-group-borderless mb-0">
                                                <li class="list-group-item">
                                                    <input type="checkbox" class="form-check-input me-2"
                                                        id="rememberCheck" :value="notice.private_notice_id"
                                                        v-model="alert.private_notices"
                                                        @click="updatePrivateNotices(notice, $event)" />
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        {{ notice.private_notice_name }}
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr />
                                    <div>
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">Categories</label>
                                        <div class="collapse show" id="collapseExample7">
                                            <div class="collapse show" id="collapseExample7">
                                                <div class="">
                                                    {{ alert.categories?.length }} of {{ sorted_categories?.length
                                                    }}
                                                    <span
                                                        v-if="alert.categories?.length !== sorted_categories?.length">
                                                        <a href="javascript:void(0)" @click="selectAllCategories()"
                                                            class="" ref="selectState">
                                                            Select All /
                                                        </a></span>
                                                    <a href="javascript:void(0)" @click="deselectCategories()" class=""
                                                        ref="selectState">
                                                        Reset all
                                                    </a>
                                                    <div class="col-md-6">
                                                        <div class="ss-filter-search">
                                                            <input class="form-control pe-5" type="search"
                                                                placeholder="Search" aria-label="Search"
                                                                v-model="category_keyword"
                                                                @keyup="sortCategory()"
                                                                style="border-radius: 0.5rem 0.5rem 0px 0px;" />
                                                            <div class="liststate scroll1 hgt" id="style-3"
                                                                style="border:1px solid #c5c5c7; border-top:0px">
                                                                <ul class="list-group checkbox"
                                                                    v-for="category in sorted_categories"
                                                                    :key="category.agency_id">
                                                                    <li
                                                                        class="list-group-item d-flex border-0 border-bottom">
                                                                        &nbsp; <input class="form-check-input me-1"
                                                                            type="checkbox"
                                                                            :value="category.category_id"
                                                                            v-model="alert.categories"
                                                                            @click="updateCategories(category, $event)" />
                                                                        &nbsp; {{ category.category_name }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                    <br />
                                    <label class="form-label" style="font-size: 20px; font-weight: 600;">State Agencies</label>
                                    <span class="mt-2" data-v-5c548d68=""> Type in a partial agency name below and then choose a match to add it to your selection. <br data-v-5c548d68=""> To remove a choice from your selection press the [X] icon on the left. </span>
                                    <div class="collapse show" id="collapseExample7">
                                        <div class="collapse show" id="collapseExample7">
                                            <div class="">
                                                {{ alert.private_agencies?.length }} of {{ sorted_private_agencies?.length
                                                }}
                                                <span
                                                    v-if="alert.private_agencies?.length !== sorted_private_agencies?.length">
                                                    <a href="javascript:void(0)" @click="selectAllPrivateAgencies()"
                                                        class="" ref="selectState">
                                                        Select All /
                                                    </a></span>
                                                <a href="javascript:void(0)" @click="deselectPrivateAgencies()" class=""
                                                    ref="selectState">
                                                    Reset all
                                                </a>
                                                <div class="col-md-6">
                                                    <div class="ss-filter-search">
                                                        <input class="form-control pe-5" type="search"
                                                            placeholder="Search" aria-label="Search"
                                                            v-model="private_agency_keyword"
                                                            @keyup="sortPrivarteAgency()"
                                                            style="border-radius: 0.5rem 0.5rem 0px 0px;" />
                                                        <div class="liststate scroll1 hgt" id="style-3"
                                                            style="border:1px solid #c5c5c7; border-top:0px">
                                                            <ul class="list-group checkbox"
                                                                v-for="private_agency in sorted_private_agencies"
                                                                :key="private_agency.agency_id">
                                                                <li
                                                                    class="list-group-item d-flex border-0 border-bottom">
                                                                    &nbsp; <input class="form-check-input me-1"
                                                                        type="checkbox"
                                                                        :value="private_agency.private_agency_id"
                                                                        v-model="alert.private_agencies"
                                                                        @click="updateStateAgencies(private_agency, $event)" />
                                                                    &nbsp; {{ private_agency.private_agency_name }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4 scroll1" v-if="selected_private_agencies?.length">
                                                    <div class="col-sm-8 col-lg-4 col-xl-3"
                                                        v-for="agency, index in selected_private_agencies" :key="index">
                                                        <div
                                                            class="bg-success bg-opacity-10 text-success d-flex justify-content-between align-items-center mb-3">
                                                            <div class="" style="padding-left: 10px;">
                                                                <span>{{ agency.private_agency_name }}</span>
                                                            </div>
                                                            <a href="javascript:void(0)"
                                                                class="icon-lg rounded-circle flex-shrink-0 bg-opacity-10 text-dark mb-0"
                                                                @click="removeStateAgency(agency)">
                                                                <i class="bi bi-x fa-fw"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="col-md-12">
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">Keywords
                                            (each seperated by ",") <span class="text-danger">*</span></label><br />
                                        <span v-if="errors.keywords" style="color: #dc3545;">{{ errors.keywords[0]
                                            }}</span>
                                        <div class="tag-input">
                                            <div v-for="(tag, index) in tags" :key="tag" class="tag-input__tag">
                                                {{ tag }}
                                                <span @click="removeTag(index)">x</span>
                                            </div>
                                            <textarea rows="4" type="text" placeholder="Enter a keyword"
                                                class="form-control mb-0 tag-input__text" @keydown.enter="addTag"
                                                @keydown.,="addTag" @keydown.delete="removeLastTag"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 text-start">
                                        <button type="submit" class="btn btn-sm btn-primary mb-0" v-if="status"
                                            @click.prevent="createAlerts()"
                                            style="padding: 5px; font-weight: 400;">Submit</button>
                                        <button type="submit" class="btn btn-sm btn-primary mb-0" v-else
                                            @click.prevent="updateAlerts()"
                                            style="padding: 5px; font-weight: 400;">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import TreeItem from "@/components/TreeItem.vue";
import PscTree from "@/components/PscTree.vue";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
// import Vue3TagsInput from "vue3-tags-input";
export default {
    components: { TreeItem, PscTree, Loading },
    data() {
        return {
            state_border_red: '',
            states: [],
            sorted_states: [],
            state_keyword: '',
            private_notices: [],
            private_agencies: [],
            sorted_categories: [],
            category_keyword: null,
            sorted_private_agencies: [],
            selected_private_agencies: [],
            categories: [],
            selected_categories : [],
            naics: [],
            alert: {
                alert_id: '',
                titel: '',
                frequency: '',
                region: 'Private',
                keywords: [],
                states: [],
                categories:[],
                private_notices: [],
                private_agencies: [],
                categories: [],
                naics: [],
                pscs: []
            },
            tags: [],
            treeData: {
                name: "",
                naics_code: "Select All",
                children: [],
            },
            service_codes: {
                name: "",
                psc_code: "Select All",
                children: [],
            },
            tag: "",
            // tags:[],
            selectedNaicses: [],
            childItems: [],
            filterAgency: [],
            state_country1: [],
            allFilterAgency: [],
            SpecificAgency: [],
            agencycheck: "",
            agencyAll: [],
            agencySpecific: [],
            searchstate: "",
            errors: [],
            tdr_agency: [],
            countryid: [],
            selected: [],
            statussearch: true,
            selectAll: false,
            searchagencyState: "",
            stateSelected: [],
            selectAllState: false,
            selectedcategory: [],
            selectAllcategory: false,
            selectedState: [],
            agencyState: [],
            categorys: [],
            status: true,
            searchagencycategory: "",
            interstedUser: {
                id: "",
                user_id: "",
            },
            liststate: {
                country_id: [10],
            },
            listcountry: {
                country_id: [],
            },
            searchfilter: {
                tdr_country: [],
            },
            keywords: [],
            countrys: [],
            state_id: [],
            naics_id: [],
            psc: [],
            category_status: [],
            agency_fedral: [],
            notice_type: [],
            state_country: [],
            federal: [],
            sideStatus: [],
            notices: [],
            state: [],
            user_id: "",
            savedata: [],
            frequency: "",
            agencycount: 0,
            categorycount: 0,
            allFilterCategroy: [],
            savealert: {
                id: "",
                user_id: "",
                on_off: 1,
                alert_label: "",
                region_id: "",
                state_id: "",
                frequency: "",
                keywords: "",
                category_id: "",
                naics_id: "",
                notice_type: "",
                psc: "",
                category_status: "",
                agency_fedral: "",
                created_on: "",
                updated_on: "",
            },
            isLoading: false,
            isLoading1: false,
            isLoading2: false,
            fullPage: true,
            fullPage1: false,
            fullPage2: false,
            naics_code: {
                search: "",
                alert_id: ''
            },
            service_code: {
                search: "",
                alert_id: ''
            },
            clear_all_naics: false,
            clear_all_psc: false,
            private_agency_keyword: null
        };
    },

    watch: {

    },
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            if (to.name == 'EditPrivateAlert') {
                vm.alert.alert_id = to.params.alert_id
                vm.getAlert()
            }
        })
    },

    mounted() {
        this.getSates()
    },
    computed: {
        filterState() {
            return this.state_country.filter((state) => {
                return state.state_name.toLowerCase().includes(this.searchstate.toLowerCase());
            });
        },

        filterSpecifyAgency() {
            return this.agencySpecific.filter((statefederal) => {
                return statefederal.private_agency_name.toLowerCase().includes(this.searchagencyState.toLowerCase());
            });
        },
    },
    methods: {

        selectAllCategories() {
            let vm = this
            vm.alert.categories = []
            vm.sorted_categories.map(function (element) {
                vm.alert.categories.push(element.category_id)
            })
            vm.selected_categories = []
            vm.alert.categories.map(function (element) {
                let selected = vm.sorted_categories.filter(function (ele) {
                    return ele.category_id == element
                })
                if (selected.length) {
                    vm.selected_categories.push({
                        category_id: selected[0].category_id,
                        category_name: selected[0].category_name
                    })
                }
            })
        },

        deselectCategories() {
            this.sorted_categories = this.categories
            this.category_keyword = null
            this.alert.categories = []
            this.selected_categories = []
        },

        getAlert() {
            let vm = this;
            if (vm.$store.getters.user) {
                vm.alert.user_id = vm.$store.getters.user.user_id
                let uri = "getAlert";
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.alert })
                    .then(function (response) {
                        vm.alert = response.data.data
                        vm.tags = vm.alert.keywords
                        vm.status = false
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },
        removeStateAgency(private_agency) {
            console.log(private_agency)
            let vm = this
            let agency = vm.selected_private_agencies.filter(function(element){
                return element.private_agency_id != private_agency.private_agency_id
            })
            vm.selected_private_agencies = agency
            vm.alert.private_agencies = []
        },

        removeTag(index) {
            this.alert.keywords.splice(index, 1);
        },
        removeLastTag(event) {
            if (event.target.value.length === 0) {
                this.removeTag(this.alert.keywords.length - 1);
            }
        },
        updateStateAgencies(private_agency, event) {
            let vm = this
            if (event.target.checked) {
                if (!vm.alert.private_agencies.includes(private_agency.private_agency_id)) {
                    vm.alert.private_agencies.push(private_agency.private_agency_id)
                }
            } else {
                if (vm.alert.private_agencies.includes(private_agency.private_agency_id)) {
                    let private_agencies = vm.alert.private_agencies.filter(function (element) {
                        return element != private_agency.private_agency_id
                    })
                    vm.alert.private_agencies = private_agencies
                }
            }
            vm.selected_private_agencies = []
            vm.alert.private_agencies.map(function (element) {
                let selected = vm.sorted_private_agencies.filter(function (ele) {
                    return ele.private_agency_id == element
                })
                if (selected.length) {
                    vm.selected_private_agencies.push({
                        private_agency_id: selected[0].private_agency_id,
                        private_agency_name: selected[0].private_agency_name
                    })
                }
            })
        },
        updateCategories(category, event) {
            if (event.target.checked) {
                if (!this.alert.categories.includes(category.category_id)) {
                    this.alert.categories.push(category.category_id)
                }
            } else {
                if (this.alert.categories.includes(category.category_id)) {
                    let categories = this.alert.categories.filter(function (element) {
                        return element != category.category_id
                    })
                    this.alert.categories = categories
                }
            }
        },
        updateStates(state, event) {
            if (event.target.checked) {
                if (!this.alert.states.includes(state.state_id)) {
                    this.alert.states.push(state.state_id)
                }
            } else {
                if (this.alert.states.includes(state.state_id)) {
                    let states = this.alert.states.filter(function (element) {
                        return element != state.state_id
                    })
                    this.alert.states = states
                }
            }
        },

        updatePrivateNotices(notice, event) {
            if (event.target.checked) {
                if (!this.alert.private_notices.includes(notice.private_notice_id)) {
                    this.alert.private_notices.push(notice.private_notice_id)
                }
            } else {
                if (this.alert.private_notices.includes(notice.private_notice_id)) {
                    let private_notices = this.alert.private_notices.filter(function (element) {
                        return element != notice.private_notice_id
                    })
                    this.alert.private_notices = private_notices
                }
            }
        },

        sortPrivarteAgency() {
            let vm = this
            vm.sorted_private_agencies = vm.private_agencies.filter(function (element) {
                return element.private_agency_name.toLowerCase().includes(vm.private_agency_keyword.toLowerCase());
            })
        },

        selectAllPrivateAgencies() {
            let vm = this
            vm.alert.private_agencies = []
            vm.sorted_private_agencies.map(function (element) {
                vm.alert.private_agencies.push(element.private_agency_id)
            })
            vm.selected_private_agencies = []
            vm.alert.private_agencies.map(function (element) {
                let selected = vm.sorted_private_agencies.filter(function (ele) {
                    return ele.private_agency_id == element
                })
                if (selected.length) {
                    vm.selected_private_agencies.push({
                        private_agency_id: selected[0].private_agency_id,
                        private_agency_name: selected[0].private_agency_name
                    })
                }
            })
        },

        deselectPrivateAgencies() {
            this.sorted_private_agencies = this.private_agencies
            this.private_agency_keyword = null
            this.alert.private_agencies = []
            this.selected_private_agencies = []
        },

        selectAllStates() {
            let vm = this
            vm.alert.states = []
            vm.sorted_states.map(function (element) {
                vm.alert.states.push(element.state_id)
            })
        },
        deselectAllStates() {
            this.sorted_states = this.states
            this.state_keyword = null
            this.alert.states = []
        },
        getSates() {
            let vm = this;
            let uri = "getStates";
            vm.$store
                .dispatch("post", { uri: uri, data: { country_id: 10 } })
                .then(function (response) {
                    vm.states = response.data
                    vm.sorted_states = vm.states
                    vm.getPrivateNotices()
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        sortStates() {
            let vm = this
            vm.sorted_states = vm.states.filter(function (element) {
                return element.state_name.toLowerCase().includes(vm.state_keyword.toLowerCase());
            })
        },

        getPrivateNotices() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getPrivateNotices" })
                .then(function (response) {
                    vm.private_notices = response.data.data
                    vm.getPrivateAgencies()
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getPrivateAgencies() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getPrivateAgencies" })
                .then(function (response) {
                    vm.private_agencies = response.data.data
                    vm.sorted_private_agencies = vm.private_agencies
                    vm.getCategories()
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        getCategories() {
            let vm = this;
            let uri = "getCategories";
            vm.$store
                .dispatch("post", { uri: uri })
                .then(function (response) {
                    vm.categories = response.data
                    vm.sorted_categories = vm.categories
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        createAlerts() {
            let vm = this
            vm.alert.keywords = vm.tags
            if (vm.$store.getters.user) {
                vm.alert.user_id = vm.$store.getters.user.user_id
                vm.$store
                    .dispatch("post", { uri: 'addPrivateAlerts', data: vm.alert })
                    .then(function (response) {
                        vm.$store.dispatch("success", "Alert is added successfully");
                        vm.$router.push("/bids/alerts");
                    })
                    .catch(function (error) {
                        console.log(error)
                        if (error.response.data.errors.states) {
                            vm.state_border_red = 'border-color:red'
                        }
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        updateAlerts() {
            let vm = this
            vm.alert.naics = vm.$store.getters.selected_naics
            vm.alert.pscs = vm.$store.getters.selected_pscs
            vm.alert.keywords = vm.tags
            if (vm.$store.getters.user) {
                vm.alert.user_id = vm.$store.getters.user.user_id
                vm.$store
                    .dispatch("post", { uri: 'updatePrivateAlerts', data: vm.alert })
                    .then(function (response) {
                        vm.$store.dispatch("success", "Alert is updated successfully");
                        vm.$router.push("/bids/alerts");
                    })
                    .catch(function (error) {
                        console.log(error)
                        if (error.response.data.errors.states) {
                            vm.state_border_red = 'border-color:red'
                        }
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        backSaveAlert() {
            this.$store.commit("setAlert", "");
            this.$store.commit("setSelectedNaics", []);
            this.$store.commit("setSelectedPsces", []);
            this.$router.push("/bids/alerts");
        },



        handleChangeTag(tags) {
            let vm = this;
            vm.tags = tags;
            vm.keywords = vm.tags;
        },

        removeTag(index) {
            this.agency_fedral.splice(index, 1);
        },
        submit() {
            let vm = this;
            if (vm.status) {
                vm.createAlerts();
            } else {
                vm.updateAlert();
            }
        },
        filterCategory() {
            if (this.searchagencycategory == "") {
                this.categorys = this.allFilterCategroy;
            }
            this.categorys = this.allFilterCategroy.filter((entry) => {
                return entry.category_name.toLowerCase().includes(this.searchagencycategory.toLowerCase());
            });
        },
        callFunction: function () {
            var currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
            // console.log(currentDateWithFormat);
            this.savealert.created_on = currentDateWithFormat;
            this.savealert.updated_on = currentDateWithFormat;
        },

        getcategory() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getCategory" })
                .then(function (response) {
                    vm.categorys = response.data.data;
                    vm.categorycount = vm.categorys.length;
                    vm.allFilterCategroy = vm.categorys;
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        getCountry() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getCountry" })
                .then(function (response) {
                    vm.countrys = response.data.data;
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
        selectCategory() {
            this.selectedcategory = [];
            this.selectAllcategory = false;
            if (!this.selectAllcategory) {
                for (let i in this.categorys) {
                    this.selectedcategory.push(this.categorys[i].category_id);
                }
                this.searchfilter.tdr_category = this.selectedcategory;
            }
        },

        DeselectCategory() {
            this.selectedcategory = [];
            this.searchfilter.tdr_category = [];
        },
        updateCheckallCategory(category) {
            if (this.categorys.length == this.selectedcategory.length) {
                this.selectedcategory = [];
                this.selectAllcategory = true;
                this.searchfilter.tdr_category = this.selectedcategory;
            } else {
                this.selectAllcategory = false;

                this.searchfilter.tdr_category = this.selectedcategory;
            }
        },
        selectCountryState() {
            this.stateSelected = [];
            this.stateselectAll = false;
            if (!this.stateselectAll) {
                this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                for (let i in this.state_country1) {
                    this.stateSelected.push(this.state_country[i].state_id);
                    this.filters.push({
                        table: "state",
                        id: this.state_country[i].state_id,
                        name: this.state_country[i].state_name,
                    });
                }
                // alert(this.selected);
                this.searchfilter.tdr_state = this.stateSelected;
                this.getfedralDocument();
            }
        },
        DeselectCountryState() {
            this.stateSelected = [];
            this.searchfilter.tdr_state = [];
            this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
            this.getfedralDocument();
        },
        updateCountryStateCheckall(state) {
            if (this.state_country.length == this.stateSelected.length) {
                this.stateSelected = [];
                this.stateselectAll = true;
                this.searchfilter.tdr_state = this.stateSelected;
                this.getfedralDocument();
                if (this.stateselectAll == true) {
                    this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                    for (let i in this.state_country) {
                        this.stateSelected.push(this.state_country[i].state_id);
                        // this.statefilter.push(this.state_country[i]);
                        this.filters.push({
                            table: "state",
                            id: this.state_country[i].state_id,
                            name: this.state_country[i].state_name,
                        });
                    }
                }
            } else {
                let i = this.filters.findIndex((data) => data.id === state.state_id);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                } else {
                    this.filters.push({
                        table: "state",
                        id: state.state_id,
                        name: state.state_name,
                    });
                    // this.statefilter.push(state);
                    this.filters = this.filters.filter((state, index) => this.filters.indexOf(state) === index);
                }
                this.stateselectAll = false;
                // alert(this.selected);
                this.searchfilter.tdr_state = this.stateSelected;

                // alert(this.selected.length);
            }
        },
        getSateCountry() {
            let vm = this;
            if (vm.listcountry.country_id[0] !== "") {
                vm.searchfilter.tdr_country = vm.listcountry.country_id;
            } else {
                vm.searchfilter.tdr_country = [];
            }

            vm.listcountry.country_id = Object.assign({}, [vm.liststate.country_id]);
            let uri = "getState";
            vm.$store
                .dispatch("post", { uri: uri, data: vm.listcountry })
                .then(function (response) {
                    vm.state_country1 = response.data.data;
                    vm.statecount1 = vm.state_country1.length;
                    vm.allFilterState = vm.state_country1;
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },







        select() {
            this.selected = [];
            if (!this.selectAll) {
                for (let i in this.state_country) {
                    this.selected.push(this.state_country[i].state_id);
                }
                // alert(this.selected);
                this.state_id = this.selected;
            }
        },
        Deselect() {
            this.selected = [];
            this.state_id = [];
        },
        updateCheckall() {
            if (this.state_country.length == this.selected.length) {
                this.selectAll = true;
                // alert(this.selected);
                //alert(this.options);
                this.state_id = this.selected;

                // alert(this.searchfilter.tdr_state);
            } else {
                this.selectAll = false;
                // alert(this.selected);
                this.state_id = this.selected;

                // alert(this.selected.length);
            }
        },

        // federal search subhash
        selectState() {
            this.selectedState = [];
            if (!this.selectAllState) {
                for (let i in this.filterAgency) {
                    this.selectedState.push(this.filterAgency[i].state_agency_name);
                }

                this.agency_fedral = this.selectedState;
            }
        },
        DeselectState() {
            this.selectedState = [];
            this.agency_fedral = [];
        },
        updateCheckallState() {
            if (this.filterAgency.length == this.selectedState.length) {
                this.selectAllState = true;
                this.agency_fedral = this.selectedState;
            } else {
                this.selectAllState = false;

                this.agency_fedral = this.selectedState;
            }
        },

        addTag(event) {
            event.preventDefault();
            let val = event.target.value.trim();
            if (val.length > 0) {
                if (this.tags.length >= 1) {
                    for (let i = 0; i < this.tags.length; i++) {
                        if (this.tags[i] === val) {
                            return false;
                        }
                    }
                }
                this.tags.push(val);
                event.target.value = "";
                console.log(this.tags);
            }
        },
        removeTag(index) {
            this.tags.splice(index, 1);
        },
        removeLastTag(event) {
            if (event.target.value.length === 0) {
                this.removeTag(this.tags.length - 1);
            }
        },
    },
};
</script>
<style scoped>
.border-red {
    border-color: red !important;
}

.x-box {
    height: 130px;
    display: block;
    overflow-y: auto;
    /* overflow: hidden; */
}

.btn-close {
    opacity: 0.9;
}

.btnwht10 {
    background-color: white !important;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.btnwht10:hover {
    background-color: white !important;
}

.form11 {
    color: #212529;
}

.drop-item:hover {
    background-color: white !important;
}

.abertbtn {
    background-color: #eeee !important;
    border: 1px solid grey !important;
}

.abertbtn:hover {
    background-color: #eeee !important;
}

.form-check-input,
.form-select:focus {
    /* border-color: #28a745; */
    box-shadow: none !important;
}

.hgttree {
    max-height: 150px;
    overflow-y: scroll;
}

.liststate {
    max-height: 230px;
    margin-bottom: 10px;
    overflow-y: scroll;
    -webkit-overflow-scrolling: touch;
}

.truncate {
    width: 240px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 0.25rem 1rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    text-decoration: none;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
}

.ss-filter-search__input {
    display: inline-block;
    width: 100%;
    border: none;
    border-bottom: 1px solid;
    border-radius: 0;
    border-color: #cfd5e0;
    box-shadow: none;
    text-align: left;
    font-size: 12px;

    font-family: "ProximaNova Regular", sans-serif;
}

.myinput {
    border-top-style: hidden;
    border-right-style: hidden;
    border-left-style: hidden;
    border-bottom-style: outset;
    border-radius: 0px;
    padding: 5px;
}

.myinput:focus {
    outline: none;
}

.dotted {
    border-bottom: 1px dotted;
}

.dotted:hover {
    border-bottom: 0px;
}

.list-style-none {
    list-style: none;
}

/* width */
::-webkit-scrollbar {
    width: 5px !important;

    cursor: pointer;
}

/* Track */
::-webkit-scrollbar-track {
    /* box-shadow: inset 0 0 5px grey;  */
    border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background-color: #5143d9 !important;
    border-radius: 10px !important;
}

.scroll1 {
    position: relative;
    height: 160px;
    overflow: hidden;
    overflow-y: scroll;
    color: rgb(89, 93, 110);
    font-size: 14px;
}

.list-group-item:last-child {
    border-bottom-right-radius: initial !important;
    border-bottom-left-radius: initial !important;
}

.list-group-item:first-child {
    border-top-left-radius: initial !important;
    border-top-right-radius: initial !important;
}

.v3ti--focus {
    box-shadow: 0 0 0 1px #9ca3af !important;
    border: #9ca3af !important;
}

.tag-input {
    width: 50%;
    border: 1px solid #d9dfe7;
    background: #fff;
    border-radius: 4px;
    font-size: 0.9em;
    min-height: 45px;
    box-sizing: border-box;
    padding: 0 10px;

    margin-bottom: 10px;
}

.tag-input__tag {
    height: 24px;
    /* color: white; */
    float: left;
    font-size: 14px;
    margin-right: 10px;
    background: #e1f1ff !important;
    color: #00639a !important;
    /* background-color: #667eea; */
    border-radius: 10px;
    margin-top: 10px;
    line-height: 24px;
    padding: 0 8px;


}

.tag-input__tag>span {
    cursor: pointer;
    opacity: 1;
    display: inline-block;
    margin-left: 8px;
}

.tag-input__text {
    border: none;
    outline: none;
    font-size: 1em;
    line-height: 40px;
    background: none;
}

.cv-catalog-list-item__expand-button[data-v-1c2a3381] {
    top: 4px !important;
}

.b1 {
    font-size: 20px;
    font-weight: 600;
}

.scroll2 {
    height: 280px !important;

}

.treehght {
    height: 287px !important
}

.hgt {
    height: 230px !important;
}
.bg-light-green{
    background-color: #f0fdf4;

}
.title-green{
 color: #16a34a;
}
.fw-400{
    font-weight: 400;
}
/* .text-align-justify {
    text-align: justify;
} */

</style>