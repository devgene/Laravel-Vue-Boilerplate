import Vue from 'vue';
import App from  './App.vue';
import router from './router';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import FlashMessage from '@smartweb/vue-flash-message';
Vue.use(FlashMessage);
Vue.use(BootstrapVue);

const app= new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
