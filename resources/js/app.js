require('./bootstrap')

import Vue from 'vue'
import VueWebSocket from 'vue-native-websocket'
//import VueWebsocket from 'vue-websocket'

//Vue.use(VueWebsocket, 'ws://172.16.3.50:8080')

Vue.use(VueWebSocket, 'ws://172.16.3.50:8080', { 
    format: 'json',
    reconnection: true,
    reconnectionAttempts: 5000,
    reconnectionDelay: 300
})

//Pages
Vue.component('adsb', require('./pages/Adsb.vue').default)


const app = new Vue({
    el: '#app',
})
