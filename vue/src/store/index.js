import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist';

// import alert from './modules/alert';
import user from './modules/user';
import pages from './modules/pages';


Vue.use(Vuex)

const vuexPersist = new VuexPersist({
    key: 'ep-aski',
    storage: sessionStorage
});

export default new Vuex.Store({
    modules: {
        // alert,
        user,
        pages,
    },
    plugins: [vuexPersist.plugin],
    strict: process.env.NODE_ENV !== 'production'
});