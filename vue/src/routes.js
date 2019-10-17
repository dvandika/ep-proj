// Layouts
import DashboardLayout from "./layouts/DashboardLayout.vue";

// Authentication
import AuthVendor from "./pages/auth/AuthVendor.vue";
import AuthAdmin from "./pages/auth/AuthAdmin.vue";
import AuthDebug from "./pages/auth/AuthDebug.vue";

// Admin Dashboard
import AdminDashboard from "./pages/admin/AdminDashboard.vue";
// Master Data
import ListMaterial from "./pages/admin/material/ListMaterial.vue";
import AddMaterial from "./pages/admin/material/AddMaterial.vue";
import ListVendors from "./pages/admin/vendor/ListVendor.vue";
import AddVendor from "./pages/admin/vendor/AddVendor.vue";
import ListUser from "./pages/admin/user/ListUser.vue";
import AddUser from "./pages/admin/user/AddUser.vue";
// Daily Report
import ListDailyReport from "./pages/admin/report/ListDailyReport.vue";
import TemplateDailyReport from "./pages/admin/report/TemplateDailyReport.vue";
import MaterialStock from "./pages/admin/stock/MaterialStock.vue";
import UploadStock from "./pages/admin/stock/UploadStock.vue";
import TemplateStock from "./pages/admin/stock/MaterialTemplate.vue";

import ListOrdersheet from "./pages/admin/ordersheet/ListOrdersheet.vue";
import UploadOrdersheet from "./pages/admin/ordersheet/UploadOrdersheet.vue"; // Add Ordersheet


// Vendor Dashboard
import VendorOrdersheet from "./pages/vendor/VendorOrdersheet.vue";
import VendorReport from "./pages/vendor/VendorReport.vue";
import VendorDashboard from "./pages/vendor/VendorDashboard.vue";
import VendorTemplateReport from "./pages/vendor/VendorTemplateReport.vue";
// Global Routes
import NotFound from "./pages/404.vue";
import Forbidden from "./pages/403.vue";
import UnderConstructed from "./pages/UnderConstructed.vue";

// Vue
import store from "./store/index";

var site_url = store.getters['pages/site_url'];
var base_url = store.getters['pages/base_url'];

const isVendorAuth = (to, from, next) => {
    axios.get(site_url + '/vendors/auth')
        .then(res => {
            store.dispatch("user/setUserState", res.data)
                .then(function(success) {
                    if (success) {
                        next();
                    }
                })
                .catch(err => next({
                    name: 'auth-vendor'
                }))
        })
        .catch(err => next({
            name: 'auth-vendor'
        }))
}

const isNotVendor = (to, from, next) => {
    axios.get(site_url + '/vendors/auth')
        .then(res => {
            next({ name: 'vendor-dashboard' })
        })
        .catch(err => {
            next();
        })
};

const isAdminAuth = (to, from, next) => {
    axios.get(site_url + '/admins/auth')
        .then(res => {
            store.dispatch("user/setUserState", res.data)
                .then(function(success) {
                    if (success) {
                        next();
                    }
                })
                .catch(err => next({
                    name: 'auth-admin'
                }))
        })
        .catch(err => next({
            name: 'auth-admin'
        }))
}

const isNotAdmin = (to, from, next) => {
    axios.get(site_url + '/admins/auth')
        .then(res => {
            next({ name: 'admin-dashboard' })
        })
        .catch(err => {
            next();
        })
};


export default [
    // authentication
    {
        name: "auth-vendor",
        path: site_url + "/v1/login",
        beforeEnter: isNotVendor,
        alias: [site_url, base_url], // Ini default root
        component: AuthVendor
    },
    {
        name: "auth-admin",
        path: site_url + "/v1/admin/login",
        beforeEnter: isNotAdmin,
        component: AuthAdmin
    },
    {
        // only on development
        name: "auth-debug",
        path: site_url + "/v1/auth-debug",
        component: AuthDebug
    },
    // Dashboard Admin
    {
        name: "admin-dashboard",
        path: site_url + "/v1/admin",
        beforeEnter: isAdminAuth,
        component: DashboardLayout,
        children: [{
                name: "admin-home",
                path: "home",
                component: AdminDashboard
            },
            {
                name: "list-os",
                path: "ordersheet",
                component: ListOrdersheet
            },
            {
                name: "upload-os",
                path: "ordersheet/upload",
                component: UploadOrdersheet
            },
            // vendor daily report
            {
                name: "list-daily-report",
                path: "report",
                component: ListDailyReport
            },
            {
                name: "template-daily-report",
                path: "report/template",
                component: TemplateDailyReport
            },

            {
                name: "material-stock",
                path: "stock",
                component: MaterialStock
            },
            {
                name: "upload-stock",
                path: "stock/upload",
                component: UploadStock
            },
            {
                name: "template-stock",
                path: "stock/template",
                component: TemplateStock
            },
            {
                name: "md-vendor",
                path: "vendor",
                component: ListVendors
            },
            {
                name: "add-vendor",
                path: "vendor/add",
                component: AddVendor
            },
            {
                name: "md-material",
                path: "material",
                component: ListMaterial,
            },
            {
                name: "add-material",
                path: "material/add",
                component: AddMaterial
            },
            {
                name: "md-user",
                path: "user",
                component: ListUser
            },
            {
                name: "add-user",
                path: "user/add",
                component: AddUser
            }
        ]
    },
    // Dashboard Vendor
    {
        name: "vendor-dashboard",
        path: site_url + "/v1/dashboard",
        alias: site_url + "/v1/",
        beforeEnter: isVendorAuth,
        component: DashboardLayout,
        children: [{
                name: "vendor-home",
                path: "home",
                component: VendorDashboard
            },
            {
                name: "vendor-os",
                path: "ordersheet",
                component: VendorOrdersheet // list & download
            },
            {
                name: "vendor-report",
                path: "report",
                component: VendorReport // sekaligus upload
            },
            {
                name: "vendor-template-report",
                path: "report/template",
                component: VendorTemplateReport
            }
        ]
    },
    {
        name: "under-constructed",
        path: site_url + "/v1/constructed/",
        component: DashboardLayout,
        children: [{
            name: "construct",
            path: "constructed",
            component: UnderConstructed
        }]
    },
    {
        name: "404",
        path: site_url + "/v1/error/404",
        component: NotFound
    },
    {
        name: "403",
        path: site_url + "/v1/error/403",
        component: Forbidden
    },
    {
        path: "*",
        redirect: "/v1/error/404"
    }
]