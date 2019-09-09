import store from "./pages";

var base_url = store.state.base_url;
var site_url = store.state.site_url;

const state = {
    // untuk login status
    status: {
        loggingIn: false
    },
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
    login: state => {
        return state.login;
    },
    isLoggedIn: state => {
        return state.isLoggedIn;
    },
    user: state => {
        if (getters.isLoggedIn) {
            return state.user;
        }
        return null;
    }
};

const mutations = {
    loginRequest(state, user) {
        state.status = { request: true, user: user };
    },
    loginSuccess(state, user) {
        state.status = { success: true, user: user }
    },
    loginFailed(state, payload) {
        state.status = { failed: true, message: payload, user: null }
    },
    clearStatus(state) {
        state.status = {};
    },
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
        commit("loginRequest", form.get('username'));
        commit("setUserStatus", null);
        return axios.post(site_url + "/vendors/auth/do_login", form)
            .then(res => {
                commit("loginSuccess", form.get('username'));
                commit("setState", res.data);
                return true;
            })
            .catch(function(err) {
                commit("loginFailed", err.response.data.message);
                // console.log(error.response.data.message);
                commit("setUserStatus", "failed");
                return false;
                // commit("loginFailed")
            });
    },
    loginAdmin: ({ commit, state }, form) => {
        commit("loginRequest", form.get('username'));
        commit("setUserStatus", null);
        return axios.post(site_url + "/admins/auth/do_login", form)
            .then(res => {
                commit("loginSuccess", form.get('username'));
                commit("setState", res.data);
                return true;
            })
            .catch(function(err) {
                commit("loginFailed", err.response.data.message);
                commit("setUserStatus", "failed");
                return false;

            });
    },
    loginDebug: ({ commit, state }, role) => {
        commit("setUserStatus", null);
        let email = state.role[role];
        return axios
            .get(site_url + "/auth/authDebug/" + email)
            .then(response => {
                commit("setUserStatus", "success");
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
    // logout: ({ commit }, payload) => {
    //     commit("setUserStatus", null);
    //     commit("setState", null);
    //     let logoutURL = "";
    //     if (payload === "vendor") {
    //         logoutURL = site_url + "/vendors/logout";
    //     } else if (payload === "operator" || payload === "admin" || payload === "developer") {
    //         logoutURL = site_url + "/admins/logout";
    //     }
    //     return axios
    //         // .get(site_url + "/auth/logout")
    //         .get(logoutURL)
    //         .then(response => {
    //             console.log(logoutURL)
    //             commit("setUserStatus", "success");
    //             return getters.isLoggedIn;
    //         })
    //         .catch(function(error) {
    //             commit("setUserStatus", "failed");
    //         });
    // }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};