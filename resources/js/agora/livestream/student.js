/**
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import firebase from "../../clients/commons/firebase";
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'

require('../../bootstrap');

import Vue from 'vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.prototype.$db = firebase.db;
Vue.prototype.$database = firebase.database;
Vue.prototype.$storage = firebase.storage;
Vue.directive('tooltip', {
    bind: function (el, binding) {
        $(el).tooltip();
        $(el).on('show.bs.tooltip', () => {
            setTimeout(function(){ $(el).tooltip('hide'); }, 2000);
        });
    },
    unbind: function (el) {
        $('.tooltip.show').remove();
    }
});
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("student-video-live-stream", require("../../components/livestream/StudentVideoLivestream").default);
Vue.component("student-join-course", require("../../components/livestream/StudentJoinCourse").default);
Vue.component("prepare-join-stream", require("../../components/livestream/PrepareJoinStream").default);
Vue.component("change-background", require("../../components/livestream/ChangeBackground").default);
Vue.component("purchase-gift", require("../../components/livestream/PurcharseDialog").default);
Vue.component("student-gift-shop", require("../../components/livestream/GiftShop").default);
Vue.component("student-box-chat", require("../../components/livestream/BoxChat").default);
Vue.component("box-extend", require("../../components/livestream/BoxExtend").default);
Vue.component("face-mark", require("../../components/livestream/FaceMark").default);
Vue.component("count-down", require("../../components/CountDown").default);
Vue.component("counter", require("../../components/Counter").default);
Vue.component('VueSlider', VueSlider);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const student = new Vue({
    el: '#student-livestream',
});
