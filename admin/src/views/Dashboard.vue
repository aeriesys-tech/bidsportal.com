<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between">
            <h2 class="main-title mb-3">Dashboard</h2>
        </div>
        <div class="row g-2 mb-3">
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-user-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ registered_users }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total registered users</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-mail-check-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ confirm_user_emails }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total users confirmed email address</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-mail-close-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ notconfirm_user_emails }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total users not confirmed email address</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-user-follow-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ actual_subscritions }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total active actual subscriptions</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-user-unfollow-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ expired_subscritions }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total expired actual subscriptions</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-check-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ total_trial_actives }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total active trail subscriptions</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-close-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ total_trial_Inactives }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total expired trail subscriptions</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-user-star-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ subs_purchase_inmonth }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total Subscriptions purchase in a month</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-one">
                    <div class="card-body p-3">
                        <div class="d-flex d-sm-block d-xl-flex align-items-center">
                            <div class="helpdesk-icon bg1"><i class="ri-user-unfollow-line"></i></div>
                            <div class="ms-3 ms-sm-0 ms-xl-3 mt-sm-3 mt-xl-0">
                                <h2 class="card-value d-flex align-items-baseline mb-0">{{ subs_expire_inmonth }}</h2>
                                <label class="card-label fs-sm fw-medium mb-1">Total Subscriptions expiring in a month</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-12">
                <div class="card card-one">
                    <div class="card-header d-flex justify-content-between align-item-center">
                        <span style="font-size: 1.2rem; font-weight: 500; font-family: 'Inter', 'sans-serif'; color: #212830;"><i class="ri-key-2-line" style="color: blue; font-size: 14pt; font-weight: bold;"></i> Update API Key</span>
                        <div>
                            <a class="fw-bold" href="javascript:void(0)" @click="api_key_div=true" v-if="!api_key_div">Show</a>
                            <a class="fw-bold" href="javascript:void(0)" @click="api_key_div=false" v-if="api_key_div">Hide</a>
                        </div>
                    </div>
                    <div class="card-body" v-if="api_key_div">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" style="font-weight: bold;">Api key</label>
                                    <input type="text" class="form-control form-control-sm" :class="{'is-invalid': errors.api_key}" v-model="dashboard.api_key" />
                                </div>
                            </div>
                            <div class="col-md-6 mt-auto">
                                <button class="btn btn-sm btn-primary" @click="updateApiKey()">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-one">
                    <div class="card-header d-flex justify-content-between align-item-center">
                        <span style="font-size: 1.2rem; font-weight: 500; font-family: 'Inter', 'sans-serif'; color: #212830;"><i class="ri-restart-line" style="color: blue; font-size: 14pt; font-weight: bold;"></i> Update Bids</span>
                        <div>
                            <a class="fw-bold" href="javascript:void(0)" @click="state_bids_div=true" v-if="!state_bids_div">Show</a>
                            <a class="fw-bold" href="javascript:void(0)" @click="state_bids_div=false" v-if="state_bids_div">Hide</a>
                        </div>
                    </div>
                    <div class="card-body" v-if="state_bids_div">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" style="font-weight: bold;">Region</label>
                                    <select v-model="meta.region" class="form-control form-control-sm">
                                        <option value="state">State</option>
                                        <option value="private">Private</option>
                                        <option value="international">International</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" style="font-weight: bold;">S3 Bucket Folders</label>
                                    <input type="date" id="calendar" v-model="meta.folder" class="form-control form-control-sm" :min="min_date" :max="max_date" @change="validateDate()" />
                                </div>
                            </div>
                            <div class="col-md-4 mt-auto">
                                <button class="btn btn-sm btn-primary" @click="updateBids()">Update</button>
                            </div>
                            <div class="col-md-12" v-if="errors.length" style="margin-top: 10px;">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th colspan="4"><span style="font-size: 1.2rem; font-weight: 500; font-family: 'Inter', 'sans-serif'; color: red; margin-left: 1rem;">Errros</span></th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Row</th>
                                                <th class="text-center">Column</th>
                                                <th class="text-center">Error</th>
                                                <th class="text-center">Cell Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="error, key in errors" :key="key">
                                                <td class="text-center">{{ error.row }}</td>
                                                <td class="text-center">{{ parseInt(error.attribute)+1 }}</td>
                                                <td class="text-center"><span v-for="error_attribute, attr_key in error.errors" :key="attr_key">{{ error_attribute }}</span></td>
                                                <td class="text-center">{{ error.values[error.attribute] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-one">
                    <div class="card-header d-flex justify-content-between align-item-center">
                        <span style="font-size: 1.2rem; font-weight: 500; font-family: 'Inter', 'sans-serif'; color: #212830;"><i class="ri-file-line" style="color: blue; font-size: 14pt; font-weight: bold;"></i> Upload Excel Sheet</span>
                        <div>
                            <a class="fw-bold" href="javascript:void(0)" @click="upload_excel_sheet_div=true" v-if="!upload_excel_sheet_div">Show</a>
                            <a class="fw-bold" href="javascript:void(0)" @click="upload_excel_sheet_div=false" v-if="upload_excel_sheet_div">Hide</a>
                        </div>
                    </div>
                    <div class="card-body" v-if="upload_excel_sheet_div">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" style="font-weight: bold;">Region</label>
                                    <select v-model="upload_excel.region" class="form-control form-control-sm">
                                        <option value="state">State</option>
                                        <option value="private">Private</option>
                                        <option value="international">International</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" style="font-weight: bold;">S3 Bucket Folders</label>
                                    <input type="date" id="calendar" :class="{'is-invalid': upload_excel?.errors.folder}" v-model="upload_excel.folder" class="form-control form-control-sm" :min="min_date" :max="max_date" @change="validateDate()" />
                                    <span v-if="upload_excel?.errors.folder" class="invalid-feedback">{{ upload_excel?.errors.folder[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-4 mt-auto">
                                <br />
                                <button class="btn btn-primary btn-sm" @click="showS3BucketFiles()">Show Files</button>
                                <button class="btn btn-danger btn-sm" @click="deleteS3BucketFiles()" v-if="upload_excel.delete_files?.length" style="margin-left: 10px;">Delete</button>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="form-group">
                                    <label class="form-label" style="font-weight: bold;">Upload Excel File</label>
                                    <input type="file" class="form-control form-control-sm" :class="{'is-invalid': upload_excel.errors.file}" @change="getExcelFile($event)" ref="excel_file" />
                                    <span v-if="upload_excel.errors.file" class="invalid-feedback">{{ upload_excel.errors.file[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-1 mt-auto">
                                <div class="form-group">
                                    <br />
                                    <button class="btn btn-primary btn-sm" @click="uploadS3BucketFile()">Upload</button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3" v-if="upload_excel.errors.duplicate">
                                <span style="color: red;">{{ upload_excel.errors.duplicate }}</span>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Sl.No.</th>
                                                <th>File Name</th>
                                                <th class="text-center">Action</th>
                                                <th class="text-center">Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" v-if="excel_files.length<=0" class="text-center">No records found</td>
                                            </tr>
                                            <tr v-for="file, file_key in excel_files" :key="file_key">
                                                <td class="text-center">{{ parseInt(file_key)+1 }}</td>
                                                <td width="60%">{{ file.filename }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" v-model="upload_excel.delete_files" :value="file" />
                                                </td>
                                                <td class="text-center">
                                                    <a v-if="file.download_url" :href="file.download_url"><i class="ri-download-line"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Dashboard",
        data() {
            return {
                min_date: "2024-09-01",
                max_date: "2024-12-05",
                selected_date: null,
                allowed_dates: [],
                dashboard: {
                    api_key_id: null,
                    api_key: null,
                    is_trial: false,
                    no_of_days: 0,
                },
                meta: {
                    region: "state",
                    folder: null,
                    upload_excel_folder: null,
                },
                upload_excel: {
                    region: "state",
                    folder: "",
                    delete_files: [],
                    file: "",
                    errors: [],
                },
                api_key_div: false,
                subscription_key: false,
                state_bids_div: true,
                upload_excel_sheet_div: false,
                excel_files: [],
                folders: [],
                errors: [],

                registered_users: 0,
                confirm_user_emails: 0,
                notconfirm_user_emails: 0,
                actual_subscritions: 0,
                expired_subscritions: 0,
                subs_purchase_inmonth: 0,
                subs_expire_inmonth: 0,
                total_trial_actives: 0,
                total_trial_Inactives: 0,
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.getApiKey();
                vm.getDashboardCount();
                // vm.getAdminSetting()
                if (from.name == "login") {
                    vm.$router.go();
                }
            });
        },
        methods: {
            updateBids() {
                if (this.meta.region == "state") {
                    this.updateStateBids();
                } else if (this.meta.region == "private") {
                    this.updatePrivateBids();
                } else if (this.meta.region == "international") {
                    this.updateInternationalBids();
                }
            },
            validateDate() {
                if (this.folders.includes(this.meta.folder)) {
                    return true;
                } else {
                    this.$store.dispatch("info", "Folder doesn't exist in S3 for the selected date");
                    return false;
                }
            },
            updateSubscriptionSetting() {
                let vm = this;
                const payload = {
                    is_trial: vm.dashboard.is_trial,
                    no_of_days: vm.dashboard.no_of_days,
                };

                vm.$store
                    .dispatch("post", { uri: "addAdminSetting", data: payload })
                    .then((response) => {
                        vm.dashboard.is_trial = response.data.subscription.is_trial;
                        vm.dashboard.no_of_days = response.data.subscription.no_of_days;
                        vm.$store.dispatch("success", response.data.message);
                    })
                    .catch((error) => {
                        console.error("Error updating subscription settings:", error);
                    });
            },
            getExcelFile(e) {
                let vm = this;
                vm.upload_excel.file = e.target.files[0];
            },
            getApiKey() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getApiKey" })
                    .then((response) => {
                        vm.dashboard = response.data;
                        vm.getAwsFolders();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            // getAdminSetting() {
            //     let vm = this;
            //     vm.$store
            //         .dispatch("post", { uri: "getAdminSetting" })
            //         .then((response) => {
            //             vm.dashboard = response.data.subscription
            //             vm.getAwsFolders()
            //         })
            //         .catch(function (error) {
            //             console.log(error)
            //         });
            // },

            showS3BucketFiles() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.upload_excel.errors = [];
                vm.$store
                    .dispatch("post", { uri: "showS3BucketFiles", data: vm.upload_excel })
                    .then((response) => {
                        loader.hide();
                        vm.excel_files = response.data;
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.upload_excel.errors = error.response.data.errors;
                    });
            },

            deleteS3BucketFiles() {
                if (confirm("Are you sure you want to delete file from S3 bucket?")) {
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.upload_excel.errors = [];
                    vm.$store
                        .dispatch("post", { uri: "deleteS3BucketFiles", data: vm.upload_excel })
                        .then(() => {
                            loader.hide();
                            vm.upload_excel.delete_files = [];
                            vm.showS3BucketFiles();
                        })
                        .catch(function (error) {
                            loader.hide();
                            vm.upload_excel.errors = error.response.data.errors;
                        });
                }
            },

            uploadS3BucketFile() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.upload_excel.errors = [];
                const formData = new FormData();
                formData.append("folder", vm.upload_excel.folder);
                formData.append("file", vm.upload_excel.file);
                vm.$store
                    .dispatch("post", { uri: "uploadS3BucketFile", data: formData })
                    .then(() => {
                        loader.hide();
                        vm.$refs.excel_file.value = "";
                        vm.upload_excel.file = "";
                        vm.showS3BucketFiles();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.$refs.excel_file.value = "";
                        vm.upload_excel.file = "";
                        vm.upload_excel.errors = error.response.data.errors;
                    });
            },

            updateApiKey() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "updateApiKey", data: vm.dashboard })
                    .then(() => {
                        loader.hide();
                        vm.getApiKey();
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error.response.data.errors;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getAwsFolders() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "getAwsFolders" })
                    .then((response) => {
                        loader.hide();
                        vm.folders = response.data;
                        if (vm.folders.length) {
                            vm.meta.folder = vm.folders[0];
                            vm.min_date = vm.folders[vm.folders.length - 1];
                            vm.max_date = vm.folders[0];
                            vm.selected_date = vm.folders[0];
                        }
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            getDashboardCount() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "dashboardCounts" })
                    .then((response) => {
                        loader.hide();
                        vm.registered_users = response.data?.registered_users;
                        vm.confirm_user_emails = response.data?.confirm_user_emails;
                        vm.notconfirm_user_emails = response.data?.notconfirm_user_emails;
                        vm.actual_subscritions = response.data?.actual_subscritions;
                        vm.expired_subscritions = response.data?.expired_subscritions;
                        vm.subs_purchase_inmonth = response.data?.subs_purchase_inmonth;
                        vm.subs_expire_inmonth = response.data?.subs_expire_inmonth;
                        vm.total_trial_actives = response.data?.total_trial_actives;
                        vm.total_trial_Inactives = response.data?.total_trial_Inactives;
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            updateStateBids() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.errors = [];
                vm.$store
                    .dispatch("post", { uri: "updateStateBids", data: vm.meta })
                    .then((response) => {
                        loader.hide();
                        vm.$store.dispatch("success", response.data.message);
                        vm.$router.push("/state_tenders");
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error?.response?.data?.error;
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            updatePrivateBids() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.errors = [];
                vm.$store
                    .dispatch("post", { uri: "updatePrivateBids", data: vm.meta })
                    .then((response) => {
                        loader.hide();
                        vm.$store.dispatch("success", response.data.message);
                        vm.$router.push("/state_tenders");
                    })
                    .catch(function (error) {
                        loader.hide();
                        console.log(error);
                        // vm.errors = error?.response.data?.error
                        // vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            updateInternationalBids() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.errors = [];
                vm.$store
                    .dispatch("post", { uri: "updateInternationalBids", data: vm.meta })
                    .then((response) => {
                        loader.hide();
                        vm.$store.dispatch("success", response.data.message);
                        vm.$router.push("/state_tenders");
                    })
                    .catch(function (error) {
                        console.log(error);
                        // loader.hide();
                        // vm.errors = error?.response.data?.error
                        // vm.$store.dispatch("error", error.response.data.message);
                    });
            },
        },
    };
</script>

<style scoped>
    .bg1 {
        background-color: #ededff;
        color: #4549f2;
    }
    .helpdesk-icon {
        width: 60px;
        height: 60px;
    }
    .helpdesk-icon i {
        font-size: 25px;
    }
    .align-item-center {
        align-items: center;
    }

</style>
