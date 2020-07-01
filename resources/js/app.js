require('./bootstrap')

import Vue from 'vue'
//import VueWebSocket from 'vue-native-websocket'

//Pages
Vue.component('adsb', require('./pages/Adsb.vue').default)

const app = new Vue({
    el: '#app',
})
