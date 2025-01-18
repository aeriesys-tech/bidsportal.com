<template>
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="main-title mb-2">Delete Bids</h2>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0"><strong>Delete Bids</strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From Date (Posted Date)</label>
                                    <input type="date" class="form-control" :class="{ 'is-invalid': errors.from_date }" v-model="meta.from_date">
                                    <span v-if="errors.from_date" class="invalid-feedback">{{ errors?.from_date[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Date (Posted Date)</label>
                                    <input type="date" class="form-control" :class="{ 'is-invalid': errors.to_date }" v-model="meta.to_date">
                                    <span v-if="errors.to_date" class="invalid-feedback">{{ errors?.to_date[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Region</label>
                                    <select class="form-control" v-model="meta.region" :class="{ 'is-invalid': errors.region }">
                                        <option value="">Select Region</option>
                                        <option value="State">State</option>
                                        <option value="Federal">Federal</option>
                                        <option value="Private">Private</option>
                                        <option value="International">International</option>
                                    </select>
                                    <span v-if="errors.region" class="invalid-feedback">{{ errors?.region[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div style="float:right">
                                    <button class="btn btn-primary mt-3 mx-2" @click="showBids()">Show Bids</button>
                                    <button class="btn btn-danger mt-3" @click="deleteBids()">Delete Bids</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-sm mt-2">
                            <table class="table table-striped table-sm text-wrap table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="1%">#</th>
                                        <th @click="sort('tender_no')" width="5%">
                                            Tender No
                                            <span>
                                                <i v-if="meta.keyword == 'tender_no' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'tender_no' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('title')" width="10%">
                                            Tender Title
                                            <span>
                                                <i v-if="meta.keyword == 'title' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'title' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('posted_date')" width="5%">
                                            Publish Date
                                            <span>
                                                <i v-if="meta.keyword == 'posted_date' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'posted_date' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('posted_date')" width="5%">
                                            Opening Date
                                            <span>
                                                <i v-if="meta.keyword == 'posted_date' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'posted_date' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                        <th @click="sort('posted_date')" width="5%">
                                            Expiry Date
                                            <span>
                                                <i v-if="meta.keyword == 'posted_date' && meta.order_by == 'asc'"
                                                    class="ri-arrow-up-line"></i>
                                                <i v-else-if="meta.keyword == 'posted_date' && meta.order_by == 'desc'"
                                                    class="ri-arrow-down-line"></i>
                                                <i v-else class="fas fa-sort"></i>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!tenders.length">
                                        <td colspan="6" class="text-center">No records found</td>
                                    </tr>
                                    <tr v-for="tender, key in tenders" :key="key">
                                        <td class="text-center">{{ key+1 }}</td>
                                        <td class="wrap-text">{{ tender.tender_no }}</td>
                                        <td class="wrap-text ">{{ tender.title }}</td>
                                        <td>{{ tender.posted_date_parsed }}</td>
                                        <td>{{ tender.opening_date_parsed }}</td>
                                        <td>{{ tender.expiry_date_parsed }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    components: {
    },
    data() {
        return {
            meta: {
                region: '',
                from_date: '',
                to_date: ''
            },
            tenders:[],
            errors:[],
            url : ''
        };
    },
    mounted() {
    },

    watch: {
    },

    methods: {
        showBids(){
            this.url = 'getStateTendersRange'
            if(this.meta.region == 'Federal'){
                this.url = 'getFederalTendersRange'
            } else if(this.meta.region == 'Private'){
                this.url = 'getPrivateTendersRange'
            } else if(this.meta.region == 'International'){
                this.url = 'getInternationalTendersRange'
            } else{
                this.url = 'getStateTendersRange'
            }
            this.getTendersRange()
        },

        deleteBids(){
            if(this.meta.region == 'Federal'){
                this.url = 'deleteFederalTendersRange'
            } else if(this.meta.region == 'Private'){
                this.url = 'deletePrivateTendersRange'
            } else if(this.meta.region == 'International'){
                this.url = 'deleteInternationalTendersRange'
            } else{
                this.url = 'getStateTendersRange'
            }
        },

        getTendersRange(url) {
            let vm = this
            let loader = vm.$loading.show()
            vm.$store
                .dispatch("post", { uri: url, data: vm.meta })
                .then((response) => {
                    loader.hide()
                    vm.tenders = response.data.data
                })
                .catch(function (error) {
                    loader.hide()
                    console.log(error)
                    vm.errors = error.response.data.errors
                });
        },

        deleteTendersRange() {
            if(confirm('Are you sure you want to delete State tenders from '+moment(this.meta.from_date).format('DD-MM-YYYY')+ ' to '+ moment(this.meta.to_date).format('DD-MM-YYYY'))){
                let vm = this
                let loader = vm.$loading.show()
                vm.$store
                    .dispatch("post", { uri: url, data: vm.meta })
                    .then(() => {
                        loader.hide()
                        vm.getStateTendersRange
                        vm.$store.dispatch("success", "State tenders deleted successfully");
                    })
                    .catch(function (error) {
                        loader.hide()
                        console.log(error)
                        vm.$store.dispatch("error", error.response.data.message);
                    });
            }
        }
    },
};
</script>
<style scoped>
.icon_ht {
    font-size: 14pt;
}

.wrap-text {
    white-space: normal;
    /* Allow text to wrap */
    word-wrap: break-word;
    /* Ensure long words break */
    overflow-wrap: break-word;
    /* Compatibility for various browsers */
}

/* Optionally, keep other columns from wrapping if needed */
.no-wrap {
    white-space: nowrap;
    /* Disable text wrapping */
}
</style>