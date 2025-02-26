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
                                <h1 style="background-color: rgb(35, 207, 107);" class="avatar text-white avatar-xl rounded-circle border border-white border-3 shadow">{{$store.getters.user?.name.substring(0,1)}}</h1>
                            </div>
                            <h6 class="mb-0 fw-500">{{$store.getters.user?.name}}</h6>
                            <a style="color: #837f88;" href="javascript:void(0)" class="text-reset1 text-primary-hover1 small1">{{$store.getters.user?.email}}</a>
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
                                <router-link class="nav-link" active-class="active" exact-active-class="active" to="/user/profile">
                                    <!-- <i class="bi bi-person fa-fw me-2"></i> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    My Profile
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" active-class="active" exact-active-class="active" to="/user/change-password">
                                    <!-- <i class="bi bi-person fa-fw me-2"></i> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"
                                        ></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>

                                    Account details
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" active-class="active" exact-active-class="active" to="/user/subscription">
                                    <!-- <i class="bi bi-ticket-perforated fa-fw me-2"></i> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                        <line x1="2" x2="22" y1="10" y2="10"></line>
                                    </svg>
                                    Subscription Info
                                </router-link>
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
<style scoped>
    .icon {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 4px;
    }
    .fw-500 {
        font-weight: 500;
    }
</style>
