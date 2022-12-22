require('./bootstrap');

import Vue from "vue";
import axios from "./axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import locale from "element-ui/lib/locale/lang/en";

Vue.use(ElementUI, { locale });

Vue.prototype.$axios = axios;

Vue.component('home', require('./components/Home').default);
Vue.component('register', require('./components/Register').default);

new Vue({
    el: '#app',
});
