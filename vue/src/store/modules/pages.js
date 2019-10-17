var meta = document.getElementsByTagName("meta")["base-url"].content;
var meta2 = document.getElementsByTagName("meta")["site-url"].content;

if (meta2[meta2.length - 1] == '/') {
    meta2 = meta2.slice(0, meta2.length - 1);
}
var meta = meta.substr(meta.indexOf('/', 7));
// var meta2 = meta2.substr(meta2.indexOf('/', 7));
// console.log(meta);
// console.log(meta2);


const state = {
    index: 0,
    base_url: meta,
    site_url: meta2
};
const getters = {
    index: state => {
        return state.index
    },
    base_url: state => {
        return state.base_url
    },
    site_url: state => {
        return state.site_url
    }
}

const mutations = {
    setIndex(state, data) {
        state.index = data;
    },
    clearIndex(state) {
        state.index = 0;
    }
};

const actions = {
    changeIndex: ({ commit }, payload) => {
        commit('setIndex', payload);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
}