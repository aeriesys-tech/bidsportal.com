<template>
    <div class="regions">
        <div class="container-fluid justify-content-center pt-3">
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item">
                    <router-link to="/bids/federal-opportunities" class="nav-link">
                        <img class="icon" src="@/assets/icons/federalwhite.svg" alt="icon" />
                        Federal Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/state-opportunities" class="nav-link">
                        <img class="icon" src="@/assets/icons/statewhite.svg" alt="icon" />
                        State Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/private-commercial" class="nav-link">
                        <img class="icon" src="@/assets/icons/privatewhite.svg" alt="icon" />
                        Private / Commercial
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/international-opportunities" class="nav-link">
                        <img class="icon" src="@/assets/icons/internationalwhite.svg" alt="icon" />
                        International Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/documents" class="nav-link active">
                        <img class="icon" src="@/assets/icons/documentblue.svg" alt="icon" />
                        Document Search
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
    <div class="search">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 d-flex justify-content-between search-left my-auto" style="">
                    <div class="label">Filters</div>
                    <div class="empty" :class="{ bluetextclass: getFilterCount }">{{ getFilterCount}} filters selected</div>
                </div>
                <div class="col-md-7 my-auto">
                    <form class="bg-body shadow rounded-2">
                        <!-- <div class="input-group ">
							<input class="form-control  form-control-sm border-1 me-1"  placeholder="Search">
							<button type="button" class=" text-primary btn-white border-1 rounded-2 mb-0"><i class="fa fa-save fa-fw fs-6" ></i></button>
						</div> -->
                        <div class="input-group input-group-sm">
                            <vue3-tags-input class="form-control form-control-sm p-0 tag-center scrollinput" @on-tags-changed="handleChangeTag" placeholder="Input keywords separated by comma" :add-tag-on-keys="[13,188]" v-model:tags="tags" v-model="tag" @allow-duplicates="false" style="text-wrap: nowrap;" />

                            <span class="input-group-text p-0 bg-transparent"> <button class="btn btn-sm" @click.prevent="handleSelectedTag(tag)" type="button" id="button-addon2">Search</button> </span>
                        </div>
                    </form>
                </div>
                <!-- <div class="col-md-4 my-auto text-end text-sm-end justify-content-between"> -->
                <div class="col-md-2 my-auto text-end text-sm-end">
                    <ul class="list-inline hstack flex-wrap gap-6 justify-content-between mb-0 s-dropdown dropdown" style="float: right;">
                        <!-- <li class="list-inline-item mb-0" ><i class="fa fa-bell fa-fw fs-6 text-dark me-1"></i>Set Alert</li> -->
                        <!-- <li class="list-inline-item mb-0 s-dropdown dropdown hover1 mb-0 dropdown-toggle" href="#" id="demoMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-save fa-fw text-success me-1"></i>Saved search

                            <ul class="s-dropdown-content dropdown-menu dphover" aria-labelledby="demoMenu">
                               
                                 <li v-for="savedbids in savedserachbids" :key="savedbids.id" class="dropdown-item">
                                                    <a class="dropdown-item" href="#" @click.prevent="runSearch(savedbids)">{{ savedbids.alert_label }}</a>
                                                    <a class="icon green" @click.prevent="updateSearch(savedbids)">
                                                        {{ savedbids.id }}
                                                        <i class="fa fa-pencil pen"></i>
                                                    </a>
                                                    <a href="#" class="icon red" @click.prevent="deleteSearch(savedbids.id)">
                                                        <i class="fa fa-trash blueicon" aria-hidden="true"></i>
                                                    </a>
                                                </li>
                                
                            </ul>
                        </li> -->

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
                    <!-- Offcanvas body -->
                    <div class="flex-column p-4 p-xl-0" id="filtershadow">
                        <form class="rounded-3 shadow">
                            <!-- Status START -->
                            <div class="card card-body rounded-0 p-2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#Region" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2">Region</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                             
                                <div class="col-12 ml2 multi-collapse collapse show" id="Region">
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center" v-for="region in regions" :key="region.region_id">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="region" :id="region.region_id + 'region'" :value="region.region_id" @click="showregion(region)" v-model="searchfilter.region_id" />
                                            <label class="form-check-label" :for="region.region_id + 'region'">{{region.region_name}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                               <hr class="my-0" />
                            <!-- <div class="card card-body rounded-0 p-2">
                               
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#status" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" >Status</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                                 <hr class="my-0" />
                                <div class="col-12 ml2 multi-collapse collapse" id="status">
                                   
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="active" value="active" @change="SaveStatusactive('active')" v-model="searchfilter.tdr_status" />
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                    </div>
                            
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="inactive" value="expried" @change="SaveStatusexpried('expried')" v-model="searchfilter.tdr_status"   />
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div> -->

                            <div class="card card-body rounded-0 p-2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#noticetype" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2">Notice Type</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                                <div class="col-12 ml2 multi-collapse collapse show" id="noticetype" v-for="notice in search_notice" :key="notice.notice_id">
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="notice.notice_id + 'notice'" :value="notice.notice_id" @change="saveNotice(notice)" v-model="searchfilter.tdr_notice" />
                                            <label class="form-check-label" :for="notice.notice_id + 'notice'">{{ notice.notice_type }}</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                </div>
                            </div>
                            <hr class="my-0" />
                            <!-- Divider -->
                            <!-- country -->
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id ==4">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#country" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{bluetextclass: searchfilter.tdr_country.length !== 0}">Country</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                                <div class="col-12 ml2 multi-collapse collapse show" id="country">
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="col-12">
                                            <select class="form-select" @change="getSateCountry()" v-model="liststate.country_id">
                                                <option selected="" value="">Select Country</option>
                                                <option v-for="(country, key) in countrys" :key="key" :value="country.country_id"> {{ country.country_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                </div>
                            </div>
                            <!-- end -->
                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id==2 || searchfilter.region_id ==3 || searchfilter.region_id ==1">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#location" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass':searchfilter.tdr_state.length !==0}">Location (Place of Performance)</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                                <div class="col-12 ml2 multi-collapse collapse show" id="location">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ selected.length }} of {{ statecount}})</a>|
                                            <span v-if="selected.length !== state_country.length"> <router-link to="" v-model="selectAll" @click="select()" class="form-check-label text-primary me-2">Select All</router-link>| </span>
                                            <span v-if="state_country.length !== 0">
                                                <router-link to="" class="form-check-label text-primary me-2" v-model="selectAll" @click="Deselect()" v-if="state_country.length !== 0">Reset</router-link>
                                                <a class="form-check-label text-primary me-2 fa fa-solid fa-times-circle ms-1" @click="removeTagnotice(filter)"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="filterState()" v-model="searchstate" placeholder="Search State" aria-label="Search" />
                                            <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center" v-for="state in state_country" :key="state.state_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :value="state.state_id" v-model="selected" @change="updateCheckall(state)" :id="state.state_id + 'state'" />
                                                <label class="form-check-label" :for="state.state_id + 'state'"> {{state.state_name}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id ==4">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#location" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass':searchfilter.tdr_state.length !==0}">Location (Place of Performance)</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                                <div class="col-12 ml2 multi-collapse collapse show" id="location">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ stateSelected.length }} of {{ statecount1}})</a>|
                                            <span v-if="stateSelected.length !== state_country1.length">
                                                <router-link to="" v-model="stateselectAll" @click="selectCountryState()" class="form-check-label text-primary me-2">Select All</router-link>|
                                            </span>
                                            <span v-if="state_country1.length !== 0">
                                                <router-link to="" class="form-check-label text-primary me-2" v-model="stateselectAll" @click="DeselectCountryState()" v-if="state_country1.length !== 0">Reset</router-link>
                                                <a class="form-check-label text-primary me-2 fa fa-solid fa-times-circle ms-1" @click="removeTagnotice(filter)"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="filterCountryState()" v-model="searchstate1" placeholder="Search State" aria-label="Search" />
                                            <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
                                        <!-- Checkbox -->
                                        <div class="scroll1">
                                            <!-- Checkbox -->
                                            <div class="d-flex justify-content-between align-items-center" v-for="state in state_country1" :key="state.state_id">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" :id="state.state_id + 'state'" :value="state.state_id" v-model="stateSelected" @change="updateCountryStateCheckall(state)" />
                                                    <label class="form-check-label" :for="state.state_id + 'state'"> {{state.state_name}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <!-- state agency -->

                            <!-- end  -->
                            <!-- category -->
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id !==2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#categorys" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6
                                        style="font-size: 15px; font-weight: normal;"
                                        class="mb-2"
                                        :class="{
                                                bluetextclass: searchfilter.tdr_category.length !== 0,
                                            }"
                                    >
                                        Category
                                    </h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="categorys">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ selectedcategory.length }} of {{ categorycount }}) </a>|
                                            <span v-if="selectedcategory.length !== categorys.length">
                                                <router-link to="" v-model="selectAllcategory" @click="selectCategory()" class="form-check-label text-primary me-2">Select All</router-link>|
                                            </span>
                                            <span v-if="categorys.length !== 0">
                                                <router-link to="" class="form-check-label text-primary me-2" v-model="selectAllcategory" @click="DeselectCategory()" v-if="state_country.length !== 0">Reset</router-link>
                                                <a class="form-check-label text-primary me-2 fa fa-solid fa-times-circle ms-1" @click="removeTagnotice(filter)"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="filterCategory()" v-model="searchagencycategory" placeholder="Search State" aria-label="Search" />
                                            <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center" v-for="category in  categorys " :key="category.category_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :value="category.category_id" v-model="selectedcategory" @change="updateCheckallCategory(category)" :id="category.category_id+ 'category'" />
                                                <label class="form-check-label" :for="category.category_id+ 'category'"> {{ category.category_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- private -->
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id==2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#federalagency" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_agency.length !==0}">Federal Agency</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="federalagency">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ selectedFederal.length }} of {{ agencycount }})</a>|
                                            <span v-if="selectedFederal.length !== agencyFederal.length">
                                                <router-link to="" v-model="selectAllFederal" @click="selectfederal()" class="form-check-label text-primary me-2">Select All</router-link>|
                                            </span>
                                            <span v-if="agencyFederal.length !== 0">
                                                <router-link to="" class="form-check-label text-primary me-2" v-model="selectAllFederal" @click="Deselectfederal()" v-if="agencyFederal.length !== 0">Reset</router-link>
                                                <a class="form-check-label text-primary me-2 fa fa-solid fa-times-circle ms-1" @click="removeTagnotice(filter)"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="filterAgency()" v-model="searchFederal" placeholder="Search State" aria-label="Search" />
                                            <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll3">
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center" v-for="federal in agencyFederal" :key="federal.agency_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :id="federal.agency_id + 'federal'" :value="federal.agency_name" v-model="selectedFederal" @change="updateCheckallfederal(federal)" />
                                                <label class="form-check-label" :for="federal.agency_id + 'federal'"> {{ federal.agency_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />

                            <!-- State agency -->
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id ==1 || searchfilter.region_id ==3 || searchfilter.region_id ==4 ">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#Private" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6
                                        style="font-size: 15px; font-weight: normal;"
                                        class="mb-2"
                                        :class="{
                                                bluetextclass: searchfilter.tdr_agency.length !== 0,
                                            }"
                                    >
                                        <span v-if="searchfilter.region_id ==1">State Agency</span>
                                        <span v-if="searchfilter.region_id ==3">Private Agency</span>
                                        <span v-if="searchfilter.region_id ==4">International Agency</span>
                                    </h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="Private">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ selectedState.length }} of {{ state_agency_count }}) </a>|
                                            <span v-if="selectedState.length !== agencyState.length">
                                                <router-link to="" v-model="selectAllState" @click="selectState()" class="form-check-label text-primary me-2">Select All</router-link>|
                                            </span>
                                            <span v-if="agencyState.length !== 0">
                                                <router-link to="" class="form-check-label text-primary me-2" v-model="selectAllState" @click="DeselectState()">Reset</router-link>
                                                <a class="form-check-label text-primary me-2 fa fa-solid fa-times-circle ms-1" @click="removeTagnotice(filter)"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="filterAgency" v-model="searchagencyState" placeholder="Search Agency" aria-label="Search" />
                                            <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center" v-for="state_agency in  agencyState " :key="state_agency.id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :id="state_agency.id + 'statefederal'" :value="state_agency.agency_name" v-model="selectedState" @change="updateCheckallState(state_agency)" />
                                                <label class="form-check-label" :for="state_agency.id + 'statefederal'"> {{ state_agency.agency_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />

                            <!-- end -->
                            <div class="card card-body rounded-0 p-2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#response" role="button" aria-expanded="false" aria-controls="response">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.response_date.length !==0}">Response Date</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="response">
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hour" id="hour1" v-model="searchfilter.response_date" value="24 Hours" @click="hideresponsedate()" @change="changeResponseDate('24 Hours')" />
                                            <label class="form-check-label" for="hour1">24 Hours</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour2" name="hour" v-model="searchfilter.response_date" value="2 Days" @click="hideresponsedate()" @change="changeResponseDate('2 Days')" />
                                            <label class="form-check-label" for="hour2">2 Days</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour3" name="hour" v-model="searchfilter.response_date" value="7 Days" @click="hideresponsedate()" @change="changeResponseDate('7 Days')" />
                                            <label class="form-check-label" for="hour3">7 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour4" name="hour" v-model="searchfilter.response_date" value="21 Days" @click="hideresponsedate()" @change="changeResponseDate('21 Days')" />
                                            <label class="form-check-label" for="hour4">21 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="hour" v-model="searchfilter.response_date" value="custom" @click="changeResponseDate('Custom')" />
                                            <label class="form-check-label" for="custom1"> &nbsp; Custom</label>
                                            <div class="row" v-if="searchfilter.response_date=='custom'" style="margin-left: 0px;">
                                                <div class="col-sm-6">
                                                    <label class="form-label">Start Date<span class="text-danger">*</span></label>
                                                    <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD" v-model:value="searchfilter.response_from_date" :clearable="false" @change="checkResponseDate()"></date-picker>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">End Date<span class="text-danger">*</span></label>
                                                    <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD" v-model:value="searchfilter.response_to_date" :clearable="false" @change="checkResponseDate()"></date-picker>
                                                </div>
                                            </div>

                                            <span v-if="errors.response_error" style="color: #dc3545;">{{ errors.response_error }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <!-- posted date -->
                            <div class="card card-body rounded-0 p-2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#posted" role="button" aria-expanded="false" aria-controls="response">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.posted_date.length !==0}">Posted Date</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="posted">
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hour_posted_date" id="hour6" v-model="searchfilter.posted_date" value="24 Hours" @click="hidedate()" @change="changePostedDate('24 Hours')" />
                                            <label class="form-check-label" for="hour6">24 Hours</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour7" name="hour_posted_date" v-model="searchfilter.posted_date" value="2 Days" @click="hidedate()" @change="changePostedDate('2 Days')" />
                                            <label class="form-check-label" for="hour27">2 Days</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour8" name="hour_posted_date" v-model="searchfilter.posted_date" value="7 Days" @click="hidedate()" @change="changePostedDate('7 Days')" />
                                            <label class="form-check-label" for="hour8">7 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour9" name="hour_posted_date" v-model="searchfilter.posted_date" value="21 Days" @click="hidedate()" @change="changePostedDate('21 Days')" />
                                            <label class="form-check-label" for="hour9">21 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="hour12" v-model="searchfilter.posted_date" value="custom" @click="changePostedDate('Custom')" />
                                            <label class="form-check-label" for="custom12"> &nbsp; Custom</label>
                                            <div class="row" v-if="searchfilter.posted_date=='custom'" style="margin-left: 0px;">
                                                <div class="col-sm-6">
                                                    <label class="form-label">Start Date<span class="text-danger">*</span></label>
                                                    <date-picker format="YYYY-MM-DD" value-type="format" v-model:value="searchfilter.posted_from_date" :clearable="false" @change="checkPostDate()"></date-picker>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">End Date<span class="text-danger">*</span></label>
                                                    <date-picker format="YYYY-MM-DD" value-type="format" v-model:value="searchfilter.posted_to_date" :clearable="false" @change="checkPostDate()"></date-picker>
                                                </div>
                                            </div>

                                            <span v-if="errors.post_error" style="color: #dc3545;">{{ errors.post_error }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id==2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more d-flex justify-content-between align-items-center" href="" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_naics.length !==0}">Primary NAICS Code</h6>

                                    <a class="p-0 mb-0">
                                        <a class="gryy1" data-bs-toggle="modal" data-bs-target="#flightdetail" role="button" aria-expanded="true" aria-controls="collapseExample5">
                                            <i class="fa fa-filter" aria-hidden="true"></i>
                                        </a>
                                        <!-- <i class="fa-solid fa-angle-down ms-2"></i> -->
                                    </a>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <!-- end -->
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id ==2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more d-flex justify-content-between align-items-center" href="" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_psc.length !==0}">Product & Service Code</h6>

                                    <a class="p-0 mb-0">
                                        <a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModal">
                                            <i class="fa fa-filter" aria-hidden="true"></i>
                                        </a>
                                    </a>
                                </div>
                            </div>
                         <!-- <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id==2">
                                
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#contract" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_type.length !==0}">Contract Type</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="contract" v-for="tender in tender_type" :key="tender.tdr_type_id">
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="tender.tdr_type_id + 'tender'" :value="tender.tdr_type_id" @change="saveContracttype(tender)" v-model="searchfilter.tdr_type" />
                                            <label class="form-check-label" :for="tender.tdr_type_id + 'tender'">{{ tender.tdr_type_name }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id==2">
                             
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#award" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_type_of_award.length !==0}">Type of Award</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="award" v-for="award in awards" :key="award.type_of_award_id">
                                 
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="award.type_of_award_id + 'award'" :value="award.type_of_award_id" @change="SaveTypeofAward(award)" v-model="searchfilter.tdr_type_of_award" />
                                            <label class="form-check-label" :for="award.type_of_award_id + 'award'">{{ award.type_of_award_name }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>  -->
                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2" v-if="searchfilter.region_id==2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#setaside" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_set_aside_status.length !==0}">Competition(Set-Aside)</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show mb-3" id="setaside">
                                    <div class="scroll1 hgt-250">
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center" v-for="sideStatu in sideStatus" :key="sideStatu.status_id">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="sideStatu.status_id + 'sideStatu'"
                                                    :value="sideStatu.status_id"
                                                    @change="SaveSetAside(sideStatu)"
                                                    v-model="searchfilter.tdr_set_aside_status"
                                                />
                                                <label class="form-check-label" :for="sideStatu.status_id + 'sideStatu'"> {{ sideStatu.status_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Form End -->
                    </div>
                </div>

                <div class="col-lg-8 col-xl-9">
                    <div class="vl-parent">
                        <Skeleton v-if="isLoading" />
                        <div class="scroll-div">
                            <div class="hstack flex-wrap gap-2">
                                <!-- Search item -->
                                <div class="alert border shadow fade show small px-1 py-0 mb-0 filtertagcss" v-for="(filter, index) in filters" :key="index">
                                    <span class="me-1" style="color: white;">{{ filter.name }}</span>
                                   <button type="button" class="btn btn-xs mb-0 text-white p-0" style="font-size:13px!important;" @click="removeTagnotice(filter)" aria-label="Close"><i class="fa fa-light fa-xmark text-white"></i></button>
                                </div>
                                <!-- Search item -->
                                <div v-if="filters.length != 0">
                                    <button type="button" class="btn btn-xs text-primary mb-0 p-1 textclose" @click.prevent="clearAllFilters">Clear all</button>
                                </div>
                            </div>
                        </div>
                        <section v-if="bids.length === 0">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-10 text-center mx-auto">
                                        <!-- Image -->
                                        <img src="assets/images/no-search-results.svg" class="mb-4" width="230px" alt="" />

                                        <h3>No results found</h3>
                                        <!-- info -->
                                        <p class="mb-4">Try adjusting your serarch or filter to find what you're looking for.</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="text-end" v-if="bids.length !== 0">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">Showing {{ meta.to }} of {{ meta.totalRows }} bids </a>
                                </li>

                                <li class="list-inline-item" v-if="$store.getters.user !== null">
                                    <a href="#javascript:void(0)" @click.prevent="emailmodalpop()" class="p-2 text-secondary"><i class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>
                        <div v-if="searchfilter.region_id">
                            <div v-if="listview">
                                <div class="card shadow mb-2" v-for="bid in bids" :key="bid.tdr_id">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <!-- Rating and buttons -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                    <a href="javascript:void(0)" @click="bidsdetails(bid)" style=" text-transform: uppercase;"><div v-html="highlight(bid.tdr_title)"></div></a>
                                                </div>
                                                <div v-else>
                                                     <a href="javascript:void(0)" @click="showModal()">
                                                        <div v-html="highlight(bid.tdr_title)"></div>
                                                        </a></div>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <!-- Heart icon -->
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0" v-if="$store.getters.user !== null">
                                                        <small class="form-check-label mb-0 me-2"><a href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox" :value="bid.tdr_id" id="flexCheckChecked" v-model="sendMails.bids" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                                <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ bid.notice.notice_type }}</li>
                                                <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />{{ bid.tdr_no }}</li>
                                                <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ dateFormat(bid.tdr_posted_date) }} &nbsp;<span>{{bid.created_at }}</span></li>
                                                <li class="nav-item">
                                                    <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" /> {{ dateFormat(bid.tdr_expiry_date) }}
                                                    <span class="col-green" v-if=" datecalcu(bid.tdr_expiry_date,currentDate()) > 1">
                                                        &nbsp; {{ datecalcu( bid.tdr_expiry_date, currentDate() ) }} Day to Go
                                                    </span>
                                                    <span class="col-red" v-else>&nbsp; Expired </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="d-flex flex-wrap">
                                            <!-- List -->
                                            <ul
                                                class="list-group list-group-borderless small mb-0 mt-2 d-flex"
                                              
                                                style="display: inline-block; padding: 0.5em;"
                                            >
                                           
                                            <li   v-for="(value, key) in bid.tdr_documents.split('@')"
                                                :key="key" style="list-style: none;">
                                                 <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                    <a :href="$store.state.baseUrl+'singleBidDownloadFromS3/'+ bid.region.region_id +'/'+ value" class="action-icon">
                                                        {{ value }}
                                                    </a>
                                                 </div>
                                                  <div v-else>
                                                 <p>
                                                        {{ value }}
                                                    </p>
                                                </div>
                                                </li>
                                          
                                           
                                               
                                            </ul>
                                        </div>

                                        <!-- Price and Button -->
                                        <div class="border-top d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                            <!-- Button -->
                                            <div class="d-flex align-items-center">
                                                <!-- <h5 class="fw-bold mb-0 me-1">$540</h5>
                                                <span class="mb-0 me-2">/day</span> -->
                                                <ul class="nav nav-divider small mt-3" style="color: #595d6e;">
                                                    <li class="nav-item text-primary"><i class="bi bi-patch-check-fill text-primary me-2"></i>{{ bid?.tdr_agency}}</li>
                                                    <!-- <li class="nav-item text-primary">Subscribe Now ! To view agency</li> -->
                                                    <li class="nav-item"><i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ bid?.state?.state_name }}<span v-if="bid?.state?.state_name">,</span> {{ bid?.country?.country_name }}</li>
                                                </ul>
                                            </div>
                                            <!-- Price -->
                                            <div class="mt-3">
                                                <!-- <a href="hotel-detail.html" class="btn btn-sm btn-dark mb-0 w-100">Select Room</a> 
                                                    -->
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <!-- Heart icon -->
                                                    <li class="list-inline-item" v-if="$store.getters.user !== null">
                                                        <a href="javascript:void(0)" @click.prevent="shareBidDocument(bid)" v-modal="shareBid.bids" class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE</a>
                                                    </li>
                                                    <!-- Share icon -->
                                                    <li class="list-inline-item" v-if="checkCartItem(bid.tdr_id)">
                                                        <!-- Share button -->
                                                        <div v-if="$store.getters.user?.subscription_id ===0">
                                                            <a href="javascript:void(0)" @click="addCart(bid)" class="p-2">
                                                                <img v-if="hidecartstatue" src="assets/images/addcart.svg" width="19" />
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <li class="list-inline-item" v-else>
                                                        <img src="assets/images/icons/cart-24.svg" width="19" />
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card shadow" v-if="bids.length !== 0">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative">
                                        <div class="table-responsive border-0">
                                            <table class="table table-sm small align-middle p-4 mb-0 table-hover table-shrink">
                                                <!-- Table head -->
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col" class="border-0">BID NUMBER & NOTICE TYPE</th>
                                                        <th scope="col" class="border-0">TITLE</th>
                                                        <th scope="col" class="border-0">AGENCY</th>
                                                        <th scope="col" class="border-0">LOCATION</th>
                                                        <th scope="col" class="border-0">DUE DATE</th>
                                                        <th scope="col" class="border-0"></th>
                                                    </tr>
                                                </thead>

                                                <!-- Table body START -->
                                                <tbody class="border-top-0" v-for="bid in bids" :key="bid.tdr_id">
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="form-check my-auto" v-if="$store.getters.user !== null">
                                                                    <input class="form-check-input me-3" type="checkbox" :value="bid.tdr_id" v-model="sendMails.bids" />
                                                                    <!-- <label class="form-check-label"><img class="mb-1 me-2" src="@/assets/icons/i-claimed.svg" width="17" /> </label> -->
                                                                </div>

                                                                <div class="row">
                                                                    <div class="column">
                                                                        <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0"><a href="javascript:void(0)" @click="bidsdetails(bid)">{{ bid.tdr_no }}</a></div>
                                                                        <div v-else><a href="javascript:void(0)" @click="showModal()">{{ bid.tdr_no }}</a></div>
                                                                    </div>

                                                                    <div class="column">
                                                                        <a :style="{color:bid.notice.backround_color}" class="badge bg-success bg-opacity-10">{{ bid.notice.notice_type }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><div v-html="highlight(bid.tdr_title)"></div></td>
                                                        <td>{{ bid.tdr_agency }}</td>
                                                        <td>{{ bid.state.state_code }},{{ bid.state.state_name }}</td>
                                                        <td style="width: 110px;">{{ bid.tdr_expiry_date }}</td>
                                                        <td>
                                                            <span v-if="checkCartItem(bid.tdr_id)">
                                                                <div v-if="$store.getters.user?.subscription_id ===0">
                                                                    <a href="javascript:void(0)" @click="addCart(bid)"><img v-if="hidecartstatue" class="mb-1 me-2" src="@/assets/icons/addcart.svg" width="20" /></a>
                                                                </div>
                                                            </span>
                                                            <span v-else>
                                                                <img src="assets/images/icons/cart-24.svg" width="19" />
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <!-- Table body END -->
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="kt-portlet mb-0" v-if="bids.length !== 0">
                            <div class="kt-portlet__body">
                                <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                            </div>
                        </div> -->

                        <div  v-if="bids.length !== 0">
                        <div style="float: left;">
                                <input type="text" class="form-control" v-model="meta.currentPage" @keypress.enter="getfedralDocument()" style="width: 60px;" />
                            </div>
                            <div style="float: right;">
                                <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- loader end -->
        </div>
    </div>
    <teleport to="#modals" :disabled="!alertmodal" v-if="alertmodal">
        <div class="modal-overlay">
            <div id="popup1" class="popup">
                <a href="javascript:void(0)" @click.prevent="closemodal()" class="close remunderline">&times;</a>
                <h5>Alert</h5>

                <div style="text-center: center;">
                    <h6 style="text-align: center; color: red !important; margin-top: 15px;">
                        Please Select Bid!
                    </h6>
                </div>
            </div>
        </div>
    </teleport>
    <teleport to="#modals" v-disabled="!emailmodal" v-if="emailmodal">
        <div class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <div class="card border">
                            <!-- Card body START -->
                            <div class="card-body vstack gap-4">
                                <!-- Traveler item START -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header d-flex justify-content-between align-items-center p-0">
                                        <!-- Avatar -->
                                        <div class="d-flex align-items-center">
                                            <!-- Avatar -->
                                            <div class="avatar avatar-sm">
                                                <img class="avatar-img" src="assets/images/mail.png" alt="avatar" />
                                            </div>
                                            <!-- Info -->
                                            <div class="ms-2">
                                                <h6 class="mb-0">Share Bid Details</h6>
                                            </div>
                                        </div>

                                        <!-- Button -->
                                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                    </div>

                                    <!-- card body -->
                                    <form class="card-body" style="min-width: 350px;">
                                        <!-- Current password -->
                                        <div class="mb-3">
                                            <input class="form-control" :class="{ 'is-invalid': errors.mails }" placeholder="Employee/Colleague Email Address" autocomplet="off" type="text" id="recipient-name" v-model="mails" ref="mails" />
                                            <span v-if="errors.mails" class="invalid-feedback">{{ errors.mails[0] }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="email_subject"
                                                :class="{ 'is-invalid': errors.subject }"
                                                placeholder="Subject of Email"
                                                autocomplet="off"
                                                id="email_subject"
                                                v-model="sendMails.subject"
                                                ref="subject"
                                            />
                                            <span v-if="errors.subject" class="invalid-feedback">{{ errors.subject[0] }}</span>
                                        </div>

                                        <!-- New password -->
                                        <div class="mb-3">
                                            <textarea
                                                class="form-control"
                                                rows="3"
                                                name="email_message"
                                                :class="{ 'is-invalid': errors.message }"
                                                placeholder="Brief Messsage/Note"
                                                autocomplet="off"
                                                id="email_message"
                                                v-model="sendMails.message"
                                            ></textarea>
                                            <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0] }}</span>
                                        </div>
                                        <!-- Confirm -->

                                        <div class="text-end">
                                            <a href="javascript:void(0)" @click="checkEmails()" class="mybutton-secondary2">Send</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer m-foot"></div>
                </div>
            </div>
        </div>
    </teleport>

    <!-- <div class="modal fade" id="savesearch" tabindex="-1" aria-labelledby="exampleModalLabel11" ref="Subscribemodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel11">Save Search</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="field-wrapper">
                        <div class="field-placeholder">Alert Label {{savesearch.id }} <span class="text-danger">*</span></div>
                        <input class="form-control" type="text" placeholder="Name" :class="{'is-invalid': errors.alert_label}" v-model="savesearch.alert_label" ref="alert_label" />
                        <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" ref="Close">
                        Close
                    </button>
                    <button type="button" v-if="statussearch" class="btn btn-primary" @click="saveSearch()">
                        Save
                    </button>
                    <button type="button" v-else class="btn btn-primary" @click="updateSearch()">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div> -->
    <teleport to="#modals" v-disabled="!sharebid" v-if="sharebid">
        <div class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <div class="card border">
                            <!-- Card body START -->
                            <div class="card-body vstack gap-4">
                                <!-- Traveler item START -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header d-flex justify-content-between align-items-center p-0">
                                        <!-- Avatar -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm">
                                                <img class="avatar-img" src="assets/images/mail.png" alt="avatar" />
                                            </div>

                                            <div class="ms-2">
                                                <h6 class="mb-0">Share Bid Detail</h6>
                                            </div>
                                        </div>

                                        <!-- Button -->
                                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                    </div>

                                    <!-- card body -->
                                    <form class="card-body" style="min-width: 350px;">
                                        <!-- Current password -->
                                        <div class="mb-3">
                                            <input class="form-control" :class="{ 'is-invalid': errors.mails }" placeholder="Employee/Colleague Email Address" autocomplet="off" type="text" id="recipient-name" v-model="mails" ref="mails" />
                                            <span v-if="errors.mails" class="invalid-feedback">{{ errors.mails[0] }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="email_subject"
                                                :class="{ 'is-invalid': errors.subject }"
                                                placeholder="Subject of Email"
                                                autocomplet="off"
                                                id="email_subject"
                                                v-model="shareBid.subject"
                                                ref="subject"
                                            />
                                            <span v-if="errors.subject" class="invalid-feedback">{{ errors.subject[0] }}</span>
                                        </div>

                                        <!-- New password -->
                                        <div class="mb-3">
                                            <textarea
                                                class="form-control"
                                                rows="3"
                                                name="email_message"
                                                :class="{ 'is-invalid': errors.message }"
                                                placeholder="Brief Messsage/Note"
                                                autocomplet="off"
                                                id="email_message"
                                                v-model="shareBid.message"
                                            ></textarea>
                                            <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0] }}</span>
                                        </div>
                                        <!-- Confirm -->

                                        <div class="text-end">
                                            <a href="javascript:void(0)" @click="shareMail()" class="mybutton-secondary2">Send</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer m-foot"></div>
                </div>
            </div>
        </div>
    </teleport>
 <teleport to="#modals" v-disabled="!userModal" v-if="userModal">
        <div class="modal-overlay">
            <div class="">
                <div class="">
                    <div class=""></div>
                    <div class="">
                        <LoginModal @closeModal="closemodal" ref="login_modal" v-if="login_modal" />
                     
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
            </div>
        </div>
    </teleport>
    <div class="modal fade" id="detailModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-header pt-0 d-sm-flex justify-content-sm-between align-items-center">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <h6 class="fw-normal mb-0">SERVICE CODES</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- <a class="me-2 dotted">cancel</a> -->
                        <a class="btn btn-sm btn-primary px-2" style="padding: 5px; font-weight:400" href="javascript:void(0)" data-bs-dismiss="modal" @click="applyFilterPsc()">APPLY FILTER</a>
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="tab-content mb-0" id="flight-pills-tabContent">
                        <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                            <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                <div class="col-md-8 small">
                                    <form class="position-relative">
                                        <input class="form-control form-control-sm pe-5 myinput" type="search" placeholder="Search in Serive Codes" aria-label="Search" v-model="service_code.search" @keypress.enter="getServiceCodes()" />
                                        <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="getServiceCodes()"><i class="fas fa-search fs-6"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-4 small d-flex">
                                    <!-- <div class="search-left1 me-2"><a class="my-auto me-2 dotted">show selected</a></div> -->
                                    <div><a class="my-auto dotted" href="javascript:void(0)" @click="deselectPsc()">deselect checked</a></div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body p-0" style="overflow: scroll; height: 300px;">
                                    <ul class="listremove pl-8">
                                        <li>
                                            <ul id="demo" style="padding:0px;">
                                                <PscTree class="item" :item="service_codes" :tdr_psc="searchfilter.tdr_psc"> </PscTree>
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
    <div class="modal fade" id="flightdetail" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-header pt-0 d-sm-flex justify-content-sm-between align-items-center">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <h6 class="fw-normal mb-0">NAICS CODES</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <a class="btn btn-sm btn-primary px-2" style="padding: 5px; font-weight:400" href="javascript:void(0)" data-bs-dismiss="modal" @click="applyFilterNaics()">APPLY FILTER</a>
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="tab-content mb-0" id="flight-pills-tabContent ">
                        <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                            <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                <div class="col-md-8 small">
                                    <form class="position-relative">
                                        <input class="form-control form-control-sm pe-5 myinput" type="search" placeholder="Search in Naics Codes" aria-label="Search" v-model="naics_code.search" @keypress.enter="getNaics()" />
                                        <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="getNaics()"><i class="fas fa-search fs-6"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-4 small d-flex">
                                    <!-- <div class="search-left1 me-2"><a class="my-auto me-2 dotted" href="javascript:void(0)">show selected</a></div> -->
                                    <div><a class="my-auto dotted" style="color: #40a4f1;" href="javascript:void(0)" @click="deselectNaics()">deselect checked</a></div>
                                </div>
                                <!-- <div  class="col-md-8 small">
                                     <label class="cv-catalog-list-item__label-checkbox"><input type="checkbox" class="cv-catalog-list-item__checkbox" /><span class="cv-catalog-list-item__fake-checkbox"></span></label>
                                </div> -->
                            </div>
                            <div class="card" style="overflow: scroll; height: 300px;">
                                <div class="card-body p-0">
                                    <ul class="listremove pl-8">
                                        <li>
                                            <ul id="demo" style="padding-left:0px;">
                                                <TreeItem class="item" :item="treeData" :tdr_naics="searchfilter.tdr_naics"> </TreeItem>
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

   <teleport to="#modals" v-disabled="!alertSubscribe" v-if="alertSubscribe">
        <div class="modal-overlay">
            <div id="popup1" class="confirm">
                <div class="">
                    <h1>Alert</h1>
                    <p>Please SUBSCRIBE !</p>
                    <button @click.prevent="closemodal()">Close</button>
                    
                </div>
              
            </div>
        </div>
    </teleport>
    <teleport to="#modals" v-disabled="!sharealertmodal" v-if="sharealertmodal">
        <div class="modal-overlay">
            <div id="popup1" class="confirm">
                <div class="">
                    <h1>Alert</h1>
                    <p>Please Select Bid!</p>
                    <button @click.prevent="closemodal()">Close</button>
                </div>
                <!-- <a href="#" @click.prevent="closemodal()" class="close remunderline">&times;</a>
              

                <div style="text-center: center;">
                    <h6 style="text-align: center; color: red !important; margin-top: 15px;">
                        Please Select Bid!
                    </h6>
                </div> -->
            </div>
        </div>
    </teleport>
