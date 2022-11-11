/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
window.Vue = require("vue");
import Vuetify from "vuetify";
import "@mdi/font/css/materialdesignicons.css";
import '@fortawesome/fontawesome-free/css/all.css';
import "vuetify/dist/vuetify.min.css";
import Auth from "./auth";
import router from "./routes";
import VueTheMask from "vue-the-mask";
import VCurrencyField from 'v-currency-field'

Vue.use(VueTheMask);
Vue.use(Vuetify);
Vue.prototype.$auth = new Auth(window.user);
Vue.use(VCurrencyField, {
    locale: 'pt-BR',
    decimalLength: 2,
    autoDecimalMode: true,
    min: null,
    max: null,
    defaultValue: 0
})

// Vue.component(
//     "example-component",
//     require("./components/ExampleComponent.vue").default
// );
Vue.component("Admin", require("./components/Admin.vue").default);

const opts = {};
const app = new Vue({
    el: "#app",
    router,
    vuetify: new Vuetify(opts)
});
