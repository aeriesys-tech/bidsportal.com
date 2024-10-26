<template>
    <transition name="fade">
        <transition name="drop-in">
            <div class="card border">
              
                        <div class="card-header  pb-0  d-flex justify-content-between align-items-center ">
                            <div class="d-flex align-items-center">
                               
                                    <h5 class="modal-title" id="exampleModalLabel11">Save Search</h5>
                              
                            </div>
                            <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                        </div>
                
                 
                                

                                    <!-- card body -->
                                    <form class="card-body  pb-0 ">
                                        <!-- Current password -->
                                    <div class="field-wrapper ">
                                        <div class="field-placeholder">Label <span class="text-danger">*</span></div>
                                        <input class="form-control" type="text" placeholder="Name" :class="{'is-invalid': errors.alert_label}" v-model="alert_label" ref="alert_label" />
                                        <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                                    </div>
                            
                                    </form>
                                        <div class="card-footer   text-end">
                                   <!-- <button type="button" @click.prevent="closeModal()" class="btn mb-0 btn-sm btn-secondary me-2" data-bs-dismiss="modal" ref="Close">
                                        Close
                                    </button> -->
                                    <button type="button" v-if="status"  class="btn mb-0 btn-sm btn-primary" @click.prevent="savedSearch()">
                                        Save
                                    </button>
                                     <button type="button" v-else class="btn mb-0 btn-sm btn-primary" @click.prevent="updateSearch()">
                                        update
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
        alert_label:String,
        savedbids:Object
    },
    data(){
        return{
            alert_label:'',
            errors:[]
        }
    },
    mounted(){
       
        if(this.status)
            this.alert_label = ''
        else
            this.alert_label = this.savedbids.alert_label
    },

    methods:{
        closeModal(){
            this.$emit("closeModal")
        },
        savedSearch(){
            if(this.alert_label){
                delete this.errors.alert_label
                this.$emit("savedSearch", this.alert_label)
            }
            else{
                this.errors.alert_label = ['This field cannot be blank']
            }
        },
         updateSearch(){
            if(this.alert_label){
                delete this.errors.alert_label
                this.$emit("updateSearch", this.alert_label)
                
            }
            else{
                this.errors.alert_label = ['This field cannot be blank']
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
</style>