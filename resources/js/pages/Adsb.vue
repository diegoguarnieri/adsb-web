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

        this.$options.sockets.onmessage = (data) => {
            console.log(data)

            this.updateItem(data.data)
        }
    },
    methods: {
        updateItem: function(data) {
            var item = JSON.parse(data)

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
        sortItems: function() {
            var items = this.items

            items.sort((a, b) => (a.timestamp < b.timestamp) ? 1 : -1)

            this.items = items
        },
        getInitialItems: function() {
            axios.get(this.route + '/active')
            .then(response => {
                var items = response.data.items

                Object.keys(items).forEach(key => {
                    this.items.push(items[key])
                })

                this.sortItems()

                console.log(this.items)
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
