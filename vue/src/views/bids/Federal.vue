<template>
    <Region />
    <loading v-model:active="isLoading" :can-cancel="false" :z-index="10001" :is-full-page="fullPage" />
    <div class="search">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 d-flex justify-content-between search-left my-auto" style="">
                    <div class="label">Filters</div>
                    <div class="empty" :class="{ bluetextclass: filters.length != 0 }">{{ countFilters }} filters
                        selected
                    </div>
                </div>

                <div class="col-md-4 my-auto">
                    <form class="bg-body shadow rounded-2">
                        <div class="input-group input-group-sm">
                            <vue3-tags-input class="form-control form-control-sm p-0 tag-center scrollinput"
                                @on-tags-changed="handleChangeTag" placeholder="Input keywords separated by comma"
                                v-model:tags="tags" :add-tag-on-keys="[13, 188]" v-model="tag" @allow-duplicates="false"
                                style="text-wrap: nowrap;" />
                            <span class="input-group-text p-0 bg-transparent"> <button class="btn btn-sm"
                                    @click.prevent="handleSelectedTag(tag)" type="button"
                                    id="button-addon2">Search</button> </span>
                        </div>
                    </form>
                </div>

                <div class="col-md-5 my-auto">
                    <ul class="list-inline hstack flex-wrap gap-4 mb-0 s-dropdown dropdown my-auto"
                        style="float: right;">
                        <li class="list-inline-item mb-0" v-if="tags?.length">
                            <a href="javascript:void(0)" class="" style="color: #747579;"
                                @click.prevent="showModal()"><i
                                    class="fa fa-save fa-fw fs-6 cursor-pointer text-primary me-1"></i>Save View</a>
                        </li>
                        <li class="cursor list-inline-item mb-0">
                            <a href="javascript:void(0)" style="color: #747579;" data-bs-toggle="modal"
                                @click.prevent="setAletModal()"><i class="fa fa-bell fa-fw fs-6 text-dark me-1"></i>Set
                                Alert</a>
                        </li>
                        <li class="cursor list-inline-item mb-0 s-dropdown dropdown hover1 mb-0 dropdown-toggle"
                            href="#" id="demoMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-save fa-fw text-success me-1"></i>Saved View

                            <ul class="s-dropdown-content dropdown-menu dphover"
                                style="max-height: 200px; overflow-y: scroll;" aria-labelledby="demoMenu">
                                <li v-for="federal_filter, key in federal_filters" :key="key"
                                    class="dropdown-item dropitem1 p-0 px-2">
                                    <i class="fas fa-caret-right text-primary my-auto"></i>
                                    <a class="dropdown-item dropitem2" href="javascript:void(0)"
                                        @click="showFederalFilter(federal_filter)">{{ federal_filter.federal_filter_name
                                        }}</a>
                                    <a href="javascript:void(0)" class="icon red my-auto">
                                        <i class="fa fa-trash text-danger blueicon" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="list-inline-item mb-0">
                            <a href="" @click.prevent="gridviewgrid()"> <i :class="{ gridblockcolor: gridview }"
                                    class="fa fa-th-large me-3"></i></a>
                            <a href="" @click.prevent="listviewgrid()"><i :class="{ gridblockcolor: listview }"
                                    class="fa fa-bars text-gray me-1"></i></a>
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
                        <form class="rounded-3 shadow" id="federal">
                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#status" role="button" aria-expanded="false"
                                    aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ bluetextclass: meta.active || meta.expired }">Status</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="status">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="all"
                                                v-model="meta.all" @click="updateStatus($event)" />
                                            <label class="form-check-label">All</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="active"
                                                v-model="meta.active" />
                                            <label class="form-check-label">Active</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="expired"
                                                v-model="meta.expired" />
                                            <label class="form-check-label">Expired</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />

                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#noticetype" role="button" aria-expanded="false"
                                    aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ bluetextclass: meta.federal_notices?.length !== 0 }">Notice Type</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="noticetype"
                                    v-for="notice in federal_notices" :key="notice.notice_id">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                v-model="meta.federal_notices" :value="notice.federal_notice_id" />
                                            <label class="form-check-label">{{ notice.notice_name }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />
                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#posted" role="button" aria-expanded="false"
                                    aria-controls="response">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.posted_date }">Posted Date</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="posted">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hour7" id="hour7"
                                                v-model="meta.posted_date" value="24 Hours" />
                                            <label class="form-check-label" for="hour7">24 Hours</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour8" name="hour7"
                                                v-model="meta.posted_date" value="2 Days" />
                                            <label class="form-check-label" for="hour8">2 Days</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour9" name="hour7"
                                                v-model="meta.posted_date" value="7 Days" />
                                            <label class="form-check-label" for="hour9">7 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour10" name="hour7"
                                                v-model="meta.posted_date" value="21 Days" />
                                            <label class="form-check-label" for="hour10">21 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="hour12"
                                                v-model="meta.posted_date" value="custom" />
                                            <label class="form-check-label" for="custom12"> &nbsp; Custom</label>
                                            <div class="row" v-if="meta.posted_date == 'custom'"
                                                style="margin-left: 0px;">
                                                <div class="col-sm-6">
                                                    <label class="form-label">Start Date<span
                                                            class="text-danger">*</span></label>
                                                    <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD"
                                                        v-model:value="meta.posted_from_date"
                                                        :clearable="false"></date-picker>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">End Date<span
                                                            class="text-danger">*</span></label>
                                                    <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD"
                                                        v-model:value="meta.posted_to_date"
                                                        :clearable="false"></date-picker>
                                                </div>
                                            </div>

                                            <span style="color: #dc3545;">{{ errors?.post_error }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#response" role="button" aria-expanded="false"
                                    aria-controls="response">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.response_date }">Response Date</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="response">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hour" id="hour1"
                                                v-model="meta.response_date" value="24 Hours" />
                                            <label class="form-check-label" for="hour1">24 Hours</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour2" name="hour3"
                                                v-model="meta.response_date" value="2 Days" />
                                            <label class="form-check-label" for="hour2">2 Days</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour3" name="hour2"
                                                v-model="meta.response_date" value="7 Days" />
                                            <label class="form-check-label" for="hour3">7 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="hour4" name="hour11"
                                                v-model="meta.response_date" value="21 Days" />
                                            <label class="form-check-label" for="hour4">21 Days</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="hour"
                                                v-model="meta.response_date" value="custom" />
                                            <label class="form-check-label" for="custom1"> &nbsp; Custom</label>
                                            <div class="row" v-if="meta.response_date == 'custom'"
                                                style="margin-left: 0px !important;">
                                                <div class="col-sm-6">
                                                    <label class="form-label">Start Date<span
                                                            class="text-danger">*</span></label>
                                                    <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD"
                                                        v-model:value="meta.response_from_date"
                                                        :clearable="false"></date-picker>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">End Date<span
                                                            class="text-danger">*</span></label>
                                                    <date-picker format="MMM-DD-YYYY" value-type="YYYY-MM-DD"
                                                        v-model:value="meta.response_to_date"
                                                        :clearable="false"></date-picker>
                                                </div>
                                            </div>
                                            <span style="color: #dc3545;">{{ errors?.response_error }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more d-flex justify-content-between align-items-center"
                                    href="" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.naics?.length !== 0 }">Primary NAICS Code</h6>

                                    <a class="p-0 mb-0">
                                        <a class="gryy1" data-bs-toggle="modal" data-bs-target="#flightdetail"
                                            role="button" aria-expanded="true" aria-controls="collapseExample5">
                                            <i class="fa fa-filter" aria-hidden="true"></i>
                                        </a>
                                    </a>
                                </div>
                            </div>

                            <hr class="my-0" />
                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more d-flex justify-content-between align-items-center"
                                    href="" role="button" aria-expanded="false" aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.pscs?.length !== 0 }">Product & Service Code
                                    </h6>

                                    <a class="p-0 mb-0">
                                        <a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModal">
                                            <i class="fa fa-filter" aria-hidden="true"></i>
                                        </a>
                                    </a>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#setaside" role="button" aria-expanded="false"
                                    aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.set_asides?.length !== 0 }">
                                        Competition(Set-Aside)
                                    </h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show mb-3" id="setaside">
                                    <div class="scroll1 hgt-250">
                                        <div class="d-flex justify-content-between align-items-center"
                                            v-for="set_aside in set_asides" :key="set_aside.set_aside_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :value="set_aside.set_aside_id" v-model="meta.set_asides" />
                                                <label class="form-check-label"> {{ set_aside.set_aside_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />
                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#location" role="button" aria-expanded="false"
                                    aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.states?.length !== 0 }">Location (Place of
                                        Performance)</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="location">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ meta.states.length }} of {{
                                                states.length }})</a>
                                            <span v-if="meta.states.length !== sorted_states.length">
                                                <a href="" @click.prevent="selectAllStates()"
                                                    class="form-check-label text-primary me-2">| Select All</a></span>
                                            <span v-if="meta.states.length">
                                                <a href="" class="form-check-label text-primary me-2"
                                                    @click.prevent="deselectAllStates()">| Reset</a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search"
                                                @keyup="searchStates()" v-model="state_keyword"
                                                placeholder="Search State" aria-label="Search" />
                                            <button
                                                class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y"
                                                type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
                                        <div class="d-flex justify-content-between align-items-center"
                                            v-for="state in sorted_states" :key="state.state_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :value="state.state_id"
                                                    v-model="meta.states" />
                                                <label class="form-check-label"> {{ state.state_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />

                            <div class="card card-body card1 rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#federalagency" role="button" aria-expanded="false"
                                    aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.federal_agencies?.length !== 0 }">Federal Agency
                                    </h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="federalagency">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ meta.federal_agencies.length }} of
                                                {{ federal_agencies.length }})</a>
                                            <span
                                                v-if="meta.federal_agencies.length !== sorted_federal_agencies.length">
                                                <a href="" @click.prevent="selectAllFederalAgencies()"
                                                    class="form-check-label text-primary me-2">| Select All</a>
                                            </span>
                                            <span v-if="meta.federal_agencies.length">
                                                <a href="" class="form-check-label text-primary me-2"
                                                    @click.prevent="deselectAllFederalAgencies()"
                                                    v-if="meta.federal_agencies.length !== 0">| Reset</a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search"
                                                @keyup="searchFederalAgencies()" v-model="federal_agency_keword"
                                                placeholder="Search Agency" aria-label="Search" />
                                            <button
                                                class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y"
                                                type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll3">
                                        <div class="d-flex justify-content-between align-items-center"
                                            v-for="federal in sorted_federal_agencies" :key="federal.agency_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :value="federal.federal_agency_id"
                                                    v-model="meta.federal_agencies" />
                                                <label class="form-check-label"> {{ federal.agency_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8 col-xl-9">
                    <div class="vl-parent">
                        <Skeleton v-if="isLoading" />
                        <div class="scroll-div" ref="myscroll" v-if="!isLoading">
                            <div class="hstack flex-wrap gap-2">
                                <div class="alert border shadow fade show small px-1 py-0 mb-0 filtertagcss"
                                    v-for="(filter, index) in filters" :key="index">
                                    <span class="me-1" style="color: white;">{{ filter.name }}</span>
                                    <button type="button" class="btn btn-xs mb-0 text-white p-0"
                                        style="font-size: 13px !important;" @click="removeFilter(filter)"
                                        aria-label="Close">
                                        <i class="fa fa-light fa-xmark text-white"></i>
                                    </button>
                                </div>

                                <div v-if="filters.length != 0">
                                    <button type="button" class="btn btn-xs text-primary textclose mb-0 p-1"
                                        @click.prevent="clearAllFilters()">Clear all</button>
                                </div>
                            </div>
                        </div>
                        <section v-if="!federal_tenders.length && !isLoading">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-10 text-center mx-auto">
                                        <img src="assets/images/no-search-results.svg" class="mb-4" width="230px"
                                            alt="" />

                                        <h3>No results found</h3>

                                        <p class="mb-4">Try adjusting your serarch or filter to find what you're looking
                                            for.</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="text-end pb-2" v-if="federal_tenders.length">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)"
                                        style="text-decoration: none; pointer-events: none; cursor: default;"
                                        class="p-2 text-dark">{{ 'Showing ' + meta.from + ' - ' + meta.to + ' of '+meta.totalRows+' bids' }}</a>
                                </li>

                                <li class="list-inline-item" v-if="$store.getters.user !== null">
                                    <a href="javascript:void(0)" @click.prevent="shareFederalTenders()"
                                        class="p-2 text-secondary"><i
                                            class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-3" v-for="federal_tender in federal_tenders"
                                    :key="federal_tender.federal_tender_id">
                                    <div class="card-body py-md-3 d-flex flex-column h-100 position-relative"
                                        id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div
                                                    v-if="$store.getters.user !== null && $store.getters.user.subscription_id !== 0">
                                                    <a href="javascript:void(0)" @click="tenderDetails(federal_tender)"
                                                        style="text-transform: uppercase;">
                                                        <div v-html="highlight(federal_tender.title)"></div>
                                                    </a>
                                                </div>
                                                <div v-else>
                                                    <a href="javascript:void(0)" @click="showModal(federal_tender)">
                                                        <div v-html="highlight(federal_tender.title)"></div>
                                                    </a>
                                                </div>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0"
                                                        v-if="$store.getters.user !== null">
                                                        <small class="form-check-label mb-0 me-2"><a
                                                                href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox"
                                                            :value="federal_tender.federal_tender_id"
                                                            id="flexCheckChecked"
                                                            v-model="share_federal_tender.federal_tenders" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/posteddate.svg" />{{
                                                        federal_tender.federal_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/bidnumber.svg" />{{ federal_tender.tender_no
                                                }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/posteddate.svg" />{{
                                                        dateFormat(federal_tender.opening_date) }}
                                                &nbsp;<span>{{ federal_tender.time_ago }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" />
                                                {{ dateFormat(federal_tender.expiry_date) }}
                                                <span class="col-green" v-if="federal_tender.days_difference">
                                                    &nbsp; {{ federal_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2">
                                            <li class="list-group-item d-flex text-success p-0">
                                                <p class="limited-text" style="color: #595d6e; text-align: justify;"
                                                    v-html="federal_tender.description"
                                                    v-if="federal_tender.description != '0' && federal_tender.description != '-'">
                                                </p>
                                            </li>
                                        </ul>

                                        <div
                                            class="border-top d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                            <div class="d-flex align-items-center">
                                                <ul class="nav nav-divider small mt-3" style="color: #595d6e;">
                                                    <li class="nav-item text-primary"><i
                                                            class="bi bi-patch-check-fill text-primary me-2"></i><span
                                                            style="color: rgb(86, 84, 109);">{{
                                                                federal_tender.federal_agency?.agency_name }}</span></li>

                                                    <li class="nav-item" v-if="federal_tender.place_of_performance">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i><span>{{
                                                            federal_tender.place_of_performance }}</span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <li class="list-inline-item" v-if="$store.getters.user !== null">
                                                        <a href="javascript:void(0)"
                                                            @click.prevent="shareFederalTender(federal_tender)"
                                                            class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE
                                                        </a>
                                                    </li>

                                                    <!-- <li class="list-inline-item" v-if="federal_tender.cart_icon">
                                                        <div>
                                                            <a href="javascript:void(0)" @click="addToCart(federal_tender)" class="p-2">
                                                                <img src="assets/images/addcart.svg" width="19" />
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <li class="list-inline-item" v-else>
                                                        <img src="assets/images/icons/cart-24.svg" width="19" />
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card shadow mb-3" v-if="federal_tenders.length !== 0">
                                    <div class="card-body py-md-3 d-flex flex-column h-100 position-relative">
                                        <div class="table-responsive table-radius1">
                                            <table class="table small align-middle p-4 mb-0 table-hover table-shrink">
                                                <thead class="table-light">
                                                    <tr class="vertical-align-top">
                                                        <th class="padding-12-16"></th>
                                                        <th scope="col" class="padding-12-16">Bid number & <br>notice
                                                            type</th>
                                                        <th scope="col" class="padding-12-16">Title</th>
                                                        <th scope="col" class="padding-12-16">Agency</th>
                                                        <th scope="col" class="padding-12-16">Place of <br>performance
                                                        </th>
                                                        <th scope="col" class="padding-12-16">Due date</th>
                                                        <th scope="col" class="padding-12-16"></th>
                                                    </tr>
                                                </thead>

                                                <tbody class="border-top-0">
                                                    <tr v-for="federal_tender in federal_tenders"
                                                        :key="federal_tender.federal_tender_id">
                                                        <td class="padding-16">
                                                            <div class="form-check my-auto"
                                                                v-if="$store.getters.user !== null">
                                                                <input class="form-check-input me-3" type="checkbox"
                                                                    :value="federal_tender.federal_tender_id"
                                                                    v-model="sendMails.bids" />
                                                            </div>
                                                        </td>
                                                        <td class="padding-16">
                                                            <div class="row">
                                                                <div class="column">
                                                                    <div
                                                                        v-if="$store.getters.user !== null && $store.getters.user.subscription_id !== 0">
                                                                        <a href="javascript:void(0)"
                                                                            @click="tenderDetails(federal_tender)">{{
                                                                                federal_tender.tender_no }}</a>
                                                                    </div>
                                                                    <div v-else><a href="javascript:void(0)"
                                                                            @click="showModal(federal_tender)">{{
                                                                                federal_tender.tender_no }}</a></div>
                                                                </div>

                                                                <div class="column">
                                                                    <a :style="{ color: federal_tender.federal_notice?.backround_color }"
                                                                        style="color:black"
                                                                        class="badge bg-success bg-opacity-10">{{
                                                                            federal_tender?.federal_notice?.notice_name
                                                                        }}</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="padding-16">
                                                            <div v-html="highlight(federal_tender.title)"></div>
                                                        </td>
                                                        <td class="padding-16">{{
                                                            federal_tender.federal_agency?.agency_name }}</td>
                                                        <td class="padding-16">{{ federal_tender.place_of_performance }}
                                                        </td>
                                                        <td class="padding-16" style="width: 110px;">{{
                                                            federal_tender.expiry_date }}</td>
                                                        <td>
                                                            <!-- <span v-if="federal_tender.cart_icon">
                                                                <div>
                                                                    <a href="javascript:void(0)" @click="addToCart(federal_tender)"><img class="mb-1 me-2" src="@/assets/icons/addcart.svg" width="20" /></a>
                                                                </div>
                                                            </span>
                                                            <span v-else>
                                                                <img src="assets/images/icons/cart-24.svg" width="19" />
                                                            </span> -->
                                                        </td>
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
                                <input type="text" class="form-control" v-model="meta.page"
                                    @keypress.enter="getFederalTenders()" style="width: 60px;" />
                            </div>
                            <div style="float: right;">
                                <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.page"
                                    @pagechanged="onPageChange" />
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="closeNaicsModal()"></button>
                </div>
                <div class="modal-header pt-0 d-sm-flex justify-content-sm-between align-items-center">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <h6 class="fw-normal mb-0">NAICS CODES</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <a class="btn btn-sm btn-primary px-2" style="padding: 5px; font-weight: 400;"
                            href="javascript:void(0)" data-bs-dismiss="modal" @click="applyFilterNaics()">Apply
                            Filter</a>
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="tab-content mb-0" id="flight-pills-tabContent ">
                        <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel"
                            aria-labelledby="flight-info">
                            <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                <div class="col-md-8 small">
                                    <form class="position-relative">
                                        <input class="form-control form-control-sm pe-5 myinput" type="search"
                                            placeholder="Search in Naics Codes" aria-label="Search"
                                            v-model="naics_code.search" @keypress.enter="getNaicsesBackend()" />
                                        <button
                                            class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y"
                                            type="button" @click="getNaicsesBackend()"><i
                                                class="fas fa-search fs-6"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-4 small d-flex">
                                    <div><a class="my-auto dotted" style="color: #40a4f1;" href="javascript:void(0)"
                                            @click="deselectNaics()">Deselect All</a></div>
                                </div>
                            </div>
                            <div class="vl-parent">
                                <div class="card" style="overflow: scroll; height: 300px;">
                                    <div class="card-body p-0">
                                        <ul class="list-style-none pl-8">
                                            <li>
                                                <ul id="demo" style="padding: 0px;">
                                                    <TreeItem class="item" :item="treeData" :tdr_naics="meta.naics"
                                                        :search="naics_code.search" :clear_all_naics="clear_all_naics">
                                                    </TreeItem>
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
    <div class="modal fade" id="detailModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="closePscModal"></button>
                </div>
                <div class="modal-header pt-0 d-sm-flex justify-content-sm-between align-items-center">
                    <div class="d-flex align-items-center mb-2 mb-sm-0">
                        <h6 class="fw-normal mb-0">SERVICE CODES</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <a class="btn btn-sm btn-primary px-2" style="padding: 5px; font-weight: 400;"
                            href="javascript:void(0)" data-bs-dismiss="modal" @click="applyFilterPsc()">Apply Filter</a>
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="tab-content mb-0" id="flight-pills-tabContent">
                        <div class="tab-pane fade show active" id="flight-info-tab" role="tabpanel"
                            aria-labelledby="flight-info">
                            <div class="row g-3 d-sm-flex justify-content-sm-between align-items-center mb-3">
                                <div class="col-md-8 small">
                                    <form class="position-relative">
                                        <input class="form-control form-control-sm pe-5 myinput" type="search"
                                            placeholder="Search in Serive Codes" aria-label="Search"
                                            v-model="service_code.search" @keypress.enter="getPscesBackend()" />
                                        <button
                                            class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y"
                                            type="button" @click="getPscesBackend()"><i
                                                class="fas fa-search fs-6"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-4 small d-flex">
                                    <div><a class="my-auto dotted" href="javascript:void(0)"
                                            @click="deselectPsc()">Deselect All</a></div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="vl-parent">
                                    <div class="card-body p-0" style="overflow: scroll; height: 300px;">
                                        <ul class="list-style-none pl-8">
                                            <li>
                                                <ul id="demo" style="padding: 0px;">
                                                    <PscTree class="item" :item="service_codes" :tdr_psc="meta.pscs"
                                                        :search="service_code.search" :clear_all_psc="clear_all_psc">
                                                    </PscTree>
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
    <teleport to="#modals" v-if="userModal">
        <div class="modal-overlay">
            <div class="" style="width: 500px;">
                <div class="">
                    <div class=""></div>
                    <div class="">
                        <LoginModal @closeModal="closeModal" ref="login_modal" v-if="login_modal" />
                        <SaveSearch @closeModal="closeModal" @savedSearch="saveSearch" @updateSearch="addFederalFilter"
                            :status="status" :alert_label="meta.alert_label" :savedbids="savedbids" ref="save_search"
                            v-if="save_search" />
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
            </div>
        </div>
    </teleport>

    <teleport to="#modals" v-if="alertModal">
        <div class="modal-overlay">
            <div class="modal-dialog" style="width: 500px;">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <LoginModal @closeModal="closeModal" ref="login_modal" v-if="login_modal" />
                        <SetAlertModal @closeModal="closeModal" :alert="savealert" @updateAlert="updateAlert"
                            @setAlert="addAlert" ref="alert_search" v-if="set_alert" />
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
            </div>
        </div>
    </teleport>

    <teleport to="#modals" v-if="share_tender">
        <div class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <!-- <div class="card border">
                            <div class="card-body vstack gap-4"> -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm">
                                        <img class="avatar-img" src="assets/images/mail.png" alt="avatar" />
                                    </div>

                                    <div class="ms-2">
                                        <h6 class="mb-0 title-green">Share Bid Detail</h6>
                                    </div>
                                </div>

                                <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button"
                                        @click.prevent="closeModal()" class="btn-close"></button></a>
                            </div>

                            <form class="card-body" style="min-width: 350px;">
                                <div class="mb-3">
                                    <input class="form-control" :class="{ 'is-invalid': errors.recipient_email }"
                                        placeholder="Employee/Colleague Email Address" autocomplet="off" type="text"
                                        id="recipient-name" v-model="share_federal_tender.recipient_email"
                                        ref="recipient_email" />
                                    <span v-if="errors.recipient_email" class="invalid-feedback">{{
                                        errors.recipient_email[0] }}</span>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="text" name="email_subject"
                                        :class="{ 'is-invalid': errors.subject }" placeholder="Subject of Email"
                                        autocomplet="off" id="email_subject" v-model="share_federal_tender.subject"
                                        ref="subject" />
                                    <span v-if="errors.subject" class="invalid-feedback">{{ errors.subject[0]
                                        }}</span>
                                </div>

                                <div class="mb-3">
                                    <textarea class="form-control" rows="3" name="email_message"
                                        :class="{ 'is-invalid': errors.message }" placeholder="Brief Messsage/Note"
                                        autocomplet="off" id="email_message"
                                        v-model="share_federal_tender.message"></textarea>
                                    <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0]
                                        }}</span>
                                </div>

                                <div class="text-end">
                                    <!-- <a href="javascript:void(0)" @click="sendFederalTenderMail()"
                                                class="mybutton-secondary2">Send</a> -->
                                    <button class="btn btn-sm btn-success"
                                        @click="sendFederalTenderMail()">Send</button>
                                </div>
                            </form>
                        </div>
                        <!-- </div>
                        </div> -->
                    </div>
                    <div class="modal-footer m-foot"></div>
                </div>
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
export default {
    setup() {
        const isOpen = ref(false);
        const savebidopen = ref(false);
        return { isOpen, savebidopen };
    },
    components: { Loading, DatePicker, Pagination, Vue3TagsInput, TreeItem, PscTree, LoginModal, SaveModal, SaveSearch, SetAlertModal, Skeleton, Region },

    data() {
        return {
            fullPage: false,
            state_keyword: null,
            tag: null,
            add_federal_filters: false,
            federal_filters: [],
            federal_notices: [],
            set_asides: [],
            states: [],
            sorted_states: [],
            federal_agencies: [],
            sorted_federal_agencies: [],
            federal_tenders: [],
            share_tender: false,
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
                state_fedral: "",
                created_on: "",
                updated_on: "",
            },
            meta: {
                federal_filter_name: '',
                alert_title: '',
                region: '',
                frequency: '',
                active: false,
                expired: false,
                response_date: false,
                response_from_date: false,
                response_to_date: false,
                posted_date: false,
                posted_from_date: false,
                posted_to_date: false,
                naics: [],
                pscs: [],
                keywords: [],
                federal_notices: [],
                set_asides: [],
                states: [],
                federal_agencies: [],
                time_zone: '',
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
                alert_label: false
            },
            isLoading: false,
            is_updating_meta: false,
            user: {
                email: "",
                password: "",
            },
            login_modal: false,
            set_alert: false,
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
            errors: [],
            tags: [],
            limit: 3,
            userModal: false,
            alertModal: false,
            listview: true,
            gridview: false,
            modal1: false,
            modal2: false,
            status: false,
            searchstate: "",
            federal_agency_keword: "",
            sendMails: {
                bids: [],
                mails: [],
                email: "",
                subject: "",
                message: "",
                bid_or_doc: "bid",
                region_id: 2,
            },
            naics: [],
            filters: [],
            errors: [],
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
            shareBid: {
                bids: [],
                mails: [],
                email: "",
                subject: "",
                message: "",
                bid_or_doc: "bid",
                region_id: 2,
            },
            hidecartstatue: false,
            savedbids: "",
            save_search: false,
            clear_all_naics: false,
            clear_all_psc: false,
            pageChangeInProgress: false,
            auto_call: true,
            login: {
                federal_tender: null
            },
            share_federal_tender: {
                recipient_email: null,
                subject: '',
                message: '',
                federal_tenders: []
            },
            federal_cart_items: []
        };
    },

    watch: {
        'meta.response_date': 'triggerFederalTendersForDates',
        'meta.response_from_date': 'triggerFederalTendersWithCondition',
        'meta.response_to_date': 'triggerFederalTendersWithCondition',
        'meta.posted_date': 'triggerFederalTendersForDates',
        'meta.posted_from_date': 'triggerFederalTenders',
        'meta.posted_to_date': 'triggerFederalTenders',
        'meta.active': 'triggerFederalTenders',
        'meta.expired': 'triggerFederalTenders',
        'meta.keywords': 'triggerFederalTenders',
        'meta.federal_notices': 'triggerFederalTenders',
        'meta.set_asides': 'triggerFederalTenders',
        'meta.states': 'triggerFederalTenders',
        'meta.federal_agencies': 'triggerFederalTenders',
        'meta.naics': 'triggerFederalTenders',
        'meta.pscs': 'triggerFederalTenders',
        'store.getters.page_redirect': 'pageRedirect'
    },

    beforeRouteEnter(to, from, next) {
        next((vm) => {
            if (from.name == 'saveAlert' && vm.$store.getters.alert) {
                vm.getAlert()
            } else {
                vm.$store.commit("setAlert", null);
            }
            if (from.name == 'federal_tender_details' && vm.$store.getters.filters) {
                vm.meta = vm.$store.getters.filters
                vm.tags = vm.meta.keywords;
            }
        })
    },

    // created() {
    //     let path = localStorage.getItem('page_redirect_path')
    //     console.log(path)
    //     if (path) {
    //         window.open(path, '_blank');
    //     }
    // },

    mounted() {
        this.meta.time_zone = moment.tz.guess()
        this.paginateFederalTenders()
        this.getFederalNotices()
        this.getPscs()
        this.getNaics()
        this.$store.commit("setSelectedNaics", null)
        this.$store.commit("setFederalTender", null)
        this.$store.commit("setStateTender", null)
        let header_menu = this.$store.getters.header_menu
        header_menu.show_bidsearch = false
        this.$store.dispatch('setHeaderMenu', header_menu)
    },

    computed: {
        countFilters() {
            let modules = []
            this.filters.map(function (element) {
                if (!modules.includes(element.module)) {
                    modules.push(element.module)
                }
            })
            return modules.length
        }
    },

    methods: {

        updateStatus(event) {
            if (event.target.checked) {
                this.meta.active = true
                this.meta.expired = true
            } else {
                this.meta.active = false
                this.meta.expired = false
            }
        },

        closeNaicsModal() {
            if (!this.meta.naics.length) {
                this.$store.dispatch("setSelectedNaics", [])
            }
        },

        deselectNaics() {
            this.$store.dispatch("setSelectedNaics", [])
        },

        closePscModal() {
            if (!this.meta.pscs.length) {
                this.$store.dispatch("setSelectedPscs", [])
            }
        },

        deselectPsc() {
            this.$store.dispatch("setSelectedPscs", [])
        },

        addToCart(federal_tender) {
            let vm = this
            vm.fullPage = true
            let cart_item = {
                user_id: vm.$store.getters.user.user_id,
                federal_tender_id: federal_tender.federal_tender_id,
                state_tender_id: null,
                region: 'Federal'
            }
            vm.$store
                .dispatch("post", { uri: "addCartItem", data: cart_item })
                .then(function () {
                    vm.fullPage = false
                    federal_tender.cart_icon = false
                    vm.$store.dispatch("success", "Tender added to cart successfully");
                    vm.getCartItemsCount()
                })
                .catch(function (error) {
                    console.log(error)
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        sendFederalTenderMail() {
            let vm = this
            vm.fullPage = true
            vm.isLoading = true
            if (this.$store.getters.user) {
                vm.share_federal_tender.user_id = this.$store.getters.user.user_id
                vm.$store
                    .dispatch("post", { uri: "sendFederalTenderMail", data: vm.share_federal_tender })
                    .then(function () {
                        vm.fullPage = false
                        vm.isLoading = false
                        vm.share_tender = false
                        vm.share_federal_tender.recipient_email = ''
                        vm.share_federal_tender.subject = ''
                        vm.share_federal_tender.message = ''
                        vm.share_federal_tender.federal_tenders = []
                        vm.$store.dispatch("success", "Mail sent successfully");
                    })
                    .catch(function (error) {
                        console.log(error)
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        listviewgrid() {
            this.listview = false;
            this.gridview = true;
            this.meta.per_page = 38;
            this.getFederalTenders()
        },
        gridviewgrid() {
            this.listview = true;
            this.gridview = false;
            this.meta.per_page = 10;
            this.getFederalTenders()
        },

        getAlert() {
            let vm = this
            vm.$store
                .dispatch("post", { uri: "getAlert", data: vm.$store.getters.alert })
                .then(function (response) {
                    vm.showFederalFilter(response.data.data)
                })
                .catch(function (error) {
                    console.log(error)
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
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

        shareFederalTender(federal_tender) {
            this.share_federal_tender.federal_tenders.push(federal_tender.federal_tender_id)
            this.share_tender = true
        },
        shareFederalTenders() {
            if (this.share_federal_tender.federal_tenders.length) {
                this.share_tender = true
            } else {
                this.$store.dispatch("info", "Select Federal Tender");
            }
        },
        emailmodalpop() {
            this.share_tender = true
        },
        triggerFederalTenders() {
            if (this.auto_call) {
                this.cancelPreviousRequest();
                this.getFederalTenders()
            }
        },

        triggerFederalTendersForDates() {
            if (((this.meta.posted_date && this.meta.posted_date != 'custom') ||
                (this.meta.response_date && this.meta.response_date != 'custom'))
                && this.auto_call) {
                this.cancelPreviousRequest();
                this.getFederalTenders();
            }
        },

        triggerFederalTendersWithCondition() {
            if ((this.meta.posted_from_date && this.meta.posted_to_date) || (this.meta.response_from_date && this.meta.response_to_date) && this.auto_call) {
                this.cancelPreviousRequest()
                this.getFederalTenders()
            }
        },

        cancelPreviousRequest() {
            if (this.cancel_token_source) {
                console.log('Cancelling previous request');
                this.cancel_token_source.cancel('Operation canceled due to new request.');
                this.cancel_token_source = null;  // Reset after cancellation
            }
        },

        showFederalFilter(federal_filter) {
            this.auto_call = false
            this.meta.active = federal_filter.active
            this.meta.expired = federal_filter.expired
            this.meta.keywords = federal_filter.keywords
            this.tags = federal_filter.keywords
            this.meta.federal_notices = federal_filter.federal_notices
            this.meta.posted_date = federal_filter.posted_date
            this.meta.response_date = federal_filter.response_date
            this.meta.naics = federal_filter.naics
            this.meta.pscs = federal_filter.pscs
            this.meta.set_asides = federal_filter.set_asides
            this.meta.states = federal_filter.states
            this.meta.federal_agencies = federal_filter.federal_agencies
            this.$store.dispatch("setSelectedNaics", this.meta.naics)
            this.$store.dispatch("setSelectedPscs", this.meta.pscs)
            this.getFederalTenders()
        },

        addFederalFilter(filter_name) {
            let vm = this
            vm.meta.federal_filter_name = filter_name
            if (vm.$store.getters.user) {
                vm.meta.user_id = vm.$store.getters.user.user_id
                vm.$store
                    .dispatch("post", { uri: "addFederalFilters", data: vm.meta })
                    .then(function (response) {
                        vm.$store.dispatch("success", "Filters saved successfully");
                        vm.closeModal()
                    })
                    .catch(function (error) {
                        console.log(error)
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        addAlert(alert) {
            let vm = this
            vm.meta.alert_title = alert.alert_label
            vm.meta.frequency = alert.frequency
            vm.meta.region = 'Federal'
            vm.$store
                .dispatch("post", { uri: "addAlerts", data: vm.meta })
                .then(function (response) {
                    vm.$store.dispatch("success", "Filters saved successfully");
                    vm.closeModal()
                })
                .catch(function (error) {
                    console.log(error)
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        closeModal(modal) {
            if (modal == "login_modal") {
                if (this.$store.getters.user) {
                    this.getSavedsearch();
                }
                this.login_modal = false;
            } else this.save_search = false;
            this.userModal = false
            this.alertModal = false
            this.share_tender = false
            this.share_federal_tender.recipient_email = ''
            this.share_federal_tender.subject = ''
            this.share_federal_tender.message = ''
            this.share_federal_tender.federal_tenders = []
        },

        tenderDetails(federal_tender) {
            localStorage.setItem("federal_tender", JSON.stringify(federal_tender));
            this.$store.commit("setFederalTender", federal_tender)
            this.$store.commit("setCurrentPage", this.meta.currentPage)
            // window.open(this.$store.getters.appUrl + "bids/federal-opportunities/" + federal_tender.title.replace(/\//g, "") + "-" + federal_tender.tender_no, '_blank');
            this.$router.push("federal-opportunities/" + federal_tender.title.replace(/\//g, "") + "-" + federal_tender.tender_no);
        },

        showModal() {
            // if(federal_tender){
            //     let page_redirect_path =  this.$store.getters.appUrl+'bids/federal-opportunities/'+ federal_tender.title.replace(/\//g, "") + "-" + federal_tender.tender_no
            //     localStorage.setItem("federal_tender", JSON.stringify(federal_tender))
            //     localStorage.setItem('page_redirect_path', page_redirect_path)
            // }
            this.userModal = true;
            if (this.$store.getters.user == null) {
                this.login_modal = true;
            } else {
                this.save_search = true;
            }
            // if (this.meta.alert_label) {
            //     this.status = false;
            // } else this.status = true;
            // if (this.$store.getters.user?.subscription_id === 0) {
            //     this.alertSubscribe = true;
            // } else {
            //     if (this.$store.getters.user == null) {
            //         this.login_modal = true;
            //     } else {
            //         this.save_search = true;
            //     }
            // }
        },

        handleSelectedTag(tag) {
            if (this.tag === "") {
                this.tag == "";
                return true;
            }
            this.tags.push(tag);
            this.meta.keywords = this.tags;
            // this.tag = "";
            // this.tags = [...new Set(this.tags)];
            this.paginateFederalTenders();
        },

        handleChangeTag(tags) {
            let vm = this;
            vm.tags = tags;
            vm.meta.keywords = vm.tags;
        },

        searchStates() {
            let vm = this
            vm.sorted_states = vm.states.filter(function (element) {
                return element.state_name.toLowerCase().includes(vm.state_keyword.toLowerCase());
            })
        },
        selectAllStates() {
            let vm = this
            vm.meta.states = []
            vm.sorted_states.map(function (element) {
                vm.meta.states.push(element.state_id)
            })
        },
        deselectAllStates() {
            let vm = this
            vm.meta.states = []
            vm.sorted_states = vm.states
            vm.state_keyword = null
        },
        selectAllFederalAgencies() {
            let vm = this
            vm.meta.federal_agencies = []
            vm.sorted_federal_agencies.map(function (element) {
                vm.meta.federal_agencies.push(element.federal_agency_id)
            })
        },
        deselectAllFederalAgencies() {
            let vm = this
            vm.meta.federal_agencies = []
            vm.sorted_federal_agencies = vm.federal_agencies
            vm.federal_agency_keword = null
        },
        searchFederalAgencies() {
            let vm = this
            vm.sorted_federal_agencies = vm.federal_agencies.filter(function (element) {
                return element.agency_name.toLowerCase().includes(vm.federal_agency_keword.toLowerCase());
            })
        },
        clearAllFilters() {
            this.auto_call = false
            this.meta.response_date = false,
                this.meta.response_from_date = false,
                this.meta.response_to_date = false,
                this.meta.posted_date = false,
                this.meta.posted_from_date = false,
                this.meta.posted_to_date = false,
                this.meta.active = false,
                this.meta.expired = false,
                this.meta.keywords = [],
                this.tags = [],
                this.meta.federal_notices = [],
                this.meta.naics = [],
                this.meta.pscs = [],
                this.meta.set_asides = [],
                this.meta.states = [],
                this.meta.federal_agencies = []
            this.getFederalTenders()
            this.$store.dispatch("setSelectedNaics", [])
            this.$store.dispatch("setSelectedPscs", [])
        },
        removeFilter(filter) {
            console.log(filter)
            if (filter.id == 'status' || filter.id == 'date') {
                this.meta[filter.module] = false
            } else if (typeof filter.id === 'number') {
                if (Array.isArray(this.meta[filter.module])) {
                    this.meta[filter.module] = this.meta[filter.module].filter(function (ele) {
                        return filter.id !== ele
                    })
                } else {
                    this.meta[filter.module] = null
                }
            } else {
                this.meta[filter.module] = []
            }
        },

        applyFilters() {
            let vm = this
            vm.filters = []
            const meta_fields = [
                { meta_field: 'federal_notices', data_field: 'federal_notices', id_field: 'federal_notice_id', name_field: 'notice_name' },
                { meta_field: 'set_asides', data_field: 'set_asides', id_field: 'set_aside_id', name_field: 'set_aside_name' },
                { meta_field: 'states', data_field: 'states', id_field: 'state_id', name_field: 'state_name' },
                { meta_field: 'federal_agencies', data_field: 'federal_agencies', id_field: 'federal_agency_id', name_field: 'agency_name' }
            ];

            if (vm.meta.active) {
                vm.filters.push({
                    name: 'active',
                    id: 'status',
                    module: 'active'
                })
            }
            if (vm.meta.expired) {
                vm.filters.push({
                    name: 'expired',
                    id: 'status',
                    module: 'expired'
                })
            }

            if (vm.meta.active && vm.meta.expired) {
                vm.meta.all = true
            } else if (!vm.meta.active || !vm.meta.expired) {
                vm.meta.all = false
            }

            if (vm.meta.keywords.length) {
                vm.filters.push({
                    name: 'keywords',
                    id: 'keywords',
                    module: 'keywords'
                })
            }

            meta_fields.forEach(field => {
                if (vm.meta[field.meta_field].length) {
                    vm.meta[field.meta_field].map(function (ele) {
                        let matched_item = vm[field.data_field].filter(function (item) {
                            return item[field.id_field] == ele;
                        });

                        if (matched_item.length) {
                            vm.filters.push({
                                name: matched_item[0][field.name_field],
                                id: matched_item[0][field.id_field],
                                module: field.meta_field
                            });
                        }
                    });
                }
            });

            if (vm.meta.posted_date) {
                vm.filters.push({
                    name: vm.meta.posted_date,
                    id: 'date',
                    module: 'posted_date'
                })
            }

            if (vm.meta.response_date) {
                vm.filters.push({
                    name: vm.meta.response_date,
                    id: 'date',
                    module: 'response_date'
                })
            }
            if (vm.meta.naics.length) {
                let naics_length = vm.meta.naics.length
                if (vm.$store.getters.is_all_naics) {
                    naics_length = 2197
                }
                vm.filters.push({
                    name: 'naics:' + naics_length,
                    id: vm.meta.naics,
                    module: 'naics'
                })
            }
            if (vm.meta.pscs.length) {
                let pscs_length = vm.meta.pscs.length
                if (vm.$store.getters.is_all_pscs) {
                    pscs_length = 3074
                }
                vm.filters.push({
                    name: 'psc:' + pscs_length,
                    id: vm.meta.pscs,
                    module: 'pscs'
                })
            }
        },
        applyFilterNaics() {
            this.meta.naics = this.$store.getters.selected_naics
            // this.paginateFederalTenders()
        },
        applyFilterPsc() {
            this.meta.pscs = this.$store.getters.selected_pscs
            // this.paginateFederalTenders()
        },

        getFederalTenders() {
            if (this.cancel_token_source) {
                this.cancel_token_source.cancel('Operation canceled due to new request.');
            }
            this.cancel_token_source = axios.CancelToken.source();
            console.log('cancel token source:', this.cancel_token_source)
            this.paginateFederalTenders(this.cancel_token_source.token)
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
        dateFormat(value) {
            return moment(value).format("ll");
        },
        highlight(title) {
            let keywords_arr = [];
            if (typeof this.meta.keywords === 'string' && this.meta.keywords.length) {
                keywords_arr = this.meta.keywords.split(",");
            } else if (Array.isArray(this.meta.keywords)) {
                keywords_arr = this.meta.keywords;
            }
            keywords_arr.map(function (element) {
                title = title.replace(new RegExp(element.trim(), "gi"), (match) => {
                    return '<span style="background:yellow">' + match + "</span>";
                });
            });
            return title;
        },
        getPscs() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getPscs", data: vm.service_code })
                .then(function (response) {
                    vm.service_codes.children = response.data.data
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getNaics() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getNaics", data: vm.meta })
                .then(function (response) {
                    vm.treeData.children = response.data.data
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getFederalNotices() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getFederalNotices" })
                .then(function (response) {
                    vm.federal_notices = response.data
                    vm.getSetAsides()
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getSetAsides() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getSetAsides" })
                .then(function (response) {
                    vm.set_asides = response.data
                    vm.getStates()
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getStates() {
            let vm = this;
            let uri = "getStates";
            vm.$store
                .dispatch("post", { uri: uri, data: { country_id: 10 } })
                .then(function (response) {
                    vm.states = response.data
                    vm.sorted_states = vm.states
                    vm.getFederalAgencies()
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getFederalAgencies() {
            let vm = this
            vm.$store
                .dispatch("post", { uri: "getFederalAgencies" })
                .then(function (response) {
                    vm.federal_agencies = response.data
                    vm.sorted_federal_agencies = vm.federal_agencies
                    if (vm.$store.getters.user) {
                        vm.getFederalFilters()
                    }
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getFederalFilters() {
            let vm = this
            if (vm.$store.getters.user) {
                vm.$store
                    .dispatch("post", { uri: "getFederalFilters", data: vm.$store.getters.user })
                    .then(function (response) {
                        vm.federal_filters = response.data.data
                    })
                    .catch(function (error) {
                        console.log(error)
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        getCartItemsCount() {
            let vm = this
            let user = vm.$store.getters.user
            if (user) {
                vm.$store
                    .dispatch("post", { uri: "getCartItemsCount", data: vm.$store.getters.user })
                    .then(function (response) {
                        if (response.data) {
                            vm.$store.dispatch('setTenderCart', response.data)
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        paginateFederalTenders(cancel_token) {
            let vm = this
            this.isLoading = true
            vm.federal_tenders = []
            vm.applyFilters()
            window.scrollTo({ top: 0, behavior: "smooth" })
            vm.meta.user_id = this.$store.getters.user?.user_id
            vm.$store
                .dispatch("post", { uri: "paginateFederalTenders", data: vm.meta, cancel_token })
                .then(function (response) {
                    vm.isLoading = false
                    vm.auto_call = true
                    vm.federal_tenders = response.data.data
                    vm.meta.totalRows = response.data.meta.total
                    vm.meta.lastPage = response.data.meta.last_page
                    vm.meta.from = response.data.meta.from
                    vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage
                    vm.meta.to = response.data.meta.to
                    vm.meta.page = response.data.meta.current_page
                    vm.getCartItemsCount()
                })
                .catch(function (error) {
                    if (axios.isCancel(error)) {
                        console.log('Previous request was canceled:', error.message);
                    } else {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    }
                });
        },
        onPageChange(page) {
            this.is_updating_meta = true
            this.pageChangeInProgress = true;
            this.meta.page = page;
            this.getFederalTenders()
        },

        onPerPageChange() {
            this.meta.page = 1;
            this.paginateFederalTenders();
        },
    },
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

.nav.nav-divider .nav-item+.nav-item:before {
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

.nav.nav-divider .nav-item+.nav-item:before {
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
    transition: color 0.2s;
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

.padding-16 {
    padding: 12px 12px;
    overflow-wrap: break-word;
}

.padding-12-16 {
    padding: 16px 12px;
}

.table-radius1 {
    border-radius: 1em;
    border: 1px solid #dfdfe3;
}

.vertical-align-top {
    vertical-align: top;
}

.rounded-3 {
    background-color: white;
}

.card1 {
    background-color: transparent;
}

.title-green {
    color: #16a34a !important;
    font-weight: 500 !important;
}
</style>