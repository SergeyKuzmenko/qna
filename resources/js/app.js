window.$ = window.jQuery = require('jquery');
require('bootstrap')
require('admin-lte')
require('select2')
require('select2/dist/js/i18n/ru')
import axios from 'axios'
import Vue from 'vue';
import LikeComponent from "../components/LikeComponent";
import SubscribeQuestionComponent from "../components/SubscribeQuestionComponent";

axios.defaults.headers.common['X-CSRF-TOKEN'] = window._token
Vue.prototype.$http = axios;

window.Vue = Vue;

let app = new Vue({
    components: {
        'like-button': LikeComponent,
        'subscribe-question-button': SubscribeQuestionComponent
    },
    el: '#app'
})
