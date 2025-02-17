<template>
    <Region />
    <div class="search">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 d-flex justify-content-between search-left my-auto" style="">
                    <div class="label">Filters1</div>
                    <div class="empty" :class="{ bluetextclass: filters.length != 0 }">{{ countFilters }} filters
                        selected</div>
                </div>

                <div class="col-md-5 my-auto">
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

                <div class="col-md-4 my-auto">
                    <ul class="list-inline hstack flex-wrap gap-4 mb-0 s-dropdown dropdown my-auto"
                        style="float: right;">
                        <li class="list-inline-item mb-0" v-if="tags?.length">
                            <a href="javascript:void(0)" class="" style="color: #747579;"
                                @click.prevent="saveSearchModal()"><i
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
                                <li v-for="international_filter, key in international_filters" :key="key"
                                    class="dropdown-item dropitem1 p-0 px-2">
                                    <i class="fas fa-caret-right text-primary my-auto"></i>
                                    <a class="dropdown-item dropitem2" href="javascript:void(0)"
                                        @click="showInternationalFilter(international_filter)">{{ international_filter.international_filter_name
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
                            <div class="card card1 card-body rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#status" role="button" aria-expanded="false"
                                    aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ bluetextclass: meta.statuses?.length }">Status</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="all" v-model="meta.all"
                                            @click="updateStatus($event)" />
                                        <label class="form-check-label">All</label>
                                    </div>
                                </div>
                                <div class="col-12 ml2 multi-collapse collapse show" id="status">
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

                            <div class="card card1 card-body rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#noticetype" role="button" aria-expanded="false"
                                    aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ bluetextclass: meta.international_notices?.length !== 0 }">Notice Type</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="noticetype"
                                    v-for="notice in international_notices" :key="notice.notice_id">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                v-model="meta.international_notices" :value="notice.international_notice_id" />
                                            <label class="form-check-label">{{ notice.international_notice_name }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />
                            <div class="card card1 card-body rounded-0 p-3">
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
                            <div class="card card1 card-body rounded-0 p-3">
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
                            <div class="card card1 card-body rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#location" role="button" aria-expanded="false"
                                    aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.categories?.length !== 0 }">Categories</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="location">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ meta.categories.length }} of {{
                                                categories.length }})</a>
                                            <span v-if="meta.categories.length !== sorted_categories.length"> <a href=""
                                                    @click.prevent="selectAllCategories()"
                                                    class="form-check-label text-primary me-2">| Select All</a></span>
                                            <span v-if="meta.categories.length">
                                                <a href="" class="form-check-label text-primary me-2"
                                                    @click.prevent="deselectAllCategories()">| Reset</a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search"
                                                @keyup="searchCategories()" v-model="category_keyword"
                                                placeholder="Search Category" aria-label="Search" />
                                            <button
                                                class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y"
                                                type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
                                        <div class="d-flex justify-content-between align-items-center"
                                            v-for="category in sorted_categories" :key="category.category_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :value="category.category_id" v-model="meta.categories" />
                                                <label class="form-check-label"> {{ category.category_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card card1 card-body rounded-0 p-3">
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
                                            <span v-if="meta.states.length !== sorted_states.length"> <a href=""
                                                    @click.prevent="selectAllStates()"
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
                                                placeholder="Search Private" aria-label="Search" />
                                            <button
                                                class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y"
                                                type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll1">
                                        <div class="d-flex justify-content-between align-items-center"
                                            v-for="state in sorted_states" :key="state.state_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :value="state.state_id" v-model="meta.states" />
                                                <label class="form-check-label"> {{ state.state_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />

                            <div class="card card1 card-body rounded-0 p-3">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#federalagency" role="button" aria-expanded="false"
                                    aria-controls="notice">
                                    <h6 style="font-size: 15px; font-weight: 500;" class="mb-2"
                                        :class="{ 'bluetextclass': meta.international_agencies?.length !== 0 }">Private Agency
                                    </h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="federalagency">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ meta.international_agencies.length }} of
                                                {{ international_agencies.length }})</a>
                                            <span
                                                v-if="meta.international_agencies.length !== sorted_international_agencies.length">
                                                <a href="" @click.prevent="selectAllPrivateAgencies()"
                                                    class="form-check-label text-primary me-2">| Select All</a>
                                            </span>
                                            <span v-if="meta.international_agencies.length">
                                                <a href="" class="form-check-label text-primary me-2"
                                                    @click.prevent="deselectAllPrivateAgencies()"
                                                    v-if="meta.international_agencies.length !== 0">| Reset</a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search"
                                                @keyup="searchPrivateAgencies()" v-model="international_agency_keword"
                                                placeholder="Search Agency" aria-label="Search" />
                                            <button
                                                class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y"
                                                type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll3">
                                        <div class="d-flex justify-content-between align-items-center"
                                            v-for="international_agency in sorted_international_agencies" :key="international_agency.international_agency_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :value="international_agency.international_agency_id"
                                                    v-model="meta.international_agencies" />
                                                <label class="form-check-label"> {{ international_agency.international_agency_name
                                                    }}</label>
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
                                <div v-for="(messages, field) in alert_errors" :key="field">
                                    <ul v-if="!meta[field]?.length">
                                        <li v-for="(message, index) in messages" :key="index" style="color:red">
                                        {{ message }}
                                        </li>
                                    </ul>
                                </div>

                                <div v-if="filters.length != 0">
                                    <button type="button" class="btn btn-xs text-primary textclose mb-0 p-1"
                                        @click.prevent="clearAllFilters()">Clear all</button>
                                </div>
                            </div>
                        </div>
                        <section v-if="!international_tenders.length && !isLoading">
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
                        <div class="text-end pb-2" v-if="international_tenders.length">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)"
                                        style="text-decoration: none; pointer-events: none; cursor: default;"
                                        class="p-2 text-dark">
                                        {{ 'Showing ' + meta.from + ' - ' + meta.to + ' of ' + meta.totalRows + ' bids'}}
                                    </a>
                                </li>

                                <li class="list-inline-item" v-if="$store.getters.user !== null">
                                    <a href="javascript:void(0)" @click.prevent="sharePrivateTenders()"
                                        class="p-2 text-secondary"><i
                                            class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-3" v-for="international_tender in international_tenders"
                                    :key="international_tender.international_tender_id">
                                    <div class="card-body py-md-3 d-flex flex-column h-100 position-relative"
                                        id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                    <a href="javascript:void(0)" @click="tenderDetails(international_tender)">
                                                        <div v-html="highlight(international_tender.title)"></div>
                                                    </a>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0"
                                                        v-if="$store.getters.user !== null">
                                                        <small class="form-check-label mb-0 me-2"><a
                                                                href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox"
                                                            :value="international_tender.international_tender_id"
                                                            id="flexCheckChecked" v-model="share_international_tender.international_tenders" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/posteddate.svg" />{{
                                                        international_tender.international_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/bidnumber.svg" />
                                                    <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;"> {{ international_tender.tender_no}}</span>
                                                    <span v-else>{{ international_tender.tender_no}}</span>
                                            </li>
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/posteddate.svg" />{{
                                                        dateFormat(international_tender.opening_date) }} &nbsp;<span>{{
                                                    international_tender.time_ago }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" />
                                                {{ dateFormat(international_tender.expiry_date) }}
                                                <span class="col-green" v-if="international_tender.days_difference">
                                                    &nbsp; {{ international_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2">
                                            <li class="list-group-item d-flex text-success p-0">
                                                <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                    <p class="limited-text" style="filter: blur(3px);color: #696969; text-align: justify;"
                                                    v-html="international_tender.description"
                                                    v-if="international_tender.description != '0' && international_tender.description != '-'">
                                                    </p>
                                                </span>
                                                <span v-else>
                                                    <p class="limited-text" style="color: #595d6e; text-align: justify;"
                                                    v-html="international_tender.description"
                                                    v-if="international_tender.description != '0' && international_tender.description != '-'">
                                                    </p>
                                                </span>
                                            </li>
                                        </ul>

                                        <div
                                            class="border-top d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                            <div class="d-flex align-items-center">
                                                <ul class="nav nav-divider small mt-3" style="color: #595d6e;">
                                                    <li class="nav-item text-primary">
                                                        <i class="bi bi-patch-check-fill text-primary me-2"></i>
                                                        <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;">{{international_tender.international_agency?.international_agency_name }}</span>
                                                         <span v-else style="color: rgb(86, 84, 109);">{{international_tender.international_agency?.international_agency_name }}</span>
                                                    </li>

                                                    <li class="nav-item">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>{{
                                                            international_tender?.state?.state_name }}<span
                                                            v-if="international_tender?.state?.state_name">,</span> {{
                                                                international_tender?.country?.country_name }}
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <li class="list-inline-item" v-if="$store.getters.user !== null">
                                                        <a href="javascript:void(0)"
                                                            @click.prevent="sharePrivateTender(international_tender)"
                                                            class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE
                                                        </a>
                                                    </li>

                                                    <!-- <li class="list-inline-item" v-if="international_tender.cart_icon">
                                                        <div>
                                                            <a href="javascript:void(0)" @click="addToCart(international_tender)" class="p-2">
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
                                <div class="card shadow mb-3" v-if="international_tenders.length !== 0">
                                    <div class="card-body p-0 d-flex flex-column h-100 position-relative">
                                        <div class="table-responsive border border-radius-10">
                                            <table class="table small align-middle p-4 mb-0 table-hover table-shrink">
                                                <thead class="table-light">
                                                    <tr class="vertical-align-middle">
                                                        <th class="border-0 text-center" v-if="$store.getters.user">
                                                            <div class="form-check1">
                                                                <input class="form-check-input" type="checkbox" />
                                                            </div>
                                                        </th>
                                                        <th scope="col" class="border-0 border-right w-250">Bid number & notice type</th>
                                                        <th scope="col" class="border-0 border-right">Title & Agency</th>
                                                        <th scope="col" class="border-0 border-right">State</th>
                                                        <th scope="col" class="border-0">Due date</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="border-top-0">
                                                    <tr v-for="international_tender in international_tenders" :key="international_tender.international_tender_id">
                                                        <td class="text-center" v-if="$store.getters.user">
                                                            <div class="form-check1">
                                                                <input class="form-check-input" type="checkbox" :value="international_tender.international_tender_id" v-model="share_international_tender.international_tenders" />
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <div class="row m-0">
                                                                <div class="column" style="margin-left: 21px;">
                                                                    <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px); color: rgb(57, 112, 228);">
                                                                        {{international_tender.tender_no }}
                                                                    </span>
                                                                    <span v-else>
                                                                        <a href="javascript:void(0)" style="color: rgb(57, 112, 228);" @click="tenderDetails(international_tender)">{{ international_tender.tender_no }}</a>
                                                                    </span>
                                                                </div>

                                                                <div class="column d-flex align-items-center">
                                                                    <span class="color-box me-2" :style="{ backgroundColor: getNoticeColor(international_tender.international_notice?.notice_name) }"> </span>

                                                                    <a :style="{ color: international_tender.international_notice?.backround_color }" class="txt-gray">
                                                                        {{ international_tender.international_notice?.notice_name }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <a style="color: rgb(57, 112, 228); font-weight: bold;" href="javascript:void(0)" @click="tenderDetails(international_tender)">
                                                                <div class="truncate-text" v-html="highlight(international_tender.title)"></div>
                                                            </a>
                                                            <span class="txt-gray" style="filter: blur(3px); color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                {{international_tender.international_agency?.international_agency_name }}
                                                            </span>
                                                            <span class="txt-gray" v-else>{{ international_tender.international_agency?.agency_name }}</span>
                                                        </td>
                                                        <td class="txt-gray">{{ international_tender.state?.state_name }}</td>
                                                        <td class="txt-gray" style="width: 110px;">{{ formatDate(international_tender.expiry_date) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="international_tenders.length !== 0">
                            <div style="float: left;">
                                <span class="input-with-icon">
                                    <input type="text" class="form-control" v-model="meta.page" @keypress.enter="getInternationalTenders()" style="width: 60px;" />
                                    <span style="margin-left: 10px;">of {{ meta.lastPage }} pages</span>
                                </span>
                                <!-- <input type="text" class="form-control" v-model="meta.page"
                                    @keypress.enter="getInternationalTenders()" style="width: 60px;" /> -->
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <teleport to="#modals" v-if="modal.save_search">
        <div class="modal-overlay">
            <div class="" style="width: 500px;">
                <div class="">
                    <div class=""></div>
                    <div class="">
                        <SaveSearch @closeModal="closeModal" @savedSearch="saveSearch" @updateSearch="addInternationalFilter"
                            :status="status" :alert_label="meta.alert_label" :savedbids="savedbids" ref="save_search"/>
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
            </div>
        </div>
    </teleport>
    <teleport to="#modals" v-if="modal.subscribe">
        <div class="modal-overlay">
             <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header m-header"></div>
                        <div class="modal-body">
                            <div class="card border">
                                <div class="card-header d-flex justify-content-between align-items-center p-3">
                                    <div class="ms-2">
                                        <h5 class="modal-title" style="color: #16a34a!important;font-weight: 500!important;">Alert</h5>
                                    </div>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0">
                                        <button @click.prevent="closeModal()" class="btn-close"></button></a>
                                </div>

                                <div class="card-body text-center" style="min-width: 350px;">
                                    <strong class="text-danger">Please SUBSCRIBE !</strong>
                                    <br/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer m-foot"></div>
                    </div>
                </div>
        </div>
    </teleport>
    <teleport to="#modals" v-if="modal.share_tender">
        <div class="modal-overlay">
            <div id="popup1" class="confirm1" style="background-color: white !important;">
                <div class="">
                    <h1>Alert</h1>
                    <p>Please select bid !</p>
                    <button @click.prevent="closeModal()" style="background-color: white !important;">Close</button>
                </div>
            </div>
        </div>
    </teleport>
    <teleport to="#modals" v-if="modal.login">
        <div class="modal-overlay">
            <div class="modal-dialog" style="width: 500px;">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <LoginModal @closeModal="closeModal" ref="login_modal" />
                    </div>
                </div>
                <div class="modal-footer m-foot"></div>
            </div>
        </div>
    </teleport>
    <teleport to="#modals" v-if="modal.set_alert">
        <div class="modal-overlay">
            <div class="modal-dialog" style="width: 500px;">
                <div class="modal-content">
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <SetAlertModal @closeModal="closeModal" :alert="savealert" @updateAlert="updateAlert"
                            @setAlert="addAlert" ref="alert_search" />
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
                     <div v-if="isLoading" class="global-loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="modal-header m-header"></div>
                    <div class="modal-body">
                        <div class="card border">
                            <div class="card-header d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xs">
                                        <img class="avatar-img" src="assets/images/mail.png" alt="avatar" />
                                    </div>

                                    <div class="ms-2">
                                           <h5 class="modal-title" style="color: #16a34a!important;font-weight: 500!important;">Share Bid Detail</h5>
                                    </div>
                                </div>

                                <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button
                                        type="button" @click.prevent="closeModal()"
                                        class="btn-close"></button></a>
                            </div>
                            <form class="card-body" style="min-width: 350px;">
                                <div class="mb-3">
                                    <input class="form-control" :class="{ 'is-invalid': errors.recipient_email }"
                                        placeholder="Employee/Colleague Email Address" autocomplet="off"
                                        type="text" id="recipient-name"
                                        v-model="share_international_tender.recipient_email" ref="recipient_email" />
                                    <span v-if="errors.recipient_email" class="invalid-feedback">{{ errors.recipient_email[0]
                                        }}</span>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="text" name="email_subject"
                                        :class="{ 'is-invalid': errors.subject }" placeholder="Subject of Email"
                                        autocomplet="off" id="email_subject"
                                        v-model="share_international_tender.subject" ref="subject" />
                                    <span v-if="errors.subject" class="invalid-feedback">{{ errors.subject[0]
                                        }}</span>
                                </div>

                                <div class="mb-3">
                                    <textarea class="form-control" rows="3" name="email_message"
                                        :class="{ 'is-invalid': errors.message }"
                                        placeholder="Brief Messsage/Note" autocomplet="off" id="email_message"
                                        v-model="share_international_tender.message"></textarea>
                                    <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0]
                                        }}</span>
                                </div>

                                <div class="text-end">
                                    <button class="mb-0 btn btn-sm btn-success fw-400" @click="sendInternationalTenderMail()">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer m-foot"></div>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script>
import axios from "axios";
import Pagination from "@/components/Pagination.vue";
import Region from "@/components/Region";
import moment from "moment-timezone";
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
            add_international_filters: false,
            international_filters: [],
            international_notices: [],
            categories: [],
            sorted_categories: [],
            category_keyword: '',
            state_keyword: '',
            states: [],
            sorted_states: [],
            international_agencies: [],
            sorted_international_agencies: [],
            international_tenders: [],
            share_tender: false,
            meta: {
                international_filter_name: '',
                alert_title: '',
                region: '',
                frequency: '',
                all: false,
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
                international_notices: [],
                categories: [],
                states: [],
                international_agencies: [],
                time_zone: "",
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
                alert_label: false,
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
                category_name: "",
                international_fedral: "",
                created_on: "",
                updated_on: "",
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
            searchprivate: "",
            international_agency_keword: "",
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
            share_international_tender: {
                user_id: null,
                recipient_email: null,
                subject: "",
                message: "",
                international_tenders: [],
            },
            international_keyword: "",
            fullPage: "",
            tag: "",
            alert_errors:[],
            modal:{
                login: null,
                subscribe: null,
                save_search: null,
                set_alert: null,
                share_tender: null
            }
        };
    },

    watch: {
        "meta.response_date": "triggerInternationalTendersForDates",
        "meta.response_from_date": "triggerInternationalTendersWithCondition",
        "meta.response_to_date": "triggerInternationalTendersWithCondition",
        "meta.posted_date": "triggerInternationalTendersForDates",
        "meta.posted_from_date": "triggerInternationalTenders",
        "meta.posted_to_date": "triggerInternationalTenders",
        "meta.active": "triggerInternationalTenders",
        "meta.expired": "triggerInternationalTenders",
        "meta.keywords": "triggerInternationalTenders",
        "meta.international_notices": "triggerInternationalTenders",
        "meta.categories": "triggerInternationalTenders",
        "meta.states": "triggerInternationalTenders",
        "meta.international_agencies": "triggerInternationalTenders",
        "meta.naics": "triggerInternationalTenders",
        "meta.pscs": "triggerInternationalTenders",
        'international_notices' : 'applyFilters',
        'categories': 'applyFilters',
        'states': 'applyFilters',
        'international_agencies': 'applyFilters'
    },

    beforeRouteEnter(to, from, next) {
        next((vm) => {
            vm.from_name = from.name
            if(vm.from_name == 'Alert' || vm.from_name == 'international_tender_details'){
                vm.isLoading = true;
                vm.getInternationalNotices();
            } else if(localStorage.getItem('meta_international')){
                vm.isLoading = true
                vm.getInternationalNotices()
            } else{
                vm.getInternationalNotices();
                vm.paginateInternationalTenders();
            }
            // if (from.name == "saveAlert" && vm.$store.getters.alert) {
            //     vm.getAlert();
            // } else {
            //     vm.$store.commit("setAlert", null);
            // }
            // if (from.name == 'international_tender_details' && vm.$store.getters.filters) {
            //     vm.meta = vm.$store.getters.filters
            //     vm.tags = vm.meta.keywords
            // }
            // vm.meta.time_zone = moment.tz.guess()
            // vm.paginateInternationalTenders()
            // vm.getInternationalNotices()
        });
    },

    mounted() {

        // let international_tender = this.$store.getters.international_tender;
        // this.tags = [];
        // if (international_tender?.title) {
        //     this.handleSelectedTag(international_tender.title);
        // }
        // if (international_tender?.tender_no) {
        //     this.handleSelectedTag(international_tender.tender_no);
        // }
        // let header_menu = this.$store.getters.header_menu
        // if (header_menu) {
        //     header_menu.show_bidsearch = false;
        //     this.$store.dispatch("setHeaderMenu", header_menu);
        // }
        // this.getPscs()
        // this.getNaics()
        // this.$store.commit("setSelectedNaics", [])
    },

    computed: {
        countFilters() {
            let modules = [];
            this.filters.map(function (element) {
                if (!modules.includes(element.module)) {
                    modules.push(element.module);
                }
            });
            return modules.length;
        },
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

        addToCart(international_tender) {
            let vm = this;
            vm.fullPage = true;
            if (vm.$store.getters.user) {
                let cart_item = {
                    user_id: vm.$store.getters.user.user_id,
                    federal_tender_id: null,
                    international_tender_id: international_tender.international_tender_id,
                    region: "Private",
                };
                vm.$store
                    .dispatch("post", { uri: "addCartItem", data: cart_item })
                    .then(function () {
                        vm.fullPage = false;
                        international_tender.cart_icon = false;
                        vm.$store.dispatch("success", "Tender added to cart successfully");
                        vm.getCartItemsCount();
                    })
                    .catch(function (error) {
                        console.log(error);
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        getCartItemsCount() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getCartItemsCount", data: vm.$store.getters.user })
                .then(function (response) {
                    if (response.data) {
                        vm.$store.dispatch("setTenderCart", response.data);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        sharePrivateTender(international_tender) {
            this.closeModal()
            if (this.$store.getters.user && this.$store.getters.user.subscription == 'valid') {
                this.share_international_tender.international_tenders.push(international_tender.international_tender_id)
                this.share_tender = true
            } else {
                if (this.$store.getters.user) {
                    this.modal.subscribe = true
                }else {
                    this.modal.login = true
                }
            }
        },

        sharePrivateTenders() {
            this.modal.login = false
            this.modal.subscribe = false
            this.modal.set_alert = false
            this.modal.save_search = false
            this.share_tender = false
            this.modal.share_tender = false
            if (this.$store.getters.user && this.$store.getters.user.subscription == 'valid') {
                if (this.share_international_tender?.international_tenders?.length) {
                    this.share_tender = true;
                } else {
                    this.share_international_tender.international_tenders = []
                    this.modal.share_tender = true
                }
            } else {
                if (this.$store.getters.user) {
                    this.modal.subscribe = true
                }else {
                    this.modal.login = true
                }
            }
        },

        sendInternationalTenderMail() {
            let vm = this;
            vm.fullPage = true;
            vm.isLoading = true;
            vm.share_international_tender.user_id = this.$store.getters.user.user_id;
            vm.$store
                .dispatch("post", { uri: "sendInternationalTenderMail", data: vm.share_international_tender })
                .then(function () {
                    vm.fullPage = false;
                    vm.isLoading = false;
                    vm.share_tender = false;
                    vm.share_international_tender.recipient_email = "";
                    vm.share_international_tender.subject = "";
                    vm.share_international_tender.message = "";
                    vm.share_international_tender.international_tenders = [];
                    vm.$store.dispatch("success", "Mail sent successfully");
                })
                .catch(function (error) {
                    console.log(error);
                    vm.fullPage = false;
                    vm.isLoading = false;
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        listviewgrid() {
            this.listview = false;
            this.gridview = true;
            this.meta.per_page = 38;
            this.getInternationalTenders();
        },
        gridviewgrid() {
            this.listview = true;
            this.gridview = false;
            this.meta.per_page = 10;
            this.getInternationalTenders();
        },

        getAlert() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getAlert", data: vm.$store.getters.alert })
                .then(function (response) {
                    vm.showInternationalFilter(response.data.data);
                })
                .catch(function (error) {
                    console.log(error);
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

        triggerInternationalTenders() {
            if (this.auto_call) {
                this.cancelPreviousRequest();
                this.getInternationalTenders();
            }
        },

        triggerInternationalTendersForDates() {
            if (((this.meta.posted_date && this.meta.posted_date != "custom") || (this.meta.response_date && this.meta.response_date != "custom")) && this.auto_call) {
                this.cancelPreviousRequest();
                this.getInternationalTenders();
            }
        },

        triggerInternationalTendersWithCondition() {
            if ((this.meta.posted_from_date && this.meta.posted_to_date) || (this.meta.response_from_date && this.meta.response_to_date && this.auto_call)) {
                this.cancelPreviousRequest();
                this.getInternationalTenders();
            }
        },

        cancelPreviousRequest() {
            if (this.cancel_token_source) {
                this.cancel_token_source.cancel("Operation canceled due to new request.");
                this.cancel_token_source = null; // Reset after cancellation
            }
        },

        showInternationalFilter(international_filter) {
            this.auto_call = false
            this.meta.active = international_filter.active
            this.meta.expired = international_filter.expired
            this.meta.keywords = international_filter.keywords
            this.tags = international_filter.keywords
            this.meta.international_notices = international_filter.international_notices
            this.meta.posted_date = international_filter.posted_date
            this.meta.response_date = international_filter.response_date
            this.meta.categories = international_filter.categories
            this.meta.states = international_filter.states
            this.meta.international_agencies = international_filter.international_agencies
            this.getInternationalTenders()
        },

        addInternationalFilter(filter_name) {
            let vm = this;
            vm.meta.international_filter_name = filter_name;
            if (this.$store.getters.user) {
                vm.meta.user_id = this.$store.getters.user.user_id;
                vm.$store
                    .dispatch("post", { uri: "addInternationalFilters", data: vm.meta })
                    .then(function (response) {
                        vm.$store.dispatch("success", "Filters saved successfully");
                        vm.getInternationalFilters()
                        vm.closeModal();
                    })
                    .catch(function (error) {
                        console.log(error);
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        addAlert(alert) {
            let vm = this;
            vm.alert_errors = []
            vm.meta.alert_title = alert.alert_label;
            vm.meta.frequency = alert.frequency;
            vm.meta.region = "International";
            vm.meta.user_id = vm.$store.getters.user?.user_id
            vm.$store
                .dispatch("post", { uri: "addInternationalAlerts", data: vm.meta })
                .then(function (response) {
                    vm.$store.dispatch("success", "Filters saved successfully");
                    vm.closeModal();
                })
                .catch(function (error) {
                    console.log(error);
                    vm.closeModal()
                    vm.alert_errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        closeModal() {
            this.modal.login = false
            this.modal.subscribe = false
            this.modal.set_alert = false
            this.modal.save_search = false
            this.share_tender = false
            this.modal.share_tender = false
            this.share_international_tender.international_tenders = []
        },

        setAletModal() {
            this.closeModal()
            if (this.$store.getters.user && this.$store.getters.user.subscription == 'valid') {
                this.modal.set_alert = true
            } else {
                if (this.$store.getters.user) {
                    this.modal.subscribe = true
                }else {
                    this.modal.login = true
                }
            }
        },


        saveSearchModal(){
            this.closeModal()
            if (this.$store.getters.user && this.$store.getters.user.subscription == 'valid') {
                this.modal.save_search = true
            } else {
                if (this.$store.getters.user) {
                    this.modal.subscribe = true
                }else {
                    this.modal.login = true
                }
            }
        },

        tenderDetails(international_tender) {
            this.closeModal()
            if(this.$store.getters.user && this.$store.getters.user.subscription == 'valid'){
                this.$store.commit("setInternationalTender", international_tender)
                this.$store.commit("setFilters", this.meta)
                this.$router.push("international-opportunities/" + international_tender.title.replace(/ /g, "-") + "-" + international_tender.tender_no)
            }else{
                if(this.$store.getters.user){
                    this.modal.subscribe = true
                }else{
                    this.modal.login = true
                }
            }
        },

        showModal() {
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
            this.paginateInternationalTenders();
        },

        handleChangeTag(tags) {
            let vm = this
            vm.tags = tags
            vm.meta.page = 1
            vm.meta.keywords = vm.tags
        },

        searchStates() {
            let vm = this;
            vm.sorted_states = vm.states.filter(function (element) {
                return element.state_name.toLowerCase().includes(vm.state_keyword.toLowerCase());
            });
        },
        selectAllStates() {
            let vm = this;
            vm.meta.states = [];
            vm.sorted_states.map(function (element) {
                vm.meta.states.push(element.state_id);
            });
        },
        deselectAllStates() {
            let vm = this;
            vm.meta.states = [];
            vm.sorted_states = vm.states;
            vm.state_keyword = null;
        },

        searchCategories() {
            let vm = this;
            vm.sorted_categories = vm.categories.filter(function (element) {
                return element.category_name.toLowerCase().includes(vm.category_keyword.toLowerCase());
            });
        },
        selectAllCategories() {
            let vm = this;
            vm.meta.categories = [];
            vm.sorted_categories.map(function (element) {
                vm.meta.categories.push(element.category_id);
            });
        },
        deselectAllCategories() {
            let vm = this;
            vm.meta.categories = [];
            vm.sorted_categories = vm.categories;
            vm.category_keyword = null;
        },

        selectAllPrivateAgencies() {
            let vm = this;
            vm.meta.international_agencies = [];
            vm.sorted_international_agencies.map(function (element) {
                vm.meta.international_agencies.push(element.international_agency_id);
            });
        },
        deselectAllPrivateAgencies() {
            let vm = this;
            vm.meta.international_agencies = [];
            vm.sorted_international_agencies = vm.international_agencies;
            vm.international_agency_keword = null;
        },
        searchPrivateAgencies() {
            let vm = this;
            vm.sorted_international_agencies = vm.international_agencies.filter(function (element) {
                return element.international_agency_name.toLowerCase().includes(vm.international_agency_keword.toLowerCase());
            });
        },
        clearAllFilters() {
            this.auto_call = false
            this.meta.response_date = false
            this.meta.response_from_date = false
            this.meta.response_to_date = false
            this.meta.posted_date = false
            this.meta.posted_from_date = false
            this.meta.posted_to_date = false
            this.meta.active = false
            this.meta.expired = false
            this.meta.keywords = []
            this.tags = []
            this.meta.international_notices = []
            this.meta.categories = []
            this.meta.states = []
            this.meta.international_agencies = []
            this.getInternationalTenders();
        },
        removeFilter(filter) {
            if (filter.id == "status" || filter.id == "date") {
                this.meta[filter.module] = false;
                this.applyFilters()
            } else if (typeof filter.id === "number") {
                if (Array.isArray(this.meta[filter.module])) {
                    this.meta[filter.module] = this.meta[filter.module].filter(function (ele) {
                        return filter.id !== ele;
                    });
                } else {
                    this.meta[filter.module] = null;
                }
            } else {
                this.meta[filter.module] = [];
            }
        },

        applyFilters() {
            let vm = this;
            vm.filters = [];
            let meta_fields = []
            if(vm.international_agencies.length == vm.meta.international_agencies.length){
                meta_fields = [
                    { meta_field: "international_notices", data_field: "international_notices", id_field: "international_notice_id", name_field: "international_notice_name" },
                    { meta_field: "categories", data_field: "categories", id_field: "category_id", name_field: "category_name" },
                    { meta_field: "states", data_field: "states", id_field: "state_id", name_field: "state_name" }
                ];
            }else{
                meta_fields = [
                    { meta_field: "international_notices", data_field: "international_notices", id_field: "international_notice_id", name_field: "international_notice_name" },
                    { meta_field: "categories", data_field: "categories", id_field: "category_id", name_field: "category_name" },
                    { meta_field: "states", data_field: "states", id_field: "state_id", name_field: "state_name" },
                    { meta_field: "international_agencies", data_field: "international_agencies", id_field: "international_agency_id", name_field: "international_agency_name" },
                ];
            }

            if (vm.meta.active) {
                vm.filters.push({
                    name: "active",
                    id: "status",
                    module: "active",
                });
            }
            if (vm.meta.expired) {
                vm.filters.push({
                    name: "expired",
                    id: "status",
                    module: "expired",
                });
            }

            if (vm.meta.active && vm.meta.expired) {
                vm.meta.all = true
            } else if (!vm.meta.active || !vm.meta.expired) {
                vm.meta.all = false
            }

            if (vm.meta.keywords.length) {
                vm.filters.push({
                    name: "keywords",
                    id: "keywords",
                    module: "keywords",
                });
            }

            if(vm.meta.international_agencies.length && vm.international_agencies.length == vm.meta.international_agencies.length){
                vm.filters.push({
                    name: "Agencies : "+vm.meta.international_agencies.length,
                    id: "international_agencies",
                    module: "international_agencies",
                });
            }

            meta_fields.forEach((field) => {
                if (vm.meta[field.meta_field] && vm.meta[field.meta_field].length) {
                    console.log('field', vm.meta[field.meta_field])
                    vm.meta[field.meta_field].map(function (ele) {
                        console.log('data_field', vm[field.data_field])
                        let matched_item = vm[field.data_field].filter(function (item) {
                            console.log('item', item)
                            console.log('ele', ele)
                            return item[field.id_field] == ele;
                        });
                        console.log('matched', matched_item)

                        if (matched_item.length) {
                            vm.filters.push({
                                name: matched_item[0][field.name_field],
                                id: matched_item[0][field.id_field],
                                module: field.meta_field,
                            });
                        }
                    });
                }
            });

            if (vm.meta.posted_date) {
                vm.filters.push({
                    name: vm.meta.posted_date,
                    id: "date",
                    module: "posted_date",
                });
            }

            if (vm.meta.response_date) {
                vm.filters.push({
                    name: vm.meta.response_date,
                    id: "date",
                    module: "response_date",
                });
            }
            localStorage.setItem('meta_international', JSON.stringify(vm.meta))
        },

        getInternationalTenders() {
            if (this.cancel_token_source) {
                this.cancel_token_source.cancel("Operation canceled due to new request.");
            }
            this.cancel_token_source = axios.CancelToken.source();
            this.paginateInternationalTenders(this.cancel_token_source.token);
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
            if (typeof this.meta.keywords === "string" && this.meta.keywords.length) {
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

        getInternationalNotices() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getInternationalNotices" })
                .then(function (response) {
                    vm.international_notices = response.data.data
                    vm.getCategories();
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getCategories() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getCategories" })
                .then(function (response) {
                    vm.categories = response.data;
                    vm.sorted_categories = vm.categories;
                    vm.getStates();
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
                    vm.getInternationalAgencies();
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getInternationalAgencies() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getInternationalAgencies" })
                .then(function (response) {
                    vm.international_agencies = response.data.data
                    vm.sorted_international_agencies = vm.international_agencies;
                    if (vm.$store.getters.user) {
                        vm.getInternationalFilters();
                    }

                    if (vm.from_name == "Alert" && vm.$store.getters.alert) {
                        vm.getAlert();
                    } else {
                        vm.$store.commit("setAlert", null);
                    }
                    if (vm.from_name == 'international_tender_details' && vm.$store.getters.filters) {
                        vm.meta = vm.$store.getters.filters
                        vm.tags = vm.meta.keywords;
                    } else if(localStorage.getItem('meta_international')){
                        vm.meta = JSON.parse(localStorage.getItem('meta_international'))
                    }
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getInternationalFilters() {
            let vm = this;
            if (vm.$store.getters.user) {
                vm.$store
                    .dispatch("post", { uri: "getInternationalFilters", data: vm.$store.getters.user })
                    .then(function (response) {
                        vm.international_filters = response.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        paginateInternationalTenders(cancel_token) {
            let vm = this;
            this.isLoading = true;
            vm.international_tenders = [];
            vm.applyFilters();
            window.scrollTo({ top: 0, behavior: "smooth" });
            vm.$store
                .dispatch("post", { uri: "paginateInternationalTenders", data: vm.meta, cancel_token })
                .then(function (response) {
                    vm.isLoading = false;
                    vm.auto_call = true;
                    vm.international_tenders = response.data.data;
                    vm.meta.totalRows = response.data.meta.total;
                    vm.meta.lastPage = response.data.meta.last_page;
                    vm.meta.from = response.data.meta.from;
                    vm.meta.maxPage = vm.meta.lastPage >= 3 ? 3 : vm.meta.lastPage;
                    vm.meta.to = response.data.meta.to;
                    vm.meta.page = response.data.meta.current_page;
                })
                .catch(function (error) {
                    if (axios.isCancel(error)) {
                        console.log("Previous request was canceled:", error.message);
                    } else {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    }
                });
        },
        onPageChange(page) {
            this.is_updating_meta = true;
            this.pageChangeInProgress = true;
            this.meta.page = page;
            this.getInternationalTenders();
        },

        onPerPageChange() {
            this.meta.page = 1;
            this.paginateInternationalTenders();
        },
        getNoticeColor(noticeName) {
            if(noticeName){
                if (noticeName === "Award Notice") return "#2569f9";
                if (noticeName === "Request for Proposal") return "green";
                if (noticeName === "Request for Information") return "yellow";
                return "gray"; // Default color
            }
        },
        formatDate(date) {
            return date ? moment(date).format("MMM DD, YYYY") : "";
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


.table-active {
    /* background-color: #f5f5f5; */
    /* background-color: rgb(237 243 255); */
    background-color: #f0f6ff
        /* Light grey background */
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
.global-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Optional: Dark background */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000; /* Higher than modal */
}
.input-with-icon {
    display: flex;
    align-items: center;
    border: none;
    padding: 5px;
    border-radius: 4px;
  }

  .input-with-icon input {
    border: none;
    outline: none;
    flex: 1;
    padding: 5px;
  }
  .vertical-align-middle {
        vertical-align: middle;
    }
    .border-radius-10 {
        border-radius: 10px;
    }
    .truncate-text {
        white-space: nowrap; /* Prevents text from wrapping */
        overflow: hidden; /* Hides overflowing text */
        text-overflow: ellipsis; /* Shows "..." for overflow text */
        max-width: 450px; /* Adjust the width as needed */
        display: block;
    }
    .color-box {
        width: 12px;
        height: 12px;
        border-radius: 10px;
        display: inline-block;
    }

    th {
        position: relative;
        color: rgba(45, 59, 84, 1);
        font-weight: 600;
        text-align: start;
        /* background: #fafbfb; */
        border-bottom: 1px solid #ebecf0;
        padding: 16px 16px;
    }

    .border-right::after {
        content: "";
        position: absolute;
        right: 10px;
        top: 50%;
        inset-inline-end: 0;
        width: 1px;
        height: 1.6em;
        background-color: #ebecf0;
        transform: translateY(-50%);
        transition: background-color 0.2s;
    }

    .border-right:last-child::after {
        display: none; /* Remove border from the last column */
    }
    .w-250 {
        width: 250px;
    }
    .txt-gray {
        color: rgba(45, 59, 84, 1);
    }
    .fs-24 {
        font-size: 24px;
    }
</style>