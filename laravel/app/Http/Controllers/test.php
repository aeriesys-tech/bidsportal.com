<div class="card card-body rounded-0 p-2">
                                <div class="ml2 d-flex btn-more collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#Region" role="button" aria-expanded="false" aria-controls="status">
                                    <h6 style="font-size: 15px; font-weight: normal;" class="mb-2">Region</h6>
                                    <a class="p-0 mb-0">
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    </a>
                                </div>
                             
                                <div class="col-12 ml2 multi-collapse collapse show" id="Region">
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
                                            <input class="form-check-input" type="radio" name="region" value="Commercial" v-model="region" />
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