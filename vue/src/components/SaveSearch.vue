<template>
    <transition name="fade">
        <transition name="drop-in">
            <div class="card border">
                        <div class="card-header p-3 d-flex justify-content-between align-items-center ">
                            <div class="d-flex align-items-center">
                                    <h5 class="modal-title title-green" id="exampleModalLabel11">Save View</h5>
                            </div>
                            <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                        </div>
                                    <!-- card body -->
                                    <form class="card-body  pb-0 ">
                                        <!-- Current password -->
                                    <div class="field-wrapper ">
                                        <div class="field-placeholder">Label <span class="text-danger">*</span></div>
                                        <input class="form-control" type="text" placeholder="Name" :class="{'is-invalid': errors.search_name}" v-model="search_name" ref="search_name" />
                                        <span v-if="errors.search_name" class="invalid-feedback">{{ errors.search_name[0] }}</span>
                                    </div>

                                    </form>
                                        <div class="card-footer text-end">
                                   <!-- <button type="button" @click.prevent="closeModal()" class="btn mb-0 btn-sm btn-secondary me-2" data-bs-dismiss="modal" ref="Close">
                                        Close
                                    </button> -->
                                    <button type="button" v-if="status"  class="btn mb-0 btn-sm btn-success" @click.prevent="savedSearch()">
                                        Save
                                    </button>
                                     <button type="button" v-else class="btn mb-0 btn-sm btn-success" @click.prevent="updateSearch()">
                                        Update
                                    </button>
                                </div>
            </div>
        </transition>
    </transition>
</template>
<script>
export default {
    props:{
        status:Boolean,
        search_name:String
    },

    watch: {
        'savebids' : function(){
            console.log('savebids', this.savedbids)
        }
    },
    data(){
        return{
            search_name:'',
            errors:[]
        }
    },
    mounted(){

        if(this.status)
            this.search_name = ''
        else
            this.search_name = this.savedbids.search_name
    },

    methods:{
        closeModal(){
            this.$emit("closeModal")
        },
        savedSearch(){
            if(this.search_name){
                delete this.errors.search_name
                this.$emit("savedSearch", this.search_name)
            }
            else{
                this.errors.search_name = ['This field cannot be blank']
            }
        },
         updateSearch(){
            if(this.search_name){
                delete this.errors.search_name
                this.$emit("updateSearch", this.search_name)

            }
            else{
                this.errors.search_name = ['This field cannot be blank']
            }
        }

    }
}
</script>
<style scoped>
.fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.5s;
    }
    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
    .drop-in-enter-active,
    .drop-in-leave-active {
        transition: all 0.3s ease-out;
    }
    .drop-in-enter-from,
    .drop-in-leave-to {
        opacity: 0;
        transform: translateY(-50px);
    }
    .title-green{
        color: #16a34a!important;
        font-weight: 500 !important;
    }
</style>