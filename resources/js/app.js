require('./bootstrap');

import Vue from 'vue'

//Pages
Vue.component('adsb', require('./pages/Adsb.vue').default)


const app = new Vue({
    el: '#app',
});
