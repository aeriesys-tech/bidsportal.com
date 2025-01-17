<template>
    <div class="col-md-3">
        <div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasSidebar">
            <div class="offcanvas-header justify-content-end pb-2">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body p-3 p-lg-0">
                <div class="card bg-light1 w-100">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="text-center">
                                <h1 class="avatar avatar-xl rounded-circle border border-white border-3 shadow">{{$store.getters.user?.name.substring(0,1)}}</h1>
                            </div>
                            <h6 class="mb-0">{{$store.getters.user?.name}}</h6>
                            <a href="javascript:void(0)" class="text-reset text-primary-hover small">{{$store.getters.user?.email}}</a>
                            <hr />
                        </div>
                        <!-- <ul class="nav nav-pills-primary-soft flex-column">
                                         <li class="nav-item">
                                             <router-link class="nav-link active" to="/user/profile"><i class="bi bi-person fa-fw me-2"></i>My Profile</router-link>
                                         </li>
                                         <li class="nav-item">
                                             <router-link class="nav-link" to="/user/change-password"><i class="bi bi-person fa-fw me-2"></i>Account details</router-link>
                                         </li>
                                         <li class="nav-item">
                                             <router-link class="nav-link" to="/user/subscription"><i class="bi bi-ticket-perforated fa-fw me-2"></i>Subscription Info</router-link>
                                         </li>
                                         <li class="nav-item" >
                                             <router-link class="nav-link" to="/user/single-bidpurchases"><i class="bi bi-people fa-fw me-2"></i> Single Bid Purchases</router-link>
                                         </li>

                                         <li class="nav-item" >
                                             <router-link class="nav-link" to="/user/my-purchasedbids"><i class="bi bi-people fa-fw me-2"></i>My Purchased Bids</router-link>
                                         </li>
                                     </ul> -->

                        <ul class="nav nav-pills-primary-soft flex-column">
                            <li class="nav-item">
                                <router-link class="nav-link" active-class="active" exact-active-class="active" to="/user/profile"> <i class="bi bi-person fa-fw me-2"></i>My Profile </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" active-class="active" exact-active-class="active" to="/user/change-password"> <i class="bi bi-person fa-fw me-2"></i>Account details </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" active-class="active" exact-active-class="active" to="/user/subscription"> <i class="bi bi-ticket-perforated fa-fw me-2"></i>Subscription Info </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        //  props: {
        //         payment: {
        //             type: Object,
        //         },
        //     },
        data() {
            return {};
        },
        methods: {},
    };
</script>
