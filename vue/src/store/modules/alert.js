var meta = document.getElementsByTagName("meta")["base-url"].content;
var meta2 = document.getElementsByTagName("meta")["site-url"].content;

if (meta2[meta2.length - 1] == '/') {
    meta2 = meta2.slice(0, meta2.length - 1);
}
var meta = meta.substr(meta.indexOf('/', 7));


const state = {
    type: null,
    message: null
};

const actions = {
    error({ commit }, message) {
        commit('error', message);
    },
    clear({ commit }) {
        commit('clear');
    }
};

const mutations = {
    error(state, message) {
        state.type = 'alert';
        state.message = message;
    }
};