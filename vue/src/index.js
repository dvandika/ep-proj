import Vue from "vue";
import App from "./App.vue";
import store from "./store/index";
import VueRouter from "vue-router";
import Routes from "./routes";
import Vuesax from "vuesax";
import "vuesax/dist/vuesax.css";
import VueScrollStop from "vue-scroll-stop";

Vue.use(Vuesax);
Vue.use(VueScrollStop);

Vue.config.productionTip = false;
Vue.config.devtools = true;


Vue.use(VueRouter);
const router = new VueRouter({
    routes: Routes,
    mode: "history"
});

new Vue({
    render: h => h(App),
    store: store,
    router: router,
}).$mount("#app");