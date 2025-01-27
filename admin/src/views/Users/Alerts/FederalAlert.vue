<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Federale Alert</h2>
            <router-link to="/alerts" class="btn btn-primary mb-2">Back</router-link>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <form class="card" @submit.prevent="submitForm()">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0" v-if="status"><strong>Add Federal Alert</strong></h6>
                            <h6 class="card-title mb-0" v-else><strong>Update Federal Alert</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form-label">User <span class="text-danger">*</span></label>
                                    <select class="form-control" :class="{ 'is-invalid': errors.user_id }" v-model="alert.user_id">
                                        <option value="">Select User</option>
                                        <option v-for="(user, key) in users" :key="key" :value="user.user_id">{{ user.name }}</option>
                                    </select>
                                    <span v-if="errors.user_id" class="invalid-feedback">{{ errors.user_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form-label">Alert Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" :class="{ 'is-invalid': errors.alert_title }" v-model="alert.alert_title" placeholder="Alert Title" />
                                    <span v-if="errors.alert_title" class="invalid-feedback">{{ errors.alert_title[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form-label">Frequency<span class="text-danger">*</span></label>
                                    <select class="form-select" v-model="alert.frequency" :class="{ 'is-invalid': errors.frequency }">
                                        <option selected="" value="">Select your Frequency</option>
                                        <option value:daily>Daily</option>
                                        <option value:weekly>Weekly</option>
                                    </select>
                                    <span v-if="errors.frequency" class="invalid-feedback">{{ errors.frequency[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>State <span class="text-danger">*</span></label>
                                    <label class="form-label">{{ alert.states.length }} of {{ sorted_states.length }} Selected</label>
                                    <div class="">
                                        <button type="button" class="btn btn-state form-select" data-bs-toggle="dropdown" :style="state_border_red">
                                            <span class="text-center" style="float: left; color: var(--bs-gray-500); font-weight: 400;">Select State</span>
                                        </button>
                                        <span v-if="errors.states" style="font-size: 0.875em; color: #dc3545;">{{ errors.states[0] }}</span>
                                        <span v-if="errors.states" class="invalid-feedback">{{ errors.states[0] }}</span>
                                        <label for="inputfrequen1" class="form-label"> </label>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-item">
                                                <div class="">
                                                    {{ alert.states?.length }} of {{ sorted_states?.length }}
                                                    <span v-if="alert.states?.length !== sorted_states?.length">
                                                        <a href="javascript:void(0)" @click="selectAllStates()" class="" ref="selectState">
                                                            Select All /
                                                        </a>
                                                    </span>
                                                    <span>
                                                        <a href="javascript:void(0)" @click="deselectAllStates()" class="" ref="selectState">
                                                            Reset all
                                                        </a>
                                                    </span>
                                                    <div class="ss-filter-search">
                                                        <input autocomplete="off" class="form-control" type="text" v-model="state_keyword" placeholder="Search state" @keyup="sortStates()" />
                                                        <div class="liststate" id="style-3">
                                                            <ul class="checkbox" style="padding-left: 10px;" v-for="state in sorted_states" :key="state.state_id">
                                                                <li class="list-group-item">
                                                                    <input class="form-check-input me-1" id="federalcheck" type="checkbox" :value="state.state_id" v-model="alert.states" @click="updateStates(state, $event)" />
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
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <strong>Notice type<span class="text-danger">*</span></strong><br />
                                    <span v-if="errors.federal_notices" style="color: #dc3545; margin-top: -10px; font-size: 0.875em;">{{ errors.federal_notices[0] }}</span>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-4 col-xl-4" v-for="notice in federal_notices" :key="notice.notice_id">
                                            <ul class="list-group mb-0">
                                                <li class="list-group-item list-group-item-borderless">
                                                    <input type="checkbox" class="form-check-input me-2" id="rememberCheck" :value="notice.federal_notice_id" v-model="alert.federal_notices" @click="updateFederalNotices(notice, $event)" />
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        {{ notice.notice_name }}
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <strong>Set-Aside Code <span class="text-danger">*</span> </strong>
                                    <div v-if="errors.set_asides" style="color: #dc3545; font-size: 0.875em;">{{ errors.set_asides[0] }}</div>
                                    <a class="inf" href="javascript:void(0)"> More Information about Set-Aside Codes</a>
                                    <div class="row g-2 text-align-justify">
                                        <div class="col-sm-6 col-lg-6 col-xl-6" style="padding-right: 20px;" v-for="set_aside in set_asides" :key="set_aside.set_aside_id">
                                            <ul class="list-group mb-0">
                                                <li class="list-group-item list-group-item-borderless d-flex">
                                                    <span>
                                                        <input type="checkbox" class="form-check-input me-2" id="rememberCheck" :value="set_aside.set_aside_id" v-model="alert.set_asides" @click="updateSetAsides(set_aside, $event)" />
                                                    </span>
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        {{ set_aside.set_aside_name }}
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <strong>Agency </strong>
                                    <div>
                                        <span class="greentitle mt-1"> About Scheduled Emails:</span>
                                        <span class="text-center mt-2">
                                            Type in a partial agency name below and then choose a match to add it to your selection.
                                            <br />
                                            To remove a choice from your selection press the [X] icon on the left.
                                        </span>
                                    </div>
                                    <div class="collapse show mt-2" id="collapseExample7">
                                        <div class="collapse show" id="collapseExample7">
                                            <div class="">
                                                {{ alert.federal_agencies.length }} of {{ sorted_federal_agencies.length }}
                                                <span v-if="alert.federal_agencies.length !== sorted_federal_agencies.length">
                                                    <a href="javascript:void(0)" @click="selectAllFederalAgencies()" class="" ref="selectState">
                                                        Select All /
                                                    </a>
                                                </span>
                                                <a href="javascript:void(0)" @click="deselectFederalAgencies()" class="" ref="selectState">
                                                    Reset all
                                                </a>
                                                <div class="col-md-6">
                                                    <div class="ss-filter-search">
                                                        <input
                                                            class="form-control pe-5"
                                                            type="search"
                                                            placeholder="Search"
                                                            aria-label="Search"
                                                            v-model="federal_agency_keyword"
                                                            @keyup="sortFederalAgency()"
                                                            style="border-radius: 0.5rem 0.5rem 0px 0px;"
                                                        />
                                                        <div class="liststate scroll1 hgt" id="style-3" style="border: 1px solid #c5c5c7; border-top: 0px;">
                                                            <ul class="list-group checkbox" v-for="federal_agency in sorted_federal_agencies" :key="federal_agency.agency_id">
                                                                <li class="list-group-item d-flex border-0 border-bottom">
                                                                    &nbsp;
                                                                    <input
                                                                        class="form-check-input me-1"
                                                                        type="checkbox"
                                                                        :value="federal_agency.federal_agency_id"
                                                                        v-model="alert.federal_agencies"
                                                                        @click="updateFederalAgencies(federal_agency, $event)"
                                                                    />
                                                                    &nbsp; {{ federal_agency.agency_name }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4 scroll1" v-if="selected_federal_agencies.length">
                                                    <div class="col-sm-8 col-lg-4 col-xl-3" v-for="agency, index in selected_federal_agencies" :key="index">
                                                        <div class="bg-success bg-opacity-10 text-success d-flex justify-content-between align-items-center p-2 mb-3">
                                                            <div class="" style="padding-left: 10px;">
                                                                <span>{{ agency.agency_name }}</span>
                                                            </div>
                                                            <a href="javascript:void(0)" class="icon-lg rounded-circle flex-shrink-0 bg-opacity-10 text-dark mb-0" @click="removeFederalAgency(agency)">
                                                                <i class="ri-close-line fs-18 lh-1"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>NAICS Code: <span class="text-danger">*</span></strong><br />
                                            <span v-if="errors.naics" style="color: #dc3545; margin-top: -10px; font-size: 0.875em;">{{ errors.naics[0] }}<br /></span>
                                            <div class="mt-1">
                                                Use the search box to find NAICS Codes and mark one or more checkboxes to add to your selection. Note:Changing your search criteria does not remove items from your selection.
                                            </div>

                                            <div class="tab-content mt-2 mb-0" id="flight-pills-tabContent">
                                                <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                                                    <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                                        <div class="col-md-8 small">
                                                            <form class="position-relative">
                                                                <input
                                                                    class="form-control form-control-sm pe-5 myinput"
                                                                    type="search"
                                                                    placeholder="Search in Naics Codes"
                                                                    aria-label="Search"
                                                                    v-model="naics_code.search"
                                                                    @keypress.enter="getNaics()"
                                                                />
                                                                <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="getNaics()"><i class="fas fa-search fs-6"></i></button>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-4 small d-flex">
                                                            <div>
                                                                <a class="my-auto dotted" href="javascript:void(0)" @click="clearAllNaics()" style="color: rgb(64, 164, 241);">Deselect All</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card border-0">
                                                        <div class="vl-parent">
                                                            <loading v-model:active="isLoading1" :can-cancel="false" :z-index="10001" :is-full-page="fullPage1" />
                                                            <div class="card-body p-0 scroll1 treehght">
                                                                <ul class="list-style-none" style="padding-left: 0px;">
                                                                    <li>
                                                                        <ul id="demo">
                                                                            <Skeleton2 v-if="loading" />
                                                                            <template v-else>
                                                                                <TreeItem class="item" :item="treeData" :tdr_naics="alert.naics" :clear_all_naics="clear_all_naics"> </TreeItem>
                                                                            </template>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>PSC Code: <span class="text-danger">*</span></strong><br />
                                            <span v-if="errors.pscs" style="color: #dc3545; margin-top: -10px; font-size: 0.875em;">{{ errors.pscs[0] }}<br /></span>
                                            <div class="mt-1">
                                                Use the search box to find psc Codes and mark one or more checkboxes to add to your selection. Note:Changing your search criteria does not remove items from your selection.
                                            </div>

                                            <div class="tab-content mt-2 mb-0" id="flight-pills-tabContent">
                                                <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                                                    <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                                        <div class="col-md-8 small">
                                                            <form class="position-relative">
                                                                <input
                                                                    class="form-control form-control-sm pe-5 myinput"
                                                                    type="search"
                                                                    placeholder="Search in PSC Codes"
                                                                    aria-label="Search"
                                                                    v-model="service_code.search"
                                                                    @keypress.enter="getServiceCodes()"
                                                                />
                                                                <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="getServiceCodes()"><i class="fas fa-search fs-6"></i></button>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-4 small d-flex">
                                                            <div><a class="my-auto dotted" href="javascript:void(0)" @click="clearAllPsc()" style="color: rgb(64, 164, 241);">Deselect All</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="card border-0">
                                                        <div class="vl-parent">
                                                            <loading v-model:active="isLoading2" :can-cancel="false" :z-index="10001" :is-full-page="fullPage2" />
                                                            <div class="card-body p-0 scroll1 treehght">
                                                                <ul class="list-style-none" style="padding-left: 0px;">
                                                                    <li>
                                                                        <ul id="demo">
                                                                            <Skeleton2 v-if="loading_psc" />
                                                                            <template v-else>
                                                                                <PscTree class="item" :item="service_codes" :clear_all_psc="clear_all_psc"> </PscTree>
                                                                            </template>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <strong>Keywords (each seperated by ",") <span class="text-danger">*</span></strong><br />
                                    <span v-if="errors.keywords" style="color: #dc3545; font-size: 0.875em;">{{ errors.keywords[0] }}</span>
                                    <div class="tag-input mt-1">
                                        <div v-for="(tag, index) in tags" :key="tag" class="tag-input__tag">
                                            {{ tag }}
                                            <span @click="removeTag(index)">x</span>
                                        </div>
                                        <textarea rows="4" type="text" placeholder="Enter a keyword" class="form-control mb-0 tag-input__text" @keydown.enter="addTag" @keydown.,="addTag" @keydown.delete="removeLastTag"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button v-if="status" @click.prevent="createAlerts()" class="btn btn-primary" type="submit">Submit</button>
                        <button v-else @click.prevent="updateAlerts()" class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import TreeItem from "@/components/TreeItem.vue";
    import PscTree from "@/components/PscTree.vue";
    import Loading from "vue-loading-overlay";
    import Skeleton2 from "@/components/Skeleton2.vue";
    export default {
        components: { TreeItem, Skeleton2, Loading, PscTree },
        data() {
            return {
                state_border_red: "",
                states: [],
                sorted_states: [],
                state_keyword: "",
                federal_notices: [],
                federal_agencies: [],
                sorted_federal_agencies: [],
                selected_federal_agencies: [],
                set_asides: [],
                naics: [],
                users: [],
                alert: {
                    user_id: "",
                    federal_alert_id: "",
                    titel: "",
                    frequency: "",
                    region: "Federal",
                    keywords: [],
                    states: [],
                    federal_notices: [],
                    federal_agencies: [],
                    set_asides: [],
                    naics: [],
                    pscs: [],
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
                set_aside_status: [],
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
                    set_aside_status: "",
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
                    alert_id: "",
                },
                service_code: {
                    search: "",
                    alert_id: "",
                },
                clear_all_naics: false,
                clear_all_psc: false,
                federal_agency_keyword: null,
                loading: true, // Initial loading state
                loading_psc: true,
            };
        },

        beforeRouteEnter(to, from, next) {
            next((vm) => {
                if (to.name == "FederalAlert.Create") {
                    // vm.$refs.name.focus();
                } else {
                    let loader = vm.$loading.show();
                    let uri = { uri: "getAlert", data: { alert_id: to.params.alert_id } };
                    vm.$store
                        .dispatch("post", uri)
                        .then(function (response) {
                            loader.hide();
                            vm.alert = response.data.data;
                            vm.tags = vm.alert.keywords;
                            vm.status = false;
                            vm.$store.dispatch("setSelectedNaics", vm.alert.naics);
                            vm.$store.dispatch("setSelectedPscs", vm.alert.pscs);
                        })
                        .catch(function (error) {
                            loader.hide();
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            });
        },
        mounted() {
            this.getUsers();
        },
        computed: {
            filterState() {
                return this.state_country.filter((state) => {
                    return state.state_name.toLowerCase().includes(this.searchstate.toLowerCase());
                });
            },
            filterSpecifyAgency() {
                return this.agencySpecific.filter((statefederal) => {
                    return statefederal.agency_name.toLowerCase().includes(this.searchagencyState.toLowerCase());
                });
            },
        },
        methods: {
            removeFederalAgency(federal_agency) {
                console.log(federal_agency);
                let vm = this;
                let agency = vm.selected_federal_agencies.filter(function (element) {
                    return element.federal_agency_id != federal_agency.federal_agency_id;
                });
                vm.selected_federal_agencies = agency;
                vm.alert.federal_agencies = [];
                vm.select;
            },

            removeTag(index) {
                this.alert.keywords.splice(index, 1);
            },
            removeLastTag(event) {
                if (event.target.value.length === 0) {
                    this.removeTag(this.alert.keywords.length - 1);
                }
            },
            updateFederalAgencies(federal_agency, event) {
                let vm = this;
                if (event.target.checked) {
                    if (!vm.alert.federal_agencies.includes(federal_agency.federal_agency_id)) {
                        vm.alert.federal_agencies.push(federal_agency.federal_agency_id);
                    }
                } else {
                    if (vm.alert.federal_agencies.includes(federal_agency.federal_agency_id)) {
                        let federal_agencies = vm.alert.federal_agencies.filter(function (element) {
                            return element != federal_agency.federal_agency_id;
                        });
                        vm.alert.federal_agencies = federal_agencies;
                    }
                }
                vm.selected_federal_agencies = [];
                vm.alert.federal_agencies.map(function (element) {
                    let selected = vm.sorted_federal_agencies.filter(function (ele) {
                        return ele.federal_agency_id == element;
                    });
                    if (selected.length) {
                        vm.selected_federal_agencies.push({
                            federeal_agency_id: selected[0].federal_agency_id,
                            agency_name: selected[0].agency_name,
                        });
                    }
                });
            },
            updateSetAsides(set_aside, event) {
                if (event.target.checked) {
                    if (!this.alert.set_asides.includes(set_aside.set_aside_id)) {
                        this.alert.set_asides.push(set_aside.set_aside_id);
                    }
                } else {
                    if (this.alert.set_asides.includes(set_aside.set_aside_id)) {
                        let set_asides = this.alert.set_asides.filter(function (element) {
                            return element != set_aside.set_aside_id;
                        });
                        this.alert.set_asides = set_asides;
                    }
                }
            },
            updateStates(state, event) {
                if (event.target.checked) {
                    if (!this.alert.states.includes(state.state_id)) {
                        this.alert.states.push(state.state_id);
                    }
                } else {
                    if (this.alert.states.includes(state.state_id)) {
                        let states = this.alert.states.filter(function (element) {
                            return element != state.state_id;
                        });
                        this.alert.states = states;
                    }
                }
            },

            updateFederalNotices(notice, event) {
                if (event.target.checked) {
                    if (!this.alert.federal_notices.includes(notice.federal_notice_id)) {
                        this.alert.federal_notices.push(notice.federal_notice_id);
                    }
                } else {
                    if (this.alert.federal_notices.includes(notice.federal_notice_id)) {
                        let federal_notices = this.alert.federal_notices.filter(function (element) {
                            return element != notice.federal_notice_id;
                        });
                        this.alert.federal_notices = federal_notices;
                    }
                }
            },

            sortFederalAgency() {
                let vm = this;
                vm.sorted_federal_agencies = vm.federal_agencies.filter(function (element) {
                    return element.agency_name.toLowerCase().includes(vm.federal_agency_keyword.toLowerCase());
                });
            },

            selectAllFederalAgencies() {
                let vm = this;
                vm.alert.federal_agencies = [];
                vm.sorted_federal_agencies.map(function (element) {
                    vm.alert.federal_agencies.push(element.federal_agency_id);
                });
                vm.selected_federal_agencies = [];
                vm.alert.federal_agencies.map(function (element) {
                    let selected = vm.sorted_federal_agencies.filter(function (ele) {
                        return ele.federal_agency_id == element;
                    });
                    if (selected.length) {
                        vm.selected_federal_agencies.push({
                            federeal_agency_id: selected[0].federal_agency_id,
                            agency_name: selected[0].agency_name,
                        });
                    }
                });
            },

            deselectFederalAgencies() {
                this.sorted_federal_agencies = this.federal_agencies;
                this.federal_agency_keyword = null;
                this.alert.federal_agencies = [];
                this.selected_federal_agencies = [];
            },

            selectAllStates() {
                let vm = this;
                vm.alert.states = [];
                vm.sorted_states.map(function (element) {
                    vm.alert.states.push(element.state_id);
                });
            },
            deselectAllStates() {
                this.sorted_states = this.states;
                this.state_keyword = null;
                this.alert.states = [];
            },
            getUsers() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getUsers" })
                    .then(function (response) {
                        vm.users = response.data;
                        vm.getSates();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getSates() {
                let vm = this;
                let uri = "getStates";
                vm.$store
                    .dispatch("post", { uri: uri, data: { country_id: 10 } })
                    .then(function (response) {
                        vm.states = response.data;
                        vm.sorted_states = vm.states;
                        vm.getFederalNotices();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            sortStates() {
                let vm = this;
                vm.sorted_states = vm.states.filter(function (element) {
                    return element.state_name.toLowerCase().includes(vm.state_keyword.toLowerCase());
                });
            },

            getFederalNotices() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getFederalNotices" })
                    .then(function (response) {
                        vm.federal_notices = response.data;
                        vm.getFederalAgencies();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getFederalAgencies() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getFederalAgencies" })
                    .then(function (response) {
                        vm.federal_agencies = response.data;
                        vm.sorted_federal_agencies = vm.federal_agencies;
                        vm.getSetAsides();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getSetAsides() {
                let vm = this;
                let uri = "getSetAsides";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.set_asides = response.data;
                        vm.getNaics();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getNaics() {
                let vm = this;
                vm.loading = true;
                let uri = "getNaics";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.treeData.children = response.data.naics;
                        vm.getPscs();
                        vm.loading = false;
                    })
                    .catch(function (error) {
                        vm.loading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getPscs() {
                let vm = this;
                vm.loading_psc = true;
                let uri = "getPscs";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.service_codes.children = response.data.data;
                        vm.loading_psc = false;
                    })
                    .catch(function (error) {
                        vm.loading_psc = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            createAlerts() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.alert.naics = vm.$store.getters.selected_naics;
                vm.alert.pscs = vm.$store.getters.selected_pscs;
                vm.alert.keywords = vm.tags;
                vm.$store
                    .dispatch("post", { uri: "createAlerts", data: vm.alert })
                    .then(function (response) {
                        loader.hide();
                        vm.$store.dispatch("success", "Alert is added successfully");
                        vm.$router.push("/alerts");
                    })
                    .catch(function (error) {
                        console.log(error);
                        loader.hide();
                        if (error.response.data.errors.states) {
                            vm.state_border_red = "border-color:red";
                        }
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            updateAlerts() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.alert.naics = vm.$store.getters.selected_naics;
                vm.alert.pscs = vm.$store.getters.selected_pscs;
                vm.alert.keywords = vm.tags;
                vm.$store
                    .dispatch("post", { uri: "updateAlerts", data: vm.alert })
                    .then(function (response) {
                        loader.hide();
                        vm.$store.dispatch("success", "Alert is updated successfully");
                        vm.$store.dispatch("setSelectedNaics", null);
                        vm.$store.dispatch("setSelectedPscs", null);
                        vm.$router.push("/alerts");
                    })
                    .catch(function (error) {
                        console.log(error);
                        loader.hide();
                        if (error.response.data.errors.states) {
                            vm.state_border_red = "border-color:red";
                        }
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getNotice(region_id) {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getNotice?region_id=" + region_id })
                    .then(function (response) {
                        vm.notices = response.data.data;

                        vm.getasideStatus();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getasideStatus() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getAllSetAsideStatus" })
                    .then(function (response) {
                        vm.sideStatus = response.data.data;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            backSaveAlert() {
                this.$store.commit("setAlert", "");
                this.$store.commit("setSelectedNaics", []);
                this.$store.commit("setSelectedPsces", []);
                this.$router.push("/bids/alerts");
            },

            clearAllNaics() {
                this.isLoading1 = true;
                setTimeout(() => {
                    this.clear_all_naics = !this.clear_all_naics;
                    this.isLoading1 = false;
                }, 1000);
            },

            clearAllPsc() {
                this.isLoading2 = true;
                setTimeout(() => {
                    this.clear_all_psc = !this.clear_all_psc;
                    this.isLoading2 = false;
                }, 1000);
            },

            handleChangeTag(tags) {
                let vm = this;
                vm.tags = tags;
                vm.keywords = vm.tags;
            },
            getNaicsBackend() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getNaics", data: vm.naics_code })
                    .then(function (response) {
                        vm.isLoading1 = false;
                        vm.treeData.children = response.data.data;
                        vm.$store.dispatch("setNaics", vm.treeData.children);
                        // vm.getServiceCodes();
                    })
                    .catch(function (error) {
                        vm.isLoading1 = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getServiceCodes() {
                let vm = this;
                vm.fullPage = false;
                vm.isLoading1 = false;
                vm.isLoading2 = true;
                vm.service_code.alert_id = vm.$store.getters.alert.id;
                vm.$store
                    .dispatch("post", { uri: "getPsc", data: vm.service_code })
                    .then(function (response) {
                        vm.isLoading2 = false;
                        vm.$store.dispatch("setPsces", response.data.data);
                        vm.service_codes.children = vm.$store.getters.psces;
                        if (response.data.data.length) {
                            if (response.data.data[0].psces && response.data.data[0].psces[0] != "") {
                                vm.$store.dispatch("setSelectedPsces", response.data.data[0].psces);
                                vm.applyFilterPsc();
                            }
                        }
                    })
                    .catch(function (error) {
                        vm.isLoading2 = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            removeTag(index) {
                this.agency_fedral.splice(index, 1);
            },
            submit() {
                let vm = this;
                if (vm.status) {
                    vm.createAlerts();
                } else {
                    vm.updateAlerts();
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

            getFederal() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getAgencyFederal" })
                    .then(function (response) {
                        vm.federal = response.data.data;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getAllAgency() {
                let vm = this;
                vm.isLoading = true;
                let uri = "getAgency";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.filterAgency = response.data.data;
                        vm.allFilterAgency = vm.filterAgency;
                        vm.agencycount = vm.filterAgency.length;
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getSpecificAgency() {
                let vm = this;
                vm.isLoading = true;
                let uri = "getAgencyFederal";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.federal = response.data.data;
                        vm.filterAgency = response.data.data;
                        vm.allFilterAgency = vm.filterAgency;
                        vm.agencycount = vm.filterAgency.length;
                        //vm.getSavedsearch();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            filter1Agency() {
                if (this.searchagencyState == "") {
                    this.filterAgency = this.allFilterAgency;
                }
                this.filterAgency = this.allFilterAgency.filter((entry) => {
                    return entry.agency_name.toLowerCase().includes(this.searchagencyState.toLowerCase());
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
                        this.selectedState.push(this.filterAgency[i].agency_name);
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
    .btn-state {
        background-color: white !important;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .list-group-item-borderless {
        border: 0px;
    }

    .scroll1 {
        position: relative;
        height: 160px;
        overflow: hidden;
        overflow-y: scroll;
        color: rgb(89, 93, 110);
        font-size: 14px;
    }

    .tag-input {
        /* width: 50%; */
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

    .tag-input__tag > span {
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

    .liststate {
        max-height: 230px;
        margin-bottom: 10px;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
    }

    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }

    .treehght {
        height: 287px !important;
    }
    .skeleton-loader {
        height: 20px;
        background: #e0e0e0;
        margin: 10px 0;
        border-radius: 4px;
        animation: shimmer 1.5s infinite linear;
    }

    @keyframes shimmer {
        0% {
            background-position: -200px 0;
        }
        100% {
            background-position: 200px 0;
        }
    }

    .skeleton-loader {
        background: linear-gradient(90deg, #e0e0e0 25%, #f2f2f2 50%, #e0e0e0 75%);
        background-size: 400px 100%;
    }

    .dotted {
        border-bottom: 1px dotted;
    }

    .dotted:hover {
        border-bottom: 0px;
    }
</style>
