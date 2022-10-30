import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Dashboard from "./pages/Dashboard";
import Settings from "./pages/Settings";
import Users from "./pages/Users";
import Roles from "./pages/Roles";
import Permissions from "./pages/Permissions";
import Activities from "./pages/Activities";
import Proprietarios from "./pages/Proprietarios";
import Unidades from "./pages/Unidades";
import Taxas from "./pages/Taxas";
import Debitos from "./pages/Debitos";
import Acordos from "./pages/Acordos";
import AcordoNovo from "./pages/AcordoNovo";

const routes = [
    {
        path: "/admin/",
        component: Dashboard
    },
    {
        path: "/admin/users",
        component: Users
    },
    {
        path: "/admin/roles",
        component: Roles
    },
    {
        path: "/admin/permissions",
        component: Permissions
    },
    {
        path: "/admin/settings",
        component: Settings
    },
    {
        path: "/admin/activities",
        component: Activities
    },
    {
        path: "/admin/unidades",
        component: Unidades
    },
    {
        path: "/admin/proprietarios",
        component: Proprietarios
    },
    {
        path: "/admin/taxas",
        component: Taxas
    },
    {
        path: "/admin/debitos",
        component: Debitos
    },
    {
        path: "/admin/acordos",
        component: Acordos
    },
    {
        path: "/admin/acordo_novo",
        component: AcordoNovo
    }
];

const router = new VueRouter({
    mode: "history",
    routes
});

export default router;
