window.$ = window.jQuery = require('jquery');
require('bootstrap')
require('admin-lte')
require('select2')
require('select2/dist/js/i18n/ru')
import axios from 'axios'
import hljs from 'highlight.js';
import Vue from 'vue';
import LikeComponent from "../components/LikeComponent";
import SubscribeQuestionComponent from "../components/SubscribeQuestionComponent";
import AnswerForm from '../components/AnswerForm'
import CommentForm from '../components/CommentForm'

axios.defaults.headers.common['X-CSRF-TOKEN'] = window._token
Vue.prototype.$http = axios;

window.Vue = Vue;

const app = new Vue({
    components: {
        'like-button': LikeComponent,
        'subscribe-question-button': SubscribeQuestionComponent,
        'answer-form': AnswerForm,
        'comment-form': CommentForm
    },
    el: '#app'
})
