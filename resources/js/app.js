/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/es'

Vue.use(ElementUI, { locale });

import Swal from 'sweetalert2'
window.Swal = Swal;

Vue.component('app', require('./components/App.vue').default);
Vue.component('Auth', require('./components/Auth.vue').default);

export const EventBus = new Vue();
window.EventBus = EventBus;

import router from './routes'; 


const app = new Vue({
    el: '#app',
    router
});
