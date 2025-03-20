<template>
<loading v-model:active="isLoading"
                 :can-cancel="false"
                  :z-index="10001"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"/>
    <section class="pt-5">
        <div class="container-fluid">
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
                            <div class="card-header border-bottom">
                                <h4 class="card-header-title" v-if="status">Create Alert</h4>
                                <h4 class="card-header-title" v-else>Update Alert</h4>
                                 <div class="text-end">
									<router-link  :to="{ path: '/bids/save-alert' }" class="btn btn-primary">Back</router-link>
								</div> 
                            </div>
                              
                            <!-- Card body START -->
                            <div class="card-body">
                                <label v-if="$route.params.region_id==2" class="form-label" style="font-size: 20px; font-weight: 600;">Federal</label>
                                <label v-if="$route.params.region_id==4" class="form-label" style="font-size: 20px; font-weight: 600;">International</label>
                                <label v-if="$route.params.region_id==3" class="form-label" style="font-size: 20px; font-weight: 600;">Private</label>
                                <label v-if="$route.params.region_id==1" class="form-label" style="font-size: 20px; font-weight: 600;">State</label>
                                <!-- Form START -->
                                <form class="row g-3">
                                    <!-- Profile photo -->

                                    <!-- Name -->
                                    <div class="col-md-3">
                                        <label class="form-label">Alert Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" :class="{'is-invalid': errors.alert_label}" v-model="savealert.alert_label" placeholder="Enter your Alert" />
                                        <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Frequency<span class="text-danger">*</span></label>
                                        <select class="form-select" :class="{'is-invalid': errors.frequency}" v-model="frequency">
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
                                        <label for="inputfrequen1" class="form-label head1">State <span class="text-danger">*</span> </label> <label>{{ selected.length }} of {{ state_country.length }} Selected</label>
                                       
                                        <div class="">
                                            <button type="button" class="btn btnwht10 form-select" data-bs-toggle="dropdown">
                                                <span class="text-center" style="float: left; font-size: 14px; font-weight: 400;">Select State</span>
                                            </button>
                                            <label for="inputfrequen1" class="form-label"> </label>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-item ">
                                                    <div class="">
                                                        {{ selected.length }} of {{ state_country.length }}
                                                        <!-- <input type="checkbox" v-model="this.selectAll" @click="select" class="hidden"/> Select all -->
                                                        <router-link to="" v-model="selectAll" @click="select()" class="" ref="selectState">
                                                            Select All/
                                                        </router-link>
                                                        <router-link to="" v-model="selectAll" @click="Deselect()" class="" ref="selectState">
                                                            Reset all
                                                        </router-link>
                                                        <div class="ss-filter-search">
                                                         <input autocomplete="off"  class="form-control" type="text" v-model="searchstate" placeholder="Search organizations" />
                                                              <div class="liststate" id="style-3">
                                                                <ul class="checkbox" v-for="state in filterState" :key="state.state_id">
                                                                    <li class="list-group-item">
                                                                        <input class="form-check-input me-1"  id="federalcheck" type="checkbox" :value="state.state_id" v-model="selected" @change="updateCheckall" aria-label="..." />

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
                                          <span v-if="errors.state_id" style="color:#dc3545" >{{ errors.state_id[0] }}</span>
                                    </div>

                                    <hr />
                                    <!-- Email -->

                                    <!-- list notice type -->
                                    <label class="form-label" style="font-size: 20px; font-weight: 600;">Notice type<span class="text-danger">*</span></label>
                                    <span v-if="errors.notice_type" style="color:#dc3545" >{{ errors.notice_type[0] }}</span>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-4 col-xl-3" v-for="notice in notices" :key="notice.notice_id">
                                            <ul class="list-group list-group-borderless mb-0" >
                                                <li class="list-group-item">
                                                    <input type="checkbox"  class="form-check-input me-2" id="rememberCheck" :value="notice.notice_id" v-model="notice_type" />
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
                                        <br><a class="inf" href="javascript:void(0)">More Information about Set-Aside Codes</a>
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-4 col-xl-3" v-for="set_side in sideStatus" :key="set_side.status_id">
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
                                                <router-link to="" v-model="selectAllcategory" @click="DeselectCategory()"  class="" ref="selectState">
                                                    Reset all
                                                </router-link>
                                                <div class="col-md-6" >
                                                    <div class="ss-filter-search" >
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
                                                    <!-- <div class="col-md-5 text-center" v-for="agency,index in categorys" :key="agency">
                                                 <div class="flex-box mb-1 text-center p-2" >
                                                    <span class="align-items-center text-center" style="height:auto; font-size:14px;"  >{{agency}}</span>
                                                <span @click="removeTag(index)" class="btn-close align-items-center" style="height:auto" ></span>
                                                        </div>

                                        </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">Agency</label><br />
                                        <div class="d-flex gap-2 gap-sm-4 flex-wrap">
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="true" v-model="agencycheck" @change="getAllAgency()" />
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    All Agency
                                                </label>
                                            </div>
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="false" v-model="agencycheck" @change="getSpecificAgency()" />
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Specific Agency
                                                </label>
                                            </div>
                                        </div>
                                        <br />
                                        <div>
                                            <label class="form-label">Agency</label><br />
                                            <span class="greentitle"> About Scheduled Emails:</span>
                                            <span class="text-center mt-2">
                                                Type in a partial agency name below and then choose a match to add it to your selection.
                                                <br />
                                                To remove a choice from your selection press the [X] icon on the left.
                                            </span>
                                        </div>
                                    </div>
                                    <br />
                                    <label class="form-label">Agency</label><br />
                                    <!-- selected federal Agency -->
                                    <div class="collapse show" id="collapseExample7">
                                        <div class="collapse show" id="collapseExample7">
                                            <div class="">
                                                {{selectedState.length}} of {{agencycount}}

                                                <router-link to="" v-model="selectAllState" @click="selectState()" class="" ref="selectState">
                                                    Select All/
                                                </router-link>
                                                <router-link to="" v-model="selectAllState" @click="DeselectState()" class="" ref="selectState">
                                                    Reset all
                                                </router-link>
                                                <div class="col-md-6">
                                                    <div class="ss-filter-search">
                                                        <!-- <input autocomplete="off" class="ss-filter-search__input" type="text" v-model="searchagencyState" @keyup="filter1Agency()" placeholder="Search organizations" /> -->
                                                        <input class="form-control pe-5" type="search" placeholder="Search" aria-label="Search" v-model="searchagencyState" @keyup="filter1Agency()" />

                                                        <!-- list state -->

                                                        <div class="liststate" id="style-3">
                                                            <ul class="list-group checkbox" v-for="statefederal in filterAgency" :key="statefederal.agency_id">
                                                                <li class="list-group-item d-flex">
                                                                    &nbsp; <input class="form-check-input me-1" type="checkbox" :value="statefederal.agency_name" v-model="selectedState" @change="updateCheckallState" aria-label="..." />
                                                                    &nbsp; {{statefederal.agency_name}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-5">
                                                    <div class="col-sm-8 col-lg-4 col-xl-3" v-for="agency,index in agency_fedral" :key="agency">
                                                        <ul class="list-group list-group-borderless mb-0">
                                                            <li class="list-group-item">
                                                                <div class="alert alert-warning alert-dismissible fade show">
                                                                    <strong>{{agency}}</strong>
                                                                    <button type="button" @click="removeTag(index)" class="btn-close" aria-label="Close"></button>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- remove tag -->
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <!-- nics code -->
                            <div v-if="$route.params.region_id ==2">
                                <div class="col-md-12">
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">NAICS Code:<span class="text-danger">*</span></label><br />
                                        <div class="d-flex gap-2 gap-sm-4 flex-wrap">
                                           <span class="text-center mt-2">Use the search box to find NAICS Codes and mark one or more checkboxes to add to your selection.
                                        Note:Changing your search criteria does not remove items from your selection.</span>
                                        </div>
                                        <br />
                                     
                                    </div>
                                        <div class="tab-content mb-0" id="flight-pills-tabContent">
                                            <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                                                <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                                    <div class="col-md-8 small">
                                                        <form class="position-relative">
                                                            <input class="form-control form-control-sm pe-5" type="search" placeholder="Search in Naics Codes" aria-label="Search" v-model="naics_code.search" @keypress.enter="getNaics()" />
                                                            <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="getNaics()"><i class="fas fa-search fs-6"></i></button>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-4 small d-flex">
                                                        <!-- <div class="search-left1 me-2"><a class="my-auto me-2 dotted" href="javascript:void(0)">show selected</a></div> -->
                                                        <div><a class="my-auto dotted" href="javascript:void(0)" @click="getNaics()">deselect checked</a></div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <ul class="list-style-none">
                                                            <li>
                                                                <ul id="demo">
                                                                    <TreeItem
                                                                        class="item"
                                                                        :item="treeData"
                                                                    >
                                                                    </TreeItem>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                                    <!-- nics end -->


                                    <hr/>

                                         <!-- nics code -->
                            <div v-if="$route.params.region_id ==2">
                                <div class="col-md-12">
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">PSC Code:<span class="text-danger">*</span></label><br />
                                        <div class="d-flex gap-2 gap-sm-4 flex-wrap">
                                           <span class="text-center mt-2">Use the search box to find psc Codes and mark one or more checkboxes to add to your selection.
                                        Note:Changing your search criteria does not remove items from your selection.</span>
                                        </div>
                                        <br />
                                     
                                    </div>
                                    <div class="tab-content mb-0" id="flight-pills-tabContent">
                                            <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                                                <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                                    <div class="col-md-8 small">
                                                        <form class="position-relative">
                                                            <input class="form-control form-control-sm pe-5" type="search" placeholder="Search in PSC Codes" aria-label="Search" v-model="service_code.search" @keypress.enter="getServiceCodes()" />
                                                            <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="getServiceCodes()"><i class="fas fa-search fs-6"></i></button>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-4 small d-flex">
                                                        <!-- <div class="search-left1 me-2"><a class="my-auto me-2 dotted" href="javascript:void(0)">show selected</a></div> -->
                                                        <div><a class="my-auto dotted" href="javascript:void(0)" @click="getServiceCodes()">deselect checked</a></div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <ul class="list-style-none">
                                                            <li>
                                                                <ul id="demo">
                                                                    <PscTree
                                                                        class="item"
                                                                        :item="service_codes"
                                                                    >
                                                                    </PscTree>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                                    <!-- Company Name -->
                                    <div class="col-md-6">
                                        <label class="form-label" style="font-size: 20px; font-weight: 600;">Keywords (each seperated by ",")<span class="text-danger">*</span></label><br />
                                        <div class="d-flex mt-3">
                                            <textarea class="form-control mb-0" placeholder="Add a Keywords ..." rows="4" spellcheck="false" id="comment" :class="{'is-invalid': errors.keywords}" v-model="keywords"></textarea>
                                            <br>
                                           
                                        </div>
                                        
                                    </div>
                                     <span v-if="errors.keywords" style="color:#dc3545" >{{ errors.keywords[0] }}</span>
                                    
                                    
                                    <!-- Website Address -->
                                    <div class="col-12 text-start">
                                       <button type="submit" class="btn btn-primary mb-0" @click.prevent="submit()">
                                        <span v-if="status">Submit </span>
                                        <span v-else>Update</span></button>
                                      
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
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
    export default {
          components: {TreeItem, PscTree,Loading },
        data() {
            return {
                 treeData: {
                    name: "Select All",
                    naics_code: "#",
                    children: [],
                },
                service_codes:{
                    name: "Select All",
                     psc_code: "#",
                    children: [],
                },
               
                selectedNaicses:[],
                childItems:[],
                filterAgency: [],
                state_country1: [],
                allFilterAgency: [],
                SpecificAgency: [],
                agencycheck:"",
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
                psc:[],
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
                 naics_code:{
                    search:''
                },
                service_code:{
                    search:''
                },
                isLoading: false,
                fullPage: true
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                 vm.getNotice();
                if (to.name == "CreateBidAlert") {
                 
                    //  vm.$refs.tax_name.focus();
                    vm.status = true;
                    vm.savealert.user_id = vm.$store.getters.user.id;
                    vm.savealert.region_id = to.params.region_id;
                    vm.getCountry();
                    if (to.params.region_id != 4) {
                        vm.liststate.country_id;
                        vm.getSate();
                    } 
                    if (vm.savealert.region_id == 1 || vm.savealert.region_id == 3 || vm.savealert.region_id == 4) {
                        vm.agencycheck =true;
                        vm.getAllAgency();
                        vm.getcategory();
                    } else {
                        vm.agencycheck =false;
                        vm.getSpecificAgency();
                    }
                } else {
                     vm.status = false;
                        vm.getSate();
                     if (vm.savealert.region_id == 1 || vm.savealert.region_id == 3 || vm.savealert.region_id == 4) {
                        vm.agencycheck =true;
                        vm.getAllAgency();
                        vm.getcategory();
                    } else {
                        vm.agencycheck =false;
                        vm.getcategory();
                        vm.getSpecificAgency();
                    }
                    vm.savealert.id = to.params.id;
                    vm.savealert.user_id = vm.$store.getters.user.id;
                    vm.$store
                        .dispatch("post", { uri: "getAlert", data: vm.savealert })
                        .then(function (response) {
                            vm.savealert = response.data;
                            vm.selectedState  = vm.savealert.agency_fedral.split(",");
                            vm.liststate.country_id = vm.savealert.country_id;
                            vm.status = false;
                            vm.frequency = vm.savealert.frequency;
                            vm.notice_type = vm.savealert.notice_type.split(",");
                            vm.set_aside_status = vm.savealert.set_aside_status.split(",");
                            vm.state_id = vm.savealert.state_id.split(",");
                            vm.naics_id = vm.savealert.naics_id.split(",");
                            vm.selected = vm.state_id;
                            vm.keywords = vm.savealert.keywords.split(",");           
                            vm.categorys =  vm.savealert.category_id.split(",");
                            vm.selectedcategory = vm.categorys;
              
                           
                            // vm.selectedState = vm.filterAgency;
                            // vm.selectedState = vm.selectedState.agency_name;
                           
                          
                            
                            // vm.getSate();
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            });
        },
        mounted() {
            console.log(this.$store.getters)
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
             getNaics(){
                let vm = this;
                vm.$store.dispatch("post", { uri: "getNaics", data:vm.naics_code })
                .then(function (response) {
                    vm.treeData.children = response.data.data
                    vm.getServiceCodes()
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
            },

            getServiceCodes(){
                let vm = this;
                vm.$store.dispatch("post", { uri: "getPsc", data:vm.service_code })
                .then(function (response) {
                    vm.service_codes.children = response.data.data
                    console.log(vm.service_codes)
                })
                .catch(function (error) {
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
                //  var currentDate = new Date();
                // alert(currentDate);
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
                vm.isLoading = true
                let uri = "getAgency";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.isLoading = false
                        vm.filterAgency = response.data.data;
                        vm.allFilterAgency = vm.filterAgency;
                        vm.agencycount = vm.filterAgency.length;
                       
                    })
                    .catch(function (error) {
                        vm.isLoading = false
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getSpecificAgency() {
                let vm = this;
                vm.isLoading = true
                let uri = "getAgencyFederal";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.isLoading = false
                        vm.filterAgency = response.data.data;
                        vm.allFilterAgency = vm.filterAgency;
                        vm.agencycount = vm.filterAgency.length;
                        //vm.getSavedsearch();
                    })
                    .catch(function (error) {
                        vm.isLoading = false
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
               vm.savealert.user_id = vm.$store.getters.user.id;
                vm.savealert.region_id = vm.$route.params.region_id;
                vm.savealert.frequency = vm.frequency;
                vm.savealert.keywords = vm.keywords.toString();
                vm.savealert.state_id = vm.state_id.toString();
                // vm.savealert.naics_id = vm.naics_id.toString();
                vm.savealert.naics_id = vm.$store.getters.selected_naicses.toString();
                vm.savealert.psc = vm.$store.getters.selected_psces.toString();
                vm.savealert.set_aside_status = vm.set_aside_status.toString();
                vm.savealert.agency_fedral = vm.agency_fedral.toString();
                vm.savealert.notice_type = vm.notice_type.toString();
                vm.savealert.country_id = vm.liststate.country_id.toString();
                vm.savealert.category_id = vm.selectedcategory.toString();

                vm.$store
                    .dispatch("post", { uri: "addAlert", data: vm.savealert })
                    .then(function (response) {
                        vm.federal = response.data.data;
                        vm.$store.dispatch("success", "Alert Added successfully");
                        vm.$router.push('/bids/save-alert');
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
                vm.savealert.user_id = vm.$store.getters.user.id;
                vm.savealert.region_id = vm.$route.params.region_id;
                vm.savealert.frequency = vm.frequency;
                vm.savealert.keywords = vm.keywords.toString();
                vm.savealert.state_id = vm.state_id.toString();
                vm.savealert.naics_id = vm.naics_id.toString();
                vm.savealert.psc = vm.psc.toString();
                vm.savealert.set_aside_status = vm.set_aside_status.toString();
                vm.savealert.agency_fedral = vm.agency_fedral.toString();
                vm.savealert.notice_type = vm.notice_type.toString();
                vm.savealert.country_id = vm.liststate.country_id.toString();
                vm.savealert.category_id = vm.selectedcategory.toString();
                vm.isLoading = true

                vm.$store
                    .dispatch("post", { uri: "updateAlert/" + vm.savealert.id, data: vm.savealert })
                    .then(function () {
                        vm.isLoading = false
                        vm.$store.dispatch("success", "BidsAlert is successfully updated");

                        vm.$router.push("/bids/save-alert");
                    })
                    .catch(function (error) {
                        vm.isLoading = false
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
   
    font-family: 'ProximaNova Regular', sans-serif;
}
</style>
