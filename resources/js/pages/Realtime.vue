<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#console">Console</button>
                </div>

                <div class="float-right">
                    <div v-if="socketStatus == 'open'" class="alert alert-success" role="alert">
                        Socket Connected
                    </div>

                    <div v-if="socketStatus == 'close'" class="alert alert-danger" role="alert">
                        Socket Not Connected!
                    </div>

                    <div v-if="socketStatus == 'initializing'" class="alert alert-warning" role="alert">
                        Socket Is Initializing!
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ICAO</th>
                                <th>Callsign</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Track</th>
                                <th>Altitude</th>
                                <th>Ground Speed</th>
                                <th>Vertical Speed</th>
                                <th>Squawk</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(track, key) in sortedTracks" :key="key">
                                <td>
                                    <a href="#" @click="map(track.id)">
                                        <svg class="bi" width="14" height="14" fill="currentColor">
                                            <use xlink:href="css/bootstrap-icons.svg#map"/>
                                        </svg>
                                    </a>
                                </td>
                                <td>{{ track.icao }}</td>
                                <td>{{ track.callsign }}</td>
                                <td>{{ track.latitude }}</td>
                                <td>{{ track.longitude }}</td>
                                <td>{{ track.track }}</td>
                                <td>{{ track.altitude }}</td>
                                <td>{{ track.groundSpeed }}</td>
                                <td>{{ track.verticalSpeed }}</td>
                                <td>{{ track.squawk }}</td>
                                <td>{{ track.updatedAt }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--Modal Console-->
        <div class="modal fade" id="console" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Console</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tr v-for="(socketEvent, key) in socketEvents.slice().reverse()" :key="key">
                                        <td>
                                            <span class="console">{{ socketEvent.type }}</span>
                                        </td>
                                        <td>
                                            <span class="console">{{ socketEvent.target }}</span>
                                        </td>
                                        <td>
                                            <span class="console">{{ socketEvent.code }}</span>
                                        </td>
                                        <td>
                                            <span class="console">{{ socketEvent.timestamp.toLocaleString() }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal Map-->
        <div class="modal fade" id="map" tabindex="-1" role="dialog" aria-hidden="true">
            <modal-flight :flightId="flightId" :version="version"></modal-flight>
        </div>

    </div>
</template>

<script>
import Vue from 'vue'
import VueWebSocket from 'vue-native-websocket'

//var socketHost = 'ws://172.16.3.120:2020'
var socketHost = 'ws://vpndiego.ddns.net:2020'

/*Vue.use(VueWebSocket, socketHost, { 
    format: 'json',
    reconnection: true,
    reconnectionAttempts: 5000,
    reconnectionDelay: 1000
})*/

Vue.use(VueWebSocket, socketHost, {
    connectManually: true,
    reconnection: true,
    reconnectionAttempts: 5000,
    reconnectionDelay: 1000
})

const vm = new Vue()

export default {
    data() {
        return {
            tracks: {},
            socketStatus: 'initializing',
            socketEvents: [],
            randon: '',
            version: 0,
            flightId: ''
        }
    },
    mounted() {
        this.getInitialItems()

        this.$options.sockets.onopen = (data) => {
            event = {
                type: data.type,
                target: data.target.url,
                code: null,
                timestamp: new Date()
            }
            this.socketEvents.push(event)

            if(this.socketStatus == 'close') {
                this.getInitialItems()
            }

            this.socketStatus = 'open'
        }

        this.$options.sockets.onclose = (data) => {
            if(this.socketStatus != 'close') {
                event = {
                    type: data.type,
                    target: data.target.url,
                    code: data.code,
                    timestamp: new Date()
                }
                this.socketEvents.push(event)
            }

            this.socketStatus = 'close'
        }

        this.$options.sockets.onerror = (data) => {
            event = {
                type: data.type,
                target: data.target.url,
                code: data.code,
                timestamp: new Date()
            }
            this.socketEvents.push(event)
        }

        this.$options.sockets.onmessage = (data) => {
            this.updateTrack(data.data)
        }

        vm.$connect()

        //vm.$connect('ws://localhost:9090/alternative/connection/', { format: 'json' })
        
        //vm.$disconnect()
    },
    computed: {
        sortedTracks: function() {
            if(this.randon == '') {
                console.log('randon',this.randon)
            }

            var tracks = []
            Object.keys(this.tracks).forEach(key => {
                tracks.push(this.tracks[key])
            })

            tracks.sort((a, b) => (a.timestamp < b.timestamp) ? 1 : -1)

            return tracks
        }
    },
    methods: {
        map: function(id) {
            this.flightId = id
            this.version++

            $('#map').modal('show')
        },
        trackDetail: function(id) {

        },
        updateTrack: function(data) {
            var track = JSON.parse(data)

            if(typeof this.tracks[track.id] == "undefined") {
                var obj = {
                    id: track.id,
                    icao: track.icao,
                    callsign: track.callsign,
                    latitude: track.latitude,
                    longitude: track.longitude,
                    track: track.track,
                    altitude: track.altitude,
                    groundSpeed: track.groundSpeed,
                    verticalSpeed: track.verticalSpeed,
                    squawk: track.squawk,
                    updatedAt: track.updatedAt,
                    timestamp: track.timestamp
                }

                this.tracks[track.id] = obj
            } else {
                if(track.callsign != null && track.callsign != '') this.tracks[track.id].callsign = track.callsign
                if(track.latitude != null && track.latitude != '') this.tracks[track.id].latitude = track.latitude
                if(track.longitude != null && track.longitude != '') this.tracks[track.id].longitude = track.longitude
                if(track.track != null && track.track != '') this.tracks[track.id].track = track.track
                if(track.altitude != null && track.altitude != '') this.tracks[track.id].altitude = track.altitude
                if(track.groundSpeed != null && track.groundSpeed != '') this.tracks[track.id].groundSpeed = track.groundSpeed
                if(track.verticalSpeed != null && track.verticalSpeed != '') this.tracks[track.id].verticalSpeed = track.verticalSpeed
                if(track.squawk != null && track.squawk != '') this.tracks[track.id].squawk = track.squawk
                this.tracks[track.id].updatedAt = track.updatedAt
                this.tracks[track.id].timestamp = track.timestamp
            }

            //only used to activate the filter - https://forum.vuejs.org/t/computed-property-not-updating/21148/11
            this.randon = Math.floor(Math.random() * 100)
        },
        getInitialItems: function() {
            axios({
                method: 'get',
                url: 'adsb/active'
            })
            .then(response => {
                this.tracks = response.data.tracks
            })
            .catch(error => {
                console.log('error',error)
            })
        },
        initializeSocket: function() {
            console.log(this.$options.sockets)            
        }
    }
}
</script>

<style scoped>

.console {
    font-family: 'Courier New', Courier, monospace;
}

</style>
