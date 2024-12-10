<template>
    <Region/>
    <div class="search">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 d-flex justify-content-between search-left my-auto" style="">
                    <div class="label">Filters</div>
                    <div class="empty" :class="{ bluetextclass: federal_filters.length }">{{ countFilters }} filters selected</div>
                </div>
                <div class="col-md-7 my-auto">
                    <form class="bg-body shadow rounded-2">
                        <div class="input-group input-group-sm">
                            <vue3-tags-input class="form-control form-control-sm p-0 tag-center scrollinput" @on-tags-changed="handleChangeTag" placeholder="Input keywords separated by comma" :add-tag-on-keys="[13,188]" v-model:tags="tags" v-model="tag" @allow-duplicates="false" style="text-wrap: nowrap;" />

                            <span class="input-group-text p-0 bg-transparent"> <button class="btn btn-sm" @click.prevent="handleSelectedTag(tag)" type="button" id="button-addon2">Search</button> </span>
                        </div>
                    </form>
                </div>
                <div class="col-md-2 my-auto text-end text-sm-end">
                    <ul class="list-inline hstack flex-wrap gap-6 justify-content-between mb-0 s-dropdown dropdown" style="float: right;">
                        <li class="list-inline-item mb-0">
                            <a href="" @click.prevent="gridviewgrid()"> <i :class="{ gridblockcolor: gridview }" class="fa fa-th-large me-3"></i></a>
                            <a href="" @click.prevent="listviewgrid()"><i :class="{ gridblockcolor: listview }" class="fa fa-bars text-gray me-1"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="result pt-3 pb-4">
        <div class="container-fluid">
            <div class="row g-2 g-lg-4">
                <div class="col-lg-4 col-xl-3">
                    <div class="flex-column p-4 p-xl-0">
                        <form class="rounded-3 shadow">
                            <div class="card card-body rounded-0 p-2">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#Region" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2">Region</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                             
                                <div class="col-12 ml2 multi-collapse collapse show">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="region" value="State" v-model="region" />
                                            <label class="form-check-label">State & Local</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="region" value="Federal" v-model="region" />
                                            <label class="form-check-label">Federal</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="region" value="Commercial" v-model="region" />
                                            <label class="form-check-label">Private/Commercial</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="region" value="International" v-model="region" />
                                            <label class="form-check-label">International</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div v-if="region == 'State'">
                                <StateFilter :clear_state_filters="clear_state_filters"  @updateStateFilters="updateStateFilters" ref="state_filter" />
                            </div>
                            <div v-if="region == 'Federal'">
                                <FederalFilter :clear_federal_filters="clear_federal_filters" :naics_codes="naics_codes" :service_codes="service_codes" @updateFederalFilters="updateFederalFilters" ref="federal_filter" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9" v-if="region == 'State'">
                    <div class="vl-parent">
                        <Skeleton v-if="isLoading" />
                        <div class="scroll-div" ref="myscroll" v-if="!isLoading">
                            <div class="hstack flex-wrap gap-2">
                                <div class="alert border shadow fade show small px-1 py-0 mb-0 filtertagcss" v-for="(filter, index) in state_filters" :key="index">
                                    <span class="me-1" style="color: white;">{{ filter.name }}</span>
                                    <button type="button" class="btn btn-xs mb-0 text-white p-0" style="font-size: 13px !important;" @click="removeStateFilter(filter)" aria-label="Close">
                                        <i class="fa fa-light fa-xmark text-white"></i>
                                    </button>
                                </div>

                                <div v-if="state_filters?.length">
                                    <button type="button" class="btn btn-xs text-primary textclose mb-0 p-1" @click.prevent="clearAllFilters()">Clear all</button>
                                </div>
                            </div>
                        </div>
                        <section v-if="!state_tenders.length && !isLoading">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-10 text-center mx-auto">
                                        <img src="assets/images/no-search-results.svg" class="mb-4" width="230px" alt="" />

                                        <h3>No results found</h3>

                                        <p class="mb-4">Try adjusting your serarch or filter to find what you're looking for.</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="text-end" v-if="state_tenders.length">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">{{'Showing '+state_filter.from+' - '+state_filter.to+' of '+state_filter.totalRows+' bids' }}</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-2" v-for="state_tender in state_tenders" :key="state_tender.state_tender_id">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                    <a href="javascript:void(0)" @click="stateTenderDetails(state_tender)" style="text-transform: uppercase;"><div v-html="highlight(state_tender.title)"></div></a>
                                                </div>
                                                <div v-else>
                                                    <a href="javascript:void(0)" @click="showModal()"><div v-html="highlight(state_tender.title)"></div></a>
                                                </div>
                                            </strong>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ state_tender.state_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />{{ state_tender.tender_no }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ dateFormat(state_tender.posted_date) }} &nbsp;<span>{{state_tender.time_ago  }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" /> {{ dateFormat(state_tender.expiry_date) }}
                                                <span class="col-green" v-if="state_tender.days_difference">
                                                    &nbsp; {{ state_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2" v-if="state_tender.state_attachments.length">
                                            <li class="list-group-item d-flex text-success p-0" v-for="attachment, key in state_tender.state_attachments" :key="key">
                                                <p style="color: #595d6e; text-align: justify;">{{ attachment.attachment_name }}</p>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-borderless small mb-0 mt-2" v-else>
                                            <li class="list-group-item d-flex text-info p-0">
                                                No files found in the attachments
                                            </li>
                                        </ul>

                                        <div class="border-top d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                            <div class="d-flex align-items-center">
                                                <ul class="nav nav-divider small mt-3" style="color: #595d6e;">
                                                    <li class="nav-item text-primary"><i class="bi bi-patch-check-fill text-primary me-2"></i><span style="color: rgb(86, 84, 109);">{{ state_tender.state_agency?.state_agency_name}}</span></li>

                                                    <li class="nav-item" v-if="state_tender.place_of_performance!=''">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i><span>{{state_tender.place_of_performance}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card shadow" v-if="state_tenders.length !== 0">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative">
                                        <div class="table-responsive border-0">
                                            <table class="table table-sm small align-middle p-4 mb-0 table-hover table-shrink">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="5%" scope="col" class="border-0">BID NUMBER & NOTICE TYPE</th>
                                                        <th scope="col" class="border-0">TITLE</th>
                                                        <th scope="col" class="border-0">AGENCY</th>
                                                        <th scope="col" class="border-0">Place of Performance</th>
                                                        <th scope="col" class="border-0">DUE DATE</th>
                                                        <th scope="col" class="border-0"></th>
                                                    </tr>
                                                </thead>

                                                <tbody class="border-top-0" v-for="state_tender in state_tenders" :key="state_tender.state_tender_id">
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="row">
                                                                    <div class="column">
                                                                        <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                                            <a href="javascript:void(0)" @click="stateTenderDetails(state_tender)">{{ state_tender.tender_no }}</a>
                                                                        </div>
                                                                        <div v-else><a href="javascript:void(0)" @click="showModal()">{{ state_tender.tender_no }}</a></div>
                                                                    </div>

                                                                    <div class="column">
                                                                        <a :style="{color:state_tender.state_notice?.backround_color}" style="color:black" class="badge bg-success bg-opacity-10">{{ state_tender.state_notice.notice_name }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><div v-html="highlight(state_tender.title)"></div></td>
                                                        <td>{{ state_tender.state_agency?.state_agency_name }}</td>
                                                        <td>{{ state_tender.place_of_performance }}</td>
                                                        <td style="width: 110px;">{{ state_tender.expiry_date }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="state_tenders.length !== 0">
                            <div style="float: left;">
                                <input type="text" class="form-control" v-model="state_filter.page" @keypress.enter="getFederalTenders()" style="width: 60px;" />
                            </div>
                            <div style="float: right;">
                                <Pagination :maxPage="state_filter.maxPage" :totalPages="state_filter.lastPage" :currentPage="state_filter.page" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9" v-if="region == 'Federal'">
                    <div class="vl-parent">
                        <Skeleton v-if="isLoading" />
                        <div class="scroll-div" ref="myscroll" v-if="!isLoading">
                            <div class="hstack flex-wrap gap-2">
                                <div class="alert border shadow fade show small px-1 py-0 mb-0 filtertagcss" v-for="(filter, index) in federal_filters" :key="index">
                                    <span class="me-1" style="color: white;">{{ filter.name }}</span>
                                    <button type="button" class="btn btn-xs mb-0 text-white p-0" style="font-size: 13px !important;" @click="removeFederalFilter(filter)" aria-label="Close">
                                        <i class="fa fa-light fa-xmark text-white"></i>
                                    </button>
                                </div>

                                <div v-if="federal_filters?.length">
                                    <button type="button" class="btn btn-xs text-primary textclose mb-0 p-1" @click.prevent="clearAllFilters()">Clear all</button>
                                </div>
                            </div>
                        </div>
                        <section v-if="!federal_tenders.length && !isLoading">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-10 text-center mx-auto">
                                        <img src="assets/images/no-search-results.svg" class="mb-4" width="230px" alt="" />

                                        <h3>No results found</h3>

                                        <p class="mb-4">Try adjusting your serarch or filter to find what you're looking for.</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="text-end" v-if="federal_tenders.length">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">{{'Showing '+federal_filter.from+' - '+federal_filter.to+' of '+federal_filter.totalRows+' bids' }}</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-2" v-for="federal_tender in federal_tenders" :key="federal_tender.federal_tender_id">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                    <a href="javascript:void(0)" @click="federalTenderDetails(federal_tender)" style="text-transform: uppercase;"><div v-html="highlight(federal_tender.title)"></div></a>
                                                </div>
                                                <div v-else>
                                                    <a href="javascript:void(0)" @click="showModal()"><div v-html="highlight(federal_tender.title)"></div></a>
                                                </div>
                                            </strong>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ federal_tender.federal_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />{{ federal_tender.tender_no }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ dateFormat(federal_tender.posted_date) }} &nbsp;<span>{{federal_tender.time_ago  }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" /> {{ dateFormat(federal_tender.expiry_date) }}
                                                <span class="col-green" v-if="federal_tender.days_difference">
                                                    &nbsp; {{ federal_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2" v-if="federal_tender.federal_attachments.length">
                                            <li class="list-group-item d-flex text-success p-0" v-for="attachment, key in federal_tender.federal_attachments" :key="key">
                                                <p style="color: #595d6e; text-align: justify;">{{ attachment.attachment_name }}</p>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-borderless small mb-0 mt-2" v-else>
                                            <li class="list-group-item d-flex text-info p-0">
                                                No files found in the attachments
                                            </li>
                                        </ul>

                                        <div class="border-top d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                            <div class="d-flex align-items-center">
                                                <ul class="nav nav-divider small mt-3" style="color: #595d6e;">
                                                    <li class="nav-item text-primary"><i class="bi bi-patch-check-fill text-primary me-2"></i><span style="color: rgb(86, 84, 109);">{{ federal_tender.federal_agency?.agency_name}}</span></li>

                                                    <li class="nav-item" v-if="federal_tender.place_of_performance!=''">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i><span>{{federal_tender.place_of_performance}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card shadow" v-if="federal_tenders.length !== 0">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative">
                                        <div class="table-responsive border-0">
                                            <table class="table table-sm small align-middle p-4 mb-0 table-hover table-shrink">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="5%" scope="col" class="border-0">BID NUMBER & NOTICE TYPE</th>
                                                        <th scope="col" class="border-0">TITLE</th>
                                                        <th scope="col" class="border-0">AGENCY</th>
                                                        <th scope="col" class="border-0">Place of Performance</th>
                                                        <th scope="col" class="border-0">DUE DATE</th>
                                                        <th scope="col" class="border-0"></th>
                                                    </tr>
                                                </thead>

                                                <tbody class="border-top-0" v-for="federal_tender in federal_tenders" :key="federal_tender.federal_tender_id">
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="row">
                                                                    <div class="column">
                                                                        <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                                            <a href="javascript:void(0)" @click="federalTenderDetails(federal_tender)">{{ federal_tender.tender_no }}</a>
                                                                        </div>
                                                                        <div v-else><a href="javascript:void(0)" @click="showModal()">{{ federal_tender.tender_no }}</a></div>
                                                                    </div>

                                                                    <div class="column">
                                                                        <a :style="{color:federal_tender.federal_notice?.backround_color}" style="color:black" class="badge bg-success bg-opacity-10">{{ federal_tender.federal_notice?.notice_name }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><div v-html="highlight(federal_tender.title)"></div></td>
                                                        <td>{{ federal_tender.federal_agency?.agency_name }}</td>
                                                        <td>{{ federal_tender.place_of_performance }}</td>
                                                        <td style="width: 110px;">{{ federal_tender.expiry_date }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="federal_tenders.length !== 0">
                            <div style="float: left;">
                                <input type="text" class="form-control" v-model="federal_filter.page" @keypress.enter="getFederalTenders()" style="width: 60px;" />
                            </div>
                            <div style="float: right;">
                                <Pagination :maxPage="federal_filter.maxPage" :totalPages="federal_filter.lastPage" :currentPage="federal_filter.page" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <teleport to="#modals"  v-if="userModal">
        <div class="modal-overlay">
            <div class="">
                <div class="">
                    <div class=""></div>
                    <div class="">
                        <LoginModal @closeModal="closeModal" ref="login_modal" v-if="login_modal" />
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
            </div>
        </div>
    </teleport>
</template>

<script>
    import axios from 'axios';
    import Pagination from "@/components/Pagination.vue";
    import Region from "@/components/Region";
    import moment from 'moment-timezone';
    import Vue3TagsInput from "vue3-tags-input";
    import Skeleton from "@/components/Skeleton.vue";
    import TreeItem from "@/components/TreeItem.vue";
    import PscTree from "@/components/PscTree.vue";
    import LoginModal from "@/components/LoginModal";
    import SaveModal from "@/components/SaveSearchModal";
    import SaveSearch from "@/components/SaveSearch";
    import SetAlertModal from "@/components/SetAlert";
    import DatePicker from "@jobinsjp/vue3-datepicker";
    import "@jobinsjp/vue3-datepicker/index.css";
    import { ref } from "vue";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    import StateFilter from "@/components/documents/State";
    import FederalFilter from "@/components/documents/Federal";
    export default {
        setup() {
            const isOpen = ref(false);
            const savebidopen = ref(false);
            return { isOpen, savebidopen };
        },
        components: { Loading, DatePicker, Pagination, Vue3TagsInput, TreeItem, PscTree, LoginModal, SaveModal, SaveSearch, SetAlertModal, Skeleton, Region, StateFilter, FederalFilter },

        data() {
            return {
                is_updating_meta : true,
                pageChangeInProgress : true,
                isLoading:false,
                state_notices : [],
                categories:[],
                sorted_categories:[],
                states:[],
                sorted_states:[],
                state_agencies:[],
                sorted_state_agencies:[],
                federal_notices:[],
                federal_agencies:[],
                sorted_federal_agencies:[],
                naics:[],
                pscs:[],
                listview: true,
                gridview: false,
                region:'State',
                naics_codes: {
                    name: "",
                    naics_code: "Select All",
                    children: [],
                },
                service_codes: {
                    name: "",
                    psc_code: "Select All",
                    children: [],
                },
                federal_filter:{
                    keywords:[],
                    federal_notices : [],
                    response_date:false,
                    response_from_date:false,
                    response_to_date:false,
                    posted_date:false,
                    posted_from_date:false,
                    posted_to_date:false,
                    states:[],
                    federal_agencies:[],
                    naics:[],
                    pscs:[],
                    search: "",
                    order_by: "asc",
                    field: "",
                    per_page: 15,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    maxPage: 1,
                    to: "",
                },
                state_filter:{
                    keywords:[],
                    state_notices : [],
                    response_date:false,
                    response_from_date:false,
                    response_to_date:false,
                    posted_date:false,
                    posted_from_date:false,
                    posted_to_date:false,
                    states:[],
                    categories:[],
                    state_agencies:[],
                    search: "",
                    order_by: "asc",
                    field: "",
                    per_page: 15,
                    totalRows: 0,
                    page: 1,
                    lastPage: 1,
                    from: 1,
                    maxPage: 1,
                    to: "",
                },
                federal_tenders:[],
                federal_filters:[],
                clear_federal_filters:false,

                state_tenders:[],
                state_filters:[],
                clear_state_filters:false,
                login_modal:false,
                userModal : false,
                tag:null,
                tags: [],
                errors:null
            };
        },

        watch: {
            'region': function(){
                this.state_filter.keywords = [] 
                this.state_filter.state_notices  =  [] 
                this.state_filter.response_date = false 
                this.state_filter.response_from_date = false 
                this.state_filter.response_to_date = false 
                this.state_filter.posted_date = false 
                this.state_filter.posted_from_date = false 
                this.state_filter.posted_to_date = false 
                this.state_filter.categories = [] 
                this.state_filter.states = [] 
                this.state_filter.state_agencies = [] 
                this.state_filter.search =  null 
                this.state_filter.order_by =  "asc" 
                this.state_filter.field = null
                this.state_filter.per_page =  15 
                this.state_filter.totalRows =  0 
                this.state_filter.page =  1 
                this.state_filter.lastPage =  1 
                this.state_filter.from =  1 
                this.state_filter.maxPage =  1 
                this.state_filter.to = null 

                this.federal_filter.keywords = [],
                this.federal_filter.federal_notices  =  [],
                this.federal_filter.response_date = false,
                this.federal_filter.response_from_date = false,
                this.federal_filter.response_to_date = false,
                this.federal_filter.posted_date = false,
                this.federal_filter.posted_from_date = false,
                this.federal_filter.posted_to_date = false,
                this.federal_filter.states = []
                this.federal_filter.federal_agencies = []
                this.federal_filter.naics = []
                this.federal_filter.pscs = []
                this.federal_filter.search = null
                this.federal_filter.order_by =  "asc"
                this.federal_filter.field = null
                this.federal_filter.per_page =  15
                this.federal_filter.totalRows =  0
                this.federal_filter.page =  1
                this.federal_filter.lastPage =  1
                this.federal_filter.from =  1
                this.federal_filter.maxPage =  1
                this.federal_filter.to =  null

                this.tags = []

                if(this.region == 'State'){
                    this.paginateStateTenders()
                }else if(this.region == 'Federal'){
                    this.getNaics()
                    this.getPscs()
                    this.paginateFederalTenders()
                }

            }
        },

        beforeRouteEnter(to, from, next) {
            next((vm) => {
                
            })
        },

        mounted() {
            this.$store.commit("setFederalTender", null)
            this.$store.commit("setStateTender", null)
            if(this.region == 'Federal'){
                this.getNaics()
                this.getPscs()
                this.paginateFederalTenders()
            }
            if(this.region == 'State'){
                this.paginateStateTenders()
            }
            let header_menu = this.$store.getters.header_menu
            header_menu.show_bidsearch = false
            this.$store.dispatch('setHeaderMenu', header_menu)
        },

        computed: {
            countFilters(){
                let modules = []
                this.federal_filters.map(function(element){
                    if(!modules.includes(element.module)){
                        modules.push(element.module)
                    }
                })
                return modules.length
            }
        },

        methods: {

            showModal() {
                this.userModal = true;
                if (this.$store.getters.user == null) {
                    this.login_modal = true;
                }
            },

            closeModal() {
                this.userModal = false
            },

            federalTenderDetails(federal_tender){
                localStorage.setItem("federal_tender", JSON.stringify(federal_tender));
                this.$store.commit("setCurrentPage", this.federal_filter.page)
                window.open(this.$store.getters.appUrl+"bids/federal-opportunities/" + federal_tender.title.replace(/\//g, "") + "-" + federal_tender.tender_no, '_blank');
            },

            stateTenderDetails(state_tender){
                localStorage.setItem("state_tender", JSON.stringify(state_tender));
                this.$store.commit("setCurrentPage", this.state_filter.page)
                window.open(this.$store.getters.appUrl+"bids/state-opportunities/" + state_tender.title.replace(/\//g, "") + "-" + state_tender.tender_no, '_blank');
            },

            listviewgrid() {
                this.listview = false;
                this.gridview = true;
                if(this.region == 'State'){
                    this.state_filter.per_page=28;
                    this.getStateTenders()
                }else if (this.region == 'Federal'){
                    this.federal_filter.per_page=28;
                    this.getFederalTenders()
                }
            },
            gridviewgrid() {
                this.listview = true
                this.gridview = false
                if(this.region == 'State'){    
                    this.state_filter.per_page=10
                    this.getStateTenders()
                }else if (this.region == 'Federal'){
                    this.federal_filter.per_page=10
                    this.getFederalTenders()
                }
            },

            removeStateFilter(filter){
                this.$refs.state_filter.removeFilter(filter)
            },

            removeFederalFilter(filter){
                this.$refs.federal_filter.removeFilter(filter)
            },

            handleChangeTag(tags) {
                let vm = this
                vm.tags = tags
                if(this.region == 'State'){
                    vm.state_filter.keywords = vm.tags
                    this.getStateTenders()
                }else if(this.region == 'Federal'){
                    vm.federal_filter.keywords = vm.tags
                    this.getFederalTenders()
                }
            }, 

            dateFormat(value) {
                return moment(value).format("ll");
            },

            paginateFederalTenders(cancel_token) {
                if(this.region == 'Federal'){
                    let vm = this
                    this.isLoading = true
                    vm.federal_tenders = []
                    window.scrollTo({ top: 0, behavior: "smooth" })
                    vm.$store
                        .dispatch("post", { uri: "paginateFederalTenders", data:vm.federal_filter, cancel_token })
                        .then(function (response) {
                            vm.isLoading = false
                            vm. auto_call = true
                            vm.federal_tenders = response.data.data
                            vm.federal_filter.totalRows = response.data.meta.total
                            vm.federal_filter.lastPage = response.data.meta.last_page
                            vm.federal_filter.from = response.data.meta.from
                            vm.federal_filter.maxPage = vm.federal_filter.lastPage >= 3 ? 3 : vm.federal_filter.lastPage
                            vm.federal_filter.to = response.data.meta.to
                            vm.federal_filter.page = response.data.meta.current_page
                        })
                        .catch(function (error) {
                            if (axios.isCancel(error)) {
                                console.log('Previous request was canceled:', error.message);
                            } else {
                                vm.errors = error.response.data.errors;
                                vm.$store.dispatch("error", error.response.data.message);
                            }
                        });
                }
            },

            paginateStateTenders(cancel_token) {
                if(this.region == 'State'){
                    let vm = this
                    this.isLoading = true
                    vm.state_tenders = []
                    window.scrollTo({ top: 0, behavior: "smooth" })
                    vm.$store
                        .dispatch("post", { uri: "paginateStateTenders", data:vm.state_filter, cancel_token })
                        .then(function (response) {
                            vm.isLoading = false
                            vm. auto_call = true
                            vm.state_tenders = response.data.data
                            vm.state_filter.totalRows = response.data.meta.total
                            vm.state_filter.lastPage = response.data.meta.last_page
                            vm.state_filter.from = response.data.meta.from
                            vm.state_filter.maxPage = vm.state_filter.lastPage >= 3 ? 3 : vm.state_filter.lastPage
                            vm.state_filter.to = response.data.meta.to
                            vm.state_filter.page = response.data.meta.current_page
                        })
                        .catch(function (error) {
                            if (axios.isCancel(error)) {
                                console.log('Previous request was canceled:', error.message);
                            } else {
                                vm.errors = error.response.data.errors;
                                vm.$store.dispatch("error", error.response.data.message);
                            }
                        });
                }
            },

            onPageChange(page) {
                if(this.region == 'State'){
                    this.is_updating_meta = true
                    this.pageChangeInProgress = true;
                    this.state_filter.page = page;
                    this.getStateTenders()
                }else if(this.region == 'Federal'){
                    this.is_updating_meta = true
                    this.pageChangeInProgress = true;
                    this.federal_filter.page = page;
                    this.getFederalTenders()
                }
            },

            getFederalTenders(){
                if (this.cancel_token_source) {
                    this.cancel_token_source.cancel('Operation canceled due to new request.');
                }
                this.cancel_token_source = axios.CancelToken.source();
                console.log('cancel token source:', this.cancel_token_source)
                this.paginateFederalTenders(this.cancel_token_source.token)
            },

            getStateTenders(){
                if (this.cancel_token_source) {
                    this.cancel_token_source.cancel('Operation canceled due to new request.');
                }
                this.cancel_token_source = axios.CancelToken.source();
                console.log('cancel token source:', this.cancel_token_source)
                this.paginateStateTenders(this.cancel_token_source.token)
            },

            onPerPageChange() {
                if(this.region == 'State'){
                    this.state_filter.page = 1;
                    this.paginateStateTenders();
                }else if(this.region == 'Federal'){
                    this.federal_filter.page = 1;
                    this.paginateFederalTenders();
                }
            },

            highlight(title) {
                let keywords_arr = [];
                if (typeof this.federal_filter.keywords === 'string' && this.federal_filter.keywords.length) {
                    keywords_arr = this.federal_filter.keywords.split(",");
                } else if (Array.isArray(this.federal_filter.keywords)) {
                    keywords_arr = this.federal_filter.keywords;
                }
                keywords_arr.map(function (element) {
                    title = title.replace(new RegExp(element.trim(), "gi"), (match) => {
                        return '<span style="background:yellow">' + match + "</span>";
                    });
                });
                return title;
            },

            clearAllFilters(){
                this.clear_federal_filters = true
                this.clear_state_filters = true
                this.$store.dispatch("setSelectedNaics", [])
                this.$store.dispatch("setSelectedPscs", [])
            },

            updateFederalFilters(meta){
                this.clear_federal_filters = false
                this.federal_filters = meta.filters
                this.federal_filter.federal_notices = meta.federal_notices
                this.federal_filter.response_date = meta.response_date
                this.federal_filter.response_from_date = meta.response_from_date
                this.federal_filter.response_to_date = meta.response_to_date
                this.federal_filter.posted_date = meta.posted_date
                this.federal_filter.posted_from_date = meta.posted_from_date
                this.federal_filter.posted_to_date = meta.posted_to_date
                this.federal_filter.states = meta.states
                this.federal_filter.federal_agencies = meta.federal_agencies
                this.federal_filter.naics = meta.naics
                this.federal_filter.pscs = meta.pscs
                this.getFederalTenders()
            },

            updateStateFilters(meta){
                console.log('meta', meta)
                this.clear_state_filters = false
                this.state_filters = meta.filters
                this.state_filter.state_notices = meta.state_notices
                this.state_filter.response_date = meta.response_date
                this.state_filter.response_from_date = meta.response_from_date
                this.state_filter.response_to_date = meta.response_to_date
                this.state_filter.posted_date = meta.posted_date
                this.state_filter.posted_from_date = meta.posted_from_date
                this.state_filter.posted_to_date = meta.posted_to_date
                this.state_filter.states = meta.states
                this.state_filter.state_agencies = meta.state_agencies
                this.state_filter.categories = meta.categories
                this.getStateTenders()
            },

            getNaics() {
                let vm = this
                let naics = vm.$store.getters.naics
                if(naics){
                    vm.naics_codes = naics
                }else{
                    vm.$store
                        .dispatch("post", { uri: "getNaics" })
                        .then(function (response) {
                            vm.naics_codes.children = response.data.data
                            vm.$store.dispatch('setNaics', vm.naics_codes)
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },

            getPscs() {
                let vm = this
                let pscs = vm.$store.getters.pscs
                console.log('pscs', pscs)
                if(pscs){
                    vm.service_codes = pscs
                }else{
                    vm.$store
                        .dispatch("post", { uri: "getPscs" })
                        .then(function (response) {
                            vm.service_codes.children = response.data.data
                            vm.$store.dispatch('setPscs', vm.service_codes)
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            }
            
        }
    };
</script>
<style scoped>
    .mx-datepicker {
        position: relative;
        display: inline-block;
        width: auto;
    }
    .mx-calendar {
        box-sizing: border-box;
        width: 210px !important;
        padding: 6px 12px;
    }
    .mx-calendar-content {
        position: relative;
        height: 210px !important;
        box-sizing: border-box;
    }
    .modal-overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        z-index: 9999;
        left: 0;
        right: 0;
        display: grid;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.3);
    }
    .w-15px {
        width: 15px;
    }
    .scroll1 ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }
    .scroll1 ::-webkit-scrollbar-track {
        border-radius: 10px;
    }
    .scroll1 ::-webkit-scrollbar-thumb {
        background-color: #5143d9;
        border-radius: 10px;
    }
    .bluetextclass {
        color: #47b1ee;
    }

    .scroll-sidebar {
        height: 550px;
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: scroll;
    }

    .nav.nav-divider .nav-item + .nav-item:before {
        content: "";
        color: inherit;
        padding-left: 0.65rem;
        padding-right: 0.75rem;
        opacity: 0.8;
    }
    .w-15px {
        width: 15px;
    }

    .scroll1 ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    .scroll1 ::-webkit-scrollbar-track {
        border-radius: 10px;
    }
    .scroll1 ::-webkit-scrollbar-thumb {
        background-color: #5143d9;
        border-radius: 10px;
    }

    .bluetextclass {
        color: #47b1ee;
    }

    .scroll-sidebar {
        height: 550px;
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: scroll;
    }

    .nav.nav-divider .nav-item + .nav-item:before {
        content: "";
        color: inherit;
        padding-left: 0.65rem;
        padding-right: 0.75rem;
        opacity: 0.8;
    }

    .scroll1 {
        position: relative;
        height: 150px;
        overflow: hidden;
        overflow-y: scroll;
    }
    .scroll2 {
        position: relative;
        height: 80px;
        overflow: hidden;
        overflow-y: scroll;
    }
    .scroll3 {
        position: relative;
        height: 350px;
        overflow: hidden;
        overflow-y: scroll;
    }

    ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    ::-webkit-scrollbar-track {
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #5143d9;
        border-radius: 10px;
    }

    .bluetextclass {
        color: #47b1ee;
    }

    .scroll-sidebar {
        height: 550px;
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-y: scroll;
    }
    .limited-text {
        display: -webkit-box;
        overflow: hidden;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .popup {
        position: fixed;
        padding: 10px;
        width: 350px;
        max-width: 500px;
        border-radius: 10px;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgb(255, 255, 255);
        z-index: 9999;
    }
    .popup .close {
        position: absolute;
        right: 5px;
        top: 5px;
        padding: 5px;
        color: #000;
        transition: color 0.3s;
        font-size: 2em;
        line-height: 0.6em;
        font-weight: bold;
    }

    .col-red {
        color: red;
    }

    .dotted {
        border-bottom: 1px dotted;
    }
    .dotted:hover {
        border-bottom: 0px;
    }
    .search-left1 {
        box-shadow: 5px 2px 4px -5px rgb(0 0 0 / 20%);
        border-right: 1px solid lightgray;
    }

    .tree .nav-item1:before {
        content: "+";
        color: inherit;
        padding-left: 0rem;
        padding-right: 0.5rem;
        opacity: 0.8;
    }

    .tree:hover .item3 {
        opacity: 1;
    }
    .item3 {
        opacity: 0;
        transition-property: opacity;
        transition-duration: 0.3s;
        flex-shrink: 0;
    }
    .list-style-none {
        list-style: none;
    }

    .dropitem1 {
        display: flex !important;
        cursor: pointer;
    }
    .dropitem1:hover {
        background-color: white;
    }
    .dropitem2:hover {
        background-color: white;
    }
    .cursor {
        cursor: pointer;
    }
    .v3ti--focus {
        box-shadow: 0 0 0 0px #000000;
        border-color: #9ca3af;
    }
    .highlight {
        color: yellow;
    }

    .v3ti .v3ti-tag {
        background: #f56c6c;
    }

    .v3ti .v3ti-tag .v3ti-remove-tag {
        color: #000000;
        transition: color 0.3s;
    }

    .v3ti .v3ti-tag .v3ti-remove-tag:hover {
        color: #ffffff;
    }
    .gaplist {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .btn-close {
        color: white;
    }
    .v3ti .v3ti-tag {
        background: #f56c6c !important;
    }

    .mybutton-success {
        background: rgb(28, 184, 65);
    }
    .mybutton-secondary {
        background: #40a4f1;
        border-color: transparent;
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
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
    .table-responsive {
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch;
    }

    .mybutton-secondary2 {
        background: #5143d9;
        border-color: transparent;
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        padding: 10px;
    }

    @keyframes fade {
        from {
            opacity: 1;
            transform: translate(-50%, -50%) scale(0.8);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
    }
    .confirm {
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        min-width: 280px;
        max-width: 500px;
        height: auto;
        background: #e2e2e2;
        border-radius: 10px;
        padding: 0;
        margin: 0;
        border-top: 1px solid white;
        animation: fade 0.3s ease 1 forwards;
    }
    .confirm h1 {
        text-align: center;
        font-size: 1.2rem;
        margin: 1.5rem 1rem 0.5rem;
    }
    .confirm p {
        text-align: center;
        font-size: 1rem;
        margin: 0 2rem 4.5rem;
        color: black;
    }
    .confirm button {
        border: none;
        color: #2a85ec;
        height: 3rem;
        font-size: 1rem;
        width: 50%;
        position: absolute;
        bottom: 0;
        cursor: pointer;
    }
    .confirm button:nth-of-type(1) {
        border-top: 1px solid #b4b4b4;
        border-right: 1px solid #b4b4b4;
        left: 0;
        border-radius: 0 0 0 10px;
    }
    .confirm button:nth-of-type(2) {
        border-top: 1px solid #b4b4b4;
        right: 0;
        border-radius: 0 0 10px 0;
    }
    .confirm button:focus,
    .confirm button:hover {
        font-weight: bold;
        background: #efefef;
    }
    .confirm button:active {
        background: #d6d6d6;
    }
    .highlightText {
        background: yellow;
    }
    .v3ti .v3ti-content .fscroll {
        width: 100%;
        display: flex;
        flex-wrap: nowrap !important;
    }

    .tag-center {
        align-items: center !important;
    }

    .scrollinput ::-webkit-scrollbar {
        width: 3px !important;
        height: 5px !important;

        cursor: pointer !important;
    }

    .scrollinput::-webkit-scrollbar-track {
        border-radius: 10px !important;
    }

    .scrollinput ::-webkit-scrollbar-thumb {
        background-color: rgb(244, 238, 238) !important;
        border-radius: 10px !important;
    }
    .hgt-250 {
        height: 250px;
    }
    .close-white {
        color: white !important;
    }
    .catalog-code__number {
        margin-left: 5px;
    }
    .pl-8 {
        padding-left: 8px;
    }

    .confirm1 {
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        min-width: 280px;
        max-width: 500px;
        height: auto;
        background: #f5f2f2;
        border-radius: 10px;
        padding: 0;
        margin: 0;
        border-top: 1px solid white;
        animation: fade 0.3s ease 1 forwards;
        z-index: 99999;
    }
    .confirm1 h1 {
        text-align: left;
        font-size: 1.2rem;
        margin: 1.5rem 1rem 0.5rem;
    }
    .confirm1 p {
        text-align: center;
        font-size: 1rem;
        margin: 0 2rem 4.5rem;
        color: red;
    }
    .confirm1 button {
        border: none;
        color: #1678e5;
        height: 3rem;
        font-size: 1rem;
        width: 100%;
        position: absolute;
        bottom: 0;
        cursor: pointer;
    }
    .confirm1 button:nth-of-type(1) {
        border-top: 1px solid #b4b4b4;
        border-right: 1px solid #b4b4b4;
        left: 0;
        border-radius: 0 0 0 10px;
    }
    .confirm1 button:nth-of-type(2) {
        border-top: 1px solid #b4b4b4;
        right: 0;
        border-radius: 0 0 10px 0;
    }
    .confirm1 button:focus,
    .confirm1 button:hover {
        font-weight: bold;
        background: #efefef;
    }
    .confirm1 button:active {
        background: #d6d6d6;
    }
</style>
