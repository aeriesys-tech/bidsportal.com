<template>
<div class="container-fluid pb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="main-title mb-2">Federal Tender</h2>
        <router-link to="/federal_tenders" class="btn btn-primary mb-2">Federal Bids</router-link>
    </div>
    <div class="row g-3">
        <div class="col-md-12">
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0"><strong>Download Federal Tenders</strong></h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="date" id="calendar" :class="{'is-invalid': errors.from_date}" v-model="federal_tender.from_date" class="form-control form-control-sm"  :max="federal_tender.max_date" />
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-primary btn-sm" @click="downloadFederalTenders()">Download Bids</button>
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
    data(){
        return{
            federal_tender:{
                from_date:moment().subtract(1, 'days').format('YYYY-MM-DD'),
                max_date:moment().subtract(1, 'days').format('YYYY-MM-DD')
            },
            errors:[]
        }
    },
    mounted(){
    },
    methods:{
        downloadFederalTenders(){
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "downloadFederalTenders", data:vm.federal_tender })
                .then((response) => {
                    loader.hide();
                    vm.$store.dispatch("success", response.data.message);
                })
                .catch(function (error) {
                    loader.hide();
                    vm.$store.dispatch("error", error.response.data.message);
                });
        }
    }
}
</script>