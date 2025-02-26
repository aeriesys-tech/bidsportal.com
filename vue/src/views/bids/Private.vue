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
                                <li v-for="private_filter, key in private_filters" :key="key"
                                    class="dropdown-item dropitem1 p-0 px-2">
                                    <i class="fas fa-caret-right text-primary my-auto"></i>
                                    <a class="dropdown-item dropitem2" href="javascript:void(0)"
                                        @click="showPrivateFilter(private_filter)">{{ private_filter.private_filter_name
                                        }}</a>
                                   <a href="javascript:void(0)" class="icon red my-auto" @click="confirmDelete(private_filter)">
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
                                        :class="{ bluetextclass: meta.private_notices?.length !== 0 }">Notice Type</h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="noticetype"
                                    v-for="notice in private_notices" :key="notice.notice_id">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                v-model="meta.private_notices" :value="notice.private_notice_id" />
                                            <label class="form-check-label">{{ notice.private_notice_name }}</label>
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

                                    <div class="scroll1 hgt-300">
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
                                        :class="{ 'bluetextclass': meta.private_agencies?.length !== 0 }">Private Agency
                                    </h6>

                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-12 ml2 multi-collapse collapse show" id="federalagency">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-1">
                                            <a class="btn btn-link p-0 mb-0 me-2">({{ meta.private_agencies?.length }} of
                                                {{ private_agencies?.length }})</a>
                                            <span
                                                v-if="meta.private_agencies?.length !== sorted_private_agencies?.length">
                                                <a href="" @click.prevent="selectAllPrivateAgencies()"
                                                    class="form-check-label text-primary me-2">| Select All</a>
                                            </span>
                                            <span v-if="meta.private_agencies?.length">
                                                <a href="" class="form-check-label text-primary me-2"
                                                    @click.prevent="deselectAllPrivateAgencies()"
                                                    v-if="meta.private_agencies?.length !== 0">| Reset</a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <form class="position-relative w-100 me-4 mb-2">
                                            <input class="form-control form-control-sm bg-light pe-5" type="search"
                                                @keyup="searchPrivateAgencies()" v-model="private_agency_keword"
                                                placeholder="Search Agency" aria-label="Search" />
                                            <button
                                                class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y"
                                                type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                        </form>
                                    </div>

                                    <div class="scroll3">
                                        <div class="d-flex justify-content-between align-items-center"
                                            v-for="private_agency in sorted_private_agencies" :key="private_agency.private_agency_id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :value="private_agency.private_agency_id"
                                                    v-model="meta.private_agencies" />
                                                <label class="form-check-label"> {{ private_agency.private_agency_name
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
                        <section v-if="!private_tenders.length && !isLoading">
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
                        <div class="text-end pb-2" v-if="private_tenders.length">
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
                                <div class="card shadow mb-3" v-for="private_tender in private_tenders"
                                    :key="private_tender.private_tender_id">
                                    <div class="card-body py-md-3 d-flex flex-column h-100 position-relative"
                                        id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                    <a href="javascript:void(0)" @click="tenderDetails(private_tender)">
                                                        <div v-html="highlight(private_tender.title)"></div>
                                                    </a>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0"
                                                        v-if="$store.getters.user !== null">
                                                        <small class="form-check-label mb-0 me-2"><a
                                                                href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox"
                                                            :value="private_tender.private_tender_id"
                                                            id="flexCheckChecked" v-model="share_private_tender.private_tenders" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/posteddate.svg" />{{
                                                        private_tender.private_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/bidnumber.svg" />
                                                    <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;"> {{ private_tender.tender_no}}</span>
                                                   <span v-else>{{ private_tender.tender_no }}</span>
                                            </li>
                                            <li class="nav-item"><img class="small w-15px me-1"
                                                    src="../../assets/icons/posteddate.svg" />{{
                                                        dateFormat(private_tender.opening_date) }} &nbsp;<span>{{
                                                    private_tender.time_ago }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" />
                                                {{ dateFormat(private_tender.expiry_date) }}
                                                <span class="col-green" v-if="private_tender.days_difference">
                                                    &nbsp; {{ private_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2">
                                            <li class="list-group-item d-flex text-success p-0">
                                                 <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                     <p class="limited-text" style="filter: blur(3px);color: #696969; text-align: justify;"
                                                    v-html="private_tender.description"
                                                    v-if="private_tender.description != '0' && private_tender.description != '-'">
                                                </p>
                                                </span>
                                                <span v-else>
                                                    <p class="limited-text" style="color: #595d6e; text-align: justify;"
                                                        v-html="private_tender.description"
                                                        v-if="private_tender.description != '0' && private_tender.description != '-'">
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
                                                        <span style="filter: blur(3px);color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">{{ private_tender.private_agency?.private_agency_name}}</span>
                                                        <span v-else style="color: rgb(86, 84, 109);">{{private_tender.private_agency?.private_agency_name }}</span>
                                                    </li>

                                                    <li class="nav-item">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>{{
                                                            private_tender?.state?.state_name }}<span
                                                            v-if="private_tender?.state?.state_name">,</span> {{
                                                                private_tender?.country?.country_name }}
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <li class="list-inline-item" v-if="$store.getters.user !== null">
                                                        <a href="javascript:void(0)"
                                                            @click.prevent="sharePrivateTender(private_tender)"
                                                            class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE
                                                        </a>
                                                    </li>

                                                    <!-- <li class="list-inline-item" v-if="private_tender.cart_icon">
                                                        <div>
                                                            <a href="javascript:void(0)" @click="addToCart(private_tender)" class="p-2">
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
                                <div class="card shadow mb-3" v-if="private_tenders.length !== 0">
                                    <div class="card-body p-0 d-flex flex-column h-100 position-relative">
                                        <div class="table-responsive border border-radius-10">
                                            <table class="table small align-middle p-4 mb-0 table-hover table-shrink">
                                                <thead class="table-light">
                                                    <tr class="vertical-align-middle">
                                                        <th class="border-0 text-center" v-if="$store.getters.user !== null">
                                                            <div class="form-check1">
                                                                <input class="form-check-input" type="checkbox" />
                                                            </div>
                                                        </th>
                                                        <th scope="col" class="border-0 border-right ">Bid Number & Notice type</th>
                                                        <th scope="col" class="border-0 border-right">Title & Agency</th>
                                                        <th scope="col" class="border-0 border-right">State</th>
                                                        <th scope="col" class="border-0">Due date</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="border-top-0">
                                                    <tr v-for="private_tender in private_tenders" :key="private_tender.private_tender_id">
                                                        <td class="text-center" v-if="$store.getters.user !== null">
                                                            <div class="form-check1">
                                                                <input class="form-check-input" type="checkbox" :value="private_tender.private_tender_id" v-model="share_private_tender.private_tenders" />
                                                            </div>
                                                        </td>
                                                        <td class="w-250">
                                                            <div class="row">
                                                                <div class="column" style="margin-left: 21px;">
                                                                    <span style="filter: blur(3px); color: rgb(57, 112, 228);" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                        {{ private_tender.tender_no }}
                                                                    </span>
                                                                    <span v-else>
                                                                        <a href="javascript:void(0)" style="color: rgb(57, 112, 228);" @click="tenderDetails(private_tender)">{{ private_tender.tender_no }}</a>
                                                                    </span>
                                                                </div>
                                                                <div class="column d-flex align-items-center">
                                                                    <span class="color-box me-2" :style="{ backgroundColor: private_tender.private_notice_color}"> </span>

                                                                    <a :style="{ color: private_tender.private_notice?.backround_color }" class="txt-gray">
                                                                        {{ private_tender.private_notice?.private_notice_name }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <a style="color: rgb(57, 112, 228); font-weight: bold;" href="javascript:void(0)" @click="tenderDetails(private_tender)">
                                                                <div class="truncate-text" v-html="highlight(private_tender.title)"></div>
                                                            </a>

                                                            <span class="txt-gray" style="filter: blur(3px); color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                {{ private_tender.private_agency?.private_agency_name}}
                                                            </span>
                                                            <span class="txt-gray" v-else>{{ private_tender.private_agency?.private_agency_name}}</span>
                                                        </td>
                                                        <td class="txt-gray">{{ private_tender?.state?.state_name }}</td>
                                                        <td class="txt-gray" style="width: 110px;">{{ private_tender.expiry_date_parsed }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="private_tenders.length !== 0">
                            <div style="float: left;">
                                <span class="input-with-icon">
                                    <input type="text" class="form-control" v-model="meta.page" @keypress.enter="getPrivateTenders()" style="width: 60px;" />
                                    <span style="margin-left: 10px;">of {{ meta.lastPage }} pages</span>
                                </span>
                                <!-- <input type="text" class="form-control" v-model="meta.page"
                                    @keypress.enter="getPrivateTenders()" style="width: 60px;" /> -->
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
                    <!-- <div class="">
                        <SaveSearch @closeModal="closeModal" @savedSearch="saveSearch" @updateSearch="addPrivateFilter"
                            :status="status" :alert_label="meta.alert_label" :savedbids="savedbids" ref="save_search"/>
                    </div> -->
                      <div class="">
                            <SaveSearch @closeModal="closeModal" @updateSearch="updatePrivateFilter"  @saveSearch="addPrivateFilter" :status="save_search_filter.status" :filter_name="meta.private_filter_name" :savedbids="savedbids" ref="save_search" />
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
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-bell fs-24 fa-fw text-success"></i>
                                        <div class="ms-2">
                                            <h5 class="modal-title" style="color: #16a34a!important;font-weight: 500!important;">Alert</h5>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0">
                                        <button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
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
            <div class="modal-body">
                <div class="card border">
                    <div class="card-header d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-bell fs-24 fa-fw text-success"></i>
                            <div class="ms-2">
                            <h5 class="modal-title" style="color: #16a34a!important;font-weight: 500!important;">Alert</h5>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button
                                type="button" @click.prevent="closeModal()"
                                class="btn-close"></button></a>
                    </div>
                    <div class="card-body text-center" style="min-width: 350px;">
                        <h6 class="text-danger">Please select bid !</h6>
                    </div>
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
                                     <i class="fa fa-envelope fs-24 fa-fw text-success"></i>
                                    <div class="ms-2">
                                       <h5 class="modal-title" style="color: #16a34a!important;font-weight: 500!important;">Share Bid Details</h5>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button
                                        type="button" @click.prevent="closeModal()"
                                        class="btn-close"></button></a>
                            </div>
                            <form class="card-body" style="min-width: 350px;">
                                <div class="mb-3">
                                    <input class="form-control" :class="{ 'is-invalid': errors.recipient_email }"
                                        placeholder="Email" autocomplet="off"
                                        type="text" id="recipient-name"
                                        v-model="share_private_tender.recipient_email" ref="recipient_email" />
                                    <span v-if="errors.recipient_email" class="invalid-feedback">{{ errors.recipient_email[0]
                                        }}</span>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="text" name="email_subject"
                                        :class="{ 'is-invalid': errors.subject }" placeholder="Subject"
                                        autocomplet="off" id="email_subject"
                                        v-model="share_private_tender.subject" ref="subject" />
                                    <span v-if="errors.subject" class="invalid-feedback">{{ errors.subject[0]
                                        }}</span>
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" rows="3" name="email_message"
                                        :class="{ 'is-invalid': errors.message }"
                                        placeholder="Messsage" autocomplet="off" id="email_message"
                                        v-model="share_private_tender.message"></textarea>
                                    <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0]
                                        }}</span>
                                </div>
                                <div class="text-end">
                                    <button class="mb-0 btn btn-sm btn-success fw-400" @click="sendPrivateTenderMail()">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer m-foot"></div>
                </div>
            </div>
        </div>
    </teleport>
    <!-- Confirmation Modal -->
    <teleport to="#modals" v-if="erroralertmodal">
        <div class="modal-overlay">
            <div class="confirm text-center" style="background-color: white !important;">
                <a class="btn btn-outline-none float-end" @click.prevent="closeModal()">
                    <i class="fa-solid fa-close"></i>
                </a>
                <h1 class="title-green">Are you sure?</h1>
                <p>Do you really want to delete these records? This process cannot be undone.</p>
                <a class="btn btn-sm btn-secondary mb-3 me-2" @click.prevent="closeModal()">Cancel</a>
                <a class="btn btn-sm btn-success mb-3" @click.prevent="deleteAlert()">Confirm</a>
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
            add_private_filters: false,
            private_filters: [],
            private_notices: [],
            categories: [],
            sorted_categories: [],
            category_keyword: '',
            state_keyword: '',
            states: [],
            sorted_states: [],
            private_agencies: [],
            sorted_private_agencies: [],
            private_tenders: [],
            share_tender: false,
            meta: {
                private_filter_name: '',
                private_filter_id: '',
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
                private_notices: [],
                categories: [],
                states: [],
                private_agencies: [],
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
                status:true
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
                private_fedral: "",
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
            private_agency_keword: "",
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
            share_private_tender: {
                user_id: null,
                recipient_email: null,
                subject: "",
                message: "",
                private_tenders: [],
            },
            private_keyword: "",
            fullPage: "",
            tag: "",
            alert_errors:[],
            modal:{
                login: null,
                subscribe: null,
                save_search: null,
                set_alert: null,
                share_tender: null
            },
            erroralertmodal: false,
            delete_alert: null,
            save_search_filter:{
                    status:true
                }
        };
    },

    watch: {
        "meta.response_date": "triggerPrivateTendersForDates",
        "meta.response_from_date": "triggerPrivateTendersWithCondition",
        "meta.response_to_date": "triggerPrivateTendersWithCondition",
        "meta.posted_date": "triggerPrivateTendersForDates",
        "meta.posted_from_date": "triggerPrivateTenders",
        "meta.posted_to_date": "triggerPrivateTenders",
        "meta.active": "triggerPrivateTenders",
        "meta.expired": "triggerPrivateTenders",
        "meta.keywords": "triggerPrivateTenders",
        "meta.private_notices": "triggerPrivateTenders",
        "meta.categories": "triggerPrivateTenders",
        "meta.states": "triggerPrivateTenders",
        "meta.private_agencies": "triggerPrivateTenders",
        "meta.naics": "triggerPrivateTenders",
        "meta.pscs": "triggerPrivateTenders",
        'private_notices' : 'applyFilters',
        'categories': 'applyFilters',
        'states': 'applyFilters',
        'private_agencies': 'applyFilters'
    },

    beforeRouteEnter(to, from, next) {
        next((vm) => {
            vm.from_name = from.name
            if(vm.from_name == 'Alert' || vm.from_name == 'private_tender_details'){
                vm.isLoading = true;
                vm.getPrivateNotices();
            } else if(localStorage.getItem('meta_private')){
                vm.isLoading = true
                vm.getPrivateNotices()
            } else{
                vm.getPrivateNotices();
                vm.paginatePrivateTenders();
            }
            // if (from.name == "saveAlert" && vm.$store.getters.alert) {
            //     vm.getAlert();
            // } else {
            //     vm.$store.commit("setAlert", null);
            // }
            // if (from.name == 'private_tender_details' && vm.$store.getters.filters) {
            //     vm.meta = vm.$store.getters.filters
            //     vm.tags = vm.meta.keywords
            // }
            // vm.meta.time_zone = moment.tz.guess()
            // vm.paginatePrivateTenders()
            // vm.getPrivateNotices()
        });
    },

    mounted() {

        // let private_tender = this.$store.getters.private_tender;
        // this.tags = [];
        // if (private_tender?.title) {
        //     this.handleSelectedTag(private_tender.title);
        // }
        // if (private_tender?.tender_no) {
        //     this.handleSelectedTag(private_tender.tender_no);
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

        addToCart(private_tender) {
            let vm = this;
            vm.fullPage = true;
            if (vm.$store.getters.user) {
                let cart_item = {
                    user_id: vm.$store.getters.user.user_id,
                    federal_tender_id: null,
                    private_tender_id: private_tender.private_tender_id,
                    region: "Private",
                };
                vm.$store
                    .dispatch("post", { uri: "addCartItem", data: cart_item })
                    .then(function () {
                        vm.fullPage = false;
                        private_tender.cart_icon = false;
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

        sharePrivateTender(private_tender) {
            this.closeModal()
            if (this.$store.getters.user && this.$store.getters.user.subscription == 'valid') {
                this.share_private_tender.private_tenders.push(private_tender.private_tender_id);
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
                if (this.share_private_tender?.private_tenders?.length) {
                    this.share_tender = true;
                } else {
                    this.share_private_tender.private_tenders = []
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

        sendPrivateTenderMail() {
            let vm = this;
            vm.fullPage = true;
            vm.isLoading = true;
            vm.share_private_tender.user_id = this.$store.getters.user.user_id;
            vm.$store
                .dispatch("post", { uri: "sendPrivateTenderMail", data: vm.share_private_tender })
                .then(function () {
                    vm.fullPage = false;
                    vm.isLoading = false;
                    vm.share_tender = false;
                    vm.share_private_tender.recipient_email = "";
                    vm.share_private_tender.subject = "";
                    vm.share_private_tender.message = "";
                    vm.share_private_tender.private_tenders = [];
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
            this.meta.per_page = 30;
            this.getPrivateTenders();
        },
        gridviewgrid() {
            this.listview = true;
            this.gridview = false;
            this.meta.per_page = 15;
            this.getPrivateTenders();
        },

        getAlert() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getAlert", data: vm.$store.getters.alert })
                .then(function (response) {
                    vm.showPrivateFilter(response.data.data);
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

        triggerPrivateTenders() {
            if (this.auto_call) {
                this.cancelPreviousRequest();
                this.getPrivateTenders();
            }
        },

        triggerPrivateTendersForDates() {
            if (((this.meta.posted_date && this.meta.posted_date != "custom") || (this.meta.response_date && this.meta.response_date != "custom")) && this.auto_call) {
                this.cancelPreviousRequest();
                this.getPrivateTenders();
            }
        },

        triggerPrivateTendersWithCondition() {
            if ((this.meta.posted_from_date && this.meta.posted_to_date) || (this.meta.response_from_date && this.meta.response_to_date && this.auto_call)) {
                this.cancelPreviousRequest();
                this.getPrivateTenders();
            }
        },

        cancelPreviousRequest() {
            if (this.cancel_token_source) {
                this.cancel_token_source.cancel("Operation canceled due to new request.");
                this.cancel_token_source = null; // Reset after cancellation
            }
        },

        showPrivateFilter(private_filter) {
            this.auto_call = false
            this.meta.active = private_filter.active
            this.meta.expired = private_filter.expired
            this.meta.keywords = private_filter.keywords
            this.tags = private_filter.keywords
            this.meta.private_notices = private_filter.private_notices
            this.meta.posted_date = private_filter.posted_date
            this.meta.response_date = private_filter.response_date
            this.meta.categories = private_filter.categories
            this.meta.states = private_filter.states
            this.meta.private_agencies = private_filter.private_agencies
            this.meta.private_filter_name = private_filter.private_filter_name;
            this.meta.private_filter_id = private_filter.private_filter_id;
            this.save_search_filter.status = false
            this.getPrivateTenders()
        },

        addPrivateFilter(filter_name) {
            let vm = this;
            vm.meta.private_filter_name = filter_name;
            if (this.$store.getters.user) {
                vm.meta.user_id = this.$store.getters.user.user_id;
                vm.$store
                    .dispatch("post", { uri: "addPrivateFilters", data: vm.meta })
                    .then(function (response) {
                        vm.$store.dispatch("success", "Filters saved successfully");
                        vm.getPrivateFilters()
                        vm.closeModal();
                    })
                    .catch(function (error) {
                        console.log(error);
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },
        updatePrivateFilter(filter_name) {
                console.log("Filter-",filter_name)
                let vm = this;
                vm.meta.private_filter_name = filter_name;
                if (this.$store.getters.user) {
                    vm.meta.user_id = this.$store.getters.user.user_id;
                    vm.$store
                        .dispatch("post", { uri: "updatePrivateFilters", data: vm.meta })
                        .then(function (response) {
                            vm.$store.dispatch("success", "Filters saved successfully");
                            vm.getPrivateFilters();
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
            let vm = this
            vm.alert_errors = []
            vm.meta.alert_title = alert.alert_label;
            vm.meta.frequency = alert.frequency;
            vm.meta.region = "Private";
            vm.meta.user_id = vm.$store.getters.user?.user_id
            vm.$store
                .dispatch("post", { uri: "addPrivateAlerts", data: vm.meta })
                .then(function (response) {
                    vm.$store.dispatch("success", "Filters saved successfully");
                    vm.closeModal();
                })
                .catch(function (error) {
                    console.log(error)
                    vm.closeModal();
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
            this.erroralertmodal = false; // Hide modal
            this.delete_alert = null;
            this.share_private_tender.private_tenders = []
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
        tenderDetails(private_tender) {
            this.closeModal()
            if(this.$store.getters.user && this.$store.getters.user.subscription == 'valid'){
                this.$store.commit("setPrivateTender", private_tender)
                this.$store.commit("setFilters", this.meta)
                this.$router.push("private-commercial/" + private_tender.title.replace(/ /g, "-") + "-" + private_tender.tender_no)
            }else{
                if(this.$store.getters.user){
                    this.modal.subscribe = true
                }else{
                    this.modal.login = true
                }
            }
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
            this.paginatePrivateTenders();
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
            vm.meta.private_agencies = [];
            vm.sorted_private_agencies.map(function (element) {
                vm.meta.private_agencies.push(element.private_agency_id);
            });
        },
        deselectAllPrivateAgencies() {
            let vm = this;
            vm.meta.private_agencies = [];
            vm.sorted_private_agencies = vm.private_agencies;
            vm.private_agency_keword = null;
        },
        searchPrivateAgencies() {
            let vm = this;
            vm.sorted_private_agencies = vm.private_agencies.filter(function (element) {
                return element.private_agency_name.toLowerCase().includes(vm.private_agency_keword.toLowerCase());
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
            this.meta.private_notices = []
            this.meta.categories = []
            this.meta.states = []
            this.meta.private_agencies = []
            this.getPrivateTenders();
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
            if(vm.private_agencies.length == vm.meta.private_agencies.length){
                meta_fields = [
                    { meta_field: "private_notices", data_field: "private_notices", id_field: "private_notice_id", name_field: "private_notice_name" },
                    { meta_field: "categories", data_field: "categories", id_field: "category_id", name_field: "category_name" },
                    { meta_field: "states", data_field: "states", id_field: "state_id", name_field: "state_name" }
                ];
            }else{
                meta_fields = [
                    { meta_field: "private_notices", data_field: "private_notices", id_field: "private_notice_id", name_field: "private_notice_name" },
                    { meta_field: "categories", data_field: "categories", id_field: "category_id", name_field: "category_name" },
                    { meta_field: "states", data_field: "states", id_field: "state_id", name_field: "state_name" },
                    { meta_field: "private_agencies", data_field: "private_agencies", id_field: "private_agency_id", name_field: "private_agency_name" },
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

            if(vm.meta.private_agencies.length && vm.private_agencies.length == vm.meta.private_agencies.length){
                vm.filters.push({
                    name: "Agencies : "+vm.meta.private_agencies.length,
                    id: "private_agencies",
                    module: "private_agencies",
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
            localStorage.setItem('meta_private', JSON.stringify(vm.meta))
        },

        getPrivateTenders() {
            if (this.cancel_token_source) {
                this.cancel_token_source.cancel("Operation canceled due to new request.");
            }
            this.cancel_token_source = axios.CancelToken.source();
            this.paginatePrivateTenders(this.cancel_token_source.token);
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

        getPrivateNotices() {
            let vm = this;
            vm.$store
                .dispatch("post", { uri: "getPrivateNotices" })
                .then(function (response) {
                    vm.private_notices = response.data.data
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
                    vm.getPrivateAgencies();
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
                    vm.sorted_private_agencies = vm.private_agencies;
                    if (vm.$store.getters.user) {
                        vm.getPrivateFilters();
                    }
                    if (vm.from_name == "Alert" && vm.$store.getters.alert) {
                        vm.getAlert();
                    } else {
                        vm.$store.commit("setAlert", null);
                    }
                    if (vm.from_name == 'private_tender_details' && vm.$store.getters.filters) {
                        vm.meta = vm.$store.getters.filters
                        vm.tags = vm.meta.keywords;
                    } else if(localStorage.getItem('meta_private')){
                        vm.meta = JSON.parse(localStorage.getItem('meta_private'))
                    }
                })
                .catch(function (error) {
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },

        getPrivateFilters() {
            let vm = this;
            if (vm.$store.getters.user) {
                vm.$store
                    .dispatch("post", { uri: "getPrivateFilters", data: vm.$store.getters.user })
                    .then(function (response) {
                        vm.private_filters = response.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        },

        paginatePrivateTenders(cancel_token) {
            let vm = this;
            this.isLoading = true;
            vm.private_tenders = [];
            vm.applyFilters();
            window.scrollTo({ top: 0, behavior: "smooth" });
            vm.$store
                .dispatch("post", { uri: "paginatePrivateTenders", data: vm.meta, cancel_token })
                .then(function (response) {
                    vm.isLoading = false;
                    vm.auto_call = true;
                    vm.private_tenders = response.data.data;
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
            this.getPrivateTenders();
        },

        onPerPageChange() {
            this.meta.page = 1;
            this.paginatePrivateTenders();
        },
         deleteAlert() {
                let vm = this;
                if (vm.delete_alert) {
                    let private_filter_id = vm.delete_alert.private_filter_id;
                    vm.$store
                        .dispatch("post", {
                            uri: "deletePrivateFilter",
                            data: { private_filter_id: private_filter_id },
                        })
                        .then((response) => {
                            vm.$store.dispatch("success", response.data.message);
                           vm.getPrivateFilters()
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
                this.closeModal();
            },
          confirmDelete(private_filter) {
                console.log("private_filter file", private_filter);
                this.delete_alert = private_filter;
                this.erroralertmodal = true;
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
    /* margin: 0 2rem 4.5rem; */
     margin: 0 2rem 1.2rem;
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
    .ml-21 {
    margin-left: 21px;
}
.hgt-300{
    height: 300px;
}
.title-green {
    color: #16a34a !important;
}
</style>