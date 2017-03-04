import Vue from 'vue';

import VueRouter from 'vue-router';

import router from './routes';

import auth from './auth';

import axios from 'axios';

import jQuery from 'jquery';

import 'bootstrap-sass';

window.$ = window.jQuery = jQuery;

window.axios = axios;

window.Vue = Vue;

Vue.use(VueRouter);

Vue.component('app', require('./components/App.vue'));
Vue.component('navbar', require('./components/Navbar.vue'));
Vue.component('loader', require('./components/Loader.vue'));

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': 'Bearer ' + localStorage.getItem('snippful_id_token')
};

axios.defaults.baseURL = '/api';