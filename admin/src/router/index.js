import { createRouter, createWebHashHistory } from "vue-router";
import store from '@/store/index.js';
import Login from "@/views/auth/Login.vue";
import ForgotPassword from "@/views/auth/ForgotPassword.vue";
import Profile from "@/views/auth/Profile.vue";
import Dashboard from "../views/Dashboard.vue";
import AddStateTender from "@/views/state_tenders/Create.vue";
import StateTenders from "@/views/state_tenders/Index.vue";

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

    
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
