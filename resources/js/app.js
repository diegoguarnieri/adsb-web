require('./bootstrap')

import Vue from 'vue'
import 'leaflet/dist/leaflet.css'
//import 'bootstrap-icons/bootstrap-icons.svg'

//Components
Vue.component('flight-map', require('./components/FlightMap.vue').default)

Vue.component('google-flight-map', require('./components/GoogleFlightMap.vue').default)
Vue.component('google-map-loader', require('./components/GoogleMapLoader.vue').default)
Vue.component('google-map-marker', require('./components/GoogleMapMarker.vue').default)
Vue.component('google-map-line', require('./components/GoogleMapLine.vue').default)

//Pages
Vue.component('adsb', require('./pages/Adsb.vue').default)

const app = new Vue({
    el: '#app',
})
