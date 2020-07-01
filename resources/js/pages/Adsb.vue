<template>
    <div class="container">
        <div class="card" style="margin-top: 1rem">
            <div class="card-header clearfix">
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
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ICAO</th>
                                <th>Callsign</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Track</th>
                                <th>Altitude</th>
                                <th>Ground Speed</th>
                                <th>Vertical Speed</th>
                                <th>Squawk</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(track, key) in tracks" :key="key">
                                <td>{{ track.icao }}</td>
                                <td>{{ track.callsign }}</td>
                                <td>{{ track.latitude }}</td>
                                <td>{{ track.longitude }}</td>
                                <td>{{ track.track }}</td>
                                <td>{{ track.altitude }}</td>
                                <td>{{ track.groundSpeed }}</td>
                                <td>{{ track.verticalSpeed }}</td>
                                <td>{{ track.squawk }}</td>
                                <td>{{ track.timestamp }}</td>
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

                        <!--<div class="form-group">
                            <label for="taxRate">Tax Rate</label>
                            <div class="input-group">
                                <input v-model="taxRate" type="text" class="form-control">
                            </div>
                        </div>-->
                    </div>

                    <!--<div class="modal-footer"></div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import VueWebSocket from 'vue-native-websocket'

Vue.use(VueWebSocket, 'ws://172.16.3.120:2020', { 
    format: 'json',
    reconnection: true,
    reconnectionAttempts: 5000,
    reconnectionDelay: 1000
})

export default {
    data() {
        return {
            tracks: [],
            socketStatus: '',
            socketEvents: []
        }
    },
    beforeMount() {
        this.getInitialItems()

        this.$options.sockets.onopen = (data) => {
            event = {
                type: data.type,
                target: data.target.url,
                code: null,
                timestamp: new Date()
            }
            this.socketEvents.push(event)

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

        /*this.$options.sockets.reconnect = (data) => {
            console.log('reconnect',data)
        }*/

        this.$options.sockets.onmessage = (data) => {
            this.updateTrack(data.data)
        }
    },
    methods: {
        updateTrack: function(data) {
            var track = JSON.parse(data)

            console.log(track)

            if(this.tracks[track.id] === undefined) {
                var obj = {
                    icao: track.icao,
                    callsign: track.callsign,
                    latitude: track.latitude,
                    longitude: track.longitude,
                    track: track.track,
                    altitude: track.altitude,
                    groundSpeed: track.groundSpeed,
                    verticalSpeed: track.verticalSpeed,
                    squawk: track.squawk,
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
                if(track.timestamp != null && track.timestamp != '') this.tracks[track.id].timestamp = track.timestamp
            }
        },
        updateTrack2: function(data) {
            var track = JSON.parse(data)

            //var items = this.items

            var found = false;
            /*Object.keys(items).forEach(key => {
                if(String(this.items[key].icao).indexOf(item.icao) > -1) {
                    this.items[key].callsign = item.callsign
                    this.items[key].latitude = item.latitude
                    this.items[key].longitude = item.longitude
                    this.items[key].track = item.track
                    this.items[key].altitude = item.altitude
                    this.items[key].groundSpeed = item.groundSpeed
                    this.items[key].verticalSpeed = item.verticalSpeed
                    this.items[key].squawk = item.squawk
                    this.items[key].timestamp = item.timestamp

                    found = true
                }
            })*/

            for(let i = 0; i < this.items.length; i++) {
                if(String(this.items[i].icao).indexOf(item.icao) > -1) {
                    if(item.callsign != null && item.callsign != '' && item.callsign != 'RM' && item.callsign != 'SL') {
                        this.items[i].callsign = item.callsign
                    }

                    if(item.latitude != null && item.latitude != '') {
                        this.items[i].latitude = item.latitude
                    }

                    if(item.longitude != null && item.longitude != '') {
                        this.items[i].longitude = item.longitude
                    }

                    if(item.track != null && item.track != '') {
                        this.items[i].track = item.track
                    }

                    if(item.altitude != null && item.altitude != '') {
                        this.items[i].altitude = item.altitude
                    }

                    if(item.groundSpeed != null && item.groundSpeed != '') {
                        this.items[i].groundSpeed = item.groundSpeed
                    }

                    if(item.verticalSpeed != null && item.verticalSpeed != '') {
                        this.items[i].verticalSpeed = item.verticalSpeed
                    }
                    
                    if(item.squawk != null && item.squawk != '') {
                        this.items[i].squawk = item.squawk
                    }

                    if(item.timestamp != null && item.timestamp != '') {
                        this.items[i].timestamp = item.timestamp
                    }

                    found = true
                }
            }

            if(!found) {
                var obj = {
                    icao: item.icao,
                    callsign: item.callsign,
                    latitude: item.latitude,
                    longitude: item.longitude,
                    track: item.track,
                    altitude: item.altitude,
                    groundSpeed: item.groundSpeed,
                    verticalSpeed: item.verticalSpeed,
                    squawk: item.squawk,
                    timestamp: item.timestamp
                }

                this.items.push(obj)
            }

            this.sortItems()

            console.log(this.items)
        },
        /*sortItems: function() {
            var items = this.items

            items.sort((a, b) => (a.timestamp < b.timestamp) ? 1 : -1)

            this.items = items
        },*/
        getInitialItems: function() {
            axios.get('adsb/active')
            .then(response => {
                this.tracks = response.data.tracks
                //console.log(this.tracks)

                /*Object.keys(items).forEach(key => {
                    this.items.push(items[key])
                })

                this.sortItems()*/
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

.console {
    font-family: 'Courier New', Courier, monospace;
}

</style>
