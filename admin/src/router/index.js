import { createRouter, createWebHashHistory } from "vue-router";
import store from '@/store/index.js';
import Login from "@/views/auth/Login.vue";
import ForgotPassword from "@/views/auth/ForgotPassword.vue";
import Profile from "@/views/auth/Profile.vue";
import Dashboard from "../views/Dashboard.vue";
import AddStateTender from "@/views/state_tenders/Create.vue";
import StateTenders from "@/views/state_tenders/Index.vue";

import AddFederalTender from "@/views/federal_tenders/Create.vue";
import FederalTenders from "@/views/federal_tenders/Index.vue";

import Users from "@/views/Users/Index.vue";

import Subscriptions from "@/views/Users/Subscription.vue";
import Alerts from "@/views/Users/Alerts.vue";

// admin managemnet
import CreateAdmin from "@/views/AdminManagement/Create.vue"
import Admins from "@/views/AdminManagement/Index.vue";

// agencies
import StateAgencies from "@/views/Agencies/State.vue";
import FederalAgencies from "@/views/Agencies/Federal.vue";

// notices
import StateNotices from "@/views/Notice/State.vue";
import FederalNotices from "@/views/Notice/Federal.vue";

// categories
import Categories from "@/views/Categories.vue";

const routes = [

    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/forgot_password",
        name: "ForgotPassword",
        component: ForgotPassword,
    },
    {
        path: "/profile",
        name: "profile",
        component: Profile,
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
    },
    {
        path: "/add_state_tender",
        name: "AddStateTender",
        component: AddStateTender,
    },
    {
        path: "/state_tenders",
        name: "StateTenders",
        component: StateTenders,
    },
    {
        path: "/state_tenders/:state_tender_id/edit", name: 'StateTender.Edit',
        component: AddStateTender,
    },

    // federal tender
    {
        path: "/add_federal_tender",
        name: "AddFederalTender",
        component: AddFederalTender,
    },
    {
        path: "/federal_tenders",
        name: "FederalTenders",
        component: FederalTenders,
    },
    {
        path: "/federal_tenders/:federal_tender_id/edit", name: 'FederalTender.Edit',
        component: AddFederalTender,
    },

    // users
    {
        path: "/users",
        name: "Users.Index",
        component: Users,
    },
    // subscription
    {
        path: "/subscriptions",
        name: "Subscriptions.Index",
        component: Subscriptions,
    },
    // alerts
    {
        path: "/alerts",
        name: "Alerts.Index",
        component: Alerts,
    },
    // admin users
    {
        path: "/admins",
        name: "Admins.Index",
        component: Admins,
    },
    {
        path: "/admin/create",
        name: "Admins.Create",
        component: CreateAdmin,
    },

    {
        path: "/admins/:admin_id/edit",
        name: "Admins.Edit",
        component: CreateAdmin,
    },

    // state agencies
    {
        path: "/state_agencies",
        name: "StateAgencies",
        component: StateAgencies,
    },
    // federal agencies
    {
        path: "/federal_agencies",
        name: "FederalAgencies",
        component: FederalAgencies,
    },

    // state notices
    {
        path: "/state_notices",
        name: "StateNotices",
        component: StateNotices,
    },
    // federal agencies
    {
        path: "/federal_notices",
        name: "FederalNotices",
        component: FederalNotices,
    },
    // categories
    {
        path: "/categories",
        name: "Categories",
        component: Categories,
    },


];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;