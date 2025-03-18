import { createRouter, createWebHashHistory } from "vue-router";
import store from '@/store/index.js';
import Login from "@/views/auth/Login.vue";
import ForgotPassword from "@/views/auth/ForgotPassword.vue";
import Profile from "@/views/auth/Profile.vue";
import Dashboard from "../views/Dashboard.vue";
import AddStateTender from "@/views/state_tenders/Create.vue";
import EditStateTender from "@/views/state_tenders/Edit.vue";
import StateTenders from "@/views/state_tenders/Index.vue";

import AddFederalTender from "@/views/federal_tenders/Create.vue";
import FederalTenders from "@/views/federal_tenders/Index.vue";
import DownloadFederalTenders from "@/views/federal_tenders/DownloadTenders.vue";

import AddInternationalTender from "@/views/international_tenders/Create.vue";
import InternationalTenders from "@/views/international_tenders/Index.vue";

import AddPrivateTender from "@/views/private_tenders/Create.vue";
import PrivateTenders from "@/views/private_tenders/Index.vue";

import Users from "@/views/Users/Index.vue";

import Subscriptions from "@/views/Users/Subscription.vue";
import Alerts from "@/views/Users/Alerts.vue";

// admin managemnet
import CreateAdmin from "@/views/AdminManagement/Create.vue"
import Admins from "@/views/AdminManagement/Index.vue";

// agencies
import StateAgencies from "@/views/Agencies/State.vue";
import FederalAgencies from "@/views/Agencies/Federal.vue";
import PrivateAgencies from "@/views/Agencies/Private.vue";
import InteranationalAgencies from "@/views/Agencies/International.vue";

// notices
import StateNotices from "@/views/Notice/State.vue";
import FederalNotices from "@/views/Notice/Federal.vue";
import PrivateNotices from "@/views/Notice/Private.vue";
import InternationalNotices from "@/views/Notice/International.vue";

// categories
import Categories from "@/views/Categories.vue";
import AwardTypes from "@/views/AwardTypes.vue";
import ContractTypes from "@/views/ContractTypes.vue";

import DuplicateStateTenders from "@/views/duplicate_state_tenders/Index.vue";

import DuplicatePrivateTenders from "@/views/duplicate_private_tenders/Index.vue";

import DuplicateInternationalTenders from "@/views/duplicate_international_tenders/Index.vue";

//Subscription
import SubscriptionPlans from "@/views/SubscriptionPlans/SubscriptionPlan.vue";

import DeleteTenders from "@/views/DeleteTenders.vue";

// alerts
import StateAlert from "@/views/Users/Alerts/StateAlert.vue";
import PrivateAlert from "@/views/Users/Alerts/PrivateAlert.vue";
import FederalAlert from "@/views/Users/Alerts/FederalAlert.vue";
import InternationalAlert from "@/views/Users/Alerts/InternationalAlert.vue";


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
    {
        path: "/state_tenders/:state_tender_id/nt", name: 'StateTender.EditNewTab',
        component: EditStateTender,
    },

    // private tenders
    {
        path: "/add_private_tender",
        name: "AddPrivateTender",
        component: AddPrivateTender,
    },
    {
        path: "/private_tenders",
        name: "PrivateTenders",
        component: PrivateTenders,
    },
    {
        path: "/private_tenders/:private_tender_id/edit", name: 'PrivateTender.Edit',
        component: AddPrivateTender,
    },

    // international tenders
    {
        path: "/add_international_tender",
        name: "AddInternationalTender",
        component: AddInternationalTender,
    },
    {
        path: "/international_tenders",
        name: "InternationalTenders",
        component: InternationalTenders,
    },
    {
        path: "/international_tenders/:international_tender_id/edit", name: 'InternationalTender.Edit',
        component: AddInternationalTender,
    },

    // federal tender
    {
        path: "/download_federal_tenders",
        name: "DownloadFederalTender",
        component: DownloadFederalTenders,
    },
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
        path: "/federal_tenders/:federal_tender_id/edit", name: 'EditFederalTender',
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

    {
        path: "/state_alerts",
        name: "StateAlert.Create",
        component: StateAlert,
    },
    {
        path: '/state_alerts/:alert_id/edit',
        name: 'StateAlert.Edit',
        component: StateAlert,
    },
    {
        path: "/private_alerts",
        name: "PrivateAlert.Create",
        component: PrivateAlert,
    },
    {
        path: '/private_alerts/:alert_id/edit',
        name: 'PrivateAlert.Edit',
        component: PrivateAlert,
    },
    {
        path: "/federal_alerts",
        name: "FederalAlert.Create",
        component: FederalAlert,
    },
    {
        path: '/federal_alerts/:alert_id/edit',
        name: 'FederalAlert.Edit',
        component: FederalAlert,
    },
    {
        path: "/international_alerts",
        name: "InternationalAlert.Create",
        component: InternationalAlert,
    },
    {
        path: '/international_alerts/:alert_id/edit',
        name: 'InternationalAlert.Edit',
        component: InternationalAlert,
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

    //Private agencies
    {
        path: "/private_agencies",
        name: "PrivateAgencies",
        component: PrivateAgencies,
    },

    //International agencies
    {
        path: "/interanational_agencies",
        name: "InteranationalAgencies",
        component: InteranationalAgencies,
    },

    // state notices
    {
        path: "/state_notices",
        name: "StateNotices",
        component: StateNotices,
    },
    // federal notices
    {
        path: "/federal_notices",
        name: "FederalNotices",
        component: FederalNotices,
    },
    // Private Notice
    {
        path: "/private_notices",
        name: "PrivateNotices",
        component: PrivateNotices,
    },

    //international notices
    {
        path: "/international_notices",
        name: "InternationalNotices",
        component: InternationalNotices,
    },
    // categories
    {
        path: "/categories",
        name: "Categories",
        component: Categories,
    },
    {
        path: "/award_types",
        name: "AwardTypes",
        component: AwardTypes,
    },
    {
        path: "/contract_types",
        name: "ContractTypes",
        component: ContractTypes,
    },

    {
        path: "/duplicate_state_tenders",
        name: "DuplicateStateTenders",
        component: DuplicateStateTenders,
    },

    {
        path: "/duplicate_private_tenders",
        name: "DuplicatePrivateTenders",
        component: DuplicatePrivateTenders,
    },

    {
        path: "/duplicate_international_tenders",
        name: "DuplicateInternationalTenders",
        component: DuplicateInternationalTenders,
    },

    //Subscription plans
    {
        path: "/subscription_plans",
        name: "SubscriptionPlans",
        component: SubscriptionPlans,
    },

    {
        path: "/delete_tenders",
        name: "DeleteTenders",
        component: DeleteTenders,
    },


];

const router = createRouter({
    history: createWebHashHistory('/admin'),
    routes,
});

export default router;
