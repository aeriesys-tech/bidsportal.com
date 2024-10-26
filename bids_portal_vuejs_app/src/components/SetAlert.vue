<template>
    <transition name="fade">
        <transition name="drop-in">
            <div class="card border">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel11">Set Alert</h5>
                    </div>
                    <a href="#" class="btn btn-sm btn-link p-0 mb-0"><button type="button" @click.prevent="closeModal()" class="btn-close"></button></a>
                </div>

                <!-- card body -->
                <form class="card-body pb-0">
                    <!-- Current password -->
                    <div class="field-wrapper mb-2">
                        <label class="form-label">Alert Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-secondary" :class="{ 'is-invalid': errors.alert_label }" v-model="savealert.alert_label" placeholder="Enter your Alert" />
                        <span v-if="errors.alert_label" class="invalid-feedback">{{ errors.alert_label[0] }}</span>
                    </div>
                    <div class="field-wrapper">
                        <label class="form-label">Frequency<span class="text-danger">*</span></label>
                        <select class="form-select text-secondary" :class="{ 'is-invalid': errors.frequency }" v-model="savealert.frequency">
                            <option selected="" value="">Select your Frequency</option>
                            <option value:daily>Daily</option>
                            <option value:weekly>Weekly</option>
                        </select>
                        <span v-if="errors.frequency" class="invalid-feedback">{{ errors.frequency[0] }}</span>
                    </div>
                    <p v-if="errors.length !== 0">Field Required</p>
                    <ul class="p-0">
                        <li style="list-style: none; color: #dc3545;" v-for="error in errors" :key="error">{{ error[0] }}</li>
                        <!-- <li v-for=" error in message.errors" :key="error">
												{{error[0]}}
											</li> -->
                    </ul>
                </form>
                <div class="card-footer pt-1 text-end">
                    <!-- <button type="button" style="margin:3px" class="btn btn-secondary" @click.prevent="closemodal()" ref="Close">
										Close
									</button> -->
                    <button type="button" v-if="status" class="mb-0 btn btn-sm btn-primary" @click="updateAlert()">
                        Update
                    </button>
                    <button type="button" v-else class="mb-0 btn btn-sm btn-primary" @click="setAlert()">
                        Save
                    </button>
                </div>
            </div>
        </transition>
    </transition>
</template>
<script>
    export default {
        props: {
            alert: Object,
        },
        data() {
            return {
                savealert: {
                    id: "",
                    alert_label: "",
                    frequency: "",
                },
                status: false,
                errors: [],
            };
        },
        mounted() {
            this.savealert.id = this.alert.id;
            this.savealert.alert_label = this.alert.alert_label;
            this.savealert.frequency = this.alert.frequency;
            if (this.alert.id) this.status = true;
            else this.status = false;
        },
        methods: {
            closeModal() {
                this.$emit("closeModal");
            },
            setAlert() {
                if (this.savealert.alert_label && this.savealert.frequency) {
                    delete this.errors.alert_label;
                    delete this.errors.frequency;
                    this.$emit("setAlert", this.savealert);
                } else {
                    if (!this.savealert.alert_label) this.errors.alert_label = ["This field cannot be blank"];
                    if (!this.savealert.frequency) this.errors.frequency = ["This field cannot be blank"];
                }
            },

            updateAlert() {
                if (this.savealert.alert_label && this.savealert.frequency) {
                    delete this.errors.alert_label;
                    delete this.errors.frequency;
                    this.$emit("updateAlert", this.savealert);
                } else {
                    if (!this.savealert.alert_label) this.errors.alert_label = ["This field cannot be blank"];
                    if (!this.savealert.frequency) this.errors.frequency = ["This field cannot be blank"];
                }
            },
        },
    };
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
