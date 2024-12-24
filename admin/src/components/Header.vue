<template>
    <nav class="header-main px-3 px-lg-4 sidebar-prime navbar navbar-expand-lg">
        <a class="navbar-brand" href="javascript:void(0)" style="margin-right: 0;">
            <img src="../../src/assets/bidsportal_logo.png" class="logo" width="100" />
            <span href="javascript:void(0)" class="sidebar-logo ml-20"><span class="title">BidsPortal </span></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="nav">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0)"
                        role="button" aria-expanded="false">Bids</a>
                    <ul class="dropdown-menu">
                        <!-- <li>
                            <router-link to="/add_state_tender" class="dropdown-item"><i class="ri-donut-chart-fill"></i> Add State Bid</router-link>
                        </li> -->
                        <li>
                            <router-link to="/state_tenders" class="dropdown-item"><i class="ri-donut-chart-fill"></i>
                                State Bids</router-link>
                        </li>
                        <li>
                            <router-link to="/duplicate_state_tenders" class="dropdown-item"><i
                                    class="ri-donut-chart-fill"></i>
                                Duplicate State Bids</router-link>
                        </li>
                        <li>
                            <router-link to="/federal_tenders" class="dropdown-item"><i class="ri-donut-chart-fill"></i>
                                Federal Bids</router-link>
                        </li>
                        <li>
                            <router-link to="/private_tenders" class="dropdown-item"><i class="ri-donut-chart-fill"></i>
                                Private Bids</router-link>
                        </li>
                        <li>
                            <router-link to="/international_tenders" class="dropdown-item"><i class="ri-donut-chart-fill"></i>
                                International Bids</router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0)"
                        role="button" aria-expanded="false">Users</a>
                    <ul class="dropdown-menu">
                        <li>
                            <router-link to="/users" class="dropdown-item"><i class="ri-group-line"></i>
                                Users</router-link>
                        </li>
                        <li>
                            <router-link to="/subscriptions" class="dropdown-item"><i
                                    class="ri-money-dollar-circle-line"></i> Subscriptions</router-link>
                        </li>
                        <li>
                            <router-link to="/alerts" class="dropdown-item"><i class="ri-error-warning-line"></i>
                                Alerts</router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <router-link to="/admins" class="nav-link">Admin Management</router-link>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0)"
                        role="button" aria-expanded="false">Agencies</a>
                    <ul class="dropdown-menu">
                        <li>
                            <router-link to="/federal_agencies" class="dropdown-item"><i class="ri-star-line"></i>
                                Federal Agencies</router-link>
                        </li>
                        <li>
                            <router-link to="/state_agencies" class="dropdown-item"><i class="ri-government-line"></i>
                                State Agencies</router-link>
                        </li>
                        <li>
                            <router-link to="/private_agencies" class="dropdown-item"><i class="ri-building-line"></i>
                                Private Agencies</router-link>
                        </li>
                        <li>
                            <router-link to="/interanational_agencies" class="dropdown-item"><i
                                    class="ri-global-line"></i> International Agencies</router-link>
                        </li>

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0)"
                        role="button" aria-expanded="false">Notices</a>
                    <ul class="dropdown-menu">
                        <li>
                            <router-link to="/federal_notices" class="dropdown-item"><i class="ri-star-line"></i>
                                Federal Notices</router-link>
                        </li>
                        <li>
                            <router-link to="/state_notices" class="dropdown-item"><i class="ri-government-line"></i>
                                State Notices</router-link>
                        </li>
                        <li>
                            <router-link to="/private_notices" class="dropdown-item"><i class="ri-building-line"></i>
                                Private Notices</router-link>
                        </li>
                        <li>
                            <router-link to="/international_notices" class="dropdown-item"><i
                                    class="ri-global-line"></i> International Notices</router-link>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <router-link to="/categories" class="nav-link">Category</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/subscription_plans" class="nav-link">Subscription Plans</router-link>
                </li>
            </ul>
            <div class="dropdown dropdown-profile ms-3 ms-xl-4 mt-4" v-if="$store.getters.user">
                <a href="#" class="dropdown-link d-flex" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <div class="text-end me-2">
                        <h6 class="mb-0 text-white fw-semibold">{{ $store.getters.user.name }}</h6>
                        <p class="fs-sm text-white">
                            {{ $store.getters.user?.first_name + ' ' + $store.getters.user?.last_name }}
                        </p>
                    </div>
                    <div class="avatar online"><img src="/admin/assets/img/user.png" alt="" /></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end mt-10-f">
                    <div class="dropdown-menu-body">
                        <nav class="nav">
                            <router-link to="/profile"><i class="ri-edit-2-line"></i> Edit Profile</router-link>
                        </nav>
                        <hr />
                        <nav class="nav">
                            <a href="javascript:void(0)" @click.prevent="logout()"><i class="ri-logout-box-r-line"></i>
                                Log Out</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
<script>
export default {
    name: "Header",
    data() {
        return {
            project_label_status: true,
            project_label: "Project Management",
            permissions: [],
            project_groups: [],
            project_types: [],
            project_categories: [],
            projects: [],
            project_group_projects: [],
            meta: {
                project_group_id: "",
                project_type_id: "",
                project_category_id: "",
                project_id: "",
            },
        };
    },
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            console.log(to);
        });
    },
    mounted() {
    },

    methods: {

        logout() {
            let vm = this;
            let loader = vm.$loading.show();
            vm.$store
                .dispatch("post", { uri: "adminLogout", data: vm.$store.getters.user })
                .then(function () {
                    loader.hide();
                    vm.$store.dispatch("logout");
                    vm.$router.push("/");
                })
                .catch(function (error) {
                    loader.hide();
                    vm.errors = error.response.data.errors;
                    vm.$store.dispatch("error", error.response.data.message);
                });
        },
    },
};
</script>
<style scoped>
.sidebar-prime1 {
    background-color: #506fd9;
    background-image: linear-gradient(to bottom, #324daa, #506fd9);
}

.header-main .nav-link {
    color: lavender;
}

.header-main .nav-link.active {
    font-weight: 600;
    color: white;
    letter-spacing: -0.1px;
}

.collpase {
    background-color: #506fd9;
    background-image: linear-gradient(to bottom, #324daa, #506fd9);
}

.show {
    background-color: #506fd9;
}

.dropdown-menu {
    background-color: white !important;
}

@media (min-width: 992px) {
    .navbar-expand-lg .navbar-collapse {
        display: flex !important;
        flex-basis: auto;
        justify-content: space-between;
    }
}

/* drop down */
.dropdown-menu li {
    position: relative;
}

.dropdown-menu .dropdown-submenu {
    display: none;
    position: absolute;
    left: 100%;
    top: -7px;
}

.dropdown-menu .dropdown-submenu-left {
    right: 100%;
    left: auto;
}

.dropdown-menu>li:hover>.dropdown-submenu {
    display: block;
}

.sub_title {
    font-size: 12px;
    padding-left: 10px;
    font-weight: 200;
}

.title {
    font-weight: bold;
    font-size: 25px;
    padding-left: 10px;
    padding-bottom: 0px;
    letter-spacing: 2px;
    display: block !important;
    margin-bottom: -10px;
}

.font_size {
    font-size: 10pt;
    margin-right: 4em;
}
</style>