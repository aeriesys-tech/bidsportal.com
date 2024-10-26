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
                    <router-link to="/bids/international-opportunities" class="nav-link active">
                        <img class="icon" src="@/assets/icons/internationalblue.svg" alt="icon" />
                        International Opportunities
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bids/documents" class="nav-link">
                        <img class="icon" src="@/assets/icons/documentwhite.svg" alt="icon" />
                        Document Search
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
    <div class="search">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 d-flex justify-content-between search-left my-auto">
                    <div class="label">Filters</div>
                    <div class="empty" :class="{ bluetextclass: getFilterCount }">{{ getFilterCount }} filters selected</div>
                </div>
                <div class="col-md-4 my-auto">
                    <form class="bg-body shadow rounded-2">
                        <div class="input-group input-group-sm">
                            <vue3-tags-input class="form-control form-control-sm p-0 tag-center scrollinput" :add-tag-on-keys="[13,188]" @on-tags-changed="handleChangeTag" placeholder="Input keywords separated by comma" v-model:tags="tags" v-model="tag" @allow-duplicates="false" style="text-wrap: nowrap;" />
                            <span class="input-group-text p-0 bg-transparent"> <button class="btn btn-sm" @click.prevent="handleSelectedTag(tag)" type="button" id="button-addon2">Search</button> </span>
                        </div>
                    </form>
                </div>
                <!-- <div class="col-md-4 my-auto text-end text-sm-end justify-content-between"> -->
                <div class="col-md-5 my-auto text-end text-sm-end">
                    <ul class="list-inline hstack flex-wrap gap-4 mb-0 s-dropdown dropdown" style="float: right;">
                        <li class="list-inline-item mb-0" v-if="tags.length !==0">
                            <a href="javascript:void(0)" style="color: #747579;" @click.prevent="showModal()"><i class="fa fa-save fa-fw fs-6 text-primary me-1"></i>Save Search</a>
                        </li>
                        <li class="list-inline-item mb-0">
                            <a href="javascript:void(0)" style="color: #747579;" data-bs-toggle="modal" @click.prevent="setAletModal()"><i class="fa fa-bell fa-fw fs-6 text-dark me-1"></i>Set Alert</a>
                        </li>
                        <li class="cursor list-inline-item mb-0 s-dropdown dropdown hover1 mb-0 dropdown-toggle" href="#" id="demoMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-save fa-fw text-success me-1"></i>Saved search

                            <ul class="s-dropdown-content dropdown-menu dphover" style="max-height: 200px; overflow-y: scroll;" aria-labelledby="demoMenu">
                                <li v-for="savedbids in savedserachbids" :key="savedbids.id" class="dropdown-item dropitem1 p-0 px-2">
                                    <i class="fas fa-caret-right text-primary my-auto"></i>
                                    <a class="dropdown-item dropitem2" href="#" @click.prevent="runSearch(savedbids)">{{ savedbids.alert_label }}</a>
                                    <a href="#" class="icon red my-auto" @click.prevent="deleteSearch(savedbids.id)">
                                        <i class="fa fa-trash text-danger blueicon" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="list-inline-item mb-0">
                            <a href="" @click.prevent="gridviewgrid()"> <i :class="{ gridblockcolor: gridview }" class="fa fa-th-large me-3"></i></a>
                            <a href="" @click.prevent="listviewgrid()"><i :class="{ gridblockcolor: listview }" class="fa fa-bars me-1"></i></a>
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
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#status" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2">Status</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="status">
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="active" value="active" @change="SaveStatusactive('active')" v-model="searchfilter.tdr_status" />
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="inactive" value="expired" @change="SaveStatusexpried('expired')" v-model="searchfilter.tdr_status" />
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                </div>
                            </div>
                            <!-- status END -->
                            <hr class="my-0" />

                            <!-- Notice Type -->
                            <div class="card card-body rounded-0 p-2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#noticetype" role="button" aria-expanded="false" aria-controls="status">
                                    <h6
                                        style="font-size: 15px; font-weight: normal;"
                                        class="mb-2"
                                        :class="{
                                                bluetextclass: searchfilter.tdr_notice.length !== 0,
                                            }"
                                    >
                                        Notice Type
                                    </h6>

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
                            <div class="card card-body rounded-0 p-2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#posted" role="button" aria-expanded="false" aria-controls="response">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.posted_date.length !==0}">Posted Date</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show mb-3" id="posted">
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hour6" id="hour6" v-model="searchfilter.posted_date" value="24 Hours" @click="hidedate()" @change="changePostedDate('24 Hours')" />
                                            <label class="form-check-label" for="hour6">24 Hours</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour7" name="hour7" v-model="searchfilter.posted_date" value="2 Days" @click="hidedate()" @change="changePostedDate('2 Days')" />
                                            <label class="form-check-label" for="hour7">2 Days</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour8" name="hour8" v-model="searchfilter.posted_date" value="7 Days" @click="hidedate()" @change="changePostedDate('7 Days')" />
                                            <label class="form-check-label" for="hour8">7 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour9" name="hour9" v-model="searchfilter.posted_date" value="21 Days" @click="hidedate()" @change="changePostedDate('21 Days')" />
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
                                                    <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD" v-model:value="searchfilter.posted_from_date" :clearable="false" @change="checkPostDate()"></date-picker>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">End Date<span class="text-danger">*</span></label>
                                                    <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD" v-model:value="searchfilter.posted_to_date" :clearable="false" @change="checkPostDate()"></date-picker>
                                                </div>
                                            </div>

                                            <span v-if="errors.post_error" style="color: #dc3545;">{{ errors.post_error }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
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
                                            <input class="form-check-input" type="radio" name="hour1" id="hour1" v-model="searchfilter.response_date" value="24 Hours" @click="hideresponsedate()" @change="changeResponseDate('24 Hours')" />
                                            <label class="form-check-label" for="hour1">24 Hours</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour2" name="hour2" v-model="searchfilter.response_date" value="2 Days" @click="hideresponsedate()" @change="changeResponseDate('2 Days')" />
                                            <label class="form-check-label" for="hour2">2 Days</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour3" name="hour3" v-model="searchfilter.response_date" value="7 Days" @click="hideresponsedate()" @change="changeResponseDate('7 Days')" />
                                            <label class="form-check-label" for="hour3">7 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour4" name="hour4" v-model="searchfilter.response_date" value="21 Days" @click="hideresponsedate()" @change="changeResponseDate('21 Days')" />
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
                            <div class="card card-body rounded-0 p-2">
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
                                                <input class="form-check-input" type="checkbox" :id="category.category_id + 'category'" :value="category.category_id" v-model="selectedcategory" @change="updateCheckallCategory(category)" />
                                                <label class="form-check-label" :for="category.category_id + 'category'"> {{ category.category_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2">
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
                                            <select class="form-select" @change="getSate(country)" v-model="liststate.country_id">
                                                <option selected="" value="">Select Country</option>
                                                <option v-for="(country, key) in countrys" :key="key" :value="country.country_id"> {{ country.country_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Checkbox -->
                                </div>
                            </div>

                            <hr class="my-0" />
                            <!-- Divider -->
                            <div class="card card-body rounded-0 p-2">
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
                                                <input class="form-check-input" type="checkbox" :id="state.state_id + 'state'" :value="state.state_id" v-model="selected" @change="updateCheckall(state)" />
                                                <label class="form-check-label" :for="state.state_id + 'state'"> {{state?.state_name}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2">
                                <!-- Title -->
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#Private" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6
                                        style="font-size: 15px; font-weight: normal;"
                                        class="mb-2"
                                        :class="{
                        bluetextclass: searchfilter.tdr_agency.length !== 0,
                      }"
                                    >
                                        International Agency
                                    </h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="Private">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ selectedState.length }} of {{ agencycount }})</a>|
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
                                            <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="filterAgency()" v-model="searchagencyState" placeholder="Search State" aria-label="Search" />
                                            <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
                                        <!-- Checkbox -->
                                        <div class="d-flex justify-content-between align-items-center" v-for="statefederal in agencyState " :key="statefederal.agency_id">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="statefederal.agency_id + 'statefederal'"
                                                    :value="statefederal.agency_name"
                                                    v-model="selectedState"
                                                    @change="updateCheckallState(statefederal)"
                                                />
                                                <label class="form-check-label" :for="statefederal.agency_id + 'statefederal'">{{ statefederal.agency_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                        </form>
                        <!-- Form End -->
                    </div>

                    <!-- Responsive offcanvas body END -->
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="vl-parent">
                        <Skeleton v-if="isLoading" />
                        <div class="scroll-div">
                            <div class="hstack flex-wrap gap-2">
                                <!-- Search item -->
                                <div class="alert border shadow fade show small px-1 py-0 mb-0 filtertagcss" role="alert" v-for="(filter, index) in filters" :key="index">
                                    <span class="me-1" style="color: white;">{{ filter.name }}</span>
                                    <button type="button" class="btn btn-xs mb-0 text-white p-0" style="font-size: 13px !important;" @click="removeTagnotice(filter)" aria-label="Close">
                                        <i class="fa fa-light fa-xmark text-white"></i>
                                    </button>
                                </div>
                                <!-- Search item -->
                                <div v-if="filters.length != 0">
                                    <button type="button" class="btn btn-xs text-primary mb-0 p-1 textclose" @click.prevent="clearAllFilters">Clear all</button>
                                </div>
                            </div>
                        </div>

                        <!-- bids -->
                        <!-- page not found -->
                        <section v-if="InternationalOppotunities.length === 0">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-10 text-center mx-auto">
                                        <!-- Image -->
                                        <img src="assets/images/no-search-results.svg" class="mb-4" width="230px" alt="" />
                                        <!-- Title -->
                                        <!-- <h1 class="display-1 text-primary mb-0">404</h1> -->
                                        <!-- Subtitle -->
                                        <h3>No results found</h3>
                                        <!-- info -->
                                        <p class="mb-4">Try adjusting your serarch or filter to find what you're looking for.</p>
                                        <!-- Button -->
                                        <!-- <a href="index.html" class="btn btn-light mb-0">Take me to Homepage</a> -->
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- end -->
                        <div class="text-end" v-if="InternationalOppotunities.length !== 0">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">Showing {{ meta.to }} of {{ meta.totalRows }} bids </a>
                                </li>
                                <!-- <li class="list-inline-item">
                                <a href="#javascript:void(0)" @click.prevent="emailmodalpop()" class="p-2"><i class="fa-solid fa-fw fa-envelope"></i></a>
                            </li> -->
                                <li class="list-inline-item" v-if="$store.getters.user !== null">
                                    <a href="#javascript:void(0)" @click.prevent="emailmodalpop()" class="p-2 text-secondary"><i class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>
                        <div v-if="InternationalOppotunities.length !== 0">
                            <div v-if="listview">
                                <div class="card shadow mb-2" v-for="international in InternationalOppotunities" :key="international.tdr_id">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <!-- Rating and buttons -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                    <a href="javascript:void(0)" @click="bidsdetails(international)" style="text-transform: uppercase;"><div v-html="highlight(international.tdr_title)"></div></a>
                                                </div>
                                                <div v-else>
                                                    <a href="javascript:void(0)" @click="showModal()">
                                                        <div v-html="highlight(international.tdr_title)"></div>
                                                    </a>
                                                </div>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <!-- Heart icon -->
                                                <li class="list-inline-item" v-if="$store.getters.user !== null">
                                                    <div class="form-check-inline mb-0">
                                                        <small class="form-check-label mb-0 me-2"><a href="#" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox" :value="international.tdr_id" id="flexCheckChecked" v-model="sendMails.bids" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" /> {{ international.notice.notice_type }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />{{ international.tdr_no }}</li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{dateFormat(international.tdr_posted_date) }} &nbsp;<span> {{ international.created_at }} </span>
                                            </li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" /> {{ dateFormat(international.tdr_expiry_date) }}
                                                <span class="col-green" style="color: green;" v-if="datecalcu(international.tdr_expiry_date,currentDate()) > 1">
                                                    &nbsp; {{ datecalcu( international.tdr_expiry_date, currentDate() ) }} Day to Go
                                                </span>
                                                <span class="col-red" style="color: red;" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <!-- List -->
                                        <ul class="list-group list-group-borderless small mb-0 mt-2">
                                            <li class="list-group-item d-flex text-success p-0">
                                                <!-- <i class="bi bi-patch-check-fill me-2"></i>Free Cancellation till 7 Jan 2022 -->
                                                <p class="limited-text" style="color: #595d6e; text-align: justify;" v-html="international.tdr_desc"></p>
                                            </li>
                                        </ul>

                                        <!-- Price and Button -->
                                        <div class="border-top d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                            <!-- Button -->
                                            <div class="d-flex align-items-center">
                                                <ul class="nav nav-divider small mt-3" style="color: #595d6e;">
                                                    <li class="nav-item text-primary"><i class="bi bi-patch-check-fill text-primary me-2"></i>{{international.tdr_agency}}</li>
                                                    <!-- <li class="nav-item text-primary">Subscribe Now ! To view agency</li> -->
                                                    <li class="nav-item">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ international?.state?.state_name }}<span v-if="international?.state?.state_name">,</span> {{ international.country.country_name
                                                        }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- Price -->
                                            <div class="mt-3">
                                                <!-- <a href="hotel-detail.html" class="btn btn-sm btn-dark mb-0 w-100">Select Room</a> 
                                                    -->
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <!-- Heart icon -->
                                                    <li class="list-inline-item" v-if="$store.getters.user !== null">
                                                        <a href="javascript:void(0)" @click.prevent="shareBidInternational(international)" v-modal="shareBid.bids" class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE</a>
                                                    </li>
                                                    <!-- Share icon -->
                                                    <li class="list-inline-item" v-if="checkCartItem(international.tdr_id)">
                                                        <!-- Share button -->
                                                        <div v-if="$store.getters.user?.subscription_id ===0">
                                                            <a href="javascript:void(0)" @click="addCart(international)" class="p-2">
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
                                <div class="card shadow" v-if="InternationalOppotunities.length !== 0">
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
                                                <tbody class="border-top-0" v-for="international in InternationalOppotunities" :key="international.tdr_id">
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="form-check my-auto" v-if="$store.getters.user !== null">
                                                                    <input class="form-check-input me-3" type="checkbox" :value="international.tdr_id" v-model="sendMails.bids" />
                                                                    <!-- <label class="form-check-label"><img class="mb-1 me-2" src="@/assets/icons/i-claimed.svg" width="17" /> </label> -->
                                                                </div>

                                                                <div class="row">
                                                                    <div class="column">
                                                                        <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                                            <a href="javascript:void(0)" @click="bidsdetails(international)">{{ international.tdr_no }}</a>
                                                                        </div>
                                                                        <div v-else>{{ international.tdr_no }}</div>
                                                                    </div>

                                                                    <div class="column">
                                                                        <a :style="{color:international.notice.backround_color}" class="badge bg-success bg-opacity-10">{{ international.notice.notice_type }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><div v-html="highlight(international.tdr_title)"></div></td>
                                                        <td>{{ international.tdr_agency }}</td>
                                                        <td>{{ international.state.state_code }},{{ international?.state?.state_name }}</td>
                                                        <td style="width: 110px;">{{ international.tdr_expiry_date }}</td>
                                                        <td>
                                                            <span v-if="checkCartItem(international.tdr_id)">
                                                                <div v-if="$store.getters.user?.subscription_id ===0">
                                                                    <a href="javascript:void(0)" @click="addCart(international)"><img v-if="hidecartstatue" class="mb-1 me-2" src="@/assets/icons/addcart.svg" width="20" /></a>
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
                        <!-- bids end -->
                        <!-- Pagination -->
                        <div v-if="InternationalOppotunities.length !== 0">
                            <div style="float: left;">
                                <input type="text" class="form-control" v-model="meta.currentPage" @keypress.enter="getInternational()" style="width: 60px;" />
                            </div>
                            <div style="float: right;">
                                <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- loader end -->
            </div>
            <!-- loader end -->
        </div>
    </div>

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

    <!-- setAlert test -->
    <teleport to="#modals" :disabled="!setalert" v-if="setalert">
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
                                            <!-- <div class="avatar avatar-sm">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar" />
                                            </div> -->
                                            <!-- Info -->
                                            <div class="ms-2">
                                                <h5 class="modal-title" id="exampleModalLabel11">Set Alert</h5>
                                            </div>
                                        </div>

                                        <!-- Button -->
                                        <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                    </div>

                                    <!-- card body -->
                                    <form class="card-body">
                                        <!-- Current password -->
                                        <div class="field-wrapper">
                                            <label class="form-label">Alert Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" :class="{'is-invalid': errors.alert_label}" v-model="savealert.alert_label" placeholder="Enter your Alert" />
                                            <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                                        </div>
                                        <div class="field-wrapper">
                                            <label class="form-label">Frequency<span class="text-danger">*</span></label>
                                            <select class="form-select" :class="{'is-invalid': errors.frequency}" v-model="frequency">
                                                <option selected="">Select your Frequency</option>
                                                <option value:daily>Daily</option>
                                                <option value:weekly>Weekly</option>
                                            </select>
                                        </div>

                                        <!-- New password -->

                                        <!-- Confirm -->

                                        <div class="modal-footer pt-3">
                                            <button type="button" style="margin: 3px;" class="btn btn-secondary" @click.prevent="closemodal()" ref="Close">
                                                Close
                                            </button>
                                            <button type="button" class="btn btn-primary" @click="addAlert()">
                                                Save
                                            </button>
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

    <!-- saved search -->
    <teleport to="#modals" :disabled="!saveSearchbid" v-if="saveSearchbid">
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
                                            <!-- <div class="avatar avatar-sm">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar" />
                                            </div> -->
                                            <!-- Info -->
                                            <div class="ms-2">
                                                <h5 class="modal-title" id="exampleModalLabel11">Save Search</h5>
                                            </div>
                                        </div>

                                        <!-- Button -->
                                        <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                    </div>

                                    <!-- card body -->
                                    <form class="card-body">
                                        <!-- Current password -->
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">Label {{savesearch.id }} <span class="text-danger">*</span></div>
                                            <input class="form-control" type="text" placeholder="Name" :class="{'is-invalid': errors.alert_label}" v-model="savesearch.alert_label" ref="alert_label" />
                                            <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                                        </div>
                                        <div class="modal-footer pt-3">
                                            <button type="button" style="margin-right: 3px;" class="btn btn-secondary" data-bs-dismiss="modal" ref="Close">
                                                Close
                                            </button>
                                            <button type="button" class="btn btn-primary" @click.prevent="saveSearch()">
                                                Save
                                            </button>
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
    <!-- end -->
    <!-- alert login user -->
    <teleport to="#modals" :disabled="!userlogin" v-if="userlogin">
        <div class="modal-overlay">
            <div class="" ref="register">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <img src="assets/images/icons/MemberIcon.png" class="imgcol" style="width: 50px; height: 50px;" />
                            <h5 class="modal-title">Login Required</h5>
                            <button type="button" class="btn-close" @click.prevent="closemodal()" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body mbodyaccess">
                            <div class="p-sm-7">
                                <p class="mb-0">New here?<a href="sign-up.html"> Already a Subscriber ?</a></p>

                                <!-- Form START -->
                                <form class="mt-4 text-start">
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label">Enter email id</label>
                                        <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="user.email" ref="email" />
                                        <span v-if="errors.email" class="invalid-feedback">{{errors.email[0]}}</span>
                                    </div>
                                    <!-- Password -->
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Enter password</label>
                                        <input class="form-control fakepassword" type="password" :class="{ 'is-invalid': errors.password }" v-model="user.password" ref="password" id="psw-input" />
                                        <span class="position-absolute top-50 end-0 translate-middle-y p-0 mt-3">
                                            <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i>
                                        </span>
                                        <span v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</span>
                                    </div>
                                    <!-- Remember me -->
                                    <div class="mb-3 d-sm-flex justify-content-between">
                                        <div>
                                            <input type="checkbox" class="form-check-input" id="rememberCheck" />
                                            <label class="form-check-label" for="rememberCheck">Remember me?</label>
                                        </div>
                                        <router-link to="/forgot_password">Forgot password?</router-link>
                                    </div>
                                    <!-- Button -->
                                    <div><button type="button" class="btn btn-primary w-100 mb-0" @click.prevent="login">Login</button></div>

                                    <!-- Divider -->
                                </form>
                                <!-- Form END -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
    <!-- setAlert test -->

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
    <teleport to="#modals" :disabled="!erroralertmodal" v-if="erroralertmodal">
        <div class="modal-overlay">
            <div id="popup1" class="confirm">
                <h1>Alert</h1>
                <p>Please Select State,Notice Type,Keyword !</p>
                <button @click.prevent="closemodal()">Close</button>
            </div>
        </div>
    </teleport>
    <teleport to="#modals" :disabled="!userModal" v-if="userModal">
        <div class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <LoginModal @closeModal="closeModal" ref="login_modal" v-if="login_modal" />
                        <SaveSearch @closeModal="closeModal" @savedSearch="saveSearch" @updateSearch="updateSearch" :status="status" :alert_label="searchfilter.alert_label" :savedbids="savedbids" ref="save_search" v-if="save_search" />
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
            </div>
        </div>
    </teleport>
    <teleport to="#modals" :disabled="!alertModal" v-if="alertModal">
        <div class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <LoginModal @closeModal="closeModal" ref="login_modal" v-if="login_modal" />
                        <SetAlertModal @closeModal="closeModal" :alert="savealert" @setAlert="addAlert" ref="alert_search" v-if="set_alert" />
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
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
    <teleport to="#modals" v-disabled="!alertSubscribe" v-if="alertSubscribe">
        <div class="modal-overlay">
            <div id="popup1" class="confirm">
                <div class="">
                    <h1>Alert</h1>
                    <p>Please SUBSCRIBE !</p>
                    <button @click.prevent="closemodal()">Close</button>
                    <!-- <button autofocus>Confirm</button> -->
                </div>
                <!-- <a href="#" @click.prevent="closemodal()" class="close remunderline">&times;</a>
             

                <div style="text-center: center;">
                    <h6 style="text-align: center; color: red !important; margin-top: 15px;">
                        Please Subscribe!
                    </h6>
                </div> -->
            </div>
        </div>
    </teleport>
</template>

<script>
    import Pagination from "@/components/Pagination.vue";
    import Skeleton from "@/components/Skeleton.vue";
    import moment from "moment";
    import Vue3TagsInput from "vue3-tags-input";
    import SaveSearch from "@/components/SaveSearch";
    import LoginModal from "@/components/LoginModal";
    import SetAlertModal from "@/components/SetAlert";
    import DatePicker from "@jobinsjp/vue3-datepicker";
    import "@jobinsjp/vue3-datepicker/index.css";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    export default {
        components: { Loading, DatePicker, Pagination, Vue3TagsInput, SaveSearch, LoginModal, SetAlertModal, Skeleton },

        data() {
            return {
                user: {
                    email: "",
                    password: "",
                },
                sharealertmodal: false,
                erroralertmodal: false,
                userModal: false,
                alertModal: false,
                tags: [],
                tag: "",
                listview: true,
                gridview: false,
                alertmodal: false,
                emailmodal: false,
                statussearch: true,
                setalert: false,
                alertSubscribe: false,
                userlogin: false,
                saveSearchbid: false,
                sharebid: false,
                status: false,
                status1: false,
                agencyState: [],
                searchagencyState: "",
                selectedState: [],
                state_country: [],
                selectAllState: false,
                searchstate: "",
                savedserachbids: [],
                categorys: [],
                selectedcategory: [],
                selectAllcategory: false,
                searchagencycategory: "",
                InternationalOppotunities: [],
                countrys: [],
                states: [],
                selected: [],
                search_notice: [],
                listcountry: {
                    country_id: [],
                },
                liststate: {
                    country_id: [],
                },

                savedserach: {
                    user_id: "",
                    region_id: "",
                    id: "",
                },
                mails: "",
                sendMails: {
                    bids: [],
                    mails: [],
                    email: "rupam@aeriesys.com",
                    subject: "",
                    bid_or_doc: "bid",
                    region_id: 4,
                },
                shareBid: {
                    bids: [],
                    mails: [],
                    email: "rupam@aeriesys.com",
                    subject: "",
                    message: "",
                    bid_or_doc: "bid",
                    region_id: 4,
                },
                testarray: [],
                savealert: {
                    id: "",
                    user_id: "",
                    on_off: 1,
                    alert_label: "",
                    region_id: "",
                    state_id: "",
                    frequency: "",
                    keywords: "",
                    country_id: "",
                    naics_id: "",
                    notice_type: "",
                    psc: "",
                    set_aside_status: "",
                    category_name: "",
                    private_fedral: "",
                    created_on: "",
                    updated_on: "",
                },
                searchfilter: {
                    alert_label: "",
                    tdr_notice: [],
                    tdr_status: [],
                    tdr_category: [],
                    tdr_agency: [],
                    tdr_state: [],
                    response_date: "",
                    posted_date: "",
                    tdr_country: [],
                    posted_from_date: "",
                    posted_to_date: "",
                    //response_date:"",
                    response_from_date: "",
                    response_to_date: "",
                    keywords: "",
                },
                savesearch: {
                    user_id: "",
                    region_id: 4,
                    state_id: "",
                    alert_label: "",
                    keywords: "",
                    country_id: "",
                    naics_id: "",
                    notice_type: "",
                    psc: "",
                    set_aside_status: "",
                    category_id: "",
                    agency_fedral: "",
                    created_on: "",
                    updated_on: "",
                },
                savedserach: {
                    user_id: "",
                    region_id: "",
                    id: "",
                },
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
                filters: [],
                allFilterState: [],
                allFilterCategroy: [],
                allFilterAgency: [],
                errors: [],
                statecount: "0",
                agencycount: "0",
                categorycount: "",
                hidecartstatue: false,
                status: true,
                savedbids: "",
                isLoading: false,
                fullPage: false,
            };
        },
        watch: {
            "liststate.country_id": function () {
                if (this.liststate.country_id) this.getSate();
            },
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                if (to.query.region_id == "4") {
                    vm.searchfilter.tdr_category = vm.$store.getters.alert.category_id ? vm.$store.getters.alert.category_id.split(",") : [];
                    vm.selectedcategory = vm.searchfilter.tdr_category;
                    vm.statussearch = false;
                    vm.searchfilter.tdr_set_aside_status = vm.$store.getters.alert.set_aside_status ? vm.$store.getters.alert.set_aside_status.split(",") : [];
                    vm.searchfilter.tdr_notice = vm.$store.getters.alert.notice_type ? vm.$store.getters.alert.notice_type.split(",") : [];

                    vm.searchfilter.tdr_agency = vm.$store.getters.alert.agency_fedral ? vm.$store.getters.alert.agency_fedral.split(",") : [];
                    vm.selectedState = vm.searchfilter.tdr_agency;
                    vm.listcountry.country_id = Object.assign({}, [vm.$store.getters.alert.country_id]);
                    vm.liststate.country_id = vm.$store.getters.alert.country_id;
                    vm.searchfilter.tdr_country = [vm.liststate.country_id];
                    vm.searchfilter.tdr_state = vm.$store.getters.alert.state_id ? vm.$store.getters.alert.state_id.split(",") : [];
                    vm.selected = vm.searchfilter.tdr_state;
                    vm.searchfilter.tdr_type = vm.$store.getters.alert.tdr_type ? vm.$store.getters.alert.tdr_type.split(",") : [];
                    vm.searchfilter.tdr_type_of_award = vm.$store.getters.alert.tdr_type_of_award ? vm.$store.getters.alert.tdr_type_of_award.split(",") : [];
                    vm.searchfilter.tdr_naics = vm.$store.getters.alert.naics_id ? vm.$store.getters.alert.naics_id.split(",") : [];
                    vm.tags = vm.$store.getters.alert.keywords ? vm.$store.getters.alert.keywords.split(",") : [];
                    vm.searchfilter.keywords = vm.tags;
                }
            });
        },
        mounted() {
            let vm = this;
            vm.getInternational();
            vm.callFunction();
            vm.getNotice();
            vm.getStateAgency();
            vm.checklogin();
            vm.hideCart();
            moment.updateLocale("language_code", {
                invalidDate: "--",
            });
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

                if (vm.searchfilter.tdr_category.length != 0) {
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
                if (vm.searchfilter.keywords.length != 0) {
                    ++count;
                }

                return count;
            },
            //save filter
        },
        methods: {
            bidsdetails(bidsdetail) {
                this.$store.commit("setBidsDetails", bidsdetail);
                this.$router.push("/bids/" + "international-opportunities" + "/" + bidsdetail.tdr_title.replace(/\//g, "") + "-" + bidsdetail.tdr_no);
            },
            highlight(title) {
                if (!this.searchfilter.keywords) {
                    return title;
                }
                console.log(this.searchfilter.keywords);
                let keywords_arr = this.searchfilter.keywords.split(",");
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
                this.getInternational();
            },
            removeDuplicates() {
                this.tags = [...new Set(this.tags)];
            },
            showModal() {
                this.userModal = true;

                if (this.searchfilter.alert_label) {
                    this.status = false;
                } else this.status = true;
                if (this.$store.getters.user?.subscription_id === 0) {
                    this.alertSubscribe = true;
                    this.userModal = false;
                } else {
                    if (this.$store.getters.user == null) {
                        this.login_modal = true;
                    } else {
                        this.save_search = true;
                    }
                }
            },
            setAletModal() {
                this.alertModal = true;

                if (this.$store.getters.user === null) {
                    this.login_modal = true;
                } else {
                    if (this.$store.getters.user.subscription_id !== 0) {
                        this.set_alert = true;
                    }
                    if (this.$store.getters.user?.subscription_id === 0) {
                        this.alertSubscribe = true;
                        this.login_modal = false;
                        this.set_alert = false;
                        this.alertModal = false;
                    }
                }
            },
            closeModal(modal) {
                if (modal == "login_modal") {
                    if (this.$store.getters.user) {
                        this.getSavedsearch();
                    }
                    this.login_modal = false;
                } else this.save_search = false;
                this.userModal = false;
                this.alertModal = false;
            },

            openSaveSearch() {
                let vm = this;

                if (vm.$store.getters.user == null) {
                    vm.userlogin = true;
                } else {
                    vm.saveSearchbid = true;
                }
            },
            checklogin() {
                let vm = this;
                if (vm.$store.state.user == null) {
                    return false;
                } else {
                    vm.getSavedsearch();
                }
            },
            setAletpopup() {
                let vm = this;

                if (vm.$store.getters.user == null) {
                    vm.userlogin = true;
                } else {
                    vm.setalert = true;
                }
            },
            handleChangeTag(tags) {
                let vm = this;
                vm.tags = tags;
                vm.searchfilter.keywords = vm.tags;
                vm.getInternational();
            },
            filterAgency() {
                if (this.searchagencyState == "") {
                    this.agencyState = this.allFilterAgency;
                }
                this.agencyState = this.allFilterAgency.filter((entry) => {
                    return entry.agency_name.toLowerCase().includes(this.searchagencyState.toLowerCase());
                });
            },
            filterCategory() {
                if (this.searchagencycategory == "") {
                    this.categorys = this.allFilterCategroy;
                }
                this.categorys = this.allFilterCategroy.filter((entry) => {
                    return entry.category_name.toLowerCase().includes(this.searchagencycategory.toLowerCase());
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
            currentDate() {
                let now = moment();
                return now.format("YYYY-MM-DD");
            },

            dateFormat(value) {
                //  moment(value).format('YYYY-MM-DD');
                return moment(value).format("ll");
            },
            datecalcu(startDate, endDate) {
                var newstartDate = moment(startDate, "YYYY-MM-DD");
                var endendDate = moment(endDate, "YYYY-MM-DD");
                var dayDiff = newstartDate.diff(endendDate, "days");
                return dayDiff;
            },
            addCart(international) {
                let vm = this;
                this.$store.commit("addTocart", international);
                vm.getInternational();
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
            callFunction: function () {
                var currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
                this.savesearch.created_on = currentDateWithFormat;
                this.savesearch.updated_on = currentDateWithFormat;
                this.savealert.created_on = currentDateWithFormat;
                this.savealert.updated_on = currentDateWithFormat;
            },
            getStateAgency() {
                let vm = this;
                let uri = "getAgency";
                vm.$store
                    .dispatch("post", { uri: uri })
                    .then(function (response) {
                        vm.agencyState = response.data.data;
                        vm.agencycount = vm.agencyState.length;
                        vm.allFilterAgency = vm.agencyState;
                        if (vm.searchfilter.tdr_agency.length) vm.appendInternationalAgencyToFilter(vm.searchfilter.tdr_agency);
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
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
                vm.$store
                    .dispatch("post", { uri: "sendMailWithBids", data: vm.sendMails })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Mails Send  successfully");
                        vm.closemodal();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            closemodal() {
                let vm = this;
                vm.sharealertmodal = false;
                vm.erroralertmodal = false;
                vm.alertSubscribe = false;
                vm.modal1 = false;
                vm.modal2 = false;
                vm.emailmodal = false;
                vm.alertmodal = false;
                vm.setalert = false;
                vm.userlogin = false;
                vm.saveSearchbid = false;
                vm.sharebid = false;
                vm.shareMail.bids = [];
                vm.shareMail.mails = [];
                vm.errors = [];
            },
            addAlert(alert) {
                let vm = this;
                vm.searchfilter.tdr_naics = [];
                vm.searchfilter.tdr_set_aside_status = [];
                vm.savealert.user_id = vm.$store.getters.user.id;
                vm.savealert.region_id = 4;
                vm.savealert.alert_label = alert.alert_label;
                vm.savealert.frequency = alert.frequency;
                vm.savealert.keywords = vm.searchfilter.keywords.toString();
                vm.savealert.state_id = vm.searchfilter.tdr_state.toString();
                vm.savealert.naics_id = vm.searchfilter.tdr_naics.toString();
                vm.savealert.set_aside_status = vm.searchfilter.tdr_set_aside_status.toString();
                vm.savealert.category_id = vm.searchfilter.tdr_category.toString();
                vm.savealert.private_fedral = vm.searchfilter.tdr_agency.toString();
                vm.savealert.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savealert.country_id = vm.liststate.country_id.toString();
                vm.$store
                .dispatch("post", { uri: "addAlert", data: vm.savealert })
                .then(function (response) {
                    vm.federal = response.data.data;
                    vm.$store.dispatch("success", "Alert Added successfully");
                    vm.$router.push("/bids/save-alert");
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    for (let error in vm.errors) {
                        vm.$store.dispatch("error", vm.errors[error][0]);
                    }
                });
            },
            getIndex() {
                let vm = this;
                vm.searchfilter.keywords = vm.tags.toString();
                let uri = "searchBidsForInternationalOppotunities?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.searchfilter })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.InternationalOppotunities = response.data.data;
                        vm.meta.totalRows = response.data.meta.total;
                        vm.meta.lastPage = response.data.meta.last_page;
                        vm.meta.from = response.data.meta.from;
                        vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                        vm.meta.to = response.data.meta.to;
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getInternational() {
                let vm = this;
                vm.searchfilter.keywords = vm.tags.toString();
                // vm.listcountry.country_id =  Object.assign({}, [vm.searchfilter.tdr_country]);
                let uri = "searchBidsForInternationalOppotunities?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;
                //vm.isLoading = true
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.searchfilter })
                    .then(function (response) {
                        //vm.isLoading = false
                        vm.isLoading = false;
                        vm.InternationalOppotunities = response.data.data;
                        vm.meta.totalRows = response.data.meta.total;
                        vm.meta.lastPage = response.data.meta.last_page;
                        vm.meta.from = response.data.meta.from;
                        vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                        vm.meta.to = response.data.meta.to;
                        vm.meta.currentPage = response.data.meta.current_page;
                        if (vm.meta.currentPage > vm.meta.lastPage) {
                            vm.meta.currentPage = vm.meta.lastPage;
                        }
                        // vm.getNotice();
                        //
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getNotice() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getNotice" })
                    .then(function (response) {
                        vm.search_notice = response.data.data;
                        if (vm.searchfilter.tdr_notice.length) vm.appendNoticeToFilter(vm.searchfilter.tdr_notice);
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
                        vm.getCountry();
                        if (vm.searchfilter.tdr_category.length) vm.appendCategoryToFilter(vm.searchfilter.tdr_category);
                        // vm.getSavedsearch();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getCountry() {
                let vm = this;
                vm.searchfilter.tdr_country = vm.listcountry.country_id;
                //  alert(vm.searchfilter.tdr_country)
                vm.$store
                    .dispatch("post", { uri: "getCountry" })
                    .then(function (response) {
                        vm.countrys = response.data.data;
                        vm.getStateAgency();
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
                    .dispatch("post", { uri: uri, data: { country_id: [vm.liststate.country_id] } })
                    .then(function (response) {
                        vm.state_country = response.data.data;
                        vm.searchfilter.tdr_country = [vm.liststate.country_id];
                        vm.statecount = vm.state_country.length;
                        vm.allFilterState = vm.state_country;
                        if (vm.searchfilter.tdr_state.length) vm.appendStateToFilter(vm.searchfilter.tdr_state);
                        // vm.Deselect();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            // state
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
                    this.searchfilter.tdr_state = this.selected;
                    this.getInternational();
                }
            },
            Deselect() {
                this.selected = [];
                this.searchfilter.tdr_state = [];
                this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getInternational();
            },
            updateCheckall(state) {
                if (this.state_country.length == this.selected.length) {
                    this.selectAll = true;
                    this.selected = [];
                    this.searchfilter.tdr_state = this.selected;
                    if (this.selectAll == true) {
                        this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                        for (let i in this.state_country) {
                            this.selected.push(this.state_country[i].state_id);
                            this.filters.push({
                                table: "state",
                                id: this.state_country[i].state_id,
                                name: this.state_country[i].state_name,
                            });
                        }
                    }
                    this.getInternational();
                    // alert(this.searchfilter.tdr_state);
                } else {
                    let i = this.filters.findIndex((data) => data.id === state.state_id);
                    if (i !== -1) {
                        this.filters.splice(i, 1);
                        this.getInternational();
                    } else {
                        this.filters.push({
                            table: "state",
                            id: state.state_id,
                            name: state.state_name,
                        });
                        // this.statefilter.push(state);
                        this.filters = this.filters.filter((state, index) => this.filters.indexOf(state) === index);
                        this.getInternational();
                    }
                    this.selectAll = false;
                    // alert(this.selected);
                    this.searchfilter.tdr_state = this.selected;
                    this.getInternational();
                    // alert(this.selected.length);
                }
            },
            // end
            showdate() {
                this.status = true;
            },
            hidedate() {
                let vm = this;
                vm.status = false;
                vm.searchfilter.posted_from_date = "";
                vm.searchfilter.posted_to_date = "";
            },

            showresponsedate() {
                this.status1 = true;
            },
            hideresponsedate() {
                let vm = this;
                vm.status1 = false;
                vm.searchfilter.response_from_date = "";
                vm.searchfilter.response_to_date = "";
            },
            onPageChange(page) {
                this.meta.currentPage = page;
                // window.scrollTo({ top: 0, behavior: "smooth" });
                this.getInternational();
            },
            onPerPageChange() {
                this.meta.currentPage = 1;
                this.getInternational();
            },

            // federal search
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
                    this.getInternational();
                }
            },
            DeselectState() {
                this.selectedState = [];
                this.searchfilter.tdr_agency = [];
                this.filters.filter((x) => x.table === "Agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getInternational();
            },
            updateCheckallState(statefederal) {
                if (this.agencyState.length == this.selectedState.length) {
                    this.selectedState = [];
                    this.selectAllState = true;
                    this.searchfilter.tdr_agency = this.selectedState;
                    if (this.selectedState == true) {
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
                    this.getInternational();
                    // alert(this.searchfilter.tdr_state);
                } else {
                    let i = this.filters.findIndex((data) => data.name === statefederal.agency_name);
                    if (i !== -1) {
                        this.filters.splice(i, 1);
                        this.getInternational();
                    } else {
                        this.filters.push({
                            table: "Agency",
                            id: statefederal.agency_id,
                            name: statefederal.agency_name,
                        });
                        // this.statefilter.push(state);
                        // this.filters = this.filters.filter((statefederal, index) => this.filters.indexOf(statefederal) === index);
                    }
                    this.selectAllState = false;
                    // alert(this.selected);
                    this.searchfilter.tdr_agency = this.selectedState;
                    this.getInternational();
                    // alert(this.selected.length);
                }
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
                    this.getInternational();
                }
            },
            DeselectCategory() {
                this.selectedcategory = [];
                this.searchfilter.tdr_category = [];
                this.filters.filter((x) => x.table === "Category").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getInternational();
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
                } else {
                    let i = this.filters.findIndex((data) => data.id === category.category_id);
                    if (i !== -1) {
                        this.filters.splice(i, 1);
                        this.getInternational();
                    } else {
                        this.filters.push({
                            table: "Category",
                            id: category.category_id,
                            name: category.category_name,
                        });
                        // this.statefilter.push(state);
                        //    this.filters = this.filters.filter((category, index) => this.filters.indexOf(category) === index);
                    }
                    this.selectAllcategory = false;
                    this.searchfilter.tdr_category = this.selectedcategory;
                    this.getInternational();
                }
            },

            //end
            saveSearch(alert_label) {
                let vm = this;

                vm.savesearch.user_id = vm.$store.getters.user.id;
                vm.savesearch.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savesearch.state_id = vm.searchfilter.tdr_state.toString();
                vm.savesearch.keywords = vm.searchfilter.keywords;
                vm.savesearch.alert_label = alert_label;
                //vm.savesearch.naics_id = vm.searchfilter.tdr_naics.toString();
                vm.savesearch.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savesearch.category_id = vm.searchfilter.tdr_category.toString();
                // vm.savesearch.set_aside_status = vm.searchfilter.tdr_set_aside_status.toString();
                vm.savesearch.agency_fedral = vm.searchfilter.tdr_agency.toString();
                vm.savesearch.country_id = vm.searchfilter.tdr_country.toString();
                // alert(vm.savesearch.region_id);
                vm.savesearch.region_id;
                vm.savesearch.created_on;
                vm.savesearch.updated_on;

                vm.isLoading = true;
                vm.fullPage = true;
                vm.$store
                    .dispatch("post", { uri: "addSaveBids", data: vm.savesearch })
                    .then(function () {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.$store.dispatch("success", "Bids Saved successfully");
                        vm.userModal = false;
                        vm.errors = [];
                        vm.getSavedsearch();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getSavedsearch() {
                let vm = this;

                vm.savedserach.user_id = vm.$store.getters.user.id;
                // console.log( vm.savedserach.user_id);
                vm.savedserach.region_id = 4;
                let uri = "getSaveBids";
                //  alert(vm.savedserach.id)
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
            updateSearch(savedbids) {
                let vm = this;
                vm.savesearch.user_id = vm.$store.getters.user.id;
                vm.savesearch.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savesearch.state_id = vm.searchfilter.tdr_state.toString();
                vm.savesearch.keywords = vm.searchfilter.keywords;
                vm.savesearch.alert_label = savedbids.alert_label;
                //vm.savesearch.naics_id = vm.searchfilter.tdr_naics.toString();
                vm.savesearch.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savesearch.category_id = vm.searchfilter.tdr_category.toString();
                // vm.savesearch.set_aside_status = vm.searchfilter.tdr_set_aside_status.toString();
                vm.savesearch.agency_fedral = vm.searchfilter.tdr_agency.toString();
                vm.savesearch.country_id = vm.searchfilter.tdr_country.toString();
                // alert(vm.savesearch.region_id);
                vm.savesearch.region_id;
                vm.savesearch.created_on;
                vm.savesearch.updated_on;
                vm.tag = "";
                vm.isLoading = true;
                vm.fullPage = true;
                let uri = "updateSaveBids/" + savedbids.id;
                vm.$store
                    .dispatch("post", { uri: uri, data: vm.savesearch })
                    .then(function () {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.$store.dispatch("success", "Saved Search Updated successfully");
                        vm.userModal = false;
                        vm.getSavedsearch();
                        vm.clearAllFilters();
                        vm.closemodal();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            deleteSearch(savedbids) {
                let vm = this;
                if (confirm("Do you want to delete this entry ?")) {
                    vm.isLoading = true;
                    vm.fullPage = true;
                    let uri = { uri: "deleteSaveBids/" + savedbids };
                    vm.$store
                        .dispatch("delete", uri)
                        .then(function () {
                            vm.isLoading = false;
                            vm.fullPage = false;
                            vm.$store.dispatch("success", "Search Bid is successfully deleted");
                            window.location.reload();
                            //vm.index()
                        })
                        .catch(function (error) {
                            vm.isLoading = false;
                            vm.fullPage = false;
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },
            runSearch(savedbids) {
                let vm = this;

                vm.statussearch = false;
                vm.savedbids = savedbids;
                vm.searchfilter.alert_label = savedbids.alert_label;
                vm.liststate.country_id = savedbids.country?.country_id;
                vm.searchfilter.tdr_notice = savedbids.notice_type ? savedbids.notice_type.split(",") : [];

                vm.searchfilter.tdr_set_aside_status = savedbids.set_aside_status ? savedbids.set_aside_status.split(",") : [];

                vm.searchfilter.tdr_state = savedbids.state_id ? savedbids.state_id.split(",") : [];
                vm.selected = vm.searchfilter.tdr_state;
                vm.searchfilter.tdr_type = savedbids.tdr_type ? savedbids.tdr_type.split(",") : [];
                vm.searchfilter.tdr_type_of_award = savedbids.tdr_type_of_award ? savedbids.tdr_type_of_award.split(",") : [];

                vm.searchfilter.tdr_agency = savedbids.agency_fedral ? savedbids.agency_fedral.split(",") : [];
                vm.selectedState = vm.searchfilter.tdr_agency;

                vm.searchfilter.tdr_naics = savedbids.naics_id ? savedbids.naics_id.split(",") : [];
                vm.savesearch.alert_label = savedbids.alert_label;

                vm.searchfilter.tdr_category = savedbids.category_id ? savedbids.category_id.split(",") : [];
                vm.selectedcategory = vm.searchfilter.tdr_category;

                vm.searchfilter.keywords = savedbids.keywords;
                vm.tags = vm.searchfilter.keywords ? vm.searchfilter.keywords.split(",") : [];
                vm.allFilterState;
                vm.allFilterCategroy;
                vm.allFilterAgency;

                vm.appendNoticeToFilter(vm.searchfilter.tdr_notice);
                vm.appendCategoryToFilter(vm.searchfilter.tdr_category);
                // vm.appendStateToFilter(vm.searchfilter.tdr_state)
                vm.appendInternationalAgencyToFilter(vm.searchfilter.tdr_agency);

                vm.getInternational();
            },
            appendNoticeToFilter(notice) {
                let vm = this;
                vm.filters = [];
                if (Array.isArray(notice)) {
                    notice.map(function (element) {
                        let notice_obj = vm.search_notice.filter(function (ele) {
                            return ele.notice_id == element;
                        });
                        if (notice_obj.length) {
                            vm.filters.push({
                                table: "notice",
                                id: notice_obj[0].notice_id,
                                name: notice_obj[0].notice_type,
                            });
                        }
                    });
                } else {
                    let notice_obj = vm.search_notice.filter(function (ele) {
                        return ele.notice_id == notice;
                    });
                    if (notice_obj.length) {
                        vm.filters.push({
                            table: "notice",
                            id: notice_obj[0].notice_id,
                            name: notice_obj[0].notice_type,
                        });
                    }
                }
            },

            appendCategoryToFilter(categories) {
                let vm = this;
                if (Array.isArray(categories)) {
                    categories.map(function (element) {
                        let category_obj = vm.categorys.filter(function (ele) {
                            return ele.category_id == element;
                        });
                        if (category_obj.length) {
                            vm.filters.push({
                                table: "state",
                                id: category_obj[0].category_id,
                                name: category_obj[0].category_name,
                            });
                        }
                    });
                } else {
                    let category_obj = vm.categorys.filter(function (ele) {
                        return ele.category_id == element;
                    });
                    if (category_obj.length) {
                        vm.filters.push({
                            table: "state",
                            id: category_obj[0].category_id,
                            name: category_obj[0].category_name,
                        });
                    }
                }
            },

            appendStateToFilter(state) {
                let vm = this;
                if (Array.isArray(state)) {
                    state.map(function (element) {
                        console.log(element);
                        console.log(vm.state_country);
                        let state_obj = vm.state_country.filter(function (ele) {
                            return ele.state_id == element;
                        });

                        if (state_obj.length) {
                            vm.filters.push({
                                table: "state",
                                id: state_obj[0].state_id,
                                name: state_obj[0].state_name,
                            });
                        }
                    });
                } else {
                    let state_obj = vm.state_country.filter(function (ele) {
                        return ele.state_id == element;
                    });
                    if (state_obj.length) {
                        vm.filters.push({
                            table: "state",
                            id: state_obj[0].state_id,
                            name: state_obj[0].state_name,
                        });
                    }
                }
            },

            appendInternationalAgencyToFilter(agencies) {
                let vm = this;
                if (Array.isArray(agencies)) {
                    agencies.map(function (element) {
                        vm.filters.push({
                            table: "agency",
                            id: 1,
                            name: element,
                        });
                    });
                }
            },

            // new tags
            addTag() {
                if (!this.tagValue == "") {
                    this.tags.push(this.tagValue);

                    this.tagValue = "";
                    this.removeDuplicates();

                    // this.getInternational();
                    this.$refs.taginput.focus();
                }
            },
            removeDuplicates() {
                this.tags = [...new Set(this.tags)];
                this.getIndex();
            },
            removeTag(index) {
                this.tags.splice(index, 1);
                this.getIndex();
            },
            removeLastTag(event) {
                if (event.target.value.length === 0) {
                    this.removeTag(this.tags.length - 1);
                }
            },
            directives: {
                focus: {
                    inserted: (el) => {
                        el.focus();
                    },
                },
            },
            clearAllFilters() {
                let vm = this;
                vm.searchfilter.tdr_notice = [];
                vm.searchfilter.tdr_status = [];
                vm.searchfilter.tdr_type = [];
                vm.searchfilter.tdr_type_of_award = [];
                vm.searchfilter.tdr_set_aside_status = [];
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
                vm.selected = [];
                vm.searchfilter.tdr_country = [];
                vm.filters = [];
                vm.tags = [];
                vm.searchfilter.tdr_category = [];
                vm.selectedcategory = [];
                vm.searchfilter.tdr_category = [];
                vm.statefilter = [];
                vm.selectedState = [];
                vm.hideresponsedate();
                vm.hidedate();
                vm.getInternational();
            },
            isChecked(searchfilter) {
                searchfilter.tdr_status.isActive = !searchfilter.tdr_status.isActive;
                this.color = "blue";
            },
            listviewgrid() {
                this.listview = false;
                this.gridview = true;
                this.meta.per_page = 28;
                this.getInternational();
            },
            gridviewgrid() {
                this.listview = true;
                this.gridview = false;
                this.meta.per_page = 10;
                this.getInternational();
            },
            //remove tages
            SaveStatusactive(active) {
                let i = this.filters.findIndex((data) => data.name === active);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getInternational();
                } else {
                    // this.fi.push(respdate);
                    this.filters.push({
                        table: "status",
                        id: active,
                        name: active,
                    });
                    this.getInternational();
                }
            },
            SaveStatusexpried(expried) {
                let i = this.filters.findIndex((data) => data.name === expried);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getInternational();
                } else {
                    // this.fi.push(respdate);
                    this.filters.push({
                        table: "statusExpried",
                        id: expried,
                        name: expried,
                    });
                    // this.filters = this.filters.filter((expried,index) => this.filters.indexOf(expried) === index);

                    this.getInternational();
                }
            },

            saveNotice(notice) {
                let i = this.filters.findIndex((data) => data.id === notice.notice_id);

                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getInternational();
                } else {
                    this.filters.push({
                        table: "notice",
                        id: notice.notice_id,
                        name: notice.notice_type,
                    });
                    // this.filters.push({});
                    //    this.filters = this.filters.filter((notice, index) => this.filters.indexOf(notice) === index);
                    this.getInternational();
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
                        this.getInternational();
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
                        this.getInternational();
                    }
                }
            },
            changeResponseDate(value) {
                let i = this.filters.findIndex((data) => data.table == "internationalResponseDate");
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getInternational();
                }
                this.filters.push({
                    table: "internationalResponseDate",
                    id: value,
                    name: value,
                });
                this.getInternational();
            },
            changePostedDate(value) {
                let i = this.filters.findIndex((data) => data.table == "internationalPostedDate");
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getInternational();
                }
                this.filters.push({
                    table: "internationalPostedDate",
                    id: value,
                    name: value,
                });
                this.getInternational();
            },
            //   remove tag start
            removeTagnotice(filter) {
                let myIndex = this.filters.indexOf(filter);

                this.filters.splice(myIndex, 1);

                let i = this.searchfilter.tdr_notice.findIndex((data) => data === filter.id);

                if (i !== -1) {
                    this.searchfilter.tdr_notice.splice(i, 1);
                }

                let state = this.searchfilter.tdr_state.findIndex((data) => data === filter.id);

                if (state !== -1) {
                    this.searchfilter.tdr_state.splice(state, 1);
                }
                let category = this.searchfilter.tdr_category.findIndex((data) => data === filter.id);

                if (category !== -1) {
                    this.searchfilter.tdr_category.splice(category, 1);
                }
                let status = this.searchfilter.tdr_status.findIndex((data) => data === filter.id);

                if (status !== -1) {
                    this.searchfilter.tdr_status.splice(status, 1);
                }
                let federalagency = this.searchfilter.tdr_agency.findIndex((data) => data === filter.name);

                if (federalagency !== -1) {
                    this.searchfilter.tdr_agency.splice(federalagency, 1);
                }

                if (filter.table == "internationalResponseDate") this.searchfilter.response_date = "";
                this.searchfilter.response_from_date = "";
                this.searchfilter.response_to_date = "";

                if (filter.table == "internationalPostedDate") this.searchfilter.posted_date = "";
                this.searchfilter.posted_from_date = "";
                this.searchfilter.posted_to_date = "";

                this.getInternational();
            },
            shareBidInternational(share) {
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
            shareMail() {
                let vm = this;
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
                // }
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
                        vm.$router.push("/bids/international-opportunities");
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
        },
    };
</script>
<style scoped>
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

    /* saved serach drop down css */
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
        /* border:0px solid gray  */
        box-shadow: 0 0 0 0px #000000;
        border-color: #9ca3af;
    }
    .table-responsive {
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch;
    }
    /* alert box */

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
        background: white;
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
        background: white;
    }
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
    .tag-center {
        align-items: center !important;
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
        background-color: rgb(244, 238, 238) !important;
        border-radius: 10px !important;
    }
</style>
