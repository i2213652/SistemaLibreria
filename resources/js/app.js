require("./bootstrap");
import Vue from "vue";
import { createInertiaApp, InertiaLink } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress";
import axios from "axios";
import Vuelidate from "vuelidate";

InertiaProgress.init();
Vue.prototype.$route = route;
Vue.component("Link", InertiaLink);
Vue.prototype.$http = axios;
Vue.use(Vuelidate);
Vue.component("v-select", VueSelect.VueSelect);

createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin);

        new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
});
