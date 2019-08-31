import store from "./pages";

var base_url = store.state.base_url;
var site_url = store.state.site_url;

const state = {
    isLoggedIn: false,
    user: null,
    userStatus: null,
    role: {
        admin: 'admin',
        operator: 'operator',
        vendor: 'vendor',
        developer: 'developer'
    }
};

const getters = {
    isLoggedIn: state => {
        return state.isLoggedIn;
    },
    user: state => {
        if (getters.isLoggedIn) {
            return state.user;
        }
        return null;
    },
};

const mutations = {
    setState(state, payload) {
        state.isLoggedIn = payload != null;
        state.user = payload;
    },
    setUserStatus(state, status) {
        state.userStatus = status;
    }
};

const actions = {
    loginVendor: ({ commit, state }, form) => {
        commit("setUserStatus", null);
        return axios.post(site_url + "/vendors/auth/do_login", form)
            .then(res => {
                console.log(res.data);
                route.push({ name: "vendor-dashboard" });
            })
            .catch(function(error) {
                console.log(error);
                commit("setUserStatus", "failed");
            });
    },

    loginAdmin: ({ commit, state }, { username, password }) => {
        commit("setUserStatus", null);
        let user = username;
        let pass = password;
        return axios.post(site_url + "/admins/auth/do_login", { user, pass })
            .then(response => {
                // console.log(response.data);
                // this.$router.push({ name: "admin-dashboard" })

                // console.log(response.request.responseURL);
                // window.location = response.request.responseURL;
            })
    },
    loginDebug: ({ commit, state }, role) => {
        commit("setUserStatus", null);
        let email = state.role[role];
        return axios
            .get(site_url + "/auth/authDebug/" + email)
            .then(response => {
                commit("setUserStatus", "success");
                // console.log(response.request.responseURL)
                window.location = response.request.responseURL;
            })
            .catch(function(error) {
                commit("setUserStatus", "failed");
            });
    },
    setUserState: ({ commit, state }, payload) => {
        commit("setUserStatus", "success");
        commit("setState", payload);
        return getters.isLoggedIn;
    },
    logout: ({ commit }) => {
        commit("setUserStatus", null);
        commit("setState", null);
        return axios
            .get(site_url + "/auth/logout")
            .then(response => {
                commit("setUserStatus", "success");
                return getters.isLoggedIn;
            })
            .catch(function(error) {
                commit("setUserStatus", "failed");
            });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};