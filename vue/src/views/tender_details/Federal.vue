<template>
    <div>
        <loading v-model="isLoading" :can-cancel="false" :is-full-page="fullPage" />
        <section class="pt-4 pt-lg-4 result pb-4">
            <div class="container position-relative">
                <div class="row px-2">
                    <div class="col-12 d-flex justify-content-md-between align-items-center">
                        <ul class="list-inline text-end">
                            <li class="list-inline-item">
                                <a href="javascript:void(0)" @click.prevent="previousPage()" class="badge text-bg-secondary fs-6 rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
                            </li>
                        </ul>
                        <ul class="list-inline text-end">
                            <!-- <li class="list-inline-item">
                                <button class="mybutton-secondary mybutton-success" @click.prevent="interstedmodalpop()"><i class="fa-solid fa-user-plus m-1"></i>Add Interest</button>
                            </li> -->
                            <li class="list-inline-item">
                                <button class="btn btn-sm btn-success" @click.prevent="interstedmodalpop()"><i class="fa-solid fa-user-plus m-1"></i>Add Interest</button>
                            </li>
                            <li class="list-inline-item" v-if="federal_tender?.notice_id">
                                <button class="btn btn-sm btn-success" @click="openWebSite()"><i class="fa-solid fa-globe m-1"></i>Open Website</button>
                            </li>
                            <li class="list-inline-item" v-else>
                                <button class="btn btn-sm btn-success" @click="showAlert()"><i class="fa-solid fa-globe m-1"></i>Open Website</button>
                            </li>

                            <li class="list-inline-item" v-if="$store.getters.user">
                                <button class="btn btn-sm btn-primary" @click.prevent="sharefederal_tenders()"><i class="fa-solid fa-fw fa fa-share-alt"></i>Share</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-md-between">
                                <ul class="list-inline text-end">
                                    <li class="list-inline-item">
                                        <img class="icon me-2" src="/assets/icons/federalblue.svg" alt="icon" />
                                        <span style="font-size: 16px; color: black;">Federal Opportunities </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <div class="d-md-flex justify-content-md-between">
                                    <div>
                                        <h5 style="color: #5143d9; font-size: 18px; margin-bottom: 3px; font-weight: 700;" class="nav-item">{{ federal_tender.title }}</h5>
                                        <ul class="nav nav-divider text-body mb-0">
                                            <li class="nav-item"><span style="font-weight: 900 !important; color: black;">Solicitiation Number :</span>&nbsp;{{ federal_tender.tender_no }}</li>
                                            <li class="nav-item"><img class="mb-1" src="assets/icons/posteddate.svg" width="17" /> Last Updated on {{ format_date(federal_tender.posted_date) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-0 result">
            <div class="container">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs nav-bottom-line" id="tour-pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active mb-0" id="tour-pills-tab-1" data-bs-toggle="pill" data-bs-target="#tour-pills-tab1" type="button" role="tab" aria-controls="tour-pills-tab1" aria-selected="true">
                                            Notice Details
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link mb-0" id="tour-pills-tab-4" data-bs-toggle="pill" data-bs-target="#tour-pills-tab4" type="button" role="tab" aria-controls="tour-pills-tab4" aria-selected="false">
                                            Vendors & Teaming
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-2 result">
            <div class="container">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row g-4 g-md-5">
                            <div class="col-xl-8">
                                <div class="tab-content mb-0" id="tour-pills-tabContent">
                                    <div class="tab-pane fade show active" id="tour-pills-tab1" role="tabpanel" aria-labelledby="tour-pills-tab-1">
                                        <div class="card bg-transparent py-0 p-4">
                                            <div class="card-body p-0">
                                                <ul class="list-group list-group-borderless mb-3">
                                                    <li class="list-group-item">
                                                        <h6 class="mb-0 fw-normal">Department / Agency :</h6>
                                                        <span class="fw-light mb-0">{{ federal_tender.federal_agency?.agency_name }}</span>
                                                    </li>
                                                </ul>
                                                <p class="mb-4 text-align-justify" v-html="federal_tender.description"></p>

                                                <div class="d-sm-flex justify-content-sm-between align-items-center mb-3">
                                                    <div v-if="federal_tender.place_of_performance">
                                                        <h6 class="fw-normal mb-0">Place of Performance:</h6>
                                                        <p>{{ federal_tender.place_of_performance }}</p>
                                                    </div>
                                                    <div v-if="federal_tender.federal_office_address">
                                                        <h6 class="fw-normal mb-0">Contracting Office Address:</h6>
                                                        <p>
                                                            {{ federal_tender.federal_office_address.city }}<span v-if="federal_tender.federal_office_address.city">, </span>
                                                            <span>{{ federal_tender.federal_office_address.state + '' + federal_tender.federal_office_address.country }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body py-0 p-4">
                                                <div class="row g-3 align-items-center justify-content-between mb-3">
                                                    <div class="col-md-6" v-if="federal_tender?.federal_attachments?.length">
                                                        <strong class="text-primary">Downloads ({{ federal_tender?.federal_attachments?.length }})</strong>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <span v-if="download_all_attachments">
                                                            <!-- <a target="_blank"
                                                                :href="$store.state.baseUrl + 'downloadFederalAttachments/' + federal_tender.federal_tender_id"
                                                                class="mybutton-secondary1 mb-0">
                                                                <i class="bi bi-cloud-download"></i> Download All
                                                                Attachments/Links
                                                            </a> -->
                                                            <a target="_blank" :href="$store.state.baseUrl + 'downloadFederalAttachments/' + federal_tender.federal_tender_id" class="btn btn-sm btn-primary">
                                                                <i class="bi bi-cloud-download"></i> Download All Attachments/Links
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="table-responsive border-2 border-radius">
                                                    <table class="table align-middle p-4 mb-0 table-hover table-shrink">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col" class="border-0 rounded-start"></th>
                                                                <th scope="col" class="border-0">Name</th>
                                                                <th scope="col" class="border-0">Size</th>
                                                                <th scope="col" class="border-0">Date</th>

                                                                <th scope="col" class="border-0 rounded-end text-center">
                                                                    Action
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="border-top-0">
                                                            <tr v-if="!federal_tender?.federal_attachments?.length">
                                                                <td class="text-center" colspan="5">No attachments are available</td>
                                                            </tr>
                                                            <tr v-for="federal_attachment, att_key in federal_tender.federal_attachments" :key="att_key">
                                                                <td class="text-center">
                                                                    <i :class="federal_attachment.attachment_icon" class="fa-fw me-2 fs-5"></i>
                                                                </td>
                                                                <td id="demo-3" :title="federal_attachment.attachment_name">
                                                                    <span class="truncated-text">
                                                                        {{ federal_attachment.attachment_name }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ federal_attachment.attachment_size }}</td>
                                                                <td>{{ federal_attachment.attachment_date }}</td>
                                                                <td class="text-center" v-if="federal_attachment.download_url">
                                                                    <a :href="federal_attachment.download_url" target="_blank" class="btn btn-light btn-round mb-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download">
                                                                        <i class="bi bi-cloud-download"></i>
                                                                    </a>
                                                                </td>
                                                                <td class="text-center" v-else>
                                                                    <!-- <a
                                                                        :href="$store.state.baseUrl+'singleBidDownloadFromS3/'+ federal_tender.region.region_id +'/'+ attachment.name+'/'+federal_tender.tdr_id"
                                                                        target="_blank"
                                                                        class="btn btn-light btn-round mb-0"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        data-bs-title="Download"
                                                                    >
                                                                        <i class="bi bi-cloud-download"></i>
                                                                    </a> -->
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tour-pills-tab2" role="tabpanel" aria-labelledby="tour-pills-tab-2">
                                        <div class="card bg-transparent p-4">
                                            <div class="card-body p-0">
                                                <h6 class="">Synopis:</h6>
                                                <p class="mb-4" v-html="federal_tender.tdr_requirement"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tour-pills-tab3" role="tabpanel" aria-labelledby="tour-pills-tab-3">
                                        <div class="card bg-transparent p-4">
                                            <div class="card-body p-0">
                                                <h6 class="">Synopis:</h6>
                                                <p class="mb-4" v-html="federal_tender.tdr_prog_information"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tour-pills-tab4" role="tabpanel" aria-labelledby="tour-pills-tab-4">
                                        <div class="card bg-transparent p-4 pt-0">
                                            <div class="card-header p-3 d-flex justify-content-between align-items-center" style="border: 1px solid rgb(223, 223, 227); border-bottom: 0px;">
                                                <div class="rounded">
                                                    <ul class="list-inline hstack flex-wrap gap-2 justify-content-between mb-0">
                                                        <li class="list-inline-item h6 fw-normal mb-0">
                                                            <a href="javascript:void:(0)" @click.prevent="interstedmodalpop()"><img class="mb-1" src="assets/icons/advertising-icon.png" width="24" /> Advertise Your Interest</a>
                                                        </li>
                                                        <li v-if="federal_interests?.length" class="list-inline-item h6 fw-normal mb-0">
                                                            <a :href="download_federal_interests" class=""><img class="mb-1" src="assets/icons/excel-icon.png" width="24" />Download to Excel</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="border-bottom-rounded p-3 text-center" style="margin-bottom: 5px; border: 1px solid #dfdfe3;" v-if="!federal_interests.length">
                                                    No records found
                                                </div>
                                                <div class="p-3" style="margin-bottom: 5px; border: 1px solid #dfdfe3;" v-for="federal_interest in federal_interests" :key="federal_interest.user_federal_interest_id">
                                                    <div class="d-sm-flex justify-content-between">
                                                        <div class="d-sm-flex align-items-center mb-3">
                                                            <div>
                                                                <h6 class="m-0 mb-2">{{ federal_interest.user?.company_name }}</h6>
                                                                <span class="me-3">User Name : {{ federal_interest.user?.name }}</span><br />

                                                                <span class="me-3">Position : {{ federal_interest.interest_type }}</span><br />
                                                                <span class="me-3">Website : {{ federal_interest.user?.web_address }}</span><br />
                                                                <span class="me-3"><i class="fas fa-phone"></i> {{ federal_interest.user?.phone }}</span>
                                                                <span class="me-3"><i class="msg11 far fa-envelope"></i> {{ federal_interest.user?.email }}</span><br />
                                                            </div>
                                                        </div>
                                                        <ul class="list-inline mb-2 mb-sm-0"></ul>
                                                    </div>
                                                    <h6 class="fw-normal"><span class="text-body">Socioeconomic</span></h6>
                                                    <ul>
                                                        <!-- <li type="1" v-for="(value, key) in bidintersed.user_details?.socioeconomic_status_description?.split(
                                                            ','
                                                        )" :key="key">
                                                            {{ value }}
                                                        </li> -->
                                                        <li type="1" v-for="(user_set_aside, key) in federal_interest.user?.user_set_asides" :key="key">
                                                            {{ user_set_aside.set_aside?.set_aside_name }}
                                                        </li>
                                                    </ul>
                                                    <div class="d-flex align-items-center" v-if="federal_interest.user_id == $store.getters.user.user_id">
                                                        <a href="javascript:void(0)" @click.prevent="edit(federal_interest)" class="btn btn-xs btn-success-soft" style="margin: 5px;">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <span>
                                                            <a href="javascript:void(0)" @click.prevent="deleteAlertpopup(federal_interest)" class="btn btn-xs btn-danger-soft" style="margin: 5px;"><i class="bi bi-trash"></i></a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet mb-0">
                                                    <div class="kt-portlet__body" v-if="userinteresd.length == 0">
                                                        <Pagination :maxPage="meta.maxPage" :totalPages="meta.lastPage" :currentPage="meta.currentPage" @pagechanged="onPageChange" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <aside class="col-xl-4">
                                <div class="row g-3">
                                    <div class="col-md-6 col-xl-12">
                                        <div class="card border card-body bg-light p-4">
                                            <h6 class="text-success fw-500" style="font-size: 18px;">GENERAL INFORMATION</h6>
                                            <ul class="list-group list-group-borderless border-top-0 mb-0">
                                                <li class="list-group-item">
                                                    <div class="h6 fw-light mb-0" style="font-weight: 500 !important;">
                                                        Notice Type
                                                    </div>
                                                    <div class="mb-0" style="color: #747579; font-size: 16px;">{{ federal_tender.federal_notice?.notice_name }}</div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="h6 fw-light mb-0" style="font-weight: 500 !important;">
                                                        Posted Date
                                                    </div>
                                                    <div class="mb-0" style="color: #747579; font-size: 16px;">{{ format_date(federal_tender.posted_date) }}</div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="h6 fw-light mb-0" style="font-weight: 500 !important;">
                                                        Response Date
                                                    </div>
                                                    <div class="mb-0" style="color: #747579; font-size: 16px;">{{ format_date(federal_tender.expiry_date) }}</div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div>
                                                        <div class="h6 fw-light mb-0" style="font-weight: 500 !important;">
                                                            Set Aside
                                                        </div>
                                                        <div class="mb-0" style="color: #747579; font-size: 16px;">{{ federal_tender.set_aside?.set_aside_name }}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div>
                                                        <div class="h6 fw-light mb-0" style="font-weight: 500 !important;">
                                                            PSC Code
                                                        </div>
                                                        <div class="mb-0" style="color: #747579; font-size: 16px;">
                                                            {{ federal_tender.psc?.psc_code }}-{{ federal_tender.psc?.psc_description }}
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div>
                                                        <div class="h6 fw-light mb-0" style="font-weight: 500 !important;">
                                                            NAICS Code
                                                        </div>
                                                        <div class="mb-0" style="color: #747579; font-size: 16px;">
                                                            {{ federal_tender.naics?.naics_code }}-{{ federal_tender.naics?.naics_description }}
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div v-if="federal_tender.tender_type && federal_tender.tender_type != 25 && federal_tender.region?.region_id == 2">
                                                        <div class="h6 fw-light mb-0" style="font-weight: 500 !important;">
                                                            Contract Type
                                                        </div>
                                                        <div class="mb-0" style="color: #747579; font-size: 16px;">
                                                            {{ federal_tender.tenderType?.tdr_type_name }}
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-12" v-if="federal_tender.federal_contacts?.length">
                                        <div class="card card-body border bg-light p-4">
                                            <!-- <div class="hstack gap-2 mb-1"> -->
                                            <h6 class="text-success fw-500" style="font-size: 18px;">CONTACT INFORMATION</h6>
                                            <!-- </div> -->
                                            <div v-for="federal_contact, key in federal_tender.federal_contacts" :key="key">
                                                <strong class="mb-1" v-if="federal_contact.type == 0">Primary Contact:</strong>
                                                <strong class="mb-1" v-if="federal_contact.type == 1">Secondary Contact:</strong>
                                                <ul lass="list-group list-group-borderless" style="border-top: none; padding-left: 0;">
                                                    <li class="list-group-item py-1" v-if="federal_contact.fullName">
                                                        <span class="text-info fw-light me -1 mb-0">{{ federal_contact.full_name }}</span>
                                                    </li>
                                                    <li class="list-group-item py-1" v-if="federal_contact.phone">
                                                        <span href="#" class="mb-0">
                                                            <i class="fa-solid fa-fw fa-phone text-primary fs-6"></i>
                                                            {{ federal_contact.phone }}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item py-1" v-if="federal_contact.email">
                                                        <span href="#" class="mb-0">
                                                            <i class="fa-solid fa-fw fa-envelope text-primary fs-6"></i>
                                                            {{ federal_contact.email }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <teleport to="#modals" v-if="sharebid">
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
                            <!-- <div class="card border">
                                <div class="card-body vstack gap-4"> -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xxs">
                                            <img class="avatar-img" src="assets/images/emailicon1.png" alt="avatar" />
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 title-green fw-500">Share Bid Detail</h6>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                </div>
                                <form class="card-body" style="min-width: 500px;">
                                    <div class="mb-3">
                                        <input
                                            class="form-control"
                                            placeholder="Employee/Colleague Email Address"
                                            :class="{ 'is-invalid': errors.recipient_email }"
                                            autocomplet="off"
                                            type="text"
                                            id="recipient-name"
                                            v-model="share_tender.recipient_email"
                                            ref="recipient_email"
                                        />
                                        <span v-if="errors.recipient_email" class="invalid-feedback">{{ errors.recipient_email[0] }}</span>
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
                                            v-model="share_tender.subject"
                                            ref="subject"
                                        />
                                        <span v-if="errors.subject" class="invalid-feedback">{{ errors.subject[0] }}</span>
                                    </div>
                                    <div class="">
                                        <textarea
                                            class="form-control"
                                            rows="3"
                                            name="email_message"
                                            :class="{ 'is-invalid': errors.message }"
                                            placeholder="Brief Messsage/Note"
                                            autocomplet="off"
                                            id="email_message"
                                            v-model="share_tender.message"
                                        ></textarea>
                                        <span v-if="errors.message" class="invalid-feedback">{{ errors.message[0] }}</span>
                                    </div>
                                </form>
                                <div class="card-footer text-end pt-0">
                                    <a href="javascript:void(0)" @click="sendFederalTenderMail()" class="btn btn-sm btn-success mb-0 mt-2">Send</a>
                                </div>
                            </div>
                            <!-- </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </teleport>
        <teleport to="#modals" v-if="interstmodal">
            <div class="modal-overlay">
                <div class="modal-dialog" style="width: 350px;">
                    <div class="modal-content">
                        <div class="modal-header m-header"></div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 title-green fw-500">
                                                <span v-if="federal_interest.status">Add Interest</span>
                                                <span v-else>Update Interest</span>
                                            </h6>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closemodal()" class="btn-close"></button></a>
                                </div>
                                <form class="card-body">
                                    <div class="form-check form-check-md mb-2">
                                        <!-- <a href="javascript:vodi(0)" class="btn btn-success-soft btn-round flex-shrink-0 ms-2 mb-0"><i class="fab fa-codepen"></i> </a> -->
                                        <input class="form-check-input mt-0" type="radio" name="box" value="Priming" id="Priming" v-model="federal_interest.interest_type" />
                                        <label class="form-check-label" for="Priming">Priming</label>
                                    </div>
                                    <div class="form-check form-check-md mb-2">
                                        <!-- <a href="javascript:vodi(0)" class="btn btn-success-soft btn-round flex-shrink-0 ms-2 mb-0"><i class="fab fa-dribbble"></i></a> -->
                                        <input class="form-check-input" type="radio" name="box" value="Subbing" id="Subbing" v-model="federal_interest.interest_type" />
                                        <label class="form-check-label" for="Subbing">Subbing</label>
                                    </div>
                                    <div class="form-check form-check-md">
                                        <!-- <a href="javascript:vodi(0)" class="btn btn-success-soft btn-round flex-shrink-0 ms-2 mb-0"><i class="fab fa-behance"></i> </a> -->
                                        <input class="form-check-input" type="radio" name="box" value="Any" id="Any" v-model="federal_interest.interest_type" />
                                        <label class="form-check-label" for="Any">Any</label>
                                    </div>
                                    <span style="color: red;" v-if="errors.bid_interested_type">{{ errors.bid_interested_type[0] }}</span>
                                </form>
                                <div class="card-footer text-end pt-0">
                                    <button class="btn btn-sm btn-success mb-0" @click.prevent="submit()">
                                        <span v-if="federal_interest.status">Add </span>
                                        <span v-else>Update </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer m-foot"></div>
                    </div>
                </div>
            </div>
        </teleport>
        <teleport to="#modals" v-if="alertmodal">
            <div class="modal-overlay">
                <div id="popup1" class="confirm1" style="background-color: white !important;">
                    <div class="">
                        <h1>Alert</h1>
                        <p>Already Added!</p>
                        <button style="background-color: white !important;" @click.prevent="closemodal()">Close</button>
                    </div>
                </div>
            </div>
        </teleport>
        <teleport to="#modals" v-if="erroralertmodal">
            <div class="modal-overlay">
                <div class="confirm" style="background-color: white !important;">
                    <h1>Are you sure?</h1>
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                    <button style="background-color: white !important;" @click.prevent="closemodal()">Cancel</button>
                    <button style="color: red !important; background-color: white !important;" @click.prevent="deleteFederalInterest(deleteduser)">Confirm</button>
                </div>
            </div>
        </teleport>
    </div>
</template>
<script>
    import Pagination from "@/components/Pagination.vue";
    import moment from "moment";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/css/index.css";
    export default {
        name: "bidsDetailsPage",
        components: { Pagination, Loading },
        props: ["items"],
        data() {
            return {
                userintertsed: "",
                federal_tender: "",
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
                emptycheck: "",
                status: true,
                addinterestmodal: false,
                interstmodal: false,
                federal_tender: {},
                userinteresd: [],
                userinteresed_id: "",
                alertmodal: false,
                sharebid: false,
                mails: "",
                shareBid: {
                    bids: [],
                    mails: [],
                    email: this.$store.getters?.user?.email,
                    subject: "",
                    message: "",
                    bid_or_doc: "bid",
                    region_id: "",
                },
                bid_documents: {
                    tdr_documents: [],
                },
                federal_interest: {
                    user_federal_interest_id: "",
                    federal_tender_id: "",
                    interest_type: "",
                    status: true,
                },
                federal_interests: [],
                tdr: {
                    tdr_id: "",
                },
                errors: [],
                isLoading: false,
                fullPage: true,
                deleteduser: "",
                erroralertmodal: false,
                var: "",
                from_path: null,
                attachments: false,
                download_all_attachments: false,
                share_tender: {
                    user_id: null,
                    recipient_email: null,
                    subject: "",
                    message: "",
                    federal_tenders: [],
                },
                delete_federal_interest: null,
                download_federal_interests: null
            };
        },

        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.from_path = from.path;
                if (vm.$store.getters.federal_tender) {
                    vm.federal_tender = vm.$store.getters.federal_tender;
                    vm.federal_interest.federal_tender_id = vm.federal_tender?.federal_tender_id;
                    vm.federal_interest.user_id = vm.$store.getters.user?.user_id;
                    vm.download_federal_interests = vm.$store.getters.baseUrl+'api/downloadFederalInterests?federal_tender_id='+vm.federal_tender.federal_tender_id
                    vm.getFederalTender();
                }
            });
        },

        methods: {
            previousPage() {
                this.$router.push(this.from_path);
            },

            getFederalTender() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getFederalTender", data: vm.federal_tender })
                    .then(function (response) {
                        vm.federal_tender = response.data.data;
                        vm.download_all_attachments = vm.federal_tender.federal_attachments.filter((attachment) => attachment.download_url).length >= 2;
                        vm.paginateFederalInterests();
                    })
                    .catch(function (error) {
                        console.log(error);
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            replaceSpecialCharacters(value) {
                value = value.replaceAll("+", " ");
                value = value.replaceAll("-", " ");
                value = value.replaceAll("_", " ");
                return value;
            },
            showAlert() {
                this.$store.dispatch("info", "Didn't find notice id to open");
            },

            openWebSite() {
                window.open("https://sam.gov/opp/" + this.federal_tender.notice_id + "/view");
            },
            checkIfEmpty(str) {
                if (str?.trim()) {
                    this.emptycheck = "exit";
                    console.log(this.emptycheck);
                    console.log("not empty");
                } else {
                    this.emptycheck = "notexit";
                    console.log(this.emptycheck);
                    console.log("empty");
                }
            },
            formatFileSize(bytes, decimalPoint) {
                if (!Number.isInteger(bytes)) return bytes;
                if (bytes == 0) return "0 Bytes";
                var k = 1000,
                    dm = decimalPoint || 2,
                    sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"],
                    i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + " " + sizes[i];
            },
            format_date(value) {
                return moment(value).format("MMMM D, YYYY");
            },
            checkContact() {
                if (
                    this.federal_tender?.tdr_pri_fullname !== "" ||
                    this.federal_tender?.tdr_pri_phone !== "" ||
                    this.federal_tender?.tdr_pri_email !== "" ||
                    this.federal_tender?.tdr_sec_phone !== "" ||
                    this.federal_tender?.tdr_sec_email !== ""
                ) {
                    return true;
                }
            },
            interstedmodalpop() {
                let vm = this;
                vm.status = true;
                vm.interstmodal = true;
                // }
            },
            checklogin() {
                let vm = this;
                if (vm.$store.getters.user == null) {
                    vm.$router.push("/bids/state-opportunities");
                }
            },
            //  window.location.reload();
            sharefederal_tenders() {
                let vm = this;
                vm.errors = [];
                vm.shareBid.bids = [];
                vm.shareBid.mails = [];
                vm.shareBid.region_id = vm.federal_tender.tdr_region;
                vm.shareBid.bids.push(vm.federal_tender.tdr_id);

                if (vm.$store.getters.user == null) {
                    vm.userlogin = true;
                } else {
                    vm.sharebid = true;
                }
            },
            sendFederalTenderMail() {
                let vm = this;
                vm.fullPage = true;
                vm.isLoading = true;
                vm.share_tender.user_id = this.$store.getters.user.user_id;
                vm.share_tender.federal_tenders.push(vm.federal_tender.federal_tender_id);
                vm.$store
                    .dispatch("post", { uri: "sendFederalTenderMail", data: vm.share_tender })
                    .then(function () {
                        vm.fullPage = false;
                        vm.isLoading = false;
                        vm.sharebid = false;
                        vm.share_tender.recipient_email = "";
                        vm.share_tender.subject = "";
                        vm.share_tender.message = "";
                        vm.share_tender.state_tenders = [];
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

            closemodal() {
                let vm = this;
                vm.interstmodal = false;
                vm.userlogin = false;
                vm.saveSearchbid = false;
                vm.sharebid = false;
                vm.alertmodal = false;
                vm.erroralertmodal = false;
                vm.shareBid.bids = [];
                vm.shareBid.mails = [];
                (vm.frequency = ""), (vm.errors = []);
            },

            index() {
                let vm = this;

                vm.tdr.tdr_id = vm.$store.getters.bidsdetails.tdr_id;
                let document_names = [];
                let document_names_link = [];
                let document_dates = [];
                let document_sizes = [];
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: "getBid", data: vm.tdr })
                    .then(function (response) {
                        vm.isLoading = false;
                        vm.federal_tender = response.data.data;
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        console.log(error);
                        // vm.errors = error.response.data.errors;
                        // vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getFileExtension(file_extension) {
                let image = null;
                switch (file_extension) {
                    case "ppt":
                    case "pptx":
                        image = "assets/icons/ppt.png";
                        break;
                    case "pdf":
                        image = "assets/icons/PDF.svg";
                        break;
                    case "doc":
                    case "docx":
                        image = "assets/icons/DOCX.svg";
                        break;
                    case "png":
                        image = "assets/icons/PNG.svg";
                        break;
                    case "xls":
                    case "xlsx":
                    case "csv":
                        image = "assets/icons/XLS.svg";
                        break;
                    case "jpg":
                    case "jpeg":
                        image = "assets/icons/JPEG.svg";
                        break;
                    case "zip":
                        image = "assets/icons/ZIP.svg";
                        break;
                    default:
                        image = "assets/icons/default_file_icon.png";
                }
                return image;
            },
            edit(bidintersed) {
                let vm = this;
                vm.status = 0;
                vm.interstmodal = true;
                vm.federal_interest = bidintersed;
            },
            getBidInterest() {
                let vm = this;

                vm.tdr.tdr_id = vm.$store.getters.bidsdetails.tdr_id;
                //  const pieces = vm.$route.params.tdr_no.split(/[\s-]+/)
                // const last = pieces[pieces.length - 1]
                // vm.tdr.tdr_no = last;
                vm.$store
                    .dispatch("post", { uri: "getBidInterest", data: vm.tdr })
                    .then(function (response) {
                        vm.userinteresd = response.data.data;
                    })
                    .catch(function (error) {
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            deleteFederalInterest() {
                let vm = this;
                vm.isLoading = true;
                let uri = { uri: "deleteFederalInterest", data: vm.delete_federal_interest };
                vm.$store
                    .dispatch("post", uri)
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Interest successfully deleted");
                        vm.index();
                        window.location.reload();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            submit() {
                let vm = this;
                if (vm.status) {
                    vm.addFederalInterest();
                } else {
                    vm.updateFederalInterest();
                }
            },
            addFederalInterest() {
                let vm = this;
                vm.status = 1;
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: "addFederalInterest", data: vm.federal_interest })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Added successfully");
                        vm.interstmodal = false;
                        vm.paginateFederalInterests();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            updateFederalInterest() {
                let vm = this;
                vm.status = 1;
                vm.isLoading = true;
                vm.$store
                    .dispatch("post", { uri: "addFederalInterest", data: vm.federal_interest })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Updated successfully");
                        vm.interstmodal = false;
                        vm.paginateFederalInterests();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            // getFileExtension(filename) {
            //     return filename.slice(((filename.lastIndexOf(".") - 1) >>> 0) + 2);
            // },

            updateInterest() {
                let vm = this;
                vm.status = 1;
                vm.addinterst.tdr_id = vm.$route.params.tdr_id;
                vm.addinterst.bid_interested_user = vm.$store.getters.user.id;

                vm.isLoading = true;
                vm.$store
                    .dispatch("post", {
                        uri: "updateBidInterest/" + vm.addinterst.bid_interest_id,
                        data: vm.addinterst,
                    })
                    .then(function () {
                        vm.isLoading = false;
                        vm.$store.dispatch("success", "Bids Interested is successfully updated");

                        vm.interstmodal = false;
                        vm.closemodal();
                    })
                    .catch(function (error) {
                        vm.isLoading = false;
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            getDocumentSize(tdr_documents_size, key) {
                let size = [];
                if (tdr_documents_size) {
                    if (tdr_documents_size.search(/@/) == -1) {
                        // size.push(tdr_documents_size);
                        return tdr_documents_size;
                    } else {
                        return tdr_documents_size?.split("@")[key];
                    }
                } else {
                    // return tdr_documents_size[key];
                    return tdr_documents_size;
                }
            },
            getDocumentDate(tdr_documents_date, key) {
                let date = [];
                if (tdr_documents_date) {
                    if (tdr_documents_date.search(/@/) == -1) {
                        // date.push(tdr_documents_date);
                        return tdr_documents_date;
                    } else {
                        return tdr_documents_date?.split("@")[key];
                    }
                } else {
                    return tdr_documents_date;
                }
            },
            getDocuments(tdr_documents) {
                console.log("tdr_doc");

                let str = [];
                if (tdr_documents) {
                    console.log(tdr_documents);
                    console.log(tdr_documents.includes(","));
                    if (tdr_documents.includes(",")) {
                        return tdr_documents.split(",");
                    } else if (tdr_documents.search(/@/) == -1) {
                        str.push(tdr_documents);
                        return str;
                    } else {
                        return tdr_documents?.split("@");
                    }
                }
                // else if(tdr_documents.includes(",")) {
                //     return tdr_documents.split(",");
                // }
                else {
                    return tdr_documents;
                }
            },
            getSize(tdr_documents) {
                if (tdr_documents) {
                    if (tdr_documents.search(/@/) == -1) {
                        return 1;
                    } else {
                        let str = tdr_documents?.split("@");
                        return str.length;
                    }
                } else {
                    return 0;
                }
            },
            paginateFederalInterests() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "paginateFederalInterests", data: vm.federal_interest })
                    .then(function (response) {
                        vm.federal_interest = response.data.federal_interest;
                        vm.federal_interests = response.data.federal_interests;
                    })
                    .catch(function (error) {
                        console.log(error);
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            onPageChange(page) {
                this.meta.currentPage = page;
                this.getBidInterest();
            },
            onPerPageChange() {
                this.meta.currentPage = 1;
                this.getBidInterest();
            },
            format_date(value) {
                return moment(value).format("MMMM D, YYYY");
            },
            deleteAlertpopup(federal_interest) {
                this.erroralertmodal = true;
                this.delete_federal_interest = federal_interest;
            },
        },
    };
</script>
<style scoped>
    .nav.nav-divider .nav-item + .nav-item:before {
        content: "";
        color: inherit;
        padding-left: 0.65rem;
        padding-right: 0.75rem;
        opacity: 0.8;
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

    .icon {
        margin-top: -5px;
        height: 20px;
        width: 20px;
    }

    .mybutton-success {
        background: rgb(28, 184, 65);
        /* this is a green */
    }

    .mybutton-secondary {
        background: rgb(28, 184, 65);
        /* this is a green */
    }

    .sec {
        background-color: #85878a !important;
    }

    .mybutton-secondary {
        /* background: rgb(66, 184, 221); */
        background: #0cbc87;
        border-color: transparent;
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        /* this is a light blue */
    }

    .mybutton-success1 {
        background: rgb(28, 184, 65);
    }

    .mybutton-secondary1 {
        /* background: rgb(66, 184, 221); */
        background: rgb(32 60 88);
        border-color: transparent;
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        padding: 5px;

        /* this is a light blue */
    }

    .mybutton-secondary2 {
        /* background: rgb(66, 184, 221); */
        background: #17a2b8;
        border-color: transparent;
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);

        /* this is a light blue */
    }

    #demo-2 {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #demo-3 {
        max-width: 350px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    img {
        max-width: auto !important;
        height: auto;
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

    .backbidbtn {
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        font-weight: 400;
        border-radius: 4px;
        background-color: #247fb5 !important;
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

    .title-green {
        color: #16a34a !important;
    }

    .fw-500 {
        font-weight: 500 !important;
    }

    .nav-tabs {
        --bs-nav-tabs-border-color: none;
    }

    .border-bottom-rounded {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }

    .truncated-text {
        max-width: 150px;
        /* Adjust to your preferred width */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        vertical-align: top;
        cursor: pointer;
        /* Optional for hover indication */
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
    .avatar-xxs{
        height: 1.5rem;
        width: 1.5rem;
    }
</style>
