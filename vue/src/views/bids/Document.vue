<template>
    <Region />
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
                            <vue3-tags-input
                                class="form-control form-control-sm p-0 tag-center scrollinput"
                                @on-tags-changed="handleChangeTag"
                                placeholder="Input keywords separated by comma"
                                :add-tag-on-keys="[13,188]"
                                v-model:tags="tags"
                                v-model="tag"
                                @allow-duplicates="false"
                                style="text-wrap: nowrap;"
                            />

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
                                            <input class="form-check-input" type="radio" name="region" value="Private" v-model="region" />
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
                                <StateFilter :clear_state_filters="clear_state_filters" @updateStateFilters="updateStateFilters" ref="state_filter" />
                            </div>
                            <div v-if="region == 'Federal'">
                                <FederalFilter :clear_federal_filters="clear_federal_filters" :naics_codes="naics_codes" :service_codes="service_codes" @updateFederalFilters="updateFederalFilters" ref="federal_filter" />
                            </div>
                            <div v-if="region == 'Private'">
                                <PrivateFilter :clear_private_filters="clear_private_filters" @updatePrivateFilters="updatePrivateFilters" ref="state_filter" />
                            </div>
                            <div v-if="region == 'International'">
                                <InternationalFilter :clear_international_filters="clear_international_filters" @updateInternationalFilters="updateInternationalFilters" ref="state_filter" />
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
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">
                                        {{'Showing '+state_filter.from+' - '+state_filter.to+' of '+state_filter.totalRows+' bids' }}
                                    </a>
                                </li>
                                <li class="list-inline-item" v-if="$store.getters.user">
                                    <a href="javascript:void(0)" @click.prevent="shareStateBids()" class="p-2 text-secondary"><i class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-3" v-for="state_tender in state_tenders" :key="state_tender.state_tender_id">
                                    <div class="card-body py-md-3 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div>
                                                    <a href="javascript:void(0)" @click="varifySubscription('state', state_tender)" >
                                                        <div v-html="highlight(state_tender.title)"></div>
                                                    </a>
                                                </div>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0" v-if="$store.getters.user">
                                                        <small class="form-check-label mb-0 me-2"><a href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox" :value="state_tender.state_tender_id" id="flexCheckChecked" v-model="share_state_tender.state_tenders" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ state_tender.state_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />
                                               <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;"> {{ state_tender.tender_no}}</span>
                                               <span v-else>{{ state_tender.tender_no }}</span>

                                            </li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ dateFormat(state_tender.opening_date) }} &nbsp;<span>{{ state_tender.time_ago }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" />
                                                {{ dateFormat(state_tender.expiry_date) }}
                                                <span class="col-green" v-if="state_tender.days_difference">
                                                    &nbsp; {{ state_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2" v-if="state_tender.state_attachments?.length">
                                            <li class="list-group-item d-flex text-success p-0" v-for="attachment, key in state_tender.state_attachments" :key="key">
                                                <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;"> {{ attachment.attachment_name }}</span>
                                                <span v-else><a :href="attachment.attachment_url" target="_blank">{{ attachment.attachment_name }}</a></span>
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
                                                    <li class="nav-item text-primary">
                                                        <i class="bi bi-patch-check-fill text-primary me-2"></i>
                                                        <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;">{{ state_tender.state_agency?.state_agency_name }}</span>
                                                        <span v-else style="color: rgb(86, 84, 109);">{{ state_tender.state_agency?.state_agency_name }}</span>
                                                    </li>

                                                    <li class="nav-item">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ state_tender?.state?.state_name }}<span v-if="state_tender?.state?.state_name">,</span> {{ state_tender?.country?.country_name }}
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <li class="list-inline-item" v-if="$store.getters.user">
                                                        <a href="javascript:void(0)" @click.prevent="shareStateBid(state_tender)" class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card shadow mb-3" v-if="state_tenders.length">
                                    <div class="card-body p-0 d-flex flex-column h-100 position-relative">
                                        <div class="table-responsive border border-radius-10">
                                            <table class="table small align-middle p-4 mb-0 table-hover table-shrink">
                                                <thead class="table-light">
                                                    <tr class="vertical-align-middle">
                                                        <th class="text-center border-0" v-if="$store.getters.user">
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
                                                    <tr v-for="state_tender in state_tenders" :key="state_tender.state_tender_id">
                                                        <td class="text-center" v-if="$store.getters.user">
                                                            <div class="form-check1">
                                                                <input class="form-check-input" type="checkbox" :value="state_tender.state_tender_id" v-model="share_state_tender.state_tenders" />
                                                            </div>
                                                        </td>
                                                        <td class="w-250">
                                                            <div class="row m-0">
                                                                <div class="column" style="margin-left: 21px;">
                                                                    <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px); color: rgb(57, 112, 228);">
                                                                        {{ state_tender.tender_no }}
                                                                    </span>
                                                                    <span v-else>
                                                                        <a style="color: rgb(57, 112, 228);" href="javascript:void(0)" @click="varifySubscription('state', state_tender)">
                                                                            {{ state_tender.tender_no }}
                                                                        </a>
                                                                    </span>
                                                                </div>

                                                                <div class="column d-flex align-items-center">
                                                                    <span class="color-box me-2" :style="{ backgroundColor: state_tender.state_notice_color }"> </span>

                                                                    <a :style="{ color: state_tender.state_notice?.backround_color }" class="txt-gray">
                                                                        {{ state_tender.state_notice?.notice_name }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <a style="color: rgb(57, 112, 228); font-weight: bold;" href="javascript:void(0)" @click="varifySubscription('state', state_tender)">
                                                                <div class="truncate-text" v-html="highlight(state_tender.title)"></div>
                                                            </a>

                                                            <span class="txt-gray" style="filter: blur(3px); color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                {{ state_tender.state_agency?.state_agency_name }}
                                                            </span>
                                                            <span class="txt-gray" v-else>{{ state_tender.state_agency?.agency_name }}</span>
                                                        </td>
                                                        <td class="txt-gray">{{ state_tender.state?.state_name }}</td>
                                                        <td class="txt-gray" style="width: 110px;">{{ state_tender.expiry_date_parsed }}</td>
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
                                <span class="input-with-icon">
                                    <input type="text" class="form-control" v-model="state_filter.page" @keypress.enter="getStateTenders()" style="width: 60px;" />
                                    <span style="margin-left: 10px;">of {{ state_filter.lastPage }} pages</span>
                                </span>
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
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">
                                        {{'Showing '+federal_filter.from+' - '+federal_filter.to+' of '+federal_filter.totalRows+' bids' }}
                                    </a>
                                </li>
                                <li class="list-inline-item" v-if="$store.getters.user">
                                    <a href="javascript:void(0)" @click.prevent="shareFederalBids()" class="p-2 text-secondary"><i class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-3" v-for="federal_tender in federal_tenders" :key="federal_tender.federal_tender_id">
                                    <div class="card-body py-md-3 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div>
                                                    <a href="javascript:void(0)" @click="varifySubscription('federal', federal_tender)">
                                                        <div v-html="highlight(federal_tender.title)"></div>
                                                    </a>
                                                </div>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0" v-if="$store.getters.user">
                                                        <small class="form-check-label mb-0 me-2"><a href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox" :value="federal_tender.federal_tender_id" id="flexCheckChecked" v-model="share_federal_tender.federal_tenders" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ federal_tender.federal_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />
                                                <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;"> {{ federal_tender.tender_no}}</span>
                                                <span v-else>{{ federal_tender.tender_no }}</span>
                                            </li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ dateFormat(federal_tender.opening_date) }} &nbsp;<span>{{ federal_tender.time_ago }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" />
                                                {{ dateFormat(federal_tender.expiry_date) }}
                                                <span class="col-green" v-if="federal_tender.days_difference">
                                                    &nbsp; {{ federal_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2" v-if="federal_tender.federal_attachments?.length">
                                            <li class="list-group-item d-flex text-success p-0" v-for="attachment, key in federal_tender.federal_attachments" :key="key">
                                                <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;">{{ attachment.attachment_name }}</span>
                                                <span v-else><a :href="attachment.attachment_url" target="_blank">{{ attachment.attachment_name }}</a></span>
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
                                                    <li class="nav-item text-primary">
                                                        <i class="bi bi-patch-check-fill text-primary me-2"></i>
                                                         <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;">{{ federal_tender.federal_agency?.agency_name }}</span>
                                                        <span v-else style="color: rgb(86, 84, 109);">{{ federal_tender.federal_agency?.agency_name }}</span>
                                                    </li>

                                                    <li class="nav-item">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ federal_tender?.state?.state_name }}<span v-if="federal_tender?.federal?.federal_name">,</span> {{
                                                        federal_tender?.country?.country_name }}
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <li class="list-inline-item" v-if="$store.getters.user">
                                                        <a href="javascript:void(0)" @click.prevent="shareFederalBid(federal_tender)" class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card shadow mb-3" v-if="federal_tenders.length">
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
                                                        <th scope="col" class="border-0 border-right w-250">Bid Number & Notice type</th>
                                                        <th scope="col" class="border-0 border-right">Title & Agency</th>
                                                        <th scope="col" class="border-0 border-right">State</th>
                                                        <th scope="col" class="border-0">Due date</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="border-top-0">
                                                    <tr v-for="federal_tender in federal_tenders" :key="federal_tender.federal_tender_id">
                                                        <td class="text-center" v-if="$store.getters.user">
                                                            <div class="form-check1">
                                                                <input class="form-check-input" type="checkbox" :value="federal_tender.federal_tender_id" v-model="share_federal_tender.federal_tenders" />
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <div class="row m-0">
                                                                <div class="column" style="margin-left: 21px;">
                                                                    <span style="filter: blur(3px); color: rgb(57, 112, 228);" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                        {{ federal_tender.tender_no }}
                                                                    </span>
                                                                    <span v-else>
                                                                        <a style="color: rgb(57, 112, 228);" href="javascript:void(0)" @click="varifySubscription('federal', federal_tender)">
                                                                            {{ federal_tender.tender_no }}
                                                                        </a>
                                                                    </span>
                                                                </div>

                                                                <div class="column d-flex align-items-center">
                                                                    <span class="color-box me-2" :style="{ backgroundColor: federal_tender?.federal_notice_color }"> </span>

                                                                    <a :style="{ color: federal_tender.federal_notice?.backround_color }" class="txt-gray">
                                                                        {{ federal_tender.federal_notice?.notice_name }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <a style="color: rgb(57, 112, 228); font-weight: bold;" href="javascript:void(0)" @click="varifySubscription('federal', federal_tender)">
                                                                <div class="truncate-text" v-html="highlight(federal_tender.title)"></div>
                                                            </a>
                                                            <span class="txt-gray" style="filter: blur(3px); color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                {{ federal_tender.federal_agency?.agency_name }}
                                                            </span>
                                                            <span class="txt-gray" v-else>{{ federal_tender.federal_agency?.agency_name }}</span>
                                                        </td>

                                                        <td class="txt-gray">{{ federal_tender.state?.state_name }}</td>
                                                        <td class="txt-gray" style="width: 110px;">{{ federal_tender.expiry_date_parsed}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="federal_tenders.length">
                            <div style="float: left;">
                                <span class="input-with-icon">
                                    <input type="text" class="form-control" v-model="federal_filter.page" @keypress.enter="getFederalTenders()" style="width: 60px;" />
                                    <span style="margin-left: 10px;">of {{ federal_filter.lastPage }} pages</span>
                                </span>
                            </div>
                            <div style="float: right;">
                                <Pagination :maxPage="federal_filter.maxPage" :totalPages="federal_filter.lastPage" :currentPage="federal_filter.page" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9" v-if="region == 'Private'">
                    <div class="vl-parent">
                        <Skeleton v-if="isLoading" />
                        <div class="scroll-div" ref="myscroll" v-if="!isLoading">
                            <div class="hstack flex-wrap gap-2">
                                <div class="alert border shadow fade show small px-1 py-0 mb-0 filtertagcss" v-for="(filter, index) in private_filters" :key="index">
                                    <span class="me-1" style="color: white;">{{ filter.name }}</span>
                                    <button type="button" class="btn btn-xs mb-0 text-white p-0" style="font-size: 13px !important;" @click="removePrivateFilter(filter)" aria-label="Close">
                                        <i class="fa fa-light fa-xmark text-white"></i>
                                    </button>
                                </div>

                                <div v-if="private_filters?.length">
                                    <button type="button" class="btn btn-xs text-primary textclose mb-0 p-1" @click.prevent="clearAllFilters()">Clear all</button>
                                </div>
                            </div>
                        </div>
                        <section v-if="!private_tenders.length && !isLoading">
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
                        <div class="text-end" v-if="private_tenders.length">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">
                                        {{'Showing '+private_filter.from+' - '+private_filter.to+' of '+private_filter.totalRows+' bids' }}
                                    </a>
                                </li>
                                <li class="list-inline-item" v-if="$store.getters.user">
                                    <a href="javascript:void(0)" @click.prevent="sharePrivateBids()" class="p-2 text-secondary"><i class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-3" v-for="private_tender in private_tenders" :key="private_tender.private_tender_id">
                                    <div class="card-body py-md-3 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div>
                                                    <a href="javascript:void(0)" @click="varifySubscription('private', private_tender)" >
                                                        <div v-html="highlight(private_tender.title)"></div>
                                                    </a>
                                                </div>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0" v-if="$store.getters.user">
                                                        <small class="form-check-label mb-0 me-2"><a href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input class="form-check-input" type="checkbox" :value="private_tender.private_tender_id" id="flexCheckChecked" v-model="share_private_tender.private_tenders" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ private_tender.private_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />
                                                 <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;"> {{ private_tender.tender_no}}</span>
                                                <span v-else>{{ private_tender.tender_no }}</span>
                                            </li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ dateFormat(private_tender.opening_date) }} &nbsp;<span>{{ private_tender.time_ago }} </span></li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" />
                                                {{ dateFormat(private_tender.expiry_date) }}
                                                <span class="col-green" v-if="private_tender.days_difference">
                                                    &nbsp; {{ private_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2" v-if="private_tender.private_attachments?.length">
                                            <li class="list-group-item d-flex text-success p-0" v-for="attachment, key in private_tender.private_attachments" :key="key">
                                                <span style="filter: blur(3px);color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">{{ attachment.attachment_name }}</span>
                                                <span v-else><a :href="attachment.attachment_url" target="_blank">{{ attachment.attachment_name }}</a></span>
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
                                                    <li class="nav-item text-primary">
                                                        <i class="bi bi-patch-check-fill text-primary me-2"></i>
                                                        <span style="filter: blur(3px);color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">{{ private_tender.private_agency?.private_agency_name }}</span>
                                                        <span v-else style="color: rgb(86, 84, 109);">{{ private_tender.private_agency?.private_agency_name }}</span>
                                                    </li>

                                                    <li class="nav-item">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ private_tender?.state?.state_name }}<span v-if="private_tender?.state?.state_name">,</span> {{
                                                        private_tender?.country?.country_name }}
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <li class="list-inline-item" v-if="$store.getters.user">
                                                        <a href="javascript:void(0)" @click.prevent="sharePrivateBid(private_tender)" class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card shadow mb-3">
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
                                                        <th scope="col" class="border-0 border-right w-250">Bid Number & Notice type</th>
                                                        <th scope="col" class="border-0 border-right">Title & Agency</th>
                                                        <th scope="col" class="border-0 border-right">State</th>
                                                        <th scope="col" class="border-0">Due date</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="border-top-0">
                                                    <tr v-for="private_tender in private_tenders" :key="private_tender.private_tender_id">
                                                        <td class="text-center" v-if="$store.getters.user">
                                                            <div class="form-check1">
                                                                <input class="form-check-input" type="checkbox" :value="private_tender.private_tender_id" v-model="share_private_tender.private_tenders" />
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <div class="row">
                                                                <div class="column" style="margin-left: 21px;">
                                                                    <span style="filter: blur(3px); color: rgb(57, 112, 228);" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                        {{ private_tender.tender_no }}
                                                                    </span>
                                                                    <span v-else>
                                                                        <a style="color: rgb(57, 112, 228);" href="javascript:void(0)" @click="varifySubscription('private', private_tender)">
                                                                            {{ private_tender.tender_no }}
                                                                        </a>
                                                                    </span>
                                                                </div>

                                                                <div class="column d-flex align-items-center">
                                                                    <span class="color-box me-2" :style="{ backgroundColor: private_tender.private_notice_color }"> </span>

                                                                    <a :style="{ color: private_tender.private_notice?.backround_color }" class="txt-gray">
                                                                        {{ private_tender.private_notice?.private_notice_name }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <a style="color: rgb(57, 112, 228); font-weight: bold;" href="javascript:void(0)" @click="varifySubscription('private', private_tender)">
                                                                <div class="truncate-text" v-html="highlight(private_tender.title)"></div>
                                                            </a>

                                                            <span class="txt-gray" style="filter: blur(3px); color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                {{ private_tender.private_agency?.private_agency_name }}
                                                            </span>
                                                            <span class="txt-gray" v-else>{{ private_tender.private_agency?.private_agency_name }}</span>
                                                        </td>
                                                        <td class="txt-gray">{{ private_tender.state?.state_name }}</td>
                                                        <td class="txt-gray" style="width: 110px;">{{ private_tender.expiry_date_parsed }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="private_tenders.length">
                            <div style="float: left;">
                                <span class="input-with-icon">
                                    <input type="text" class="form-control" v-model="private_filter.page" @keypress.enter="getPrivateTenders()" style="width: 60px;" />
                                    <span style="margin-left: 10px;">of {{ private_filter.lastPage }} pages</span>
                                </span>
                            </div>
                            <div style="float: right;">
                                <Pagination :maxPage="private_filter.maxPage" :totalPages="private_filter.lastPage" :currentPage="private_filter.page" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9" v-if="region == 'International'">
                    <div class="vl-parent">
                        <Skeleton v-if="isLoading" />
                        <div class="scroll-div" ref="myscroll" v-if="!isLoading">
                            <div class="hstack flex-wrap gap-2">
                                <div class="alert border shadow fade show small px-1 py-0 mb-0 filtertagcss" v-for="(filter, index) in international_filters" :key="index">
                                    <span class="me-1" style="color: white;">{{ filter.name }}</span>
                                    <button type="button" class="btn btn-xs mb-0 text-white p-0" style="font-size: 13px !important;" @click="removePrivateFilter(filter)" aria-label="Close">
                                        <i class="fa fa-light fa-xmark text-white"></i>
                                    </button>
                                </div>

                                <div v-if="international_filters?.length">
                                    <button type="button" class="btn btn-xs text-primary textclose mb-0 p-1" @click.prevent="clearAllFilters()">Clear all</button>
                                </div>
                            </div>
                        </div>
                        <section v-if="!international_tenders.length && !isLoading">
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
                        <div class="text-end" v-if="international_tenders.length">
                            <ul class="list-inline mb-0 z-index-2 small">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" style="text-decoration: none; pointer-events: none; cursor: default;" class="p-2 text-dark">
                                        {{'Showing '+international_filter.from+' - '+international_filter.to+' of '+international_filter.totalRows+' bids' }}
                                    </a>
                                </li>
                                <li class="list-inline-item" v-if="$store.getters.user">
                                    <a href="javascript:void(0)" @click.prevent="shareInternationalBids()" class="p-2 text-secondary"><i class="fa-solid fa-fw text-primary fa-share-alt"></i>SHARE</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div v-if="listview">
                                <div class="card shadow mb-3" v-for="international_tender in international_tenders" :key="international_tender.international_tender_id">
                                    <div class="card-body py-md-3 d-flex flex-column h-100 position-relative" id="hovershadow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="card-title mb-1">
                                                <div>
                                                    <a href="javascript:void(0)" @click="varifySubscription('international',international_tender)">
                                                        <div v-html="highlight(international_tender.title)"></div>
                                                    </a>
                                                </div>
                                            </strong>
                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <div class="form-check-inline mb-0" v-if="$store.getters.user">
                                                        <small class="form-check-label mb-0 me-2"><a href="javascript:void(0)" class="">SELECT</a></small>
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            :value="international_tender.international_tender_id"
                                                            id="flexCheckChecked"
                                                            v-model="share_international_tender.international_tenders"
                                                        />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <ul class="nav nav-divider mt-3" style="color: #646c9a;">
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ international_tender.international_notice?.notice_name }}</li>
                                            <li class="nav-item"><img class="small w-15px me-1" src="../../assets/icons/bidnumber.svg" />
                                                <span v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')" style="filter: blur(3px);color: #696969;"> {{ international_tender.tender_no }}</span>
                                                <span v-else>{{ international_tender.tender_no }}</span>
                                            </li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/posteddate.svg" />{{ dateFormat(international_tender.opening_date) }} &nbsp;<span>{{ international_tender.time_ago }} </span>
                                            </li>
                                            <li class="nav-item">
                                                <img class="small w-15px me-1" src="../../assets/icons/duedate.svg" />
                                                {{ dateFormat(international_tender.expiry_date) }}
                                                <span class="col-green" v-if="international_tender.days_difference">
                                                    &nbsp; {{ international_tender.days_difference }} Days to Go
                                                </span>
                                                <span class="col-red" v-else>&nbsp; Expired </span>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-borderless small mb-0 mt-2" v-if="international_tender.international_attachments?.length">
                                            <li class="list-group-item d-flex text-success p-0" v-for="attachment, key in international_tender.international_attachments" :key="key">
                                                <span style="filter: blur(3px);color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">{{ attachment.attachment_name }}</span>
                                                <span v-else><a :href="attachment.attachment_url" target="_blank">{{ attachment.attachment_name }}</a></span>
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
                                                    <li class="nav-item text-primary">
                                                        <i class="bi bi-patch-check-fill text-primary me-2"></i>
                                                        <span style="filter: blur(3px);color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">{{ international_tender.international_agency?.international_agency_name }}</span>
                                                        <span v-else style="color: rgb(86, 84, 109);">{{ international_tender.international_agency?.international_agency_name }}</span>
                                                    </li>

                                                    <li class="nav-item">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>{{ international_tender?.state?.state_name }}
                                                        <span v-if="international_tender?.state?.state_name">,</span> {{ international_tender?.country?.country_name }}
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mt-3">
                                                <ul class="list-inline mb-0 z-index-2 small">
                                                    <li class="list-inline-item" v-if="$store.getters.user">
                                                        <a href="javascript:void(0)" @click.prevent="shareInternationalBid(international_tender)" class="p-2"><i class="fa-solid fa-fw fa-share-alt"></i>SHARE </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card shadow" v-if="international_tenders.length !== 0">
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
                                                                    <span style="filter: blur(3px); color: rgb(57, 112, 228);" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                        {{ international_tender.tender_no }}
                                                                    </span>
                                                                    <span v-else>
                                                                        <a style="color: rgb(57, 112, 228);" href="javascript:void(0)" @click="varifySubscription('international',international_tender)">
                                                                            {{ international_tender.tender_no }}
                                                                        </a>
                                                                    </span>
                                                                </div>

                                                                <div class="column d-flex align-items-center">
                                                                    <span class="color-box me-2" :style="{ backgroundColor: international_tender.international_notice_color }"> </span>

                                                                    <a :style="{ color: international_tender.international_notice?.backround_color }" class="txt-gray">
                                                                        {{ international_tender.international_notice?.international_notice_name }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <a style="color: rgb(57, 112, 228); font-weight: bold;" href="javascript:void(0)" @click="varifySubscription('international',international_tender)">
                                                                <div class="truncate-text" v-html="highlight(international_tender.title)"></div>
                                                            </a>

                                                            <span class="txt-gray" style="filter: blur(3px); color: #696969;" v-if="(this.$store.getters.user && this.$store.getters.user.subscription !== 'valid')">
                                                                {{ international_tender.international_agency?.international_agency_name }}
                                                            </span>
                                                            <span class="txt-gray" v-else>{{ international_tender.international_agency?.international_agency_name }}</span>
                                                        </td>
                                                        <td class="txt-gray">{{ international_tender.state?.state_name }}</td>
                                                        <td class="txt-gray" style="width: 110px;">{{international_tender.expiry_date_parsed}}</td>
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
                                    <input type="text" class="form-control" v-model="international_filter.page" @keypress.enter="getInternationalTenders()" style="width: 60px;" />
                                    <span style="margin-left: 10px;">of {{ international_filter.lastPage }} pages</span>
                                </span>
                            </div>
                            <div style="float: right;">
                                <Pagination :maxPage="international_filter.maxPage" :totalPages="international_filter.lastPage" :currentPage="international_filter.page" @pagechanged="onPageChange" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                        <h5 class="modal-title" style="color: #16a34a !important; font-weight: 500 !important;">Alert</h5>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"> <button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                            </div>

                            <div class="card-body text-center" style="min-width: 350px;">
                                <strong class="text-danger">Please SUBSCRIBE !</strong>
                                <br />
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
    <teleport to="#modals" v-if="share_state_bid">
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
                                            <i class="fa fa-envelope fs-24 fa-fw text-success"></i>
                                            <div class="ms-2">
                                                <h5 class="modal-title" style="color: #16a34a!important;font-weight: 500!important;">Share Bid Details</h5>
                                            </div>
                                        </div>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                                    </div>

                                    <form class="card-body" style="min-width: 350px;">
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                :class="{ 'is-invalid': errors.recipient_email }"
                                                placeholder="Email"
                                                autocomplet="off"
                                                type="text"
                                                id="recipient-name"
                                                v-model="share_state_tender.recipient_email"
                                                ref="mails"
                                            />
                                            <span v-if="errors.recipient_email" class="invalid-feedback">{{ errors.recipient_email[0] }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="email_subject"
                                                :class="{ 'is-invalid': errors.subject }"
                                                placeholder="Subject"
                                                autocomplet="off"
                                                id="email_subject"
                                                v-model="share_state_tender.subject"
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
                                                placeholder="Messsage"
                                                autocomplet="off"
                                                id="email_message"
                                                v-model="share_state_tender.message"
                                            ></textarea>
                                            <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0] }}</span>
                                        </div>

                                        <div class="text-end">
                                            <!-- <a href="javascript:void(0)" @click="sendStateTenderMail()" class="mybutton-secondary2">Send</a> -->
                                            <button type="button" class="mb-0 btn btn-sm btn-success fw-400" @click="sendStateTenderMail()">Send</button>
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
    <teleport to="#modals" v-if="share_federal_bid">
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
                                            <i class="fa fa-envelope fs-24 fa-fw text-success"></i>
                                            <div class="ms-2">
                                                <h6 class="mb-0">Share Bid Details</h6>
                                            </div>
                                        </div>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                                    </div>

                                    <form class="card-body" style="min-width: 350px;">
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                :class="{ 'is-invalid': errors.recipient_email }"
                                                placeholder="Email"
                                                autocomplet="off"
                                                type="text"
                                                id="recipient-name"
                                                v-model="share_federal_tender.recipient_email"
                                                ref="mails"
                                            />
                                            <span v-if="errors.recipient_email" class="invalid-feedback">{{ errors.recipient_email[0] }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="email_subject"
                                                :class="{ 'is-invalid': errors.subject }"
                                                placeholder="Subject"
                                                autocomplet="off"
                                                id="email_subject"
                                                v-model="share_federal_tender.subject"
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
                                                placeholder="Messsage"
                                                autocomplet="off"
                                                id="email_message"
                                                v-model="share_federal_tender.message"
                                            ></textarea>
                                            <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0] }}</span>
                                        </div>

                                        <div class="text-end">
                                            <a href="javascript:void(0)" @click="sendFederalTenderMail()" class="mybutton-secondary2">Send</a>
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
    <teleport to="#modals" v-if="share_private_bid">
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
                                            <i class="fa fa-envelope fs-24 fa-fw text-success"></i>
                                            <div class="ms-2">
                                                <h6 class="mb-0">Share Bid Details</h6>
                                            </div>
                                        </div>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                                    </div>

                                    <form class="card-body" style="min-width: 350px;">
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                :class="{ 'is-invalid': errors.recipient_email }"
                                                placeholder="Email"
                                                autocomplet="off"
                                                type="text"
                                                id="recipient-name"
                                                v-model="share_private_tender.recipient_email"
                                                ref="mails"
                                            />
                                            <span v-if="errors.recipient_email" class="invalid-feedback">{{ errors.recipient_email[0] }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="email_subject"
                                                :class="{ 'is-invalid': errors.subject }"
                                                placeholder="Subject"
                                                autocomplet="off"
                                                id="email_subject"
                                                v-model="share_private_tender.subject"
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
                                                placeholder="Messsage"
                                                autocomplet="off"
                                                id="email_message"
                                                v-model="share_private_tender.message"
                                            ></textarea>
                                            <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0] }}</span>
                                        </div>

                                        <div class="text-end">
                                            <a href="javascript:void(0)" @click="sendPrivateTenderMail()" class="mybutton-secondary2">Send</a>
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
    <teleport to="#modals" v-if="share_international_bid">
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
                                            <i class="fa fa-envelope fs-24 fa-fw text-success"></i>
                                            <div class="ms-2">
                                                <h6 class="mb-0">Share Bid Details</h6>
                                            </div>
                                        </div>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                                    </div>

                                    <form class="card-body" style="min-width: 350px;">
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                :class="{ 'is-invalid': errors.recipient_email }"
                                                placeholder="Email"
                                                autocomplet="off"
                                                type="text"
                                                id="recipient-name"
                                                v-model="share_international_tender.recipient_email"
                                                ref="mails"
                                            />
                                            <span v-if="errors.recipient_email" class="invalid-feedback">{{ errors.recipient_email[0] }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="email_subject"
                                                :class="{ 'is-invalid': errors.subject }"
                                                placeholder="Subject"
                                                autocomplet="off"
                                                id="email_subject"
                                                v-model="share_international_tender.subject"
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
                                                placeholder="Messsage"
                                                autocomplet="off"
                                                id="email_message"
                                                v-model="share_international_tender.message"
                                            ></textarea>
                                            <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0] }}</span>
                                        </div>

                                        <div class="text-end">
                                            <a href="javascript:void(0)" @click="sendInternationalTenderMail()" class="mybutton-secondary2">Send</a>
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
    import StateFilter from "@/components/documents/State";
    import FederalFilter from "@/components/documents/Federal";
    import PrivateFilter from "@/components/documents/Private";
    import InternationalFilter from "@/components/documents/International";
    export default {
        setup() {
            const isOpen = ref(false);
            const savebidopen = ref(false);
            return { isOpen, savebidopen };
        },
        components: { Loading, DatePicker, Pagination, Vue3TagsInput, TreeItem, PscTree, LoginModal, SaveModal, SaveSearch, SetAlertModal, Skeleton, Region, StateFilter, FederalFilter, PrivateFilter, InternationalFilter },

        data() {
            return {
                is_updating_meta: true,
                pageChangeInProgress: true,
                isLoading: false,
                state_notices: [],
                categories: [],
                sorted_categories: [],
                states: [],
                sorted_states: [],
                state_agencies: [],
                sorted_state_agencies: [],
                federal_notices: [],
                federal_agencies: [],
                sorted_federal_agencies: [],
                naics: [],
                pscs: [],
                listview: true,
                gridview: false,
                region: "State",
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
                federal_filter: {
                    keywords: [],
                    federal_notices: [],
                    response_date: false,
                    response_from_date: false,
                    response_to_date: false,
                    posted_date: false,
                    posted_from_date: false,
                    posted_to_date: false,
                    states: [],
                    federal_agencies: [],
                    naics: [],
                    pscs: [],
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
                state_filter: {
                    keywords: [],
                    state_notices: [],
                    response_date: false,
                    response_from_date: false,
                    response_to_date: false,
                    posted_date: false,
                    posted_from_date: false,
                    posted_to_date: false,
                    states: [],
                    categories: [],
                    state_agencies: [],
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
                private_filter: {
                    keywords: [],
                    private_notices: [],
                    response_date: false,
                    response_from_date: false,
                    response_to_date: false,
                    posted_date: false,
                    posted_from_date: false,
                    posted_to_date: false,
                    states: [],
                    categories: [],
                    private_agencies: [],
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
                international_filter: {
                    keywords: [],
                    international_notices: [],
                    response_date: false,
                    response_from_date: false,
                    response_to_date: false,
                    posted_date: false,
                    posted_from_date: false,
                    posted_to_date: false,
                    states: [],
                    categories: [],
                    international_agencies: [],
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
                federal_tenders: [],
                federal_filters: [],
                clear_federal_filters: false,

                state_tenders: [],
                private_tenders: [],
                international_tenders: [],
                state_filters: [],
                clear_state_filters: false,
                private_filters: [],
                clear_private_filters: false,
                international_filters: [],
                clear_international_filters: false,
                login_modal: false,
                userModal: false,
                tag: null,
                tags: [],
                modal: {
                    login: null,
                    subscribe: null,
                    share_tender: null,
                },
                share_bid: {
                    recipient_email: null,
                    subject: "",
                    message: "",
                },
                share_tender: null,
                errors: [],
                share_state_tender: {
                    user_id: null,
                    recipient_email: null,
                    subject: "",
                    message: "",
                    state_tenders: [],
                },
                share_state_bid: false,
                share_federal_tender: {
                    user_id: null,
                    recipient_email: null,
                    subject: "",
                    message: "",
                    federal_tenders: [],
                },
                share_federal_bid: false,
                share_private_tender: {
                    user_id: null,
                    recipient_email: null,
                    subject: "",
                    message: "",
                    private_tenders: [],
                },
                share_private_bid: false,
                share_international_tender: {
                    user_id: null,
                    recipient_email: null,
                    subject: "",
                    message: "",
                    international_tenders: [],
                },
                share_international_bid: false,
            };
        },

        watch: {
            region: function () {
                this.state_filter.keywords = [];
                this.state_filter.state_notices = [];
                this.state_filter.response_date = false;
                this.state_filter.response_from_date = false;
                this.state_filter.response_to_date = false;
                this.state_filter.posted_date = false;
                this.state_filter.posted_from_date = false;
                this.state_filter.posted_to_date = false;
                this.state_filter.categories = [];
                this.state_filter.states = [];
                this.state_filter.state_agencies = [];
                this.state_filter.search = null;
                this.state_filter.order_by = "asc";
                this.state_filter.field = null;
                this.state_filter.per_page = 15;
                this.state_filter.totalRows = 0;
                this.state_filter.page = 1;
                this.state_filter.lastPage = 1;
                this.state_filter.from = 1;
                this.state_filter.maxPage = 1;
                this.state_filter.to = null;

                (this.federal_filter.keywords = []),
                    (this.federal_filter.federal_notices = []),
                    (this.federal_filter.response_date = false),
                    (this.federal_filter.response_from_date = false),
                    (this.federal_filter.response_to_date = false),
                    (this.federal_filter.posted_date = false),
                    (this.federal_filter.posted_from_date = false),
                    (this.federal_filter.posted_to_date = false),
                    (this.federal_filter.states = []);
                this.federal_filter.federal_agencies = [];
                this.federal_filter.naics = [];
                this.federal_filter.pscs = [];
                this.federal_filter.search = null;
                this.federal_filter.order_by = "asc";
                this.federal_filter.field = null;
                this.federal_filter.per_page = 15;
                this.federal_filter.totalRows = 0;
                this.federal_filter.page = 1;
                this.federal_filter.lastPage = 1;
                this.federal_filter.from = 1;
                this.federal_filter.maxPage = 1;
                this.federal_filter.to = null;

                this.tags = [];

                if (this.region == "State") {
                    this.paginateStateTenders();
                } else if (this.region == "Federal") {
                    this.getNaics();
                    this.getPscs();
                    this.paginateFederalTenders();
                } else if (this.region == "Private") {
                    this.paginatePrivateTenders();
                } else if (this.region == "International") {
                    this.paginateInternationalTenders();
                }
            },
        },

        beforeRouteEnter(to, from, next) {
            next((vm) => {});
        },

        mounted() {
            this.$store.commit("setFederalTender", null);
            this.$store.commit("setStateTender", null);
            if (this.region == "Federal") {
                this.getNaics();
                this.getPscs();
                this.paginateFederalTenders();
            }
            if (this.region == "State") {
                this.paginateStateTenders();
            }
            let header_menu = this.$store.getters.header_menu;
            header_menu.show_bidsearch = false;
            this.$store.dispatch("setHeaderMenu", header_menu);
        },

        computed: {
            countFilters() {
                let modules = [];
                this.federal_filters.map(function (element) {
                    if (!modules.includes(element.module)) {
                        modules.push(element.module);
                    }
                });
                return modules.length;
            },
        },

        methods: {

            sendStateTenderMail() {
                let vm = this;
                vm.fullPage = true;
                vm.isLoading = true;
                vm.share_state_tender.user_id = this.$store.getters.user.user_id;
                let uri = {
                    uri: "sendStateTenderMail",
                    data: vm.share_state_tender,
                };
                vm.sendMail(uri);
            },

            sendFederalTenderMail() {
                let vm = this;
                vm.fullPage = true;
                vm.isLoading = true;
                vm.share_federal_tender.user_id = this.$store.getters.user.user_id;
                let uri = {
                    uri: "sendFederalTenderMail",
                    data: vm.share_federal_tender,
                };
                vm.sendMail(uri);
            },

            sendPrivateTenderMail() {
                let vm = this;
                vm.fullPage = true;
                vm.isLoading = true;
                vm.share_private_tender.user_id = this.$store.getters.user.user_id;
                let uri = {
                    uri: "sendPrivateTenderMail",
                    data: vm.share_private_tender,
                };
                vm.sendMail(uri);
            },

            sendInternationalTenderMail() {
                let vm = this;
                vm.fullPage = true;
                vm.isLoading = true;
                vm.share_international_tender.user_id = this.$store.getters.user.user_id;
                let uri = {
                    uri: "sendInternationalTenderMail",
                    data: vm.share_international_tender,
                };
                vm.sendMail(uri);
            },

            sendMail(uri) {
                let vm = this;
                vm.$store
                    .dispatch("post", uri)
                    .then(function () {
                        vm.fullPage = false;
                        vm.isLoading = false;
                        vm.closeModal();
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

            showModal() {
                this.userModal = true;
                if (this.$store.getters.user == null) {
                    this.login_modal = true;
                }
            },
            shareBid() {
                this.closeModal();
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    this.share_tender = true;
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            shareStateBid(state_tender) {
                this.closeModal();
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    this.share_state_tender.state_tenders.push(state_tender.state_tender_id);
                    this.share_state_bid = true;
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },
            shareStateBids() {
                this.modal.login = false;
                this.modal.subscribe = false;
                this.share_state_bid = false;
                this.modal.share_tender = false;
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    if (this.share_state_tender.state_tenders.length) {
                        this.share_state_bid = true;
                    } else {
                        this.share_state_tender.state_tenders = [];
                        this.modal.share_tender = true;
                    }
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            shareFederalBid(federal_tender) {
                this.closeModal();
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    this.share_federal_tender.federal_tenders.push(federal_tender.federal_tender_id);
                    this.share_federal_bid = true;
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            shareFederalBids() {
                this.modal.login = false;
                this.modal.subscribe = false;
                this.share_state_bid = false;
                this.modal.share_tender = false;
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    if (this.share_federal_tender.federal_tenders.length) {
                        this.share_federal_bid = true;
                    } else {
                        this.share_federal_tender.federal_tenders = [];
                        this.modal.share_tender = true;
                    }
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            sharePrivateBid(private_tender) {
                this.closeModal();
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    this.share_private_tender.private_tenders.push(private_tender.private_tender_id);
                    this.share_private_bid = true;
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            sharePrivateBids() {
                this.modal.login = false;
                this.modal.subscribe = false;
                this.share_state_bid = false;
                this.modal.share_tender = false;
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    if (this.share_private_tender.private_tenders.length) {
                        this.share_private_bid = true;
                    } else {
                        this.share_private_tender.private_tenders = [];
                        this.modal.share_tender = true;
                    }
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            shareInternationalBid(international_tender) {
                this.closeModal();
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    this.share_international_tender.international_tenders.push(international_tender.international_tender_id);
                    this.share_international_bid = true;
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            shareInternationalBids() {
                this.modal.login = false;
                this.modal.subscribe = false;
                this.share_state_bid = false;
                this.modal.share_tender = false;
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    if (this.share_international_tender.international_tenders.length) {
                        this.share_international_bid = true;
                    } else {
                        this.share_international_tender.international_tenders = [];
                        this.modal.share_tender = true;
                    }
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            shareBids() {},

            closeModal() {
                this.modal.login = false;
                this.modal.subscribe = false;
                this.modal.share_tender = false;

                this.share_state_bid = false;
                this.share_state_tender.recipient_email = "";
                this.share_state_tender.subject = "";
                this.share_state_tender.message = "";
                this.share_state_tender.state_tenders = [];

                this.share_federal_bid = false;
                this.share_federal_tender.recipient_email = "";
                this.share_federal_tender.subject = "";
                this.share_federal_tender.message = "";
                this.share_federal_tender.federal_tenders = [];

                this.share_private_bid = false;
                this.share_private_tender.recipient_email = "";
                this.share_private_tender.subject = "";
                this.share_private_tender.message = "";
                this.share_private_tender.private_tenders = [];

                this.share_international_bid = false;
                this.share_international_tender.recipient_email = "";
                this.share_international_tender.subject = "";
                this.share_international_tender.message = "";
                this.share_international_tender.international_tenders = [];

                this.errors = [];
            },

            varifySubscription(region, tender) {
                this.closeModal();
                if (this.$store.getters.user && this.$store.getters.user.subscription == "valid") {
                    if (region == "federal") {
                        this.federalTenderDetails(tender);
                    } else if (region == "state") {
                        this.stateTenderDetails(tender);
                    } else if (region == "private") {
                        this.privateTenderDetails(tender);
                    } else if (region == "international") {
                        this.internationalTenderDetails(tender);
                    }
                } else {
                    if (this.$store.getters.user) {
                        this.modal.subscribe = true;
                    } else {
                        this.modal.login = true;
                    }
                }
            },

            federalTenderDetails(federal_tender) {
                this.$store.commit("setFederalTender", federal_tender);
                this.$store.commit("setFilters", this.federal_filter);
                this.$router.push("federal-opportunities/" + federal_tender.title.replace(/ /g, "-") + "-" + federal_tender.tender_no);
            },

            stateTenderDetails(state_tender) {
                this.$store.commit("setStateTender", state_tender);
                this.$store.commit("setFilters", this.state_filter);
                this.$router.push("state-opportunities/" + state_tender.title.replace(/ /g, "-") + "-" + state_tender.tender_no);
            },

            privateTenderDetails(private_tender) {
                this.$store.commit("setPrivateTender", private_tender);
                this.$store.commit("setFilters", this.private_filter);
                this.$router.push("private-commercial/" + private_tender.title.replace(/ /g, "-") + "-" + private_tender.tender_no);
            },

            internationalTenderDetails(international_tender) {
                this.$store.commit("setPrivateTender", international_tender);
                this.$store.commit("setFilters", this.international_filter);
                this.$router.push("international-opportunities/" + international_tender.title.replace(/ /g, "-") + "-" + international_tender.tender_no);
            },

            listviewgrid() {
                this.listview = false;
                this.gridview = true;
                if (this.region == "State") {
                    this.state_filter.per_page = 30;
                    this.getStateTenders();
                } else if (this.region == "Federal") {
                    this.federal_filter.per_page = 30;
                    this.getFederalTenders();
                } else if (this.region == "Private") {
                    this.private_filter.per_page = 30;
                    this.getPrivateTenders();
                } else if (this.region == "International") {
                    this.international_filter.per_page = 30;
                    this.getInternationalTenders();
                }
            },
            gridviewgrid() {
                this.listview = true;
                this.gridview = false;
                if (this.region == "State") {
                    this.state_filter.per_page = 15;
                    this.getStateTenders();
                } else if (this.region == "Federal") {
                    this.federal_filter.per_page = 15;
                    this.getFederalTenders();
                } else if (this.region == "Private") {
                    this.private_filter.per_page = 15;
                    this.getPrivateTenders();
                } else if (this.region == "International") {
                    this.international_filter.per_page = 15;
                    this.getInternationalTenders();
                }
            },

            removeStateFilter(filter) {
                this.$refs.state_filter.removeFilter(filter);
            },

            removeFederalFilter(filter) {
                this.$refs.federal_filter.removeFilter(filter);
            },

            removePrivateFilter(filter) {
                this.$refs.private_filter.removeFilter(filter);
            },

            removeInternationalFilter(filter) {
                this.$refs.international_filter.removeFilter(filter);
            },

            handleChangeTag(tags) {
                let vm = this;
                vm.tags = tags
                if (this.region == "State") {
                    vm.state_filter.keywords = vm.tags;
                    this.getStateTenders();
                } else if (this.region == "Federal") {
                    vm.federal_filter.keywords = vm.tags;
                    this.getFederalTenders();
                } else if (this.region == "Private") {
                    vm.private_filter.keywords = vm.tags;
                    this.getPrivateTenders();
                } else if (this.region == "International") {
                    vm.international_filter.keywords = vm.tags;
                    this.getInternationalTenders();
                }
            },

            dateFormat(value) {
                return moment(value).format("ll");
            },

            paginateFederalTenders(cancel_token) {
                if (this.region == "Federal") {
                    let vm = this;
                    this.isLoading = true;
                    vm.federal_tenders = [];
                    window.scrollTo({ top: 0, behavior: "smooth" });
                    vm.$store
                        .dispatch("post", { uri: "paginateFederalTenders", data: vm.federal_filter, cancel_token })
                        .then(function (response) {
                            vm.isLoading = false;
                            vm.auto_call = true;
                            vm.federal_tenders = response.data.data;
                            vm.federal_filter.totalRows = response.data.meta.total;
                            vm.federal_filter.lastPage = response.data.meta.last_page;
                            vm.federal_filter.from = response.data.meta.from;
                            vm.federal_filter.maxPage = vm.federal_filter.lastPage >= 3 ? 3 : vm.federal_filter.lastPage;
                            vm.federal_filter.to = response.data.meta.to;
                            vm.federal_filter.page = response.data.meta.current_page;
                        })
                        .catch(function (error) {
                            if (axios.isCancel(error)) {
                                console.log("Previous request was canceled:", error.message);
                            } else {
                                vm.errors = error.response.data.errors;
                                vm.$store.dispatch("error", error.response.data.message);
                            }
                        });
                }
            },

            paginateStateTenders(cancel_token) {
                if (this.region == "State") {
                    let vm = this;
                    this.isLoading = true;
                    vm.state_tenders = [];
                    window.scrollTo({ top: 0, behavior: "smooth" });
                    vm.$store
                        .dispatch("post", { uri: "paginateStateTenders", data: vm.state_filter, cancel_token })
                        .then(function (response) {
                            vm.isLoading = false;
                            vm.auto_call = true;
                            vm.state_tenders = response.data.data;
                            vm.state_filter.totalRows = response.data.meta.total;
                            vm.state_filter.lastPage = response.data.meta.last_page;
                            vm.state_filter.from = response.data.meta.from;
                            vm.state_filter.maxPage = vm.state_filter.lastPage >= 3 ? 3 : vm.state_filter.lastPage;
                            vm.state_filter.to = response.data.meta.to;
                            vm.state_filter.page = response.data.meta.current_page;
                        })
                        .catch(function (error) {
                            if (axios.isCancel(error)) {
                                console.log("Previous request was canceled:", error.message);
                            } else {
                                vm.errors = error.response.data.errors;
                                vm.$store.dispatch("error", error.response.data.message);
                            }
                        });
                }
            },

            paginatePrivateTenders(cancel_token) {
                if (this.region == "Private") {
                    let vm = this;
                    this.isLoading = true;
                    vm.private_tenders = [];
                    window.scrollTo({ top: 0, behavior: "smooth" });
                    vm.$store
                        .dispatch("post", { uri: "paginatePrivateTenders", data: vm.private_filter, cancel_token })
                        .then(function (response) {
                            vm.isLoading = false;
                            vm.auto_call = true;
                            vm.private_tenders = response.data.data;
                            vm.private_filter.totalRows = response.data.meta.total;
                            vm.private_filter.lastPage = response.data.meta.last_page;
                            vm.private_filter.from = response.data.meta.from;
                            vm.private_filter.maxPage = vm.private_filter.lastPage >= 3 ? 3 : vm.private_filter.lastPage;
                            vm.private_filter.to = response.data.meta.to;
                            vm.private_filter.page = response.data.meta.current_page;
                        })
                        .catch(function (error) {
                            if (axios.isCancel(error)) {
                                console.log("Previous request was canceled:", error.message);
                            } else {
                                vm.errors = error.response.data.errors;
                                vm.$store.dispatch("error", error.response.data.message);
                            }
                        });
                }
            },

            paginateInternationalTenders(cancel_token) {
                if (this.region == "International") {
                    let vm = this;
                    this.isLoading = true;
                    vm.international_tenders = [];
                    window.scrollTo({ top: 0, behavior: "smooth" });
                    vm.$store
                        .dispatch("post", { uri: "paginateInternationalTenders", data: vm.international_filter, cancel_token })
                        .then(function (response) {
                            vm.isLoading = false;
                            vm.auto_call = true;
                            vm.international_tenders = response.data.data;
                            vm.international_filter.totalRows = response.data.meta.total;
                            vm.international_filter.lastPage = response.data.meta.last_page;
                            vm.international_filter.from = response.data.meta.from;
                            vm.international_filter.maxPage = vm.international_filter.lastPage >= 3 ? 3 : vm.international_filter.lastPage;
                            vm.international_filter.to = response.data.meta.to;
                            vm.international_filter.page = response.data.meta.current_page;
                        })
                        .catch(function (error) {
                            if (axios.isCancel(error)) {
                                console.log("Previous request was canceled:", error.message);
                            } else {
                                vm.errors = error.response.data.errors;
                                vm.$store.dispatch("error", error.response.data.message);
                            }
                        });
                }
            },

            onPageChange(page) {
                if (this.region == "State") {
                    this.is_updating_meta = true;
                    this.pageChangeInProgress = true;
                    this.state_filter.page = page;
                    this.getStateTenders();
                } else if (this.region == "Federal") {
                    this.is_updating_meta = true;
                    this.pageChangeInProgress = true;
                    this.federal_filter.page = page;
                    this.getFederalTenders();
                } else if (this.region == "Private") {
                    this.is_updating_meta = true;
                    this.pageChangeInProgress = true;
                    this.private_filter.page = page;
                    this.getPrivateTenders();
                } else if (this.region == "International") {
                    this.is_updating_meta = true;
                    this.pageChangeInProgress = true;
                    this.international_filter.page = page;
                    this.getInternationalTenders();
                }
            },

            getFederalTenders() {
                if (this.cancel_token_source) {
                    this.cancel_token_source.cancel("Operation canceled due to new request.");
                }
                this.cancel_token_source = axios.CancelToken.source();
                console.log("cancel token source:", this.cancel_token_source);
                this.paginateFederalTenders(this.cancel_token_source.token);
            },

            getPrivateTenders() {
                if (this.cancel_token_source) {
                    this.cancel_token_source.cancel("Operation canceled due to new request.");
                }
                this.cancel_token_source = axios.CancelToken.source();
                console.log("cancel token source:", this.cancel_token_source);
                this.paginatePrivateTenders(this.cancel_token_source.token);
            },

            getInternationalTenders() {
                if (this.cancel_token_source) {
                    this.cancel_token_source.cancel("Operation canceled due to new request.");
                }
                this.cancel_token_source = axios.CancelToken.source();
                console.log("cancel token source:", this.cancel_token_source);
                this.paginateInternationalTenders(this.cancel_token_source.token);
            },

            getStateTenders() {
                if (this.cancel_token_source) {
                    this.cancel_token_source.cancel("Operation canceled due to new request.");
                }
                this.cancel_token_source = axios.CancelToken.source();
                console.log("cancel token source:", this.cancel_token_source);
                this.paginateStateTenders(this.cancel_token_source.token);
            },

            onPerPageChange() {
                if (this.region == "State") {
                    this.state_filter.page = 1;
                    this.paginateStateTenders();
                } else if (this.region == "Federal") {
                    this.federal_filter.page = 1;
                    this.paginateFederalTenders();
                } else if (this.region == "Private") {
                    this.private_filter.page = 1;
                    this.paginatePrivateTenders();
                } else if (this.region == "International") {
                    this.international_filter.page = 1;
                    this.paginateInternationalTenders();
                }
            },

            highlight(title) {
                let keywords_arr = [];
                if (typeof this.federal_filter.keywords === "string" && this.federal_filter.keywords.length) {
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

            clearAllFilters() {
                this.clear_federal_filters = true;
                this.clear_state_filters = true;
                this.clear_private_filters = true;
                this.clear_international_filters = true;
                this.$store.dispatch("setSelectedNaics", []);
                this.$store.dispatch("setSelectedPscs", []);
            },

            updateFederalFilters(meta) {
                this.clear_federal_filters = false;
                this.federal_filters = meta.filters;
                this.federal_filter.federal_notices = meta.federal_notices;
                this.federal_filter.response_date = meta.response_date;
                this.federal_filter.response_from_date = meta.response_from_date;
                this.federal_filter.response_to_date = meta.response_to_date;
                this.federal_filter.posted_date = meta.posted_date;
                this.federal_filter.posted_from_date = meta.posted_from_date;
                this.federal_filter.posted_to_date = meta.posted_to_date;
                this.federal_filter.states = meta.states;
                this.federal_filter.federal_agencies = meta.federal_agencies;
                this.federal_filter.naics = meta.naics;
                this.federal_filter.pscs = meta.pscs;
                this.getFederalTenders();
            },

            updateStateFilters(meta) {
                console.log("meta", meta);
                this.clear_state_filters = false;
                this.state_filters = meta.filters;
                this.state_filter.state_notices = meta.state_notices;
                this.state_filter.response_date = meta.response_date;
                this.state_filter.response_from_date = meta.response_from_date;
                this.state_filter.response_to_date = meta.response_to_date;
                this.state_filter.posted_date = meta.posted_date;
                this.state_filter.posted_from_date = meta.posted_from_date;
                this.state_filter.posted_to_date = meta.posted_to_date;
                this.state_filter.states = meta.states;
                this.state_filter.state_agencies = meta.state_agencies;
                this.state_filter.categories = meta.categories;
                this.getStateTenders();
            },

            updatePrivateFilters(meta) {
                console.log("meta", meta);
                this.clear_private_filters = false;
                this.private_filters = meta.filters;
                this.private_filter.private_notices = meta.private_notices;
                this.private_filter.response_date = meta.response_date;
                this.private_filter.response_from_date = meta.response_from_date;
                this.private_filter.response_to_date = meta.response_to_date;
                this.private_filter.posted_date = meta.posted_date;
                this.private_filter.posted_from_date = meta.posted_from_date;
                this.private_filter.posted_to_date = meta.posted_to_date;
                this.private_filter.states = meta.states;
                this.private_filter.private_agencies = meta.private_agencies;
                this.private_filter.categories = meta.categories;
                this.getPrivateTenders();
            },

            updateInternationalFilters(meta) {
                console.log("meta", meta);
                this.clear_international_filters = false;
                this.international_filters = meta.filters;
                this.international_filter.international_notices = meta.international_notices;
                this.international_filter.response_date = meta.response_date;
                this.international_filter.response_from_date = meta.response_from_date;
                this.international_filter.response_to_date = meta.response_to_date;
                this.international_filter.posted_date = meta.posted_date;
                this.international_filter.posted_from_date = meta.posted_from_date;
                this.international_filter.posted_to_date = meta.posted_to_date;
                this.international_filter.states = meta.states;
                this.international_filter.international_agencies = meta.international_agencies;
                this.international_filter.categories = meta.categories;
                this.getInternationalTenders();
            },

            getNaics() {
                let vm = this;
                let naics = vm.$store.getters.naics;
                if (naics) {
                    vm.naics_codes = naics;
                } else {
                    vm.$store
                        .dispatch("post", { uri: "getNaics" })
                        .then(function (response) {
                            vm.naics_codes.children = response.data.data;
                            vm.$store.dispatch("setNaics", vm.naics_codes);
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
            },

            getPscs() {
                let vm = this;
                let pscs = vm.$store.getters.pscs;
                console.log("pscs", pscs);
                if (pscs) {
                    vm.service_codes = pscs;
                } else {
                    vm.$store
                        .dispatch("post", { uri: "getPscs" })
                        .then(function (response) {
                            vm.service_codes.children = response.data.data;
                            vm.$store.dispatch("setPscs", vm.service_codes);
                        })
                        .catch(function (error) {
                            vm.errors = error.response.data.errors;
                            vm.$store.dispatch("error", error.response.data.message);
                        });
                }
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