</template>

<script>
    import Pagination from "@/components/Pagination.vue";
    import Vue3TagsInput from "vue3-tags-input";
    import Skeleton from "@/components/Skeleton.vue";
    import TreeItem from "@/components/TreeItem.vue";
    import PscTree from "@/components/PscTree.vue";
    import moment from "moment";
    import DatePicker from "@jobinsjp/vue3-datepicker";
    import "@jobinsjp/vue3-datepicker/index.css";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    import LoginModal from "@/components/LoginModal";
    export default {
        name: "Home",
        components: { Loading, DatePicker, Pagination, Vue3TagsInput, TreeItem, PscTree,LoginModal, Skeleton },
        data() {
            return {
                userModal:false,
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
                selectedNaicses: [],
                childItems: [],
                errors: [],
                regions: [],
                fedraldocuments: [],
                bids: [],
                filters: [],
                StateOppotunities: [],
                selectedFederal: [],
                selectedcategory: [],
                selectAllcategory: false,
                sharealertmodal: false,
                searchagencycategory: "",
                selectedStateAgency: [],
                selectAllStateAgency: false,
                selectedState: [],
                selectAllState: false,
                tags: [],
                tag: "",
                countrys: [],
                listview: true,
                gridview: false,
                alertmodal: false,
                emailmodal: false,
                sharebid: false,
                alertSubscribe: false,
                state_country: [],
                state_country1: [],
                agencyFederal: [],
                categorys: [],
                agencyState: [],
                tender_type: [],
                savedserachbids: [],
                asideStatus: [],
                sideStatus: [],
                awards: [],
                selected: [],
                stateSelected: [],
                searchstate: "",
                search_federal_agency: "",
                searchfederal: "",
                liststate: {
                    country_id: [10],
                },
                listcountry: {
                    country_id: [],
                },
                selectAll: false,
                stateselectAll: false,
                mails: "",
                sendMails: {
                    bids: [],
                    mails: [],
                    email: "rupam@aeriesys.com",
                    subject: "",
                    bid_or_doc: "bid",
                    region_id: "",
                },
                shareBid: {
                    bids: [],
                    mails: [],
                    email: "rupam@aeriesys.com",
                    subject: "",
                    message: "",
                    bid_or_doc: "bid",
                    region_id: "",
                },
                statussearch: true,
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
                    naics_id: "111,112,113",
                    notice_type: "",
                    psc: "",
                    set_aside_status: "",
                    agency_fedral: "",
                    created_on: "",
                    updated_on: "",
                },
                statecount: 0,
                agencycount: 0,
                categorycount: 0,
                state_agency_count: 0,
                savedserach: {
                    user_id: "",
                    region_id: "",
                    id: "",
                },
                searchfilter: {
                    region_id: 2,
                    keywords: "",
                    tdr_type: [],
                    tdr_type_of_award: [],
                    tdr_set_aside_status: [],
                    tdr_state: [],
                    tdr_notice: [],
                    tdr_category: [],
                    tdr_country: [],
                    tdr_naics: [],
                    tdr_psc: [],
                    tdr_status: [],
                    tdr_agency: [],
                    response_date: "",
                    posted_date: "",
                },
                agency_name: "Federal Agency",
                meta: {
                    search: "",
                    order_by: "asc",
                    field: "",
                    per_page: 15,
                    totalRows: 0,
                    currentPage: 1,
                    lastPage: 1,
                    from: 1,
                    maxPage: 1,
                    to: "",
                },
                naics_code: {
                    search: "",
                },
                hidecartstatue: false,
                service_code: {
                    search: "",
                },
                isLoading: false,
                fullPage: false,
            };
        },
        mounted() {
            this.getfedralDocument();
            this.getRegion();
            this.getCountry();
            this.callFunction();
            this.checklogin();
            this.getNaics();
            this.hideCart();
        },
        computed: {
            getFilterCount() {
                let vm = this;
                let count = 0;
                if (vm.searchfilter.tdr_notice.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.tdr_agency.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.tdr_state.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.tdr_type.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.tdr_type_of_award.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.tdr_set_aside_status.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.tdr_category.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.tdr_naics.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.tdr_status.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.response_date.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.posted_date.length != 0) {
                    ++count;
                }
                if (vm.searchfilter.keywords != "") {
                    ++count;
                }

                return count;
            },
        },
        methods: {
            bidsdetails(bidsdetail) {
                this.$store.commit("setBidsDetails", bidsdetail);
                if (bidsdetail.tdr_region == 2) {
                    this.$router.push("/bids/" + "federal-opportunities" + "/" + bidsdetail.tdr_title.replace(/\//g, "") + "-" + bidsdetail.tdr_no);
                }
                if (bidsdetail.tdr_region == 1) {
                    this.$router.push("/bids/" + "state-opportunities" + "/" + bidsdetail.tdr_title.replace(/\//g, "") + "-" + bidsdetail.tdr_no);
                }
                if (bidsdetail.tdr_region == 3) {
                    this.$router.push("/bids/" + "private-commercial-opportunities" + "/" + bidsdetail.tdr_title.replace(/\//g, "") + "-" + bidsdetail.tdr_no);
                }
                if (tdr_region == 4) {
                    this.$router.push("/bids/" + "international-opportunities" + "/" + bidsdetail.tdr_title.replace(/\//g, "") + "-" + bidsdetail.tdr_no);
                }
            },
            highlight(title) {
                if (!this.searchfilter.keywords) {
                    return title;
                }
              
                // let keywords_arr = this.searchfilter.keywords.split(",");
                let keywords_arr = this.searchfilter.keywords.split(",") ? this.searchfilter.keywords.split(",") : [];
                keywords_arr.map(function (element) {
                    title = title.replace(new RegExp(element, "gi"), (match) => {
                        return '<span style="background:yellow">' + match + "</span>";
                    });
                });
                return title;
            },
            handleSelectedTag(tag) {
                 if (this.tag === "") {
                    return true;
                }
                this.tags.push(tag);
                this.removeDuplicates();
                this.searchfilter.keywords = this.tags;
                this.tag = "";
                this.getfedralDocument();
            },
            applyFilterNaics() {
                let vm = this;
                let sub_filtes = [];
                if (Array.isArray(this.$store.getters.selected_naicses) && this.$store.getters.selected_naicses.length) {
                    this.searchfilter.tdr_naics = this.$store.getters.selected_naicses;
                    if (this.searchfilter.tdr_naics.length) {
                        sub_filtes = vm.filters.filter(function (element) {
                            return element.table != "tdr_naics";
                        });
                        sub_filtes.push({
                            table: "tdr_naics",
                            id: "naics_code_" + this.searchfilter.tdr_naics.length,
                            name: "NAICS Code :" + this.searchfilter.tdr_naics.length,
                        });
                        this.filters = sub_filtes;
                    } else this.searchfilter.tdr_naics = [];
                }
                this.getfedralDocument();
            },
            applyFilterPsc() {
                let vm = this;
                let sub_filtes = [];
                if (Array.isArray(vm.$store.getters.selected_psces) && vm.$store.getters.selected_psces.length) {
                    vm.searchfilter.tdr_psc = vm.$store.getters.selected_psces;
                    if (vm.searchfilter.tdr_psc.length) {
                        sub_filtes = vm.filters.filter(function (element) {
                            return element.table != "tdr_psc";
                        });
                        sub_filtes.push({
                            table: "tdr_psc",
                            id: "psc_code_" + vm.searchfilter.tdr_psc.length,
                            name: "PSC Code :" + vm.searchfilter.tdr_psc.length,
                        });
                        vm.filters = sub_filtes;
                    } else vm.searchfilter.tdr_psc = [];
                }
                this.getfedralDocument();
            },
            handleChangeTag(tags) {
                let vm = this;
                vm.tags = tags;
                vm.searchfilter.keywords = vm.tags;
                vm.getfedralDocument();
            },
            checklogin() {
                let vm = this;
                if (vm.$store.state.user == null) {
                    return false;
                } else {
                    vm.getSavedsearch();
                }
            },
            getNaics() {
                let vm = this;
                //vm.isLoading = true
                // vm.isLoading= true
                //  vm.fullPage= true
                vm.$store
                    .dispatch("post", { uri: "getNaics", data: vm.naics_code })
                    .then(function (response) {
                        //    vm.isLoading= false
                        //    vm.fullPage= false;
                        vm.treeData.children = response.data.data;
                        vm.getServiceCodes();
                    })
                    .catch(function (error) {
                        //    vm.isLoading= false
                        //    vm.fullPage= false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getServiceCodes() {
                let vm = this;

                //vm.isLoading = true
                // vm.isLoading= true
                //  vm.fullPage= true;
                vm.$store
                    .dispatch("post", { uri: "getPsc", data: vm.service_code })
                    .then(function (response) {
                        // vm.isLoading= false
                        // vm.fullPage= false;
                        vm.service_codes.children = response.data.data;
                    })
                    .catch(function (error) {
                        // vm.isLoading= false
                        // vm.fullPage= false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            callFunction: function () {
                var currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
                // console.log(currentDateWithFormat);
                this.savesearch.created_on = currentDateWithFormat;
                this.savesearch.updated_on = currentDateWithFormat;
            },
            currentDate() {
                let now = moment();
                return now.format("YYYY-MM-DD");
            },
            dateFormat(value) {
                //  moment(value).format('YYYY-MM-DD');
                return moment(value).format("ll");
            },
            showregion(region) {
                this.searchfilter.region_id = region.region_id;
                this.meta.currentPage = 1;
                if(region.region_id==2) {
                    this.getNotice(2)
                }
                else {
                    this.getNotice('')
                }
                this.getfedralDocument();
            },
              datecalcu(startDate, endDate) {
                var newstartDate = moment(startDate, "YYYY-MM-DD");
                var endendDate = moment(endDate, "YYYY-MM-DD");
                var dayDiff = newstartDate.diff(endendDate, "days");
                return dayDiff;
            },

            getNotice(region_id) {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getNotice?region_id="+region_id })
                    .then(function (response) {
                        vm.search_notice = response.data.data;
                        vm.getStateAgency();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            showresponsedate() {
                this.status1 = true;
            },
            getRegion() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getRegion" })
                    .then(function (response) {
                        vm.regions = response.data.data;
                        vm.getNotice(2);
                        vm.getTender();
                        vm.getSate();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            filterState() {
                if (this.searchstate == "") {
                    this.state_country = this.allFilterState;
                }
                this.state_country = this.allFilterState.filter((entry) => {
                    return entry.state_name.toLowerCase().includes(this.searchstate.toLowerCase());
                });
            },
            filterCountryState() {
                if (this.searchstate1 == "") {
                    this.state_country1 = this.allFilterState;
                }
                this.state_country1 = this.allFilterState.filter((entry) => {
                    return entry.state_name.toLowerCase().includes(this.searchstate1.toLowerCase());
                });
            },
            filterAgency() {
                if (this.searchFederal == "") {
                    this.agencyFederal = this.allFilterAgency;
                }
                this.agencyFederal = this.allFilterAgency.filter((entry) => {
                    return entry.agency_name.toLowerCase().includes(this.searchFederal.toLowerCase());
                });
            },

            getCountry() {
                let vm = this;
                vm.searchfilter.tdr_country = vm.liststate.country_id;
                //  alert(vm.searchfilter.tdr_country)
                vm.$store
                    .dispatch("post", { uri: "getCountry" })
                    .then(function (response) {
                        vm.countrys = response.data.data;
                        //    vm.getfedralDocument();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getSate() {
                let vm = this;
                let uri = "getState";
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.liststate })
                    .then(function (response) {
                        vm.state_country = response.data.data;
                        vm.statecount = vm.state_country.length;
                        vm.allFilterState = vm.state_country;
                        vm.testdatastate = vm.state_country;
                        vm.getfederalAgency();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
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
                        vm.DeselectCountryState();
                        vm.getfedralDocument();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getfederalAgency() {
                let vm = this;
                let uri = "getAgencyFederal";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.agencyFederal = response.data.data;
                        vm.agencycount = vm.agencyFederal.length;
                        vm.allFilterAgency = vm.agencyFederal;
                        vm.getcategory();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getAward() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getTypeOfAward" })
                    .then(function (response) {
                        vm.awards = response.data.data;
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
                        vm.getcategory();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
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
            checkCartItem(tdr_id) {
                let items = this.$store.getters.cartItems;
                if (items && items.length != 0) {
                    let item = items.find((items) => items.tdr_id === tdr_id);
                    if (item) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            },
            getfedralDocument() {
                let vm = this;
                vm.searchfilter.keywords = vm.tags.toString();

                if (vm.searchfilter.region_id == 1) {
                    vm.uri = "docSearchBidsForStateOppotunities?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;
                }
                if (vm.searchfilter.region_id == 2) {
                    vm.uri = "docSearchBidsForFedralOppotunities?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;
                }
                if (vm.searchfilter.region_id == 3) {
                    vm.uri = "docSearchBidsForPrivateOrCommercial?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;
                }
                if (vm.searchfilter.region_id == 4) {
                    vm.searchfilter.tdr_country = [];
                    vm.uri = "docSearchBidsForInternationalOppotunities?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;
                }
                vm.isLoading = true;
                vm.fullPage = false;

                //vm.isLoading = true
                vm.$store
                    .dispatch("post", { uri: this.uri, data: vm.searchfilter })
                    .then(function (response) {
                        vm.isLoading = false;

                        vm.bids = response.data.data;
                        vm.meta.totalRows = response.data.meta.total;
                        vm.meta.lastPage = response.data.meta.last_page;
                        vm.meta.from = response.data.meta.from;
                        vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                        vm.meta.to = response.data.meta.to;
                        vm.meta.currentPage = response.data.meta.current_page;
                        if (vm.meta.currentPage > vm.meta.lastPage) {
                            vm.meta.currentPage = vm.meta.lastPage;
                        }
                        
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            saveNotice(notice) {
                let i = this.filters.findIndex((data) => data.id === notice.notice_id);

                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getfedralDocument();
                } else {
                    this.filters.push({
                        table: "notice",
                        id: notice.notice_id,
                        name: notice.notice_type,
                    });

                    this.getfedralDocument();
                }
            },
            listviewgrid() {
                this.listview = false;
                this.gridview = true;
                 this.meta.per_page=28;
                this.getfedralDocument();
            },
            gridviewgrid() {
                this.listview = true;
                this.gridview = false;
                this.meta.per_page=10;
                this.getfedralDocument();
            },
            onPageChange(page) {
                this.meta.currentPage = page;
                // window.scrollTo({ top: 0, behavior: 'smooth' });
                this.getfedralDocument();
            },
            onPerPageChange() {
                this.meta.currentPage = 1;
                this.getfedralDocument();
            },
            addCart(StateOppotunitie) {
                let vm = this;
                vm.$store.commit("addTocart", StateOppotunitie);
                vm.getfedralDocument();
            },
            checkCartItem(tdr_id) {
                let items = this.$store.getters.cartItems;
                if (items && items.length != 0) {
                    let item = items.find((items) => items.tdr_id === tdr_id);
                    if (item) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            },
            SaveStatusactive(active) {
                let i = this.filters.findIndex((data) => data.name === active);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    // this.getFedral();
                    this.getfedralDocument();
                } else {
                    // this.fi.push(respdate);
                    this.filters.push({
                        table: "status",
                        id: active,
                        name: active,
                    });

                    this.getfedralDocument();
                }
            },
            SaveStatusexpried(expried) {
                let i = this.filters.findIndex((data) => data.name === expried);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getfedralDocument();
                } else {
                    // this.fi.push(respdate);
                    this.filters.push({
                        table: "statusExpried",
                        id: expried,
                        name: expried,
                    });

                    this.getfedralDocument();
                }
            },
            emailmodalpop() {
                let vm = this;
                if (vm.$store.getters.user.subscription_id == 0) {
                    vm.alertSubscribe = true;

                    setTimeout(() => (vm.alertSubscribe = false), 2000);
                } else {
                    if (vm.sendMails.bids.length === 0) {
                        vm.sharealertmodal = true;
                    } else {
                        vm.emailmodal = true;
                    }
                }
            },

            checkEmails() {
                let vm = this;
                var regExp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                vm.errors.mails = [];
                if (this.mails) {
                    var emailArray = this.mails.split(",");
                    emailArray.map(function (element) {
                        let verify_email = regExp.test(element);
                        if (!verify_email) {
                            vm.errors.mails.push("Invalid email");
                        }
                    });
                } else {
                    this.errors.mails = ["This field cannot be blank"];
                }
                if (!this.errors.mails.length) {
                    delete this.errors.mails;
                    this.sendMails.mails = this.mails.split(",");
                    this.SendMail();
                }
            },

            SendMail() {
                let vm = this;
                vm.isLoading = true;
                vm.fullPage = true;
                vm.$store
                    .dispatch("post", { uri: "sendMailWithBids", data: vm.sendMails })
                    .then(function () {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.$store.dispatch("success", "Mails Send  successfully");
                        vm.closemodal();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            closemodal() {
                let vm = this;
                vm.modal1 = false;
                vm.modal2 = false;
                vm.sharealertmodal = false;
                vm.emailmodal = false;
                vm.alertSubscribe = false;
                vm.alertmodal = false;
                vm.sharebid = false;
                 vm.userModal= false;
                vm.login_modal= false;
                vm.shareMail.bids = [];
                vm.shareMail.mails = [];
               
                vm.errors = [];
            },
            getTender() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getTenderType" })
                    .then(function (response) {
                        vm.tender_type = response.data.data;
                        vm.getAward();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            select() {
                this.selected = [];
                this.selectAll = false;
                if (!this.selectAll) {
                    this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                    for (let i in this.state_country) {
                        this.selected.push(this.state_country[i].state_id);
                        this.filters.push({
                            table: "state",
                            id: this.state_country[i].state_id,
                            name: this.state_country[i].state_name,
                        });
                    }
                    // alert(this.selected);
                    this.searchfilter.tdr_state = this.selected;
                    this.getfedralDocument();
                }
            },
            Deselect() {
                this.selected = [];
                this.searchfilter.tdr_state = [];
                this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getfedralDocument();
            },
            updateCheckall(state) {
                if (this.state_country.length == this.selected.length) {
                    this.selected = [];
                    this.selectAll = true;
                    this.searchfilter.tdr_state = this.selected;
                    this.getfedralDocument();
                    if (this.selectAll == true) {
                        this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                        for (let i in this.state_country) {
                            this.selected.push(this.state_country[i].state_id);
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
                        this.getfedralDocument();
                    } else {
                        this.filters.push({
                            table: "state",
                            id: state.state_id,
                            name: state.state_name,
                        });
                        // this.statefilter.push(state);
                        this.filters = this.filters.filter((state, index) => this.filters.indexOf(state) === index);
                        this.getfedralDocument();
                    }
                    this.selectAll = false;
                    // alert(this.selected);
                    this.searchfilter.tdr_state = this.selected;
                    this.getfedralDocument();
                    // alert(this.selected.length);
                }
            },

            // fedral agency

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
                        this.getfedralDocument();
                    } else {
                        this.filters.push({
                            table: "state",
                            id: state.state_id,
                            name: state.state_name,
                        });
                        // this.statefilter.push(state);
                        this.filters = this.filters.filter((state, index) => this.filters.indexOf(state) === index);
                        this.getfedralDocument();
                    }
                    this.stateselectAll = false;
                    // alert(this.selected);
                    this.searchfilter.tdr_state = this.stateSelected;
                    this.getfedralDocument();
                    // alert(this.selected.length);
                }
            },

            // federal search
            selectfederal() {
                this.selectedFederal = [];
                this.selectAllFederal = false;
                if (!this.selectAllFederal) {
                    this.filters.filter((x) => x.table === "agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                    for (let i in this.agencyFederal) {
                        this.selectedFederal.push(this.agencyFederal[i].agency_name);
                        //this.stateFederalfilter.push(this.agencyFederal[i]);
                        this.filters.push({
                            table: "agency",
                            id: this.agencyFederal[i].agency_id,
                            name: this.agencyFederal[i].agency_name,
                        });
                    }

                    this.searchfilter.tdr_agency = this.selectedFederal;
                    this.getfedralDocument();
                }
            },
            Deselectfederal() {
                this.selectedFederal = [];
                this.searchfilter.tdr_agency = [];
                this.stateFederalfilter = [];
                this.filters.filter((x) => x.table === "agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getfedralDocument();
            },
            updateCheckallfederal(federal) {
                if (this.agencyFederal.length == this.selectedFederal.length) {
                    this.selectAllFederal = true;
                    this.searchfilter.tdr_agency = this.selectedFederal;
                    if (this.selectAllFederal == true) {
                        this.filters.filter((x) => x.table === "agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                        for (let i in this.agencyFederal) {
                            this.selectedFederal.push(this.agencyFederal[i].agency_name);

                            this.filters.push({
                                table: "agency",
                                id: this.agencyFederal[i].agency_id,
                                name: this.agencyFederal[i].agency_name,
                            });
                        }
                    }
                } else {
                    let i = this.filters.findIndex((data) => data.name === federal.agency_name);

                    if (i !== -1) {
                        this.filters.splice(i, 1);
                        this.getfedralDocument();
                    } else {
                        this.filters.push({
                            table: "agency",
                            id: federal.agency_id,
                            name: federal.agency_name,
                        });
                        // this.statefilter.push(state);
                        this.filters = this.filters.filter((federal, index) => this.filters.indexOf(federal) === index);
                    }

                    this.selectAllFederal = false;
                    this.searchfilter.tdr_agency = this.selectedFederal;
                    this.getfedralDocument();
                    // alert(this.selected.length);
                }
            },
            // state agency

            // fedral agency
            selectState() {
                this.selectedState = [];
                this.selectAllState = false;
                if (!this.selectAllState) {
                    this.filters.filter((x) => x.table === "Agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                    for (let i in this.agencyState) {
                        this.selectedState.push(this.agencyState[i].agency_name);
                        this.filters.push({
                            table: "Agency",
                            id: this.agencyState[i].id,
                            name: this.agencyState[i].agency_name,
                        });
                    }

                    this.searchfilter.tdr_agency = this.selectedState;
                    this.getfedralDocument();
                }
            },
            DeselectState() {
                this.selectedState = [];
                this.searchfilter.tdr_agency = [];
                this.filters.filter((x) => x.table === "Agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getfedralDocument();
            },
            updateCheckallState(statefederal) {
                //this.selectedState = [];
                if (this.agencyState.length == this.selectedState.length) {
                    this.selectedState = [];
                    this.selectAllState = true;
                    this.searchfilter.tdr_agency = this.selectedState;
                    if (this.selectAllState == true) {
                        this.filters.filter((x) => x.table === "Agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                        for (let i in this.agencyState) {
                            this.selectedState.push(this.agencyState[i].agency_name);
                            this.filters.push({
                                table: "Agency",
                                id: this.agencyState[i].id,
                                name: this.agencyState[i].agency_name,
                            });
                        }
                    }

                    this.getfedralDocument();
                    // alert(this.searchfilter.tdr_state);
                } else {
                    let i = this.filters.findIndex((data) => data.name === statefederal.agency_name);
                    if (i !== -1) {
                        this.filters.splice(i, 1);
                        this.getfedralDocument();
                    } else {
                        this.filters.push({
                            table: "Agency",
                            id: statefederal.agency_id,
                            name: statefederal.agency_name,
                        });
                    }
                    this.selectAllState = false;

                    this.searchfilter.tdr_agency = this.selectedState;
                    this.getfedralDocument();
                    // alert(this.selected.length);
                }
            },
            checkResponseDate() {
                if (this.searchfilter.response_from_date == "" && this.searchfilter.response_to_date == "") {
                    return true;
                }
                if (this.searchfilter.response_from_date !== "" && this.searchfilter.response_to_date !== "") {
                    if (this.searchfilter.response_from_date > this.searchfilter.response_to_date) {
                        this.errors = { response_error: "Start Date Less then End Date" };
                    } else {
                        this.errors = [];
                        this.getfedralDocument();
                    }
                }
            },
            checkPostDate() {
                if (this.searchfilter.posted_from_date == "" && this.searchfilter.posted_to_date == "") {
                    return true;
                }
                if (this.searchfilter.posted_from_date !== "" && this.searchfilter.posted_to_date !== "") {
                    if (this.searchfilter.posted_from_date > this.searchfilter.posted_to_date) {
                        this.errors = { post_error: "Start Date Less then End Date" };
                    } else {
                        this.errors = [];
                        this.getfedralDocument();
                    }
                }
            },
            // postdate
            changeResponseDate(value) {
                let i = this.filters.findIndex((data) => data.table == "PrivateResponseDate");
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getfedralDocument();
                }
                this.filters.push({
                    table: "PrivateResponseDate",
                    id: value,
                    name: value,
                });
                this.getfedralDocument();
            },
            changePostedDate(value) {
                let i = this.filters.findIndex((data) => data.table == "PrivatePostedDate");
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getfedralDocument();
                }
                this.filters.push({
                    table: "PrivatePostedDate",
                    id: value,
                    name: value,
                });
                this.getfedralDocument();
            },

            // clear all filters

            clearAllFilters() {
                let vm = this;
                vm.searchfilter.tdr_notice = [];
                vm.searchfilter.tdr_status = [];
                vm.searchfilter.tdr_type = [];
                vm.searchfilter.tdr_type_of_award = [];
                vm.searchfilter.tdr_set_aside_status = [];
                vm.searchfilter.tdr_category = [];
                vm.searchfilter.tdr_state = [];
                vm.searchfilter.tdr_naics = [];
                vm.searchfilter.tdr_agency = [];
                vm.searchfilter.response_date = "";
                vm.searchfilter.posted_date = "";
                vm.searchfilter.posted_from_date = "";
                vm.searchfilter.posted_to_date = "";
                //response_date:"",
                vm.searchfilter.response_from_date = "";
                vm.searchfilter.response_to_date = "";
                vm.searchfilter.keywords = "";
                vm.selectedFederal = [];
                vm.selectedcategory = [];
                vm.selected = [];
                vm.filters = [];
                vm.selectedState = [];
                vm.tags = [];
                vm.hideresponsedate();
                vm.hidedate();
                vm.getfedralDocument();
            },

            //removetag
            removeTagnotice(filter) {
                let sub_filters = this.filters.filter(function (element) {
                    return element.id != filter.id;
                });
                this.filters = sub_filters;

                if (filter.table == "notice") {
                    let tdr_notice = this.searchfilter.tdr_notice.filter(function (element) {
                        return element != filter.id;
                    });
                    this.searchfilter.tdr_notice = tdr_notice;
                }

                if (filter.table == "state") {
                    let tdr_state = this.searchfilter.tdr_state.filter(function (element) {
                        return element != filter.id;
                    });
                    this.searchfilter.tdr_state = tdr_state;
                    this.selected = tdr_state;
                }

                if (filter.table == "agency") {
                    let tdr_agency = this.searchfilter.tdr_agency.filter(function (element) {
                        return element != filter.id;
                    });
                    this.searchfilter.tdr_agency = tdr_agency;
                    this.selectedFederal = tdr_agency;
                }

                if (filter.table == "tdr_naics") {
                    this.searchfilter.tdr_naics = [];
                    this.getNaics();
                }

                if (filter.table == "tdr_psc") {
                    this.searchfilter.tdr_psc = [];
                    this.getServiceCodes();
                }

                if (filter.table == "contracttype") {
                    let tdr_type = this.searchfilter.tdr_type.filter(function (element) {
                        return element != filter.id;
                    });
                    this.searchfilter.tdr_type = tdr_type;
                }

                if (filter.table == "typeofaward") {
                    let tdr_type_of_award = this.searchfilter.tdr_type_of_award.filter(function (element) {
                        return element != filter.id;
                    });
                    this.searchfilter.tdr_type_of_award = tdr_type_of_award;
                }

                if (filter.table == "setAside") {
                    let tdr_set_aside_status = this.searchfilter.tdr_set_aside_status.filter(function (element) {
                        return element != filter.id;
                    });
                    this.searchfilter.tdr_set_aside_status = tdr_set_aside_status;
                }

                if (filter.table == "PrivateResponseDate") this.searchfilter.response_date = "";
                this.searchfilter.response_from_date = "";
                this.searchfilter.response_to_date = "";

                if (filter.table == "PrivatePostedDate") this.searchfilter.posted_date = "";

                this.getfedralDocument();
            },

            // contract type
            saveContracttype(tender) {
                let i = this.filters.findIndex((data) => data.id === tender.tdr_type_id);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getfedralDocument();
                } else {
                    this.filters.push({
                        table: "contracttype",
                        id: tender.tdr_type_id,
                        name: tender.tdr_type_name,
                    });
                    this.filters = this.filters.filter((tender, index) => this.filters.indexOf(tender) === index);
                    this.getfedralDocument();
                }
            },
            // type of award

            SaveTypeofAward(award) {
                let i = this.filters.findIndex((data) => data.id === award.type_of_award_id);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    // this.getFedral();
                    vm.getfedralDocument();
                } else {
                    this.filters.push({
                        table: "typeofaward",
                        id: award.type_of_award_id,
                        name: award.type_of_award_name,
                    });

                    this.getfedralDocument();
                }
            },

            // set-aside
            SaveSetAside(sideStatu) {
                let i = this.filters.findIndex((data) => data.id === sideStatu.status_id);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getfedralDocument();
                } else {
                    this.filters.push({
                        table: "setAside",
                        id: sideStatu.status_id,
                        name: sideStatu.status_name,
                    });
                    this.getfedralDocument();
                }
            },

            // getstateagency
            getStateAgency() {
                let vm = this;
                let uri = "getAgency";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.agencyState = response.data.data;
                        vm.state_agency_count = vm.agencyState.length;
                        vm.allFilterAgency = vm.agencyState;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            // category list//
            selectCategory() {
                this.selectedcategory = [];
                this.selectAllcategory = false;
                if (!this.selectAllcategory) {
                    this.filters.filter((x) => x.table === "Category").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                    for (let i in this.categorys) {
                        this.selectedcategory.push(this.categorys[i].category_id);
                        this.filters.push({
                            table: "Category",
                            id: this.categorys[i].category_id,
                            name: this.categorys[i].category_name,
                        });
                    }

                    this.searchfilter.tdr_category = this.selectedcategory;
                    this.getfedralDocument();
                }
            },
            DeselectCategory() {
                this.selectedcategory = [];
                this.searchfilter.tdr_category = [];
                this.filters.filter((x) => x.table === "Category").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getfedralDocument();
            },
            updateCheckallCategory(category) {
                if (this.categorys.length == this.selectedcategory.length) {
                    this.selectedcategory = [];
                    this.selectAllcategory = true;
                    this.searchfilter.tdr_category = this.selectedcategory;
                    if (this.selectAllcategory == true) {
                        this.filters.filter((x) => x.table === "Category").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                        for (let i in this.categorys) {
                            this.selectedcategory.push(this.categorys[i].category_id);
                            this.filters.push({
                                table: "Category",
                                id: this.categorys[i].category_id,
                                name: this.categorys[i].category_name,
                            });
                        }
                    }

                    this.getfedralDocument();
                } else {
                    let i = this.filters.findIndex((data) => data.id === category.category_id);
                    if (i !== -1) {
                        this.filters.splice(i, 1);
                        this.getfedralDocument();
                    } else {
                        this.filters.push({
                            table: "Category",
                            id: category.category_id,
                            name: category.category_name,
                        });
                    }
                    this.selectAllcategory = false;

                    this.searchfilter.tdr_category = this.selectedcategory;
                    this.getfedralDocument();
                }
            },

            getSavedsearch() {
                let vm = this;
                vm.savedserach.user_id = vm.$store.getters.user.id;
                vm.savedserach.region_id = vm.searchfilter.region_id;
                // alert(vm.savesearch.region_id);
                let uri = "getSaveBids";
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.savedserach })
                    .then(function (response) {
                        vm.savedserachbids = response.data.data;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
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
                //vm.savesearch.agency_fedral = vm.searchfilter.tdr_agency;
                vm.savesearch.agency_fedral = vm.searchfilter.tdr_agency.toString();
                // alert(vm.savesearch.agency_fedral);
                vm.savesearch.tdr_type = vm.searchfilter.tdr_type.toString();
                vm.savesearch.tdr_type_of_award = vm.searchfilter.tdr_type_of_award.toString();
                vm.savesearch.country_id;
                vm.savesearch.region_id = vm.searchfilter.region_id;
                vm.savesearch.created_on;
                vm.savesearch.updated_on;
                //  vm.
                // vm.savesearch.psc= vm.searchfilter.tdr

                vm.isLoading = true;
                vm.fullPage = true;
                vm.$store
                    .dispatch("post", { uri: "addSaveBids", data: vm.savesearch })
                    .then(function () {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.$store.dispatch("success", "Bids Saved successfully");
                        vm.$refs.Close.click();
                        // vm.getSavedsearch();
                        // window.location.reload();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            shareBidDocument(share) {
                let vm = this;
                vm.errors = [];
                vm.shareBid.bids = [];
                vm.shareBid.mails = [];
                vm.shareBid.bids.push(share.tdr_id);
                if (vm.$store.getters.user.subscription_id == 0) {
                    vm.alertSubscribe = true;

                    setTimeout(() => (vm.alertSubscribe = false), 2000);
                } else {
                    if (vm.$store.getters.user == null) {
                        vm.userlogin = true;
                    } else {
                        vm.sharebid = true;
                    }
                }
            },
            shareMailbids() {
                let vm = this;
                vm.shareBid.region_id = vm.searchfilter.region_id;
                vm.shareBid.mails = vm.mails.split(",");
                if (vm.shareBid.mails[0] == "") {
                    vm.shareBid.mails.splice(0);
                } else {
                    vm.shareBid.mails = vm.mails.split(",");
                }
                vm.isLoading = true;
                vm.fullPage = true;
                vm.$store
                    .dispatch("post", { uri: "sendMailWithBids", data: vm.shareBid })
                    .then(function () {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.$store.dispatch("success", "Share Bids successfully");
                        vm.closemodal();
                        vm.shareBid.bids = [];
                        vm.shareBid.mails = [];
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
          
            login() {
                let vm = this;
                vm.isLoading = true;
                vm.fullPage = true;
                vm.$store
                    .dispatch("auth", { uri: "login", data: vm.user })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.$store.dispatch("success", "Successfuly logged in");
                        vm.$store.dispatch("setUser", response.data);
                        vm.$router.push("/bids/documents");
                        vm.userlogin = false;
                        vm.errors = [];
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            hideCart() {
                let vm = this;
                if (vm.$store.getters.user?.subscription_id === 0 || vm.$store.getters.user === null) {
                    vm.hidecartstatue = true;
                } else {
                    vm.hidecartstatue = false;
                }
            },
            showModal() {
                this.userModal = true;
          
                 if(this.$store.getters.user?.subscription_id ===0){
                    this.alertSubscribe = true;
                    this.userModal = false;
                }else{
                         if (this.$store.getters.user == null) {
                    this.login_modal = true;
                         }
                }
               
            },
        },
    };
</script>
<style scoped>
    /* bids*/
    /* bids*/
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
    /* bids*/
    .w-15px {
        width: 15px;
    }
    .scroll1 {
        position: relative;
        height: 150px;
        overflow: hidden;
        overflow-y: scroll;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px;
    }

    /* Handle */
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

    .scroll3 {
        position: relative;
        height: 350px;
        overflow: hidden;
        overflow-y: scroll;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px;
    }

    /* Handle */
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
        transition: all 0.5s ease-in-out;
        transition: background 0.3s ease-in;
        background: rgba(255, 255, 255, 0.9);
        opacity: 100;
        transition: opacity 0.5s, visibility 0s linear 0.5s;
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
    /* .modal-content {
      
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        min-height: 200px;
        width: 480px;
        margin: 1rem;
        position: relative;
        min-width: 200px;
        box-shadow: 0 3px 6px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 23%);
        justify-self: center;
        transition: all 5s ease-in-out;
    } */
    .col-red {
        color: red;
    }
    .limited-text {
        display: -webkit-box;
        overflow: hidden;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .mybutton-success {
        background: rgb(28, 184, 65);
        /* this is a green */
    }
    .mybutton-secondary {
        /* background: rgb(66, 184, 221); */
        background: #40a4f1;
        border-color: transparent;
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        /* this is a light blue */
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
    .listremove {
        list-style-type: none;
    }
    .table-responsive {
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch;
    }
    /* alert box */

   
    
    .mybutton-secondary2 {
        /* background: rgb(66, 184, 221); */
        background: #5143d9;
        border-color: transparent;
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        padding: 10px;
    }
    /* input tag */
    .tag-center{
        align-items:center!important;
    }
    /* width */
    .scrollinput ::-webkit-scrollbar {
        width: 3px !important;
        height: 5px !important;

        cursor: pointer !important;
    }

    /* Track */
    .scrollinput::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px !important;
    }

    /* Handle */
    .scrollinput ::-webkit-scrollbar-thumb {
       background-color: rgb(244, 238, 238)!important;
        border-radius: 10px !important;
    }

     .v3ti--focus {
        /* border:0px solid gray  */
        box-shadow: 0 0 0 0px #000000;
        border-color: #9ca3af;
    }
      .hgt-250{
        height:250px;
    }
    .pl-8{
        padding-left:8px;
    }
    .col-green{color:green

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
        position: fixed;
        /* top: 50%;
  left: 50%; */
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        min-width: 280px;
        max-width: 500px;
        height: auto;
        background: white;
        border-radius: 10px;
        padding: 0;
        margin: 0;
        border-top: 1px solid white;
        animation: fade 0.3s ease 1 forwards;
        z-index: 99999;
    }
    .confirm h1 {
        text-align: left;
        font-size: 1.2rem;
        margin: 1.5rem 1rem 0.5rem;
    }
    .confirm p {
        text-align: center;
        font-size: 1rem;
        margin: 0 2rem 4.5rem;
        color: red;
    }
    .confirm button {
        /* background: transparent; */
        background:white;
        border: none;
        color: #1678e5;
        height: 3rem;
        font-size: 1rem;
        width: 100%;
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
        background: white;
    }
    .confirm button:active {
        background:white;
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
        /* transition: all 0.5s ease-in-out;
        transition: background 0.3s ease-in; */
        background: rgb(255, 255, 255);
        /* opacity: 100; */
        /* transition: opacity 0.5s, visibility 0s linear 0.5s; */
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
    .highlight {
        color: yellow!important;
    }
    .highlightText {
        background: yellow!important;
    }

</style>
