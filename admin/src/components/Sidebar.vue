<template>
    <div class="sidebar sidebar-prime">
        <div class="sidebar-header">
            <!-- <a href="" class="sidebar-logo">PMS</a> -->
            <img src="../../src/assets/bidsportal_logo.png" class="logo" width="50" />
            <a href="" class="sidebar-logo ml-20">PMS & BATS</a>
        </div>
        <!-- sidebar-header -->
        <div id="sidebarMenu" class="sidebar-body">
            <div class="nav-group">
                <router-link to="/dashboard" class="nav-label">Dashboard</router-link>
            </div>
            <div class="nav-group">
                <a href="javascript:void(0)" class="nav-label">User Management</a>
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <router-link to="/role_groups" class="nav-link"><i class="ri-group-line"></i> <span>Role Groups</span></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/roles" class="nav-link"><i class="ri-user-star-line"></i> <span>Roles</span></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/users" class="nav-link"><i class="ri-user-line"></i> <span>Users</span></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link"><i class="ri-lock-line"></i> <span>Permissions</span></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/approval_settings" class="nav-link"><i class="ri-settings-4-line"></i> <span>Approval Settings</span></router-link>
                    </li>
                </ul>
            </div>
            <div class="nav-group">
                <router-link to="/configuration" class="nav-label">Configurations</router-link>
            </div>
            <div class="nav-group">
                <router-link to="/templates" class="nav-label">PMT Master Templates</router-link>
            </div>
            <div class="nav-group">
                <router-link to="/template_master_costs" class="nav-label">BATS Master Templates</router-link>
            </div>
            <div class="nav-group">
                <a href="javascript:void(0)" class="nav-label">Projects</a>
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <router-link to="/project/create" class="nav-link"><i class="ri-shape-line"></i> <span>New Project</span></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/projects" class="nav-link"><i class="ri-folder-add-line"></i> <span>Existing Project</span></router-link>
                    </li>
                </ul>
            </div>
            <!-- <div class="nav-group">
                <router-link to="/dashboard" class="nav-label">Projects</router-link>
            </div> -->
          
            <div class="nav-group">
                <router-link to="/dashboard" class="nav-label">Plan</router-link>
            </div>
            <div class="nav-group">
                <a href="javascript:void(0)" class="nav-label">Review</a>
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link"><i class="ri-group-line"></i> <span>DPR</span></router-link>
                    </li>
                </ul>
            </div>
            <div class="nav-group">
                <router-link to="/dashboard" class="nav-label">Analysis</router-link>
            </div>
            <div class="nav-group">
                <router-link to="/dashboard" class="nav-label">Forcasting</router-link>
            </div>
        </div>
    </div>
    <!-- sidebar -->
</template>
<script>
    export default {
        methods: {
            logout() {
                let vm = this;
                vm.$store.dispatch("setUser", null);
                vm.$router.push("/");
            },
        },
    };
</script>
<style scoped>
    .ml-20 {
        margin-left: 20px;
    }
</style>
