<template>
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage" />
    <section class="pt-5">
        <div class="container">
            <div class="row">
                <!-- Main content START -->
                <div class="col-lg-12 col-xl-12">
                    <!-- Offcanvas menu button -->
                    <div class="d-grid mb-0 d-lg-none w-100">
                        <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"><i class="fas fa-sliders-h"></i> Menu</button>
                    </div>

                    <div class="vstack gap-4">
                        <div class="card border">
                            <!-- Card header -->
                            <div class="card-header border-bottom d-sm-flex justify-content-between align-items-center p-3">
                                <h5 class="mb-2 mb-sm-0" v-if="status">
                                    Create
                                    <label v-if="$route.params.region_id==2">Federal</label>
                                    <label v-if="$route.params.region_id==4">International</label>
                                    <label v-if="$route.params.region_id==3">Private</label>
                                    <label v-if="$route.params.region_id==1">State</label>
                                    <!-- Form START -->
                                    Alert
                                </h5>
                                <h5 class="mb-2 mb-sm-0" v-else>Update Alert</h5>

                                <div class="">
                                    <router-link to="/bids/state-opportunities" class="btn btn-primary me-2">Back To Bids</router-link>
                                    <router-link :to="{ path: '/bids/save-alert' }" class="btn btn-primary">Back</router-link>
                                </div>
                            </div>

                            <!-- Card body START -->
                            <div class="card-body">
                                <form class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Alert Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" :class="{'is-invalid': errors.alert_label}" v-model="savealert.alert_label" placeholder="Enter your Alert" />
                                        <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Frequency<span class="text-danger">*</span></label>
                                        <select class="form-select" style="color: var(--bs-gray-500);" :class="{'is-invalid': errors.frequency}" v-model="frequency">
                                            <option selected="" value="">Select your Frequency</option>
                                            <option value:daily>Daily</option>
                                            <option value:weekly>Weekly</option>
                                        </select>
                                        <span v-if="errors.frequency" class="invalid-feedback">{{ errors.frequency[0] }}</span>
                                    </div>
                                    <!-- position -->

                                    <div class="col-md-3" v-if="$route.params.region_id==4 || savealert.region_id==4">
                                        <label for="inputfrequen1" class="form-label head1">Country<span class="text-danger">*</span></label>
                                        <select id="inputfrequency1" class="form-select" @change="getSate()" v-model="liststate.country_id">
                                            <option vlaue="">Select Country</option>
                                            <option v-for="country,key in countrys" :key="key" :value="country.country_id">{{country.country_name}}</option>
                                        </select>
                                    </div>

                                    <!-- test stat -->
                                    <div class="col-md-3">
                                        <label for="inputfrequen1" class="form-label head1">State <span class="text-danger">*</span> </label> <label class="form-label">{{ selected.length }} of {{ state_country.length }} Selected</label>

                                        <div class="">
                                            <button type="button" class="btn btnwht10 form-select" data-bs-toggle="dropdown">
                                                <span class="text-center" style="float: left;color: var(--bs-gray-500); font-weight: 400;">Select State</span>
                                            </button>
                                            <label for="inputfrequen1" class="form-label"> </label>
                                            <ul class="dropdown-menu" :class="{'is-invalid': errors.state_id}">
                                                <li class="dropdown-item" >
                                                    <div class="">
                                                        {{ selected.length }} of {{ state_country.length }}
                                                        <!-- <input type="checkbox" v-model="this.selectAll" @click="select" class="hidden"/> Select all -->
                                                       <span v-if="selected.length !==state_country.length"> <router-link to="" v-model="selectAll" @click="select()" class="" ref="selectState">
                                                            Select All /
                                                        </router-link></span>
                                                      <span>  <router-link to="" v-model="selectAll" @click="Deselect()" class="" ref="selectState">
                                                            Reset all
                                                        </router-link> </span>
                                                        <div class="ss-filter-search">
                                                            <input autocomplete="off" class="form-control" type="text" v-model="searchstate" placeholder="Search organizations" />
                                                            <div class="liststate" id="style-3">
                                                                <ul class="checkbox" style="padding-left: 10px;" v-for="state in filterState" :key="state.state_id">
                                                                    <li class="list-group-item">
                                                                        <input class="form-check-input me-1" id="federalcheck" type="checkbox" :value="state.state_id" v-model="selected" @change="updateCheckall" aria-label="..." />

                                                                        {{ state.state_name }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <!-- <span v-if="errors.state_id" class="invalid-feedback">{{ errors.state_id[0] }}</span> -->
                                                            <!-- list end -->
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <span v-if="errors.state_id" style="color: #dc3545;">{{ errors.state_id[0] }}</span>
                                    </div>

                                    <hr />
                                    <!-- Email -->

                                    <!-- list notice type -->
                                    <label class="form-label" style="font-size: 20px; font-weight: 600;">Notice type<span class="text-danger">*</span></label>
                                    <span v-if="errors.notice_type" style="color: #dc3545;">{{ errors.notice_type[0] }}</span>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-4 col-xl-4" v-for="notice in notices" :key="notice.notice_id">
                                            <ul class="list-group list-group-borderless mb-0">
                                                <li class="list-group-item">
                                                    <input type="checkbox" class="form-check-input me-2" id="rememberCheck" :value="notice.notice_id" v-model="notice_type" />
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        {{notice.notice_type}}
                                                    </label>

                                                    <!-- <a href="#" class="h6 fw-normal mb-0"> <i class="bi fa-fw bi-arrow-right me-1"></i>Foot Treatments </a> -->
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr />
                                    <div v-if="$route.params.region_id==2">
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">Set-Aside Code</label>
                                        <br />
                                        <a class="inf" href="javascript:void(0)">More Information about Set-Aside Codes</a>
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-4 col-xl-4" v-for="set_side in sideStatus" :key="set_side.status_id">
                                                <ul class="list-group list-group-borderless mb-0">
                                                    <li class="list-group-item">
                                                        <input type="checkbox" class="form-check-input me-2" id="rememberCheck" :value="set_side.status_id" v-model="set_aside_status" />
                                                        <label class="form-check-label truncate" for="flexRadioDefault1">
                                                            {{set_side.status_name}}
                                                        </label>
                                                        <!-- <a href="#" class="h6 fw-normal mb-0"> <i class="bi fa-fw bi-arrow-right me-1"></i>Foot Treatments </a> -->
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                    <!-- end -->

                                    <!-- Mobile -->
                                    <div class="col-md-12" v-if="$route.params.region_id ==1 || $route.params.region_id ==3 || $route.params.region_id ==4 ">
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">Category</label><br />
                                        <br />

                                        <div class="collapse show" id="collapseExample7">
                                            <div class="">
                                                {{ selectedcategory.length }} of {{ categorycount }}

                                                <router-link to="" v-model="selectAllcategory" @click="selectCategory()" class="" ref="selectState">
                                                    Select All/
                                                </router-link>
                                                <router-link to="" v-model="selectAllcategory" @click="DeselectCategory()" class="" ref="selectState">
                                                    Reset all
                                                </router-link>
                                                <div class="col-md-6">
                                                    <div class="ss-filter-search">
                                                        <!-- <input autocomplete="off" class="ss-filter-search__input" type="text" v-model="searchagencyState" @keyup="filter1Agency()" placeholder="Search organizations" /> -->
                                                        <input class="form-control pe-5" type="search" placeholder="Search" aria-label="Search" @keyup="filterCategory()" v-model="searchagencycategory" />

                                                        <!-- list state -->

                                                        <div class="liststate" id="style-3">
                                                            <ul class="list-group checkbox" v-for="category in  categorys " :key="category.category_id">
                                                                <li class="list-group-item d-flex">
                                                                    &nbsp;
                                                                    <input
                                                                        class="form-check-input me-1"
                                                                        type="checkbox"
                                                                        :value="category.category_id"
                                                                        v-model="selectedcategory"
                                                                        @change="updateCheckallCategory(category)"
                                                                        :id="category.category_id+ 'category'"
                                                                        aria-label="..."
                                                                    />
                                                                    &nbsp; {{ category.category_name }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                               
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>

                                    <div class="col-md-12">
                                        
                                            <label class="form-label b1" v-if="$route.params.region_id==2">Federal</label>
                                            <label class="form-label b1" v-if="$route.params.region_id==4">International</label>
                                            <label class="form-label b1" v-if="$route.params.region_id==3">Private</label>
                                            <label class="form-label b1" v-if="$route.params.region_id==1">State</label>
                                    
                                        &nbsp;<label class="form-label" style="font-size: 20px; font-weight: 600;">Agency</label><br />
                                       
                                        <div>
                                           
                                            <span class="greentitle"> About Scheduled Emails:</span>
                                            <span class="text-center mt-2">
                                                Type in a partial agency name below and then choose a match to add it to your selection.
                                                <br />
                                                To remove a choice from your selection press the [X] icon on the left.
                                            </span>
                                        </div>
                                    </div>
                                    <br />
                                   
                                    <!-- selected state Agency -->
                                    <div class="collapse show" id="collapseExample7" v-if="$route.params.region_id==1">
                                        <div class="collapse show" id="collapseExample7">
                                            <div class="">
                                                {{selectedState?.length}} of {{agencyState?.length}}

                                              <span v-if="selectedState?.length!==agencyState?.length">  <router-link to="" v-model="selectAllState" @click="selectState()" class="" ref="selectState">
                                                    Select All /
                                                </router-link></span>
                                                <router-link to="" @click="DeselectState()" class="" ref="selectState">
                                                    Reset all
                                                </router-link>
                                                <div class="col-md-6">
                                                    <div class="ss-filter-search">
                                                        <input class="form-control form-control-sm pe-5" type="search" placeholder="Search" aria-label="Search" v-model="searchagencyState" @keyup="filter1Agency()" />
                                                        <div class="liststate scroll1 hgt" id="style-3">
                                                            <ul class="list-group checkbox" v-for="state_agency in agencyState" :key="state_agency.agency_id">
                                                                <li class="list-group-item d-flex border-0 border-bottom">
                                                                    &nbsp; <input class="form-check-input me-1" type="checkbox" :value="state_agency.agency_name" checked v-model="selectedState" @change="updateCheckallState" aria-label="..." />
                                                                    &nbsp; {{state_agency.agency_name}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- selected federal Agency -->
                                    <div class="collapse show" id="collapseExample7" v-if="$route.params.region_id==2">
                                        <div class="collapse show" id="collapseExample7">
                                            <div class="">
                                                {{selectedState.length}} of {{agencycount}}

                                              <span v-if="selectedState.length!==agencycount">  <router-link to="" v-model="selectAllState" @click="selectState()" class="" ref="selectState">
                                                    Select All /
                                                </router-link></span>
                                                <router-link to="" v-model="selectAllState" @click="DeselectState()" class="" ref="selectState">
                                                    Reset all
                                                </router-link>
                                                <div class="col-md-6">
                                                    <div class="ss-filter-search" v-if="$route.params.region_id==2">
                                                        <input class="form-control form-control-sm pe-5" type="search" placeholder="Search" aria-label="Search" v-model="searchagencyState" @keyup="filterFederal()" />
                                                        <div class="liststate scroll1 hgt" id="style-3">
                                                            <ul class="list-group checkbox" v-for="statefederal in filterAgency" :key="statefederal.agency_id">
                                                                <li class="list-group-item d-flex border-0 border-bottom">
                                                                    &nbsp; <input class="form-check-input me-1" type="checkbox" :value="statefederal.agency_name" v-model="selectedFederal" @change="updateCheckallFederal" aria-label="..." />
                                                                    &nbsp; {{statefederal.agency_name}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- nics code -->
                                    <div v-if="$route.params.region_id ==2">
                                        <div class="col-md-8">
                                            <label class="form-label" style="font-size: 20px; font-weight: 600;">NAICS Code:<span class="text-danger">*</span></label><br />
                                            <div class="d-flex gap-2 gap-sm-4 flex-wrap">
                                                <span class="mt-2">
                                                    Use the search box to find NAICS Codes and mark one or more checkboxes to add to your selection. Note:Changing your search criteria does not remove items from your selection.
                                                </span>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="col-md-8">
                                            <div class="tab-content mb-0" id="flight-pills-tabContent">
                                                
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
                                                            <!-- <div class="search-left1 me-2"><a class="my-auto me-2 dotted" href="javascript:void(0)">show selected</a></div> -->
                                                            <div>
                                                                <a class="my-auto dotted" href="javascript:void(0)" @click="clearAllNaics()" style="color: rgb(64, 164, 241);">Deselect All</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                    <div class="vl-parent">
                                                     <loading v-model:active="isLoading1" :can-cancel="false" :z-index="10001" :is-full-page="fullPage1" />
                                                        <div class="card-body p-0 scroll1 treehght">
                                                            <ul class="list-style-none" style="padding-left: 0px;">
                                                                <li>
                                                                    <ul id="demo">
                                                                          <TreeItem class="item" :item="treeData" :tdr_naics="naics_id" :clear_all_naics="clear_all_naics" > </TreeItem>
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
                                    <!-- nics end -->

                                    <hr />

                                    <!-- nics code -->
                                    <div v-if="$route.params.region_id ==2">
                                        <div class="col-md-8">
                                            <label class="form-label" style="font-size: 20px; font-weight: 600;">PSC Code:<span class="text-danger">*</span></label><br />
                                            <div class="d-flex gap-2 gap-sm-4 flex-wrap">
                                                <span class="mt-2">
                                                    Use the search box to find psc Codes and mark one or more checkboxes to add to your selection. Note:Changing your search criteria does not remove items from your selection.
                                                </span>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="col-md-8">
                                            <div class="tab-content mb-0" id="flight-pills-tabContent">
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
                                                            <!-- <div class="search-left1 me-2"><a class="my-auto me-2 dotted" href="javascript:void(0)">show selected</a></div> -->
                                                            <div><a class="my-auto dotted" href="javascript:void(0)" @click="clearAllPsc()" style="color: rgb(64, 164, 241);">Deselect All</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                       <div class="vl-parent">
                                                     <loading v-model:active="isLoading2" :can-cancel="false" :z-index="10001" :is-full-page="fullPage2" />
                                                        <div class="card-body p-0 scroll1 treehght">
                                                            <ul class="list-style-none" style="padding-left: 0px;">
                                                                <li>
                                                                    <ul id="demo">
                                                                        <PscTree class="item" :item="service_codes" :clear_all_psc="clear_all_psc"> </PscTree>
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
                                    <!-- Company Name -->
                                    <div class="col-md-12">
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">Keywords (each seperated by ",")<span class="text-danger">*</span></label><br />
                                        <!-- <div class="d-flex mt-3">
                                            <textarea class="form-control mb-0" placeholder="Add a Keywords ..." rows="4" spellcheck="false" id="comment" :class="{'is-invalid': errors.keywords}" v-model="tags"></textarea>
                                              <vue3-tags-input  class="form-control form-control-sm p-0" @on-tags-changed="handleChangeTag" placeholder="Input Keyword" v-model:tags="tags" v-model="tag" @allow-duplicates="false"/>
                                            <br />
                                        </div> -->

                                        <!-- try start -->
                                        <div class="tag-input">
                                            <div v-for="(tag, index) in tags" :key="tag" class="tag-input__tag">
                                                {{ tag }}
                                                <span @click="removeTag(index)">x</span>
                                            </div>
                                            <textarea rows="4" type="text" placeholder="Enter a keyword" class="form-control mb-0 tag-input__text" @keydown.enter="addTag" @keydown.,="addTag" @keydown.delete="removeLastTag" ></textarea>
                                        </div>

                                        <!-- try ends -->
                                    </div>

                                    <!-- <div class="col-md-6">
                                    <vue3-tags-input  class="form-control form-control-sm p-0" @on-tags-changed="handleChangeTag" placeholder="Input Keyword" v-model:tags="tags" v-model="tag" @allow-duplicates="false"/>
                                    </div> -->

                                    <span v-if="errors.keywords" style="color: #dc3545;">{{ errors.keywords[0] }}</span>

                                    <!-- Website Address -->
                                    <div class="col-12 text-start">
                                        <button type="submit" class="btn btn-primary mb-0" @click.prevent="submit()">
                                            <span v-if="status">Submit </span>
                                            <span v-else>Update</span>
                                        </button>
                                    </div>
                                </form>
                                <!-- Form END -->
                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                </div>
                <!-- Main content END -->
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
                selectedFederal: [],
                selectedState: [],
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
                agency_state:[],
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
                agencyState:[],
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
                 alert:{
                    tdr_naics:[],
                    tdr_psc:[]
                },
               
                isLoading: false,
                isLoading1: false,
                isLoading2: false,
                fullPage: true,
                fullPage1: false,
                fullPage2: false,
                  naics_code: {
                    search: "",
                    alert_id:''
                },
                service_code: {
                    search: "",
                     alert_id:''
                },
                clear_all_naics:false,
                clear_all_psc:false,
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.getNotice();
                if (to.name == "CreateBidAlert") {
                    vm.status = true;
                    vm.savealert.user_id = vm.$store.getters.user.id;
                    vm.savealert.region_id = to.params.region_id;
                    vm.getCountry();
                    if (to.params.region_id != 4) {
                        vm.liststate.country_id;
                        vm.getSate();
                    }
                    if (vm.savealert.region_id == 1 || vm.savealert.region_id == 3 || vm.savealert.region_id == 4) {
                        vm.agencycheck = true;
                        vm.getAllAgency()
                        vm.getcategory()
                    } else {
                        vm.agencycheck = false;
                        vm.getSpecificAgency();
                    }
                } else {
                    vm.service_code.alert_id = vm.$store.getters.alert.id
                    vm.naics_code.alert_id = vm.$store.getters.alert.id   
                    vm.getStateAgency()    
                    vm.status = false;
                    vm.getSate();
                    if (vm.savealert.region_id == 1 || vm.savealert.region_id == 3 || vm.savealert.region_id == 4) {
                        vm.agencycheck = true;
                        vm.getAllAgency();
                        vm.getcategory();
                        
                    } else {
                        vm.agencycheck = false;
                        vm.getcategory();
                        vm.getSpecificAgency();
                    }
                    vm.savealert.id = to.params.id;
                    vm.savealert.user_id = vm.$store.getters.user.id;
                    vm.$store
                        .dispatch("post", { uri: "getAlert", data: vm.savealert })
                        .then(function (response) {
                            vm.savealert = response.data;
                            vm.selectedState = vm.savealert.agency_fedral ? vm.savealert.agency_fedral.split("@") : [];
                            vm.liststate.country_id = vm.savealert.country_id;
                            vm.status = false;
                            vm.frequency = vm.savealert.frequency;
                            vm.notice_type = vm.savealert.notice_type ? vm.savealert.notice_type.split(",") : [];
                            vm.set_aside_status = vm.savealert.set_aside_status ? vm.savealert.set_aside_status.split(",") : [];
                            vm.state_id = vm.savealert.state_id ? vm.savealert.state_id.split(",") : [];
                            vm.naics_id = vm.savealert.naics_id ? vm.savealert.naics_id.split(",") : [];
                            vm.psc = vm.savealert.psc ? vm.savealert.psc.split(",") : [];
                            vm.selected = vm.state_id;
                            vm.tags = vm.savealert.keywords ? vm.savealert.keywords.split(","):'';
                            vm.keywords = vm.tags;
                            vm.categorys = vm.savealert.category_id? vm.savealert.category_id.split(","):[];
                            vm.selectedcategory = vm.categorys
                            let naics = []
                            vm.naics_id.map(function(element){
                                naics.push(parseInt(element))
                            })
                            vm.$store.dispatch("setSelectedNaics", naics);
                            let psc = []
                            vm.psc.map(function(element){
                                psc.push(parseInt(element))
                            })
                            vm.$store.dispatch("setSelectedPsces", psc);
                        })
                        .catch(function (error) {
                            console.log(error)
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            });
        },
        mounted() {
            let vm = this;
            vm.callFunction();
            vm.getNaics();
            vm.interstedUser.user_id = vm.$store.getters.user.id;
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

            getStateAgency() {
                let vm = this;
                let uri = "getAgency";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.agencyState = response.data.data;
                        // vm.allFilterAgency = vm.agencyState;
                        // vm.agencycount = vm.agencyState.length;
                        // if (vm.searchfilter.tdr_agency.length) vm.appendTenderAgencyToFilter(vm.searchfilter.tdr_agency);
                        // vm.getSate();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            clearAllNaics(){
                this.isLoading1 = true
                setTimeout(() => {
                    this.clear_all_naics = !this.clear_all_naics
                    this.isLoading1 = false
                }, 1000);
            },

            clearAllPsc(){
                this.isLoading2 = true
                setTimeout(() => {
                    this.clear_all_psc = !this.clear_all_psc
                    this.isLoading2 = false
                }, 1000);
            },

            handleChangeTag(tags) {
                let vm = this;
                vm.tags = tags;
                vm.keywords = vm.tags;
            },
            //  appendNaicsCodeToFilter(tdr_naics_codes) {
            //     let vm = this;
            //     if (Array.isArray(tdr_naics_codes) && tdr_naics_codes.length) {
            //         vm.filters.push({
            //             table: "tdr_naics",
            //             id: "naics_code_" + vm.searchfilter.tdr_naics.length,
            //             name: "NAICS Code :" + vm.searchfilter.tdr_naics.length,
            //         });
            //     }
            // },

            // appendPscCodeToFilter(tdr_psc) {
            //     let vm = this;
            //     if (Array.isArray(tdr_psc) && tdr_psc.length) {
            //         vm.filters.push({
            //             table: "tdr_psc",
            //             id: "psc_code_" + vm.searchfilter.tdr_psc.length,
            //             name: "PSC Code :" + vm.searchfilter.tdr_psc.length,
            //         });
            //     }
            // },
            getNaicsBackend(){
                let vm = this
                vm.$store
                    .dispatch("post", { uri: "getNaics", data: vm.naics_code })
                    .then(function (response) {
                        vm.isLoading1 = false
                        vm.treeData.children = response.data.data
                        vm.$store.dispatch("setNaics", vm.treeData.children)
                        vm.getServiceCodes();
                    })
                    .catch(function (error) {
                        vm.isLoading1 = false
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getNaics() {
                let vm = this;
                vm.fullPage = false;
                vm.isLoading2 = false;
                vm.isLoading1 = true;
                if(vm.naics_code.alert_id){
                    this.getNaicsBackend()
                }else{
                    if(vm.$store.getters.naicses.length){
                        vm.treeData.children = vm.$store?.getters?.naicses
                        vm.isLoading1 = false
                        vm.getServiceCodes();
                    }else{
                        this.getNaicsBackend()
                    }
                }
            },
          
            getServiceCodes() {
                let vm = this;
                 vm.fullPage = false;
                vm.isLoading1 = false;
                vm.isLoading2 = true;
                vm.service_code.alert_id = vm.$store.getters.alert.id
                if(vm.$store.getters.psces.length){
                    vm.service_codes.children = vm.$store.getters.psces
                    vm.isLoading2 = false
                }
                else{
                    vm.$store
                        .dispatch("post", { uri: "getPsc", data: vm.service_code })
                        .then(function (response) {
                            vm.isLoading2 = false
                            vm.$store.dispatch("setPsces", response.data.data)
                            vm.service_codes.children = vm.$store.getters.psces
                            if(response.data.data.length){
                                if(response.data.data[0].psces && response.data.data[0].psces[0] != ""){
                                    vm.$store.dispatch("setSelectedPsces", response.data.data[0].psces);
                                    vm.applyFilterPsc()
                                }
                            }
                        })
                        .catch(function (error) {
                            //    vm.isLoading = false
                            //      vm.fullPage= false
                            vm.isLoading2 = false
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },
            removeTag(index) {
                this.agency_fedral.splice(index, 1);
            },
            submit() {
                let vm = this;
                if (vm.status) {
                    vm.AddAlert();
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
            getSate() {
                let vm = this;
                vm.listcountry.country_id = Object.assign({}, [vm.liststate.country_id]);
                let uri = "getState";
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.listcountry })
                    .then(function (response) {
                        vm.state_country = response.data.data;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getNotice() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getNotice" })
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
                    .dispatch("post", { uri: "getSetAsideStatus" })
                    .then(function (response) {
                        vm.sideStatus = response.data.data;
                        vm.getFederal();
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
                        //console.log(vm.federal);
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
            AddAlert() {
                let vm = this;
                if (vm.$route.params.region_id == 1 || vm.$route.params.region_id == 3 || vm.$route.params.region_id == 4) {
                    vm.naics_id = [];
                    vm.set_aside_status = [];
                }
                let state = ''
                vm.agency_fedral.map(function(element){
                    
                    if(state){
                        state = state +'@'+element
                    }else{
                        console.log(element)
                        state = element

                    }
                })
                vm.savealert.user_id = vm.$store.getters.user.id;
                vm.savealert.region_id = vm.$route.params.region_id;
                vm.savealert.frequency = vm.frequency;
                vm.savealert.keywords = vm.tags.toString();
                vm.savealert.state_id = vm.state_id.toString();
                vm.savealert.naics_id = vm.naics_id.toString()
                vm.savealert.psc = vm.$store.getters.selected_psces.toString();
                vm.savealert.set_aside_status = vm.set_aside_status.toString();
                vm.savealert.agency_fedral = state
                vm.savealert.notice_type = vm.notice_type.toString();
                vm.savealert.country_id = vm.liststate.country_id.toString();
                vm.savealert.category_id = vm.selectedcategory.toString();

                vm.$store
                    .dispatch("post", { uri: "addAlert", data: vm.savealert })
                    .then(function (response) {
                        vm.federal = response.data.data;
                        vm.$store.dispatch("success", "Alert Added successfully");
                        vm.$router.push("/bids/save-alert");
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            updateAlert() {
                let vm = this;
                if (vm.$route.params.region_id == 1 || vm.$route.params.region_id == 3 || vm.$route.params.region_id == 4) {
                    vm.naics_id = [];
                    vm.set_aside_status = [];
                   
                }
                let state = ''
                vm.agency_fedral.map(function(element){
                    
                    if(state){
                        state = state +'@'+element
                    }else{
                        console.log(element)
                        state = element

                    }
                })
                vm.savealert.user_id = vm.$store.getters.user.id;
                vm.savealert.region_id = vm.$route.params.region_id;
                vm.savealert.frequency = vm.frequency;
                vm.savealert.keywords = vm.tags.toString();
                vm.savealert.state_id = vm.state_id.toString();
                vm.savealert.naics_id = vm.$store.getters.selected_naicses.toString();
                vm.savealert.psc = vm.$store.getters.selected_psces.toString();
                vm.savealert.set_aside_status= vm.set_aside_status.toString();
                vm.savealert.agency_fedral = state
                vm.savealert.notice_type = vm.notice_type.toString();
                vm.savealert.country_id = vm.liststate.country_id.toString();
                vm.savealert.category_id = vm.selectedcategory.toString();
                vm.isLoading = true;

                vm.$store
                    .dispatch("post", { uri: "updateAlert/" + vm.savealert.id, data: vm.savealert })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "BidsAlert is successfully updated");

                        vm.$router.push("/bids/save-alert");
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            filterFederal() {
                if (this.searchagencyState == "") {
                    this.filterAgency = this.allFilterAgency;
                }
                this.filterAgency = this.allFilterAgency.filter((entry) => {
                    return entry.agency_name.toLowerCase().includes(this.searchagencyState.toLowerCase());
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
            
            selectState() {
                this.selectedState = [];
                if (!this.selectAllState) {
                    for (let i in this.agencyState) {
                        this.selectedState.push(this.agencyState[i].agency_name);
                    }
                    this.agency_state = this.selectedState;
                }
            },
            DeselectState() {
                this.selectedState = [];
            },
            DeselectFederal() {
                this.agency_fedral = [];
            },
            
            updateCheckallFederal() {
                if (this.filterAgency.length == this.selectedState.length) {
                    this.selectAllState = true;
                    this.agency_fedral = this.selectedState;
                } else {
                    this.selectAllState = false;

                    this.agency_fedral = this.selectedState;
                }
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
        max-height: 200px;
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
        font-size: 13px;
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
         background: #e1f1ff!important;
    color: #00639a!important;
        /* background-color: #667eea; */
        border-radius: 10px;
        margin-top: 10px;
        line-height: 24px;
        padding: 0 8px;
        
       
    }

    .tag-input__tag > span {
        cursor: pointer;
        opacity:1;
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
    top: 4px!important;
}
.b1{
    font-size: 20px;
    font-weight: 600;
}
.scroll2{
    height:280px!important;

}
.treehght{
    height:287px!important
}
.hgt{
    height:175px!important;
}
</style>
