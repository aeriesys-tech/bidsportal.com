<template>
    <div class="regions">
        <div class="container-fluid justify-content-center pt-3">
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item">
                    <router-link to="/bids/federal-opportunities" @click.prevent="getFedral()" class="nav-link active">
                        <img class="icon" src="@/assets/icons/federalblue.svg" alt="icon" />
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
                <div class="col-md-3 d-flex justify-content-between search-left my-auto" style="">
                    <div class="label">Filters</div>
                    <div class="empty" :class="{ bluetextclass: getFilterCount }">{{ getFilterCount}} filters selected</div>
                </div>

                <div class="col-md-4 my-auto">
                    <form class="bg-body shadow rounded-2">
                        <div class="input-group input-group-sm">
                            <vue3-tags-input class="form-control form-control-sm p-0 tag-center scrollinput" @on-tags-changed="handleChangeTag" placeholder="Input keyword" v-model:tags="tags" v-model="tag" @allow-duplicates="false" />
                            <span class="input-group-text p-0 bg-transparent"> <button class="btn btn-sm" @click.prevent="handleSelectedTag(tag)" type="button" id="button-addon2">Search</button> </span>
                        </div>
                    </form>
                </div>

                <div class="col-md-5 my-auto">
                    <ul class="list-inline hstack flex-wrap gap-4 mb-0 s-dropdown dropdown my-auto" style="float: right;">
                        <li class="list-inline-item mb-0" v-if="tags.length !==0">
                            <a href="javascript:void(0)" class="" style="color: #747579;" @click.prevent="showModal()"><i class="fa fa-save fa-fw fs-6 cursor-pointer text-primary me-1"></i>Save Search</a>
                        </li>
                        <li class="cursor list-inline-item mb-0">
                            <a href="javascript:void(0)" style="color: #747579;" data-bs-toggle="modal" @click.prevent="setAletModal()"><i class="fa fa-bell fa-fw fs-6 text-dark me-1"></i>Set Alert</a>
                        </li>
                        <li class="cursor list-inline-item mb-0 s-dropdown dropdown hover1 mb-0 dropdown-toggle" href="#" id="demoMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-save fa-fw text-success me-1"></i>Saved search

                            <ul class="s-dropdown-content dropdown-menu dphover" style="max-height: 200px; overflow-y: scroll;" aria-labelledby="demoMenu">
                                <li v-for="savedbids in savedserachbids" :key="savedbids.id" class="dropdown-item dropitem1 p-0 px-2">
                                    <i class="fas fa-caret-right text-primary my-auto"></i>
                                    <a class="dropdown-item dropitem2" href="javascript:void(0)" @click.prevent="runSearch(savedbids)">{{ savedbids.alert_label }}</a>
                                    <a href="javascript:void(0)" class="icon red my-auto" @click.prevent="deleteAlertpopup(savedbids.id)">
                                        <i class="fa fa-trash text-danger blueicon" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>

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
                    <div class="flex-column p-4 p-xl-0" id="filtershadow">
                        <form class="rounded-3 shadow">
                            <div class="card card-body rounded-0 p-2">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#status" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{bluetextclass: searchfilter.tdr_status.length !== 0}">Status</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="status">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="active" value="active" @change="SaveStatusactive('active')" v-model="searchfilter.tdr_status" />
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="inactive" value="expired" @change="SaveStatusexpried('expired')" v-model="searchfilter.tdr_status" />
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />

                            <div class="card card-body rounded-0 p-2">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#noticetype" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{bluetextclass: searchfilter.tdr_notice.length !== 0}">Notice Type</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="noticetype" v-for="notice in search_notice" :key="notice.notice_id">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="notice.notice_id + 'notice'" :value="notice.notice_id" @change="saveNotice(notice)" v-model="searchfilter.tdr_notice" />
                                            <label class="form-check-label" :for="notice.notice_id + 'notice'">{{ notice.notice_type }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#posted" role="button" aria-expanded="false" aria-controls="response">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.posted_date.length !==0}">Posted Date</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="posted">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hour7" id="hour7" v-model="searchfilter.posted_date" value="24 Hours" @click="hidedate()" @change="changePostedDate('24 Hours')" />
                                            <label class="form-check-label" for="hour7">24 Hours</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour8" name="hour7" v-model="searchfilter.posted_date" value="2 Days" @click="hidedate()" @change="changePostedDate('2 Days')" />
                                            <label class="form-check-label" for="hour8">2 Days</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour9" name="hour7" v-model="searchfilter.posted_date" value="7 Days" @click="hidedate()" @change="changePostedDate('7 Days')" />
                                            <label class="form-check-label" for="hour9">7 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour10" name="hour7" v-model="searchfilter.posted_date" value="21 Days" @click="hidedate()" @change="changePostedDate('21 Days')" />
                                            <label class="form-check-label" for="hour10">21 Days</label>
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
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#response" role="button" aria-expanded="false" aria-controls="response">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.response_date.length !==0}">Response Date</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="response">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hour" id="hour1" v-model="searchfilter.response_date" value="24 Hours" @click="hideresponsedate()" @change="changeResponseDate('24 Hours')" />
                                            <label class="form-check-label" for="hour1">24 Hours</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour2" name="hour3" v-model="searchfilter.response_date" value="2 Days" @click="hideresponsedate()" @change="changeResponseDate('2 Days')" />
                                            <label class="form-check-label" for="hour2">2 Days</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour3" name="hour2" v-model="searchfilter.response_date" value="7 Days" @click="hideresponsedate()" @change="changeResponseDate('7 Days')" />
                                            <label class="form-check-label" for="hour3">7 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour4" name="hour11" v-model="searchfilter.response_date" value="21 Days" @click="hideresponsedate()" @change="changeResponseDate('21 Days')" />
                                            <label class="form-check-label" for="hour4">21 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="hour" v-model="searchfilter.response_date" value="custom" @click="changeResponseDate('Custom')" />
                                            <label class="form-check-label" for="custom1"> &nbsp; Custom</label>
                                            <div class="row" v-if="searchfilter.response_date=='custom'" style="margin-left: 0px !important;">
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
                                <div class="ml2 d-flex btn-more d-flex justify-content-between align-items-center" href="" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_naics.length !==0}">Primary NAICS Code</h6>

                                    <a class="p-0 mb-0">
                                        <a class="gryy1" data-bs-toggle="modal" data-bs-target="#flightdetail" role="button" aria-expanded="true" aria-controls="collapseExample5">
                                            <i class="fa fa-filter" aria-hidden="true"></i>
                                        </a>
                                    </a>
                                </div>
                            </div>

                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2">
                                <div class="ml2 d-flex btn-more d-flex justify-content-between align-items-center" href="" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_psc.length !==0}">Product & Service Code</h6>

                                    <a class="p-0 mb-0">
                                        <a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModal">
                                            <i class="fa fa-filter" aria-hidden="true"></i>
                                        </a>
                                    </a>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#setaside" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2" :class="{'bluetextclass': searchfilter.tdr_set_aside_status.length !==0}">Competition(Set-Aside)</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show mb-3" id="setaside">
                                    <div class="scroll1 hgt-250">
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

                            <hr class="my-0" />
                            <div class="card card-body rounded-0 p-2">
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
                                        <div class="d-flex justify-content-between align-items-center" v-for="state in state_country" :key="state.state_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :id="state.state_id + 'state'" :value="state.state_id" v-model="selected" @change="updateCheckall(state)" />
                                                <label class="form-check-label" :for="state.state_id + 'state'"> {{state.state_name}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />

                            <div class="card card-body rounded-0 p-2">
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
                                            <input class="form-control form-control-sm bg-light pe-5" type="search" @keyup="filterAgency" v-model="searcFederal" placeholder="Search State" aria-label="Search" />
                                            <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
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

                            <div class="card card-body rounded-0 p-2">
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
                            <div class="card card-body rounded-0 p-2">
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
                            </div>
                            <hr class="my-0" />
                        </form>
                    </div>
                </div>

                <div class="col-lg-8 col-xl-9">
                    <div class="vl-parent">
                        <Skeleton v-if="isLoading" />
                        <!-- <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage" /> -->
                        <div class="scroll-div" ref="myscroll">
                            <div class="hstack flex-wrap gap-2">
                                <div class="alert border shadow fade show small px-1 py-0 mb-0 filtertagcss" v-for="(filter, index) in filters" :key="index">
                                    <span class="me-1" style="color: white;">{{ filter.name }}</span>
                                    <button type="button" class="btn btn-xs mb-0 text-white p-0" style="font-size: 13px !important;" @click="removeTagnotice(filter)" aria-label="Close">
                                        <i class="fa fa-light fa-xmark text-white"></i>
                                    </button>
                                </div>

                                <div v-if="filters.length != 0">
                                    <button type="button" class="btn btn-xs text-primary textclose mb-0 p-1" @click.prevent="clearAllFilters">Clear all</button>
                                </div>
                            </div>
                        </div>
                        <section v-if="FedralOppotunities.length === 0">
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
                        <div class="text-end" v-if="FedralOppotunities.length !== 0">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">Showing {{ meta.to }} of {{ meta.totalRows }} bids </a>
                                </li>

                                <li class="list-inline-item" v-if="$store.getters.user !== null">
                                    <a href="javascript:void(0)" @click.prevent="emailmodalpop()" class="p-2 text-secondary"><i class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-2" v-for="fedralopption in FedralOppotunities" :key="fedralopption.tdr_id">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                    <a href="javascript:void(0)" @click="bidsdetails(fedralopption)" style="text-transform: uppercase;"><div v-html="highlight(fedralopption.tdr_title)"></div></a>
                                                </div>
                                                <div v-else>
                                                    <a href="javascript:void(0)" @click="showModal()"><div v-html="highlight(fedralopption.tdr_title)"></div></a>
                                                </div>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0" v-if="$store.getters.user !==null">
                                                        <small class="form-check-label mb-0 me-2"><a href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox" :value="fedralopption.tdr_id" id="flexCheckChecked" v-model="sendMails.bids" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ fedralopption.notice.notice_type }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />{{ fedralopption.tdr_no }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ dateFormat(fedralopption.tdr_posted_date) }} &nbsp;<span>{{fedralopption.created_at }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" /> {{ dateFormat(fedralopption.tdr_expiry_date) }}
                                                <span class="col-green" v-if=" datecalcu(fedralopption.tdr_expiry_date,currentDate()) >1">
                                                    &nbsp; {{ datecalcu(fedralopption.tdr_expiry_date,currentDate()) }} Day to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2">
                                            <li class="list-group-item d-flex text-success p-0">
                                                <p class="limited-text" style="color: #595d6e; text-align: justify;" v-html="fedralopption.tdr_desc"></p>
                                            </li>
                                        </ul>

                                        <div class="border-top d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                            <div class="d-flex align-items-center">
                                                <ul class="nav nav-divider small mt-3" style="color: #595d6e;">
                                                    <li class="nav-item text-primary"><i class="bi bi-patch-check-fill text-primary me-2"></i><span style="color: rgb(86, 84, 109);">{{ fedralopption.tdr_agency}}</span></li>

                                                    <li class="nav-item"><i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ fedralopption.state?.state_name }}, {{ fedralopption.country?.country_name }}</li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <li class="list-inline-item" v-if="$store.getters.user !== null">
                                                        <a href="javascript:void(0)" @click.prevent="shareBidfed(fedralopption)" v-modal="shareBid.bids" class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE </a>
                                                    </li>

                                                    <li class="list-inline-item" v-if="checkCartItem(fedralopption.tdr_id)">
                                                        <div v-if="$store.getters.user?.subscription_id ===0">
                                                            <a href="javascript:void(0)" @click="addCart(fedralopption)" class="p-2">
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
                                <div class="card shadow" v-if="FedralOppotunities.length !== 0">
                                    <div class="card-body py-md-2 d-flex flex-column h-100 position-relative">
                                        <div class="table-responsive border-0">
                                            <table class="table table-sm small align-middle p-4 mb-0 table-hover table-shrink">
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

                                                <tbody class="border-top-0" v-for="fedralopption in FedralOppotunities" :key="fedralopption.tdr_id">
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="form-check my-auto" v-if="$store.getters.user !==null">
                                                                    <input class="form-check-input me-3" type="checkbox" :value="fedralopption.tdr_id" v-model="sendMails.bids" />
                                                                </div>

                                                                <div class="row">
                                                                    <div class="column">
                                                                        <div v-if="$store.getters.user !==null && $store.getters.user.subscription_id !==0">
                                                                            <a href="javascript:void(0)" @click="bidsdetails(fedralopption)">{{ fedralopption.tdr_no }}</a>
                                                                        </div>
                                                                        <div v-else><a href="javascript:void(0)" @click="showModal()">{{ fedralopption.tdr_no }}</a></div>
                                                                    </div>

                                                                    <div class="column">
                                                                        <a :style="{color:fedralopption.notice.backround_color}" class="badge bg-success bg-opacity-10">{{ fedralopption.notice.notice_type }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><div v-html="highlight(fedralopption.tdr_title)"></div></td>
                                                        <td>{{ fedralopption.tdr_agency }}</td>
                                                        <td>{{ fedralopption.state.state_code }},{{ fedralopption.state.state_name }}</td>
                                                        <td style="width: 110px;">{{ fedralopption.tdr_expiry_date }}</td>
                                                        <td>
                                                            <span v-if="checkCartItem(fedralopption.tdr_id)">
                                                                <div v-if="$store.getters.user?.subscription_id ===0">
                                                                    <a href="javascript:void(0)" @click="addCart(fedralopption)"><img v-if="hidecartstatue" class="mb-1 me-2" src="@/assets/icons/addcart.svg" width="20" /></a>
                                                                </div>
                                                            </span>
                                                            <span v-else>
                                                                <img src="assets/images/icons/cart-24.svg" width="19" />
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet mb-0" v-if="FedralOppotunities.length !== 0">
                            <div class="kt-portlet__body">
                                <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        <a class="mybutton-success mybutton-secondary px-2" style="padding: 5px;" href="javascript:void(0)" data-bs-dismiss="modal" @click="applyFilterPsc()">APPLY FILTER</a>
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="tab-content mb-0" id="flight-pills-tabContent">
                        <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                            <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                <div class="col-md-8 small">
                                    <form class="position-relative">
                                        <input class="form-control form-control-sm pe-5 myinput" type="search" placeholder="Search in Serive Codes" aria-label="Search" v-model="service_code.search" @keypress.enter="getServiceCodes()" />
                                        <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="deselectPsc()"><i class="fas fa-search fs-6"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-4 small d-flex">
                                    <div><a class="my-auto dotted" href="javascript:void(0)" @click="deselectPsc()">Deselect All</a></div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="vl-parent">
                                    <loading v-model:active="isLoading2" :can-cancel="false" :z-index="10002" :is-full-page="fullPage" />
                                    <div class="card-body p-0" style="overflow: scroll; height: 300px;">
                                        <ul class="list-style-none pl-8">
                                            <li>
                                                <ul id="demo" style="padding: 0px;">
                                                    <PscTree class="item" :item="service_codes" :tdr_psc="searchfilter.tdr_psc" :search="service_code.search" :clear_all_psc="clear_all_psc"> </PscTree>
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
                        <a class="mybutton-success mybutton-secondary px-2" style="padding: 5px;" href="javascript:void(0)" data-bs-dismiss="modal" @click="applyFilterNaics()">APPLY FILTER</a>
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="tab-content mb-0" id="flight-pills-tabContent ">
                        <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel" aria-labelledby="flight-info">
                            <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                <div class="col-md-8 small">
                                    <form class="position-relative">
                                        <input class="form-control form-control-sm pe-5 myinput" type="search" placeholder="Search in Naics Codes" aria-label="Search" v-model="naics_code.search" @keypress.enter="getNaics()" />
                                        <button class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y" type="button" @click="deselectNaics()"><i class="fas fa-search fs-6"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-4 small d-flex">
                                    <div><a class="my-auto dotted" style="color: #40a4f1;" href="javascript:void(0)" @click="deselectNaics()">Deselect All</a></div>
                                </div>
                            </div>
                            <div class="vl-parent">
                                <loading v-model:active="isLoading1" :can-cancel="false" :z-index="10002" :is-full-page="fullPage" />
                                <div class="card" style="overflow: scroll; height: 300px;">
                                    <div class="card-body p-0">
                                        <ul class="list-style-none pl-8">
                                            <li>
                                                <ul id="demo" style="padding: 0px;">
                                                    <TreeItem class="item" :item="treeData" :tdr_naics="searchfilter.tdr_naics" :search="naics_code.search" :clear_all_naics="clear_all_naics"> </TreeItem>
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
    <teleport to="#modals" v-disabled="!userModal" v-if="userModal">
        <div class="modal-overlay">
            <div class="">
                <div class="">
                    <div class=""></div>
                    <div class="">
                        <LoginModal @closeModal="closeModal" ref="login_modal" v-if="login_modal" />
                        <SaveSearch @closeModal="closeModal" @savedSearch="saveSearch" @updateSearch="updateSearch" :status="status" :alert_label="searchfilter.alert_label" :savedbids="savedbids" ref="save_search" v-if="save_search" />
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
            </div>
        </div>
    </teleport>

    <teleport to="#modals" v-disabled="!alertModal" v-if="alertModal">
        <div class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <LoginModal @closeModal="closeModal" ref="login_modal" v-if="login_modal" />
                        <SetAlertModal @closeModal="closeModal" :alert="savealert" @updateAlert="updateAlert" @setAlert="addAlert" ref="alert_search" v-if="set_alert" />
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
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

    <teleport to="#modals" v-disabled="!sharealertmodal" v-if="sharealertmodal">
        <div class="modal-overlay">
            <div id="popup1" class="confirm">
                <div class="">
                    <h1>Alert</h1>
                    <p>Please Select Bid!</p>
                    <button @click.prevent="closemodal()">Close</button>
                </div>
            </div>
        </div>
    </teleport>

    <teleport to="#modals" v-disabled="!alertSubscribe" v-if="alertSubscribe">
        <div class="modal-overlay">
            <div id="popup1" class="confirm1" style="background-color: white !important;">
                <div class="">
                    <h1>Alert</h1>
                    <p>Please SUBSCRIBE !</p>
                    <button @click.prevent="closemodal()" style="background-color: white !important;">Close</button>
                </div>
            </div>
        </div>
    </teleport>

    <teleport to="#modals" v-disabled="!userlogin" v-if="userlogin">
        <div class="modal-overlay1">
            <div class="" ref="register">
                <div class="modal-dialog">
                    <div class="modal-content1">
                        <div class="modal-header">
                            <img src="assets/images/icons/MemberIcon.png" class="imgcol" style="width: 50px; height: 50px;" />
                            <h5 class="modal-title">Login Required</h5>
                            <button type="button" class="btn-close" @click.prevent="closemodal()" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body mbodyaccess">
                            <div class="p-sm-7">
                                <p class="mb-0">New here?<a href="sign-up.html"> Already a Subscriber ?</a></p>

                                <form class="mt-4 text-start">
                                    <div class="mb-3">
                                        <label class="form-label">Enter email id</label>
                                        <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="user.email" ref="email" />
                                        <span v-if="errors.email" class="invalid-feedback">{{errors.email[0]}}</span>
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Enter password</label>
                                        <input class="form-control fakepassword" type="password" :class="{ 'is-invalid': errors.password }" v-model="user.password" ref="password" id="psw-input" />
                                        <span class="position-absolute top-50 end-0 translate-middle-y p-0 mt-3">
                                            <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i>
                                        </span>
                                        <span v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</span>
                                    </div>

                                    <div class="mb-3 d-sm-flex justify-content-between">
                                        <div>
                                            <input type="checkbox" class="form-check-input" id="rememberCheck" />
                                            <label class="form-check-label" for="rememberCheck">Remember me?</label>
                                        </div>
                                        <router-link to="/forgot_password">Forgot password?</router-link>
                                    </div>

                                    <div><button type="button" class="btn btn-primary w-100 mb-0" @click.prevent="login">Login</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                            <div class="card-body vstack gap-4">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center p-0">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm">
                                                <img class="avatar-img" src="assets/images/mail.png" alt="avatar" />
                                            </div>

                                            <div class="ms-2">
                                                <h6 class="mb-0">Share Bid Details</h6>
                                            </div>
                                        </div>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                    </div>

                                    <form class="card-body" style="min-width: 350px;">
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

    <teleport to="#modals" v-disabled="!sharebid" v-if="sharebid">
        <div class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <div class="card border">
                            <div class="card-body vstack gap-4">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center p-0">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm">
                                                <img class="avatar-img" src="assets/images/mail.png" alt="avatar" />
                                            </div>

                                            <div class="ms-2">
                                                <h6 class="mb-0">Share Bid Detail</h6>
                                            </div>
                                        </div>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                    </div>

                                    <form class="card-body" style="min-width: 350px;">
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

    <teleport to="#modals" v-disabled="!saveSearchbid" v-if="saveSearchbid">
        <div class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <div class="card border">
                            <div class="card-body vstack gap-4">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center p-0">
                                        <div class="d-flex align-items-center">
                                            <div class="ms-2">
                                                <h5 class="modal-title" id="exampleModalLabel11">Save Search</h5>
                                            </div>
                                        </div>

                                        <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                    </div>

                                    <form class="card-body">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">Label <span class="text-danger">*</span></div>
                                            <input class="form-control" type="text" placeholder="Name" :class="{'is-invalid': errors.alert_label}" v-model="savesearch.alert_label" ref="alert_label" />
                                            <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                                        </div>
                                        <div class="modal-footer pt-3">
                                            <button type="button" style="margin-right: 3px;" class="btn btn-secondary" @click.prevent="closemodal()" ref="Close">
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
    <teleport to="#modals" :disabled="!errordeletealertmodal" v-if="errordeletealertmodal">
        <div class="modal-overlay">
            <div class="confirm" style="background-color: white !important;">
                <h1>Are you sure?</h1>
                <p>Do you really want to delete these records? This process cannot be undone.</p>
                <button style="background-color: white !important;" @click.prevent="closemodal()">Cancel</button>
                <button style="color: red !important; background-color: white !important;" @click.prevent="deleteSearch(deleteduser)">Confirm</button>
            </div>
        </div>
    </teleport>
</template>

<script>
    import Pagination from "@/components/Pagination.vue";
    import moment from "moment";
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
    export default {
        setup() {
            const isOpen = ref(false);
            const savebidopen = ref(false);
            return { isOpen, savebidopen };
        },
        components: { Loading, DatePicker, Pagination, Vue3TagsInput, TreeItem, PscTree, LoginModal, SaveModal, SaveSearch, SetAlertModal, Skeleton },

        data() {
            return {
                user: {
                    email: "",
                    password: "",
                },
                searchnaics: [],
                errordeletealertmodal: false,
                valid_email: false,
                error_email_msg: [],
                poststatus: false,
                responsestatus: false,
                login_modal: false,
                save_search: false,
                set_alert: false,
                respStatus: false,
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
                allFilterState: [],

                tags: [],
                tag: "",
                limit: 3,
                user: {
                    email: "",
                    password: "",
                },
                userModal: false,
                alertModal: false,
                arraylen: [],
                listview: true,
                gridview: false,
                blurmodal: false,
                alertmodal: false,
                emailmodal: false,
                userlogin: false,
                sharealertmodal: false,
                erroralertmodal: false,
                saveSearchbid: false,
                modal1: false,
                modal2: false,
                setalert: false,
                sharebid: false,
                alertSubscribe: false,
                status: false,
                savebidsstatus: true,
                tabs: "",
                savedserachbids: [],
                subscriptions: {},
                savedserach: {
                    user_id: "",
                    region_id: "",
                    id: "",
                },
                searchstate: "",
                searcFederal: "",
                region_id: 1,
                currentTab: 1,
                liststate: {
                    country_id: [10],
                },

                statussearch: true,
                selected: [],
                selectedFederal: [],
                selectAll: false,
                selectAllFederal: false,

                agencyFederal: [],
                mails: "",
                sendMails: {
                    bids: [],
                    mails: [],
                    email: "subhash@aeriesys.com",
                    subject: "",
                    message: "",
                    bid_or_doc: "bid",
                    region_id: 2,
                },
                shareBid: {
                    bids: [],
                    mails: [],
                    email: "subhash@aeriesys.com",
                    subject: "",
                    message: "",
                    bid_or_doc: "bid",
                    region_id: 2,
                },

                searchmy: "",
                FedralOppotunities: [],
                search_notice: [],
                asideStatus: [],
                tender_type: [],
                sideStatus: [],

                awards: [],
                state_country: [],
                naics: [],
                bidAlert: [],
                alertuser: {
                    id: "",
                    user_id: "",
                },
                alertSearch: {},
                teststate: [],
                searchfilter: {
                    alert_label: "",
                    tdr_notice: [],
                    tdr_status: [],
                    tdr_type: [],
                    tdr_type_of_award: [],
                    tdr_set_aside_status: [],
                    tdr_category: [],
                    tdr_state: [],
                    tdr_naics: [],
                    tdr_agency: [],
                    tdr_psc: [],
                    response_date: "",
                    posted_date: "",
                    posted_from_date: "",
                    posted_to_date: "",
                    response_from_date: "",
                    response_to_date: "",
                    keywords: "",
                },
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
                meta: {
                    search: "",
                    order_by: "asc",
                    field: "",
                    per_page: 10,
                    totalRows: 0,
                    currentPage: 1,
                    lastPage: 1,
                    from: 1,
                    maxPage: 1,
                    to: "",
                },
                alert: {
                    tdr_naics: [],
                },
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
                    agency_fedral: "",
                    created_on: "",
                    updated_on: "",
                },
                deleteduser: "",
                savedserach: {
                    user_id: "",
                    region_id: "",
                    id: "",
                },
                filters: [],
                allFilterAgency: [],
                statecount: 0,
                agencycount: 0,
                testdatastate: [],
                errors: [],
                btncancel: true,
                arrayitemsearch: [],
                searchdata: "",
                bidsearchStatus: true,
                scbscribemsg: "",
                naics_code: {
                    search: "",
                    alert_id: "",
                    save_bid_id: "",
                    tdr_naics: [],
                },
                service_code: {
                    search: "",
                    alert_id: "",
                    save_bid_id: "",
                    tdr_psc: [],
                },
                hidecartstatue: false,
                status: true,
                savedbids: "",
                runbids: [],
                isLoading: false,
                isLoading1: false,
                isLoading2: false,
                fullPage: false,
                txt1: "",
                colorCache: {},
                clear_all_naics:false,
                clear_all_psc:false,
            };
        },

        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.$store.commit("setPage", "bids");
                vm.fullPage = true;
                if (to.query.region_id == 2) {
                    vm.savesearch.alert_label = vm.$store.getters.alert.alert_label;
                    vm.searchfilter.alert_label = vm.$store.getters.alert.alert_label;
                    vm.runbids = vm.$store.getters.alert.naics_id ? vm.$store.getters.alert.naics_id.split(",") : [];
                    vm.searchfilter.tdr_set_aside_status = vm.$store.getters.alert.set_aside_status ? vm.$store.getters.alert.set_aside_status.split(",") : [];
                    vm.searchfilter.tdr_notice = vm.$store.getters.alert.notice_type ? vm.$store.getters.alert.notice_type.split(",") : [];
                    vm.searchfilter.tdr_agency = vm.$store.getters.alert.agency_fedral ? vm.$store.getters.alert.agency_fedral.split("@") : [];
                    vm.selectedFederal = vm.searchfilter.tdr_agency;
                    vm.searchfilter.tdr_state = vm.$store.getters.alert.state_id ? vm.$store.getters.alert.state_id.split(",") : [];
                    vm.selected = vm.searchfilter.tdr_state;
                    vm.searchfilter.tdr_type = vm.$store.getters.alert.tdr_type ? vm.$store.getters.alert.tdr_type.split(",") : [];
                    vm.searchfilter.tdr_type_of_award = vm.$store.getters.alert.tdr_type_of_award ? vm.$store.getters.alert.tdr_type_of_award.split(",") : [];

                    vm.searchfilter.tdr_naics = vm.runbids;
                    vm.searchfilter.tdr_psc = vm.$store.getters.alert.psc ? vm.$store.getters.alert.psc.split(",") : [];
                    vm.tags = vm.$store.getters.alert.keywords ? vm.$store.getters.alert.keywords.split(",") : [];
                    vm.searchfilter.keywords = vm.tags;

                    vm.naics_code.alert_id = vm.$store.getters.alert.id;
                    vm.savealert = vm.$store.getters.alert;
                }else if(from.name=='bidsDetailsPage' && vm.$store.getters.searchfilter){
                    vm.searchfilter = vm.$store.getters.searchfilter
                }
            });
        },

        mounted() {
            let vm = this;
            vm.frequency = "";
            vm.getServiceCodes();
            vm.getNaics();
            vm.getSate();
            vm.getFedral();
            vm.callFunction();
            vm.closerested();
            vm.checklogin();
            vm.hideCart();
            moment.updateLocale("language_code", {
                invalidDate: "--",
            });
        },

        computed: {
            uniquenotice() {
                return this.filters.reduce((filternotice, current) => {
                    return Object.assign(filternotice, {
                        [current.id]: current,
                    });
                }, {});
            },

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
                if (vm.searchfilter.tdr_psc.length != 0) {
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
                this.$store.commit("setBidsDetails", bidsdetail)
                this.$store.commit("setSearchFilter", this.searchfilter);
                this.$router.push("/bids/" + "federal-opportunities" + "/" + bidsdetail.tdr_title + "-" + bidsdetail.tdr_no);
            },

            highlight(title) {
                if (!this.searchfilter.keywords) {
                    return title;
                }

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
                    this.tag == "";
                    return true;
                }
                this.tags.push(tag);
                this.removeDuplicates();
                this.searchfilter.keywords = this.tags;
                this.tag = "";

                this.getFedral();
            },
            removeDuplicates() {
                this.tags = [...new Set(this.tags)];
            },

            getFedralchangedate() {
                this.getFedral();
            },

            showModal() {
                this.userModal = true;
                if (this.searchfilter.alert_label) {
                    this.status = false;
                } else this.status = true;
                if (this.$store.getters.user?.subscription_id === 0) {
                    this.alertSubscribe = true;
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

            loginModal() {
                let vm = this;

                if (vm.$store.getters.user == null) {
                    vm.isOpen = true;
                } else {
                    vm.savebidopen = true;
                }
            },
            close() {
                this.isOpen = !this.isOpen;
            },
            saveclose() {
                this.savebidopen = !this.savebidopen;
            },
            deselectNaics() {
                this.isLoading1 = true
                setTimeout(() => {
                    this.clear_all_naics = !this.clear_all_naics
                    this.isLoading1 = false
                }, 1000);
            },
            deselectPsc() {
                this.isLoading2 = true
                setTimeout(() => {
                    this.clear_all_psc = !this.clear_all_psc
                    this.isLoading2 = false
                }, 1000);
            },
            applyFilterNaics() {
                let vm = this;
                let sub_filtes = [];
                this.searchfilter.tdr_naics = [];
                this.searchfilter.tdr_naics = this.$store.getters.selected_naicses;
                if (this.searchfilter.tdr_naics.length) {
                    console.log(this.searchfilter.tdr_naics);
                    sub_filtes = vm.filters.filter(function (element) {
                        return element.table != "tdr_naics";
                    });
                    sub_filtes.push({
                        table: "tdr_naics",
                        id: "naics_code_" + this.searchfilter.tdr_naics.length,
                        name: "NAICS Code :" + this.searchfilter.tdr_naics.length,
                    });
                    vm.filters = sub_filtes;
                } else {
                    this.searchfilter.tdr_naics = [];
                    let temp_filters = vm.filters.filter(function (element) {
                        return element.table != "tdr_naics";
                    });
                    vm.filters = temp_filters;
                }

                this.getFedral();
            },
            applyFilterPsc() {
                let vm = this;
                let sub_filtes = [];
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
                } else {
                    this.searchfilter.tdr_psc = [];
                    let temp_filters = vm.filters.filter(function (element) {
                        return element.table != "tdr_psc";
                    });
                    vm.filters = temp_filters;
                }
                vm.getFedral();
            },

            handleChangeTag(tags) {
                let vm = this;
                vm.tags = tags;
                vm.searchfilter.keywords = vm.tags;
                vm.getFedral();
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

                vm.setalert = true;
            },
            openSaveSearch() {
                let vm = this;

                if (vm.$store.getters.user == null) {
                    vm.userlogin = true;
                } else {
                    vm.saveSearchbid = true;
                }
            },

            filterAgency() {
                if (this.searcFederal == "") {
                    this.agencyFederal = this.allFilterAgency;
                }
                this.agencyFederal = this.allFilterAgency.filter((entry) => {
                    return entry.agency_name.toLowerCase().includes(this.searcFederal.toLowerCase());
                });
            },

            filterState() {
                if (this.state_country == "") {
                    this.state_country = this.allFilterState;
                }
                this.state_country = this.allFilterState.filter((entry) => {
                    return entry.state_name.toLowerCase().includes(this.searchstate.toLowerCase());
                });
            },
            filterbids() {
                let runkey = this.FedralOppotunities.filter((entry) => {
                    return entry.tdr_title.toLowerCase().includes(this.searchfilter.keywords.toLowerCase());
                });
            },
            closerested() {
                if (this.state_country.length === 0) {
                    this.btncancel = true;
                }
            },

            showModal1() {
                let userlogin = this.$store.getters.user;
                if (userlogin === null) {
                    this.modal1 = true;
                    this.modal2 = false;
                } else {
                    this.modal2 = true;
                    this.modal1 = false;
                }
            },

            closemodal() {
                let vm = this;
                vm.userModal = false;
                vm.modal1 = false;
                vm.login = false;
                vm.alertSubscribe = false;
                vm.emailmodal = false;
                vm.erroralertmodal = false;
                vm.errordeletealertmodal = false;
                vm.alertmodal = false;
                vm.sharealertmodal = false;
                vm.setalert = false;
                vm.userlogin = false;
                vm.saveSearchbid = false;
                vm.sharebid = false;
                vm.shareMail.bids = [];
                vm.shareMail.mails = [];
                (vm.frequency = ""), (vm.errors = []);
            },
            runAlert() {},

            timecalcu(currenttime, bidtime) {
                let startTime = moment(currenttime, "YYYY-MM-DD HH");
                let end = moment(bidtime, "YYYY-MM-DD HH");
                let duration = moment.duration(end.diff(startTime));
                let hours = duration.asHours();
                return hours;
            },

            currenttime() {
                let now = moment();
                return now.format("YYYY-MM-DD hh:mm:ss");
            },
            currentDate() {
                let now = moment();
                return now.format("YYYY-MM-DD");
            },

            dateFormat(value) {
                return moment(value).format("ll");
            },
            timeformat(value) {
                return moment(value).locale("sv").format("HH:mm:ss");
            },
            datecalcu(startDate, endDate) {
                console.log(startDate)
                var newstartDate = moment(startDate, "YYYY-MM-DD");
                var endendDate = moment(endDate, "YYYY-MM-DD");
                var dayDiff = newstartDate.diff(endendDate, "days");
                console.log(newstartDate)
                console.log(endDate)
                console.log(dayDiff)
                return dayDiff;
            },

            addCart(fedralopption) {
                let vm = this;
                vm.$store.commit("addTocart", fedralopption);
                vm.getFedral();
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

            chekcforlogin() {
                let vm = this;
                if (vm.$store.state.user === null) {
                    vm.$refs.rolesSelected.checked === false;
                    vm.modal1 = true;
                }

                vm.$refs.rolesSelected.checked === true;
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
            shareMail() {
                let vm = this;
                vm.shareBid.mails = vm.mails.split(",");
                if (vm.shareBid.mails[0] == "") {
                    vm.shareBid.mails.splice(0);
                } else {
                    vm.shareBid.mails = vm.mails.split(",");
                }
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: "sendMailWithBids", data: vm.shareBid })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Share Bids successfully");
                        vm.closemodal();
                        vm.shareBid.bids = [];
                        vm.shareBid.mails = [];
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getFedral() {
                let vm = this;
                vm.fullPage = false;
                vm.searchfilter.keywords = vm.tags.toString();

                let uri = "searchBidsForFedralOppotunities?page=" + vm.meta.currentPage + "&search=" + vm.meta.search + "&order_by=" + vm.meta.order_by + "&field=" + vm.meta.field + "&per_page=" + vm.meta.per_page;
                vm.isLoading = true;

                vm.$store
                    .dispatch("post", { uri: uri, data: vm.searchfilter })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.FedralOppotunities = response.data.data;
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

            getNotice() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getNotice" })
                    .then(function (response) {
                        vm.search_notice = response.data.data;
                        if (vm.searchfilter.tdr_notice.length) vm.appendNoticeToFilter(vm.searchfilter.tdr_notice);
                        vm.getfederalAgency();
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getTender() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getTenderType" })
                    .then(function (response) {
                        vm.tender_type = response.data.data;
                        if (vm.searchfilter.tdr_type.length) vm.appendContractTypeToFilter(vm.searchfilter.tdr_type);
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
                        if (vm.searchfilter.tdr_set_aside_status.length) vm.appendSetAsideStatusToFilter(vm.searchfilter.tdr_set_aside_status);
                        vm.getAward();
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
                        if (vm.searchfilter.tdr_type_of_award.length) vm.appendAwardTypeToFilter(vm.searchfilter.tdr_type_of_award);
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
                        if (vm.searchfilter.tdr_state.length) vm.appendStateToFilter(vm.searchfilter.tdr_state);
                        vm.getNotice();
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
                        vm.allFilterAgency = vm.agencyFederal;
                        vm.agencycount = vm.agencyFederal.length;
                        if (vm.searchfilter.tdr_agency.length) vm.appendFederalAgencyToFilter(vm.searchfilter.tdr_agency);
                        vm.getTender();
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
                    this.searchfilter.tdr_state = this.selected;
                    this.getFedral();
                }
            },
            Deselect() {
                this.selected = [];
                this.searchfilter.tdr_state = [];
                this.filters.filter((x) => x.table === "state").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getFedral();
            },
            updateCheckall(state) {
                if (this.state_country.length == this.selected.length) {
                    this.selected = [];
                    this.selectAll = true;
                    this.searchfilter.tdr_state = this.selected;
                    this.getFedral();
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
                } else {
                    let i = this.filters.findIndex((data) => data.id === state.state_id);
                    if (i !== -1) {
                        this.filters.splice(i, 1);
                        this.getFedral();
                    } else {
                        this.filters.push({
                            table: "state",
                            id: state.state_id,
                            name: state.state_name,
                        });

                        this.filters = this.filters.filter((state, index) => this.filters.indexOf(state) === index);
                    }
                    this.selectAll = false;
                    this.searchfilter.tdr_state = this.selected;
                    this.getFedral();
                }
            },

            selectfederal() {
                this.selectedFederal = [];
                this.selectAllFederal = false;
                if (!this.selectAllFederal) {
                    this.filters.filter((x) => x.table === "agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                    for (let i in this.agencyFederal) {
                        this.selectedFederal.push(this.agencyFederal[i].agency_name);
                        this.filters.push({
                            table: "agency",
                            id: this.agencyFederal[i].agency_id,
                            name: this.agencyFederal[i].agency_name,
                        });
                    }

                    this.searchfilter.tdr_agency = this.selectedFederal;
                    this.getFedral();
                }
            },
            Deselectfederal() {
                this.selectedFederal = [];
                this.searchfilter.tdr_agency = [];
                this.stateFederalfilter = [];
                this.filters.filter((x) => x.table === "agency").forEach((x) => this.filters.splice(this.filters.indexOf(x), 1));
                this.getFedral();
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
                        this.getFedral();
                    } else {
                        this.filters.push({
                            table: "agency",
                            id: federal.agency_id,
                            name: federal.agency_name,
                        });

                        this.filters = this.filters.filter((federal, index) => this.filters.indexOf(federal) === index);
                    }

                    this.selectAllFederal = false;

                    this.searchfilter.tdr_agency = this.selectedFederal;
                    this.getFedral();
                }
            },

            callFunction: function () {
                var currentDateWithFormat = new Date().toJSON().slice(0, 10).replace(/-/g, "/");
                this.savesearch.created_on = currentDateWithFormat;
                this.savesearch.updated_on = currentDateWithFormat;
                this.savealert.created_on = currentDateWithFormat;
                this.savealert.updated_on = currentDateWithFormat;
            },

            showdate() {
                this.responsestatus = true;
            },
            hidedate() {
                let vm = this;

                vm.searchfilter.posted_from_date = "";
                vm.searchfilter.posted_to_date = "";
            },

            showresponsedate() {},
            hideresponsedate() {
                let vm = this;
                vm.responsestatus = true;
                vm.respStatus = false;

                vm.searchfilter.response_from_date = "";
                vm.searchfilter.response_to_date = "";
            },

            onPageChange(page) {
                this.meta.currentPage = page;
                window.scrollTo({ top: 0, behavior: 'smooth' });
                this.getFedral();
            },
            onPerPageChange() {
                this.meta.currentPage = 1;
                this.getFedral();
            },

            addAlert(alert) {
                let vm = this;
                if (vm.searchfilter.tdr_state.length == 0 && vm.searchfilter.tdr_notice.length == 0 && vm.searchfilter.keywords.length == 0) {
                    vm.erroralertmodal = true;
                    vm.alertModal = false;
                }
                vm.savealert.user_id = vm.$store.getters.user.id;
                vm.savealert.region_id = 2;
                vm.savealert.keywords = vm.searchfilter.keywords.toString();
                vm.savealert.state_id = vm.searchfilter.tdr_state.toString();
                vm.savealert.naics_id = vm.searchfilter.tdr_naics.toString();
                vm.savealert.psc = vm.searchfilter.tdr_psc.toString();
                vm.savealert.set_aside_status = vm.searchfilter.tdr_set_aside_status.toString();
                vm.savealert.agency_fedral = vm.searchfilter.tdr_agency.toString();
                vm.savealert.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savealert.country_id = vm.liststate.country_id.toString();
                vm.savealert.alert_label = alert.alert_label;
                vm.savealert.frequency = alert.frequency;

                vm.$store
                    .dispatch("post", { uri: "addAlert", data: vm.savealert })
                    .then(function (response) {
                        vm.federal = response.data.data;
                        vm.getPscesBackend();
                        vm.getNaicsesBackend();
                        vm.$store.dispatch("success", "Alert Added successfully");
                        vm.$router.push("/bids/save-alert");
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            updateAlert(alert) {
                let vm = this;
                if (vm.searchfilter.tdr_state.length == 0 && vm.searchfilter.tdr_notice.length == 0 && vm.searchfilter.keywords.length == 0) {
                    vm.erroralertmodal = true;
                    vm.alertModal = false;
                }
                vm.savealert.user_id = vm.$store.getters.user.id;
                vm.savealert.region_id = 2;
                vm.savealert.keywords = vm.searchfilter.keywords.toString();
                vm.savealert.state_id = vm.searchfilter.tdr_state.toString();
                vm.savealert.naics_id = vm.searchfilter.tdr_naics.toString();
                vm.savealert.psc = vm.searchfilter.tdr_psc.toString();
                vm.savealert.set_aside_status = vm.searchfilter.tdr_set_aside_status.toString();
                vm.savealert.agency_fedral = vm.searchfilter.tdr_agency.toString();
                vm.savealert.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savealert.country_id = vm.liststate.country_id.toString();
                vm.savealert.alert_label = alert.alert_label;
                vm.savealert.frequency = alert.frequency;

                vm.$store
                    .dispatch("post", { uri: "updateAlert/" + vm.savealert.id, data: vm.savealert })
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

            checkout() {
                let vm = this;
                if (vm.$store.getters.user.id === null) {
                    vm.$router.push("/login");
                } else {
                    // vm.$router.push('/ShippingMethods');
                }
            },
            saveSearch(alert_label) {
                let vm = this;
                vm.savesearch.user_id = vm.$store.getters.user.id;
                vm.savesearch.alert_label = alert_label;
                vm.savesearch.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savesearch.state_id = vm.searchfilter.tdr_state.toString();
                vm.savesearch.keywords = vm.searchfilter.keywords;
                vm.savesearch.naics_id = vm.searchfilter.tdr_naics.toString();
                vm.savesearch.psc = vm.searchfilter.tdr_psc.toString();
                vm.savesearch.notice_type = vm.searchfilter.tdr_notice.toString();
                vm.savesearch.set_aside_status = vm.searchfilter.tdr_set_aside_status.toString();
                vm.savesearch.agency_fedral = vm.searchfilter.tdr_agency.toString();
                vm.savesearch.tdr_type = vm.searchfilter.tdr_type.toString();
                vm.savesearch.tdr_type_of_award = vm.searchfilter.tdr_type_of_award.toString();
                vm.savesearch.country_id;
                vm.savesearch.region_id;
                vm.savesearch.created_on;
                vm.savesearch.updated_on;
                vm.isLoading = true;
                vm.fullPage = true;
                vm.$store
                    .dispatch("post", { uri: "addSaveBids", data: vm.savesearch })
                    .then(function () {
                        vm.$store.dispatch("success", "Bids Saved successfully");
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.userModal = false;
                        vm.savesearch.alert_label = "";
                        vm.getPscesBackend();
                        vm.getNaicsesBackend();
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
                vm.savedserach.region_id = 2;
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
            updateSearch(savedbids) {
                let vm = this;

                vm.savesearch.alert_label = savedbids.alert_label;
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
                vm.isLoading = true;
                vm.fullPage = true;

                vm.$store
                    .dispatch("post", {
                        uri: "updateSaveBids/" + savedbids.id,
                        data: vm.savesearch,
                    })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Saved Search Updated successfully");
                        vm.getSavedsearch();
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.clearAllFilters();
                        vm.closemodal();
                        vm.tag = "";
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            deleteAlertpopup(userintersted) {
                this.errordeletealertmodal = true;
                this.deleteduser = userintersted;
            },
            deleteSearch(deleteduser) {
                let vm = this;

                vm.isLoading = true;
                vm.fullPage = true;
                let uri = { uri: "deleteSaveBids/" + deleteduser };
                vm.$store
                    .dispatch("delete", uri)
                    .then(function () {
                        vm.$store.dispatch("success", "Search Bid is successfully deleted");
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errordeletealertmodal = false;
                        vm.getSavedsearch();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            runSearch(savedbids) {
                let vm = this;
                vm.statussearch = false;
                vm.savedbids = savedbids;
                vm.searchfilter.alert_label = savedbids.alert_label;
                vm.searchfilter.tdr_set_aside_status = savedbids.set_aside_status ? savedbids.set_aside_status.split(",") : [];
                vm.searchfilter.tdr_notice = savedbids.notice_type ? savedbids.notice_type.split(",") : [];
                vm.searchfilter.tdr_state = savedbids.state_id ? savedbids.state_id.split(",") : [];
                vm.searchfilter.tdr_type = savedbids.tdr_type ? savedbids.tdr_type.split(",") : [];
                vm.searchfilter.tdr_type_of_award = savedbids.tdr_type_of_award ? savedbids.tdr_type_of_award.split(",") : [];
                vm.searchfilter.tdr_agency = savedbids.agency_fedral ? savedbids.agency_fedral.split(",") : [];
                vm.searchfilter.tdr_naics = savedbids.naics_id ? savedbids.naics_id.split(",") : [];
                vm.searchfilter.tdr_psc = savedbids.psc ? savedbids.psc.split(",") : [];
                vm.savesearch.alert_label = savedbids.alert_label;
                vm.selected = vm.searchfilter.tdr_state;
                vm.selectedFederal = vm.searchfilter.tdr_agency;
                vm.searchfilter.keywords = savedbids.keywords;
                vm.tags = vm.searchfilter.keywords ? vm.searchfilter.keywords.split(",") : [];
                vm.allFilterState;
                vm.appendStateToFilter(vm.searchfilter.tdr_state);
                vm.appendNoticeToFilter(vm.searchfilter.tdr_notice);
                vm.appendFederalAgencyToFilter(vm.searchfilter.tdr_agency);
                vm.appendNaicsCodeToFilter(vm.searchfilter.tdr_naics);
                vm.appendPscCodeToFilter(vm.searchfilter.tdr_psc);
                vm.appendContractTypeToFilter(vm.searchfilter.tdr_type);
                vm.appendAwardTypeToFilter(vm.searchfilter.tdr_type_of_award);
                vm.appendSetAsideStatusToFilter(vm.searchfilter.tdr_set_aside_status);
                vm.naics_code.save_bid_id = savedbids.id;
                vm.service_code.save_bid_id = savedbids.id;
                vm.getNaics();
                vm.getServiceCodes();
                vm.getFedral();
            },

            appendStateToFilter(state) {
                let vm = this;
                if (Array.isArray(state)) {
                    state.map(function (element) {
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
            appendNoticeToFilter(notice) {
                let vm = this;

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

            appendFederalAgencyToFilter(federal_agencies) {
                let vm = this;
                if (Array.isArray(federal_agencies)) {
                    federal_agencies.map(function (element) {
                        vm.filters.push({
                            table: "federal_agency",
                            id: 1,
                            name: element,
                        });
                    });
                }
            },

            appendNaicsCodeToFilter(tdr_naics_codes) {
                let vm = this;
                if (Array.isArray(tdr_naics_codes) && tdr_naics_codes.length) {
                    vm.filters.push({
                        table: "tdr_naics",
                        id: "naics_code_" + vm.searchfilter.tdr_naics.length,
                        name: "NAICS Code :" + vm.searchfilter.tdr_naics.length,
                    });
                }
            },

            appendPscCodeToFilter(tdr_psc) {
                let vm = this;
                if (Array.isArray(tdr_psc) && tdr_psc.length) {
                    vm.filters.push({
                        table: "tdr_psc",
                        id: "psc_code_" + vm.searchfilter.tdr_psc.length,
                        name: "PSC Code :" + vm.searchfilter.tdr_psc.length,
                    });
                }
            },

            appendContractTypeToFilter(tdr_types) {
                let vm = this;
                if (Array.isArray(tdr_types)) {
                    tdr_types.map(function (element) {
                        let contract_type_obj = vm.tender_type.filter(function (ele) {
                            return ele.tdr_type_id == element;
                        });
                        if (contract_type_obj.length) {
                            vm.filters.push({
                                table: "tender_type",
                                id: contract_type_obj[0].tdr_type_id,
                                name: contract_type_obj[0].tdr_type_name,
                            });
                        }
                    });
                } else {
                    let contract_type_obj = vm.tender_type.filter(function (ele) {
                        return element.tdr_type_id == tdr_types;
                    });
                    if (contract_type_obj.length) {
                        vm.filters.push({
                            table: "tender_type",
                            id: contract_type_obj[0].tdr_type_id,
                            name: contract_type_obj[0].tdr_type_name,
                        });
                    }
                }
            },

            appendAwardTypeToFilter(award_types) {
                let vm = this;
                if (Array.isArray(award_types)) {
                    award_types.map(function (element) {
                        let award_type_obj = vm.awards.filter(function (ele) {
                            return ele.type_of_award_id == element;
                        });
                        if (award_type_obj.length) {
                            vm.filters.push({
                                table: "type_of_awards",
                                id: award_type_obj[0].type_of_award_id,
                                name: award_type_obj[0].type_of_award_name,
                            });
                        }
                    });
                } else {
                    let award_type_obj = vm.awards.filter(function (ele) {
                        return ele.type_of_award_id == award_types;
                    });
                    if (award_type_obj.length) {
                        vm.filters.push({
                            table: "type_of_awards",
                            id: award_type_obj[0].type_of_award_id,
                            name: award_type_obj[0].type_of_award_name,
                        });
                    }
                }
            },
            appendSetAsideStatusToFilter(set_aside_statuses) {
                let vm = this;
                if (Array.isArray(set_aside_statuses)) {
                    set_aside_statuses.map(function (element) {
                        let set_aside_status_obj = vm.sideStatus.filter(function (ele) {
                            return ele.status_id == element;
                        });
                        if (set_aside_status_obj.length) {
                            vm.filters.push({
                                table: "set_aside_status",
                                id: set_aside_status_obj[0].status_id,
                                name: set_aside_status_obj[0].status_name,
                            });
                        }
                    });
                } else {
                    let set_aside_status_obj = vm.sideStatus.filter(function (ele) {
                        return ele.status_id == set_aside_statuses;
                    });
                    if (set_aside_status_obj.length) {
                        vm.filters.push({
                            table: "set_aside_status",
                            id: set_aside_status_obj[0].status_id,
                            name: set_aside_status_obj[0].status_name,
                        });
                    }
                }
            },

            clearAllFilters() {
                let vm = this;
                vm.deselectNaics();
                vm.deselectPsc();
                vm.searchfilter.alert_label = "";
                vm.searchfilter.tdr_notice = [];
                vm.searchfilter.tdr_status = [];
                vm.searchfilter.tdr_type = [];
                vm.searchfilter.tdr_type_of_award = [];
                vm.searchfilter.tdr_set_aside_status = [];
                vm.searchfilter.tdr_category = [];
                vm.searchfilter.tdr_state = [];
                vm.searchfilter.tdr_naics = [];
                vm.searchfilter.tdr_psc = [];
                vm.searchfilter.tdr_agency = [];
                vm.searchfilter.response_date = "";
                vm.searchfilter.posted_date = "";
                vm.searchfilter.posted_from_date = "";
                vm.searchfilter.posted_to_date = "";
                vm.searchfilter.response_from_date = "";
                vm.searchfilter.response_to_date = "";
                vm.searchfilter.keywords = "";
                vm.selectedFederal = [];
                vm.selected = [];
                vm.tags = [];
                vm.filters = [];
                vm.contractTypefilter = [];
                vm.typeOfAwardfilter = [];
                vm.setAsidefilter = [];
                vm.statefilter = [];
                vm.hideresponsedate();
                vm.hidedate();
                vm.getFedral();
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
                        vm.$store.commit("setUser", response.data);
                        vm.$store.commit("setToken", response.data.token);

                        vm.$router.push("/plans_pricing");
                        vm.closemodal();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.fullPage = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            addTag() {
                if (!this.tagValue == "") {
                    this.tags.push(this.tagValue);

                    this.tagValue = "";
                    this.removeDuplicates();
                }
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

            listviewgrid() {
                this.listview = false;
                this.gridview = true;
                this.meta.per_page = 38;
                this.getFedral();
            },
            gridviewgrid() {
                this.listview = true;
                this.gridview = false;
                this.meta.per_page = 10;
                this.getFedral();
            },

            removeTagnotice(filter) {
                let myIndex = this.filters.indexOf(filter);

                this.filters.splice(myIndex, 1);

                let tdr_notice = this.searchfilter.tdr_notice.filter(function (element) {
                    return element != filter.id;
                });
                this.searchfilter.tdr_notice = tdr_notice;

                let tdr_type = this.searchfilter.tdr_type.filter(function (element) {
                    return element != filter.id;
                });
                this.searchfilter.tdr_type = tdr_type;

                let tdr_type_of_award = this.searchfilter.tdr_type_of_award.filter(function (element) {
                    return element != filter.id;
                });
                this.searchfilter.tdr_type_of_award = tdr_type_of_award;

                let tdr_set_aside_status = this.searchfilter.tdr_set_aside_status.filter(function (element) {
                    return element != filter.id;
                });
                this.searchfilter.tdr_set_aside_status = tdr_set_aside_status;

                let tdr_state = this.searchfilter.tdr_state.filter(function (element) {
                    return element != filter.id;
                });

                if (filter.table === "tdr_naics") {
                    this.$store.commit("setSelectedNaics", []);
                    this.$store.commit("setSelectedNaicsItems", []);
                    this.searchfilter.tdr_naics = [];
                }
                if (filter.table === "tdr_psc") {
                    this.$store.commit("setSelectedPsces", []);
                    this.$store.commit("setSelectedPscItems", []);
                    this.searchfilter.tdr_psc = [];
                }

                this.searchfilter.tdr_state = tdr_state;
                this.selected = tdr_state;

                let tdr_status = this.searchfilter.tdr_status.filter(function (element) {
                    return element != filter.id;
                });
                this.searchfilter.tdr_status = tdr_status;

                let tdr_agency = this.searchfilter.tdr_agency.filter(function (element) {
                    return element !== filter.name;
                });
                this.searchfilter.tdr_agency = tdr_agency;
                this.selectedFederal = tdr_agency;

                if (filter.table == "ResponseDate") this.searchfilter.response_date = "";
                this.searchfilter.response_from_date = "";
                this.searchfilter.response_to_date = "";

                if (filter.table == "PostedDate") this.searchfilter.posted_date = "";
                this.searchfilter.posted_from_date = "";
                this.searchfilter.posted_to_date = "";

                this.getFedral();
            },

            removeDuplicatesfilter() {
                this.filters = [...new Set(this.filters)];
            },

            saveNotice(notice) {
                let i = this.filters.findIndex((data) => data.id === notice.notice_id);

                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getFedral();
                } else {
                    this.filters.push({
                        table: "notice",
                        id: notice.notice_id,
                        name: notice.notice_type,
                    });
                    this.getFedral();
                }
            },

            saveContracttype(tender) {
                let i = this.filters.findIndex((data) => data.id === tender.tdr_type_id);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getFedral();
                } else {
                    this.filters.push({
                        table: "contracttype",
                        id: tender.tdr_type_id,
                        name: tender.tdr_type_name,
                    });

                    this.filters = this.filters.filter((tender, index) => this.filters.indexOf(tender) === index);

                    this.getFedral();
                }
            },
            SaveTypeofAward(award) {
                let i = this.filters.findIndex((data) => data.id === award.type_of_award_id);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                } else {
                    this.filters.push({
                        table: "typeofaward",
                        id: award.type_of_award_id,
                        name: award.type_of_award_name,
                    });

                    this.getFedral();
                }
            },

            SaveStatusactive(active) {
                let i = this.filters.findIndex((data) => data.name === active);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getFedral();
                } else {
                    this.filters.push({
                        table: "status",
                        id: active,
                        name: active,
                    });

                    this.getFedral();
                }
            },
            SaveStatusexpried(expried) {
                let i = this.filters.findIndex((data) => data.name === expried);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getFedral();
                } else {
                    this.filters.push({
                        table: "statusExpried",
                        id: expried,
                        name: expried,
                    });

                    this.getFedral();
                }
            },

            SaveSetAside(sideStatu) {
                let i = this.filters.findIndex((data) => data.id === sideStatu.status_id);
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getFedral();
                } else {
                    this.filters.push({
                        table: "setAside",
                        id: sideStatu.status_id,
                        name: sideStatu.status_name,
                    });

                    this.getFedral();
                }
            },

            changeResponseDate(value) {
                let i = this.filters.findIndex((data) => data.table == "ResponseDate");
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getFedral();
                }
                this.filters.push({
                    table: "ResponseDate",
                    id: value,
                    name: value,
                });
                this.getFedral();
            },
            checkResponseDate() {
                if (this.searchfilter.response_from_date == "" && this.searchfilter.response_to_date == "" && this.searchfilter.posted_from_date == "" && this.searchfilter.posted_to_date == "") {
                    return true;
                }
                if (this.searchfilter.response_from_date !== "" && this.searchfilter.response_to_date !== "") {
                    if (this.searchfilter.response_from_date > this.searchfilter.response_to_date) {
                        this.errors = { response_error: "Start Date Less then End Date" };
                    } else {
                        this.errors = [];
                        this.getFedral();
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
                        this.getFedral();
                    }
                }
            },
            changePostedDate(value) {
                this.searchfilter.posted_from_date = moment().format("yyyy-m-dd");
                this.searchfilter.posted_to_date = moment().format("yyyy-m-dd");
                let i = this.filters.findIndex((data) => data.table == "PostedDate");
                if (i !== -1) {
                    this.filters.splice(i, 1);
                    this.getFedral();
                }
                this.filters.push({
                    table: "PostedDate",
                    id: value,
                    name: value,
                });
                this.getFedral();
            },
            shareBidfed(share) {
                let vm = this;
                vm.errors = [];
                vm.shareBid.bids = [];
                vm.shareBid.mails = [];
                vm.shareBid.bids.push(share.tdr_id);
                if (vm.$store.getters.user.subscription_id == 0) {
                    vm.alertSubscribe = true;

                    setTimeout(() => (this.alertSubscribe = false), 2000);
                } else {
                    if (vm.$store.getters.user == null) {
                        vm.userlogin = true;
                    } else {
                        vm.sharebid = true;
                    }
                }
            },
            getNaicsesBackend() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getNaics", data: vm.naics_code })
                    .then(function (response) {
                        vm.isLoading1 = false;
                        if (vm.searchfilter.tdr_naics.length) {
                            vm.treeData.children = response.data.data;
                        } else {
                            let naics = response.data.data;
                            vm.$store.dispatch("setNaics", naics);
                            let naics_store = vm.$store.getters.naicses;
                            vm.treeData.children = naics_store;
                        }
                        vm.getServiceCodes();
                    })
                    .catch(function (error) {
                        vm.isLoading1 = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getNaics() {
                let vm = this;
                vm.fullPage = false;
                vm.isLoading2 = false;
                vm.isLoading1 = true;
                if (vm.searchfilter.tdr_naics.length) {
                    vm.naics_code.tdr_naics = vm.searchfilter.tdr_naics;
                    vm.getNaicsesBackend();
                } else {
                    if (vm.$store.getters.naicses.length) {
                        vm.treeData.children = vm.$store?.getters?.naicses;
                        vm.isLoading1 = false;
                    } else {
                        vm.getNaicsesBackend();
                    }
                }
            },

            getPscesBackend() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getPsc", data: vm.service_code })
                    .then(function (response) {
                        vm.isLoading2 = false;
                        if (vm.searchfilter.tdr_psc.length) {
                            vm.service_codes.children = response.data.data;
                        } else {
                            vm.$store.dispatch("setPsces", response.data.data);
                            vm.service_codes.children = response.data.data;
                        }
                    })
                    .catch(function (error) {
                        vm.isLoading2 = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getServiceCodes() {
                let vm = this;
                vm.fullPage = false;
                vm.isLoading2 = true;
                vm.isLoading1 = false;
                if (vm.searchfilter.tdr_psc.length) {
                    vm.service_code.tdr_psc = vm.searchfilter.tdr_psc;
                    vm.getPscesBackend();
                } else {
                    if (vm.$store.getters.psces.length) {
                        vm.service_codes.children = vm.$store?.getters?.psces;
                        vm.isLoading2 = false;
                    } else {
                        vm.getPscesBackend();
                    }
                }
            },

            hideCart() {
                let vm = this;
                if (vm.$store.getters.user?.subscription_id === 0 || vm.$store.getters.user === null) {
                    vm.hidecartstatue = true;
                } else {
                    vm.hidecartstatue = false;
                }
            },
            checkplaceholder() {
                if (placeholder.length !== 0) {
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
    /* popup modal */

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

    /* width */
    .scroll1 ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    /* Track */
    .scroll1 ::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px;
    }

    /* Handle */
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

    /* width */
    .scroll1 ::-webkit-scrollbar {
        width: 5px;

        cursor: pointer;
    }

    /* Track */
    .scroll1 ::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey;  */
        border-radius: 10px;
    }

    /* Handle */
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

    .col-red {
        color: red;
    }

    /* tree css */

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
    /* .tree .nav-item1:after {
        content: "-";
        color: inherit;
        padding-left: 0rem;
        padding-right: 0.5rem;
        opacity: 0.8;
    }  */

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
    /*  */
    /* .modal-overlay1 {
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
 .modal-content1 {
        /* font-family: "Fondamento", cursive; */
    /* padding: 20px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        min-height: 200px;
        width: 480px;
        margin: 1rem;
        position: relative;
        min-width: 200px; */
    /* box-shadow: 0 3px 6px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 23%);
        justify-self: center;
        transition: all 5s ease-in-out; */
    /* }  */
    .highlight {
        color: yellow;
    }

    .v3ti .v3ti-tag {
        background: #f56c6c;
        /*border: 1px solid #222222;*/
        /*border-radius: 0;*/
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
        /*border: 1px solid #222222;*/
        /*border-radius: 0;*/
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
    .table-responsive {
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch;
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
        /* background: transparent; */
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
        /* top: 50%;
  left: 50%; */
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
        /* background: transparent; */
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
