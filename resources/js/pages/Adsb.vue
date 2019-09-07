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

        var ws = new WebSocket('ws://172.16.3.50:8080');

        ws.onopen = function() {
            console.log('websocket is connected...')
            ws.send('connected')
        }

        ws.onmessage = function(ev) {
            console.log(ev);
        }

        ws.onerror = function(error) {
            console.log(`WebSocket error: ${error}`)
        }

        ws.onclose = function() {
            console.log('WebSocket disconnected')
        }
    },
    methods: {
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
