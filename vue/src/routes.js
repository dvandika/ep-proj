// Layouts
import DashboardLayout from "./layouts/DashboardLayout.vue";
// Authentication
import AuthVendor from "./pages/auth/AuthVendor.vue";
import AuthAdmin from "./pages/auth/AuthAdmin.vue";
import AuthDebug from "./pages/auth/AuthDebug.vue";
// Admin Dashboard
import ListOrdersheet from "./pages/admin/ListOrdersheet.vue";
import ListVendors from "./pages/admin/ListVendors.vue";
import ListUsers from "./pages/admin/ListUsers.vue";
import CreateUser from "./pages/admin/CreateUser.vue";
import CreateVendor from "./pages/admin/CreateVendor.vue";
// Vendor Dashboard
import VendorListOS from "./pages/vendor/ListOrdersheet.vue";
import VendorStock from "./pages/vendor/VendorStock.vue";
import VendorDashboard from "./pages/vendor/VendorDashboard.vue";
// Global Routes
import NotFound from "./pages/NotFound.vue";
import UnderConstructed from "./pages/UnderConstructed.vue";
// Vue
import store from "./store/index";

var site_url = store.getters['pages/site_url'];
var base_url = store.getters['pages/base_url'];


const isVendorAuth = (to, from, next) => {
    axios.get(site_url + '/vendors/auth')
        .then(res => {
            console.log('sukses');
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
                // next({ path: site_url + '/v1/dashboard' })
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
};

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
        path: site_url + "/v1/auth",
        beforeEnter: isNotVendor,
        alias: [site_url, base_url], // Ini default root
        component: AuthVendor
    },
    {
        name: "auth-admin",
        path: site_url + "/v1/admin-auth",
        beforeEnter: isNotAdmin,
        component: AuthAdmin
    },
    {
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
                name: "md-vendor",
                path: "vendor",
                component: ListVendors
            },
            {
                name: "md-users",
                path: "users",
                component: ListUsers
            }
        ]
    },
    // Dashboard Vendor
    {
        name: "vendor-dashboard",
        path: site_url + "/v1/dashboard",
        beforeEnter: isVendorAuth,
        component: DashboardLayout,
        children: [{
                name: "home-vendor",
                path: "home",
                component: VendorDashboard
            },
            {
                name: "vendor-os-list",
                path: "ordersheet",
                component: VendorListOS
            },
            {
                name: "vendor-stock",
                path: "stock",
                component: VendorStock
            }
        ]
    },
    {
        name: "under-constructed",
        path: site_url + "/v1/under-constructed",
        component: UnderConstructed
    },
    {
        name: "404",
        path: site_url + "/v1/notfound",
        component: NotFound
    }
    // {
    //     path: "*",
    //     redirect: "/v1/notfound"
    // }
]