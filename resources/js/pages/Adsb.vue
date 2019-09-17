<template>
    <div>
        <div class="card">
            <div class="card-header clearfix">
                <div class="float-left">
                </div>

                <div class="float-right">
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
                            <tr v-for="(item, index) in items" :key="index">
                                <td>{{ item.icao }}</td>
                                <td>{{ item.callsign }}</td>
                                <td>{{ item.latitude }}</td>
                                <td>{{ item.longitude }}</td>
                                <td>{{ item.track }}</td>
                                <td>{{ item.altitude }}</td>
                                <td>{{ item.groundSpeed }}</td>
                                <td>{{ item.verticalSpeed }}</td>
                                <td>{{ item.squawk }}</td>
                                <td>{{ item.timestamp }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            route: 'adsb',
            items: []
        }
    },
    beforeMount() {
        this.getInitialItems()

        //this.connect()

        this.$options.sockets.onmessage = (data) => {
            console.log(data)

            this.updateItem(data.data)
        }

        /*var ws = new WebSocket('ws://172.16.3.50:8080');

        ws.onopen = function() {
            console.log('websocket is connected...')
            ws.send('connected')
        }

        ws.onmessage = function(ev) {
            console.log(ev);
            updateItem(ev.data)
            //parei aqui: Uncaught TypeError: this.updateItem is not a function
        }

        ws.onerror = function(error) {
            console.log(`WebSocket error: ${error}`)
        }

        ws.onclose = function() {
            console.log('WebSocket disconnected')
        }*/
    },
    /*socket: {
        events: {
            changes(msg) {
                console.log(msg)
            },
            connect() {
                console.log("Websocket connected to " + this.$socket.nsp);
            },
            disconnect() {
                console.log("Websocket disconnected from " + this.$socket.nsp);
            },
            error(err) {
                console.error("Websocket error!", err);
            }
        }
    },*/
    methods: {
        connect: function() {
            /*Vue.use(VueWebSocket, 'ws://172.16.3.50:8080', { 
                format: 'json',
                reconnection: true,
                reconnectionAttempts: 5000,
                reconnectionDelay: 300
            })

            this.$options.sockets.onmessage = (data) => console.log(data)*/

            /*this.socket = new VueWebSocket('ws://172.16.3.50:8080')

            this.socket.onopen = () => {
                console.log('websocket is connected...')

                this.socket.onmessage = ({data}) => {
                    console.log(data)
                }
            }*/
        },
        updateItem: function(data) {
            var item = JSON.parse(data)

            var items = this.items

            var found = false;
            Object.keys(items).forEach(key => {
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
            })

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
        },
        getInitialItems: function() {
            axios.get(this.route + '/active')
            .then(response => {
                this.items = response.data.items
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
