<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between">
            <h2 class="main-title mb-3">Dashboard</h2>
        </div>
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <span style="font-size:1.2rem; font-weight: 500; font-family: 'Inter', 'sans-serif'; color: #212830;"><i class="ri-key-2-line" style="color:blue;font-size: 14pt;font-weight: bold"></i> Update API Key</span>
                        <div style="float:right">
                            <a href="javascript:void(0)" @click="api_key_div=true" v-if="!api_key_div">Show</a>
                            <a href="javascript:void(0)" @click="api_key_div=false" v-if="api_key_div">Hide</a>
                        </div>
                    </div>
                    <div class="card-body" v-if="api_key_div">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Api key</label>
                                    <input type="text" class="form-control form-control-sm" :class="{'is-invalid': errors.api_key}" v-model="dashboard.api_key">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br/>
                                <button class="btn btn-primary btn-sm" style="margin-left:10px" @click="updateApiKey()">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <span style="font-size:1.2rem; font-weight: 500; font-family: 'Inter', 'sans-serif'; color: #212830;"><i class="ri-restart-line" style="color:blue;font-size: 14pt;font-weight: bold"></i> Update State Bids</span>
                        <div style="float:right">
                            <a href="javascript:void(0)" @click="state_bids_div=true" v-if="!state_bids_div">Show</a>
                            <a href="javascript:void(0)" @click="state_bids_div=false" v-if="state_bids_div">Hide</a>
                        </div>
                    </div>
                    <div class="card-body" v-if="state_bids_div">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: bold;">S3 Bucket Folders</label>
                                    <select class="form-control" style="margin-right: 10px" v-model="meta.folder">
                                        <option v-for="folder, key in folders" :key="key" :value="folder">{{ folder }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br/>
                                <button class="btn btn-primary btn-sm" @click="updateStateBids()">Update</button>
                            </div>
                            <div class="col-md-12" v-if="errors.length" style="margin-top: 10px;">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr><th colspan="4"><span style="font-size:1.2rem; font-weight: 500; font-family: 'Inter', 'sans-serif'; color: red;margin-left: 1rem;">Errros</span></th></tr>
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
                <div class="card">
                    <div class="card-header">
                        <span style="font-size:1.2rem; font-weight: 500; font-family: 'Inter', 'sans-serif'; color: #212830;"><i class="ri-file-line" style="color:blue;font-size: 14pt;font-weight: bold"></i> Upload Excel Sheet</span>
                        <div style="float:right">
                            <a href="javascript:void(0)" @click="upload_excel_sheet_div=true" v-if="!upload_excel_sheet_div">Show</a>
                            <a href="javascript:void(0)" @click="upload_excel_sheet_div=false" v-if="upload_excel_sheet_div">Hide</a>
                        </div>
                    </div>
                    <div class="card-body" v-if="upload_excel_sheet_div">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">S3 Bucket Folders</label>
                                    <select class="form-control" style="margin-right: 10px" v-model="upload_excel.folder" :class="{'is-invalid': upload_excel.errors.folder}">
                                        <option value=''>Select Folder</option>
                                        <option v-for="folder, key in folders" :key="key" :value="folder">{{ folder }}</option>
                                    </select>
                                    <span v-if="upload_excel.errors.folder" class="invalid-feedback">{{ upload_excel.errors.folder[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <br/>
                                <button class="btn btn-primary btn-sm" @click="showS3BucketFiles()">Show Files</button>
                                <button class="btn btn-danger btn-sm" @click="deleteS3BucketFiles()" v-if="upload_excel.delete_files?.length" style="margin-left: 10px;">Delete</button>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Upload Excel File</label>
                                    <input type="file" class="form-control form-control-sm" :class="{'is-invalid': upload_excel.errors.file}" @change="getExcelFile($event)" ref="excel_file">
                                    <span v-if="upload_excel.errors.file" class="invalid-feedback">{{ upload_excel.errors.file[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <br/>
                                    <button class="btn btn-primary btn-sm" @click="uploadS3BucketFile()">Upload</button>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px;" v-if="upload_excel.errors.duplicate">
                                <span style="color:red">{{ upload_excel.errors.duplicate }}</span>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px;">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="20%">Sl.No.</th>
                                                <th class="text-center" width="60%">File Name</th>
                                                <th class="text-center" width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" v-if="excel_files.length<=0" class="text-center">No records found</td>
                                            </tr>
                                            <tr v-for="file, file_key in excel_files" :key="file_key">
                                                <td class="text-center">{{ parseInt(file_key)+1 }}</td>
                                                <td class="text-center">{{ file }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" v-model="upload_excel.delete_files" :value="file">
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
                dashboard:{
                    api_key_id:null,
                    api_key:null
                },
                meta:{
                    folder:null,
                    upload_excel_folder:null
                },
                upload_excel:{
                    folder:'',
                    delete_files:[],
                    file:'',
                    errors:[]
                },
                api_key_div:false,
                state_bids_div:true,
                upload_excel_sheet_div:false,
                excel_files:[],
                folders:[],
                errors:[]
            };
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.getApiKey()
                if (from.name == "login") {
                    vm.$router.go();
                }
            });
        },
        methods: {
            getExcelFile(e){
                let vm = this
                vm.upload_excel.file= e.target.files[0]
            },
            getApiKey() {
                let vm = this;
                vm.$store
                    .dispatch("post", { uri: "getApiKey" })
                    .then((response) => {
                        vm.dashboard = response.data
                        vm.getAwsFolders()
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },

            showS3BucketFiles() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.upload_excel.errors = []
                vm.$store
                    .dispatch("post", { uri: "showS3BucketFiles", data: vm.upload_excel })
                    .then((response) => {
                        loader.hide()
                        vm.excel_files = response.data
                    })
                    .catch(function (error) {
                        loader.hide()
                        vm.upload_excel.errors = error.response.data.errors
                    });
            },

            deleteS3BucketFiles(){
                if(confirm('Are you sure you want to delete file from S3 bucket?')){
                    let vm = this;
                    let loader = vm.$loading.show();
                    vm.upload_excel.errors = []
                    vm.$store
                        .dispatch("post", { uri: "deleteS3BucketFiles", data: vm.upload_excel })
                        .then(() => {
                            loader.hide()
                            vm.upload_excel.delete_files=[]
                            vm.showS3BucketFiles()
                        })
                        .catch(function (error) {
                            loader.hide()
                            vm.upload_excel.errors = error.response.data.errors
                        });
                }
            },

            uploadS3BucketFile(){
                let vm = this;
                let loader = vm.$loading.show();
                vm.upload_excel.errors = []
                const formData = new FormData()
                formData.append('folder', vm.upload_excel.folder)
                formData.append('file', vm.upload_excel.file)
                vm.$store
                    .dispatch("post", { uri: "uploadS3BucketFile", data: formData })
                    .then(() => {
                        loader.hide()
                        vm.$refs.excel_file.value= ''
                        vm.upload_excel.file = ''
                        vm.showS3BucketFiles()
                    })
                    .catch(function (error) {
                        loader.hide()
                        vm.$refs.excel_file.value= ''
                        vm.upload_excel.file = ''
                        vm.upload_excel.errors = error.response.data.errors
                    });
            },

            updateApiKey() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.$store
                    .dispatch("post", { uri: "updateApiKey", data:vm.dashboard })
                    .then(() => {
                        loader.hide();
                        vm.getApiKey()
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
                        vm.folders = response.data
                        if(vm.folders.length){
                            vm.meta.folder = vm.folders[0]
                        }
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },

            updateStateBids() {
                let vm = this;
                let loader = vm.$loading.show();
                vm.errors = []
                vm.$store
                    .dispatch("post", { uri: "updateStateBids", data:vm.meta })
                    .then((response) => {
                        loader.hide();
                        vm.$store.dispatch("success", response.data.message);
                        vm.$router.push('/state_tenders')
                    })
                    .catch(function (error) {
                        loader.hide();
                        vm.errors = error?.response.data?.error
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            },
            
        },
    };
</script>

<style scoped>

</style>