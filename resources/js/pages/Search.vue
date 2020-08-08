<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>ICAO</label>
                            <div class="input-group">
                                <input v-model="icao" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Callsign</label>
                            <div class="input-group">
                                <input v-model="callsign" type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label>Period</label>
                            <div class="input-group">
                                <input v-model="startDate" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <input v-model="endDate" type="text" class="form-control">
                            </div>
                        </div>
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
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(track, key) in tracks" :key="key">
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

        <!--Modal Map-->
        <div class="modal fade" id="map" tabindex="-1" role="dialog" aria-hidden="true">
            <modal-flight :flightId="flightId" :version="version"></modal-flight>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            tracks: [],
            icao: '',
            callsign: '',
            startDate: '',
            endDate: '',
            flightId: '',
            version: 0
        }
    },
    watch: {
        icao: function() {
            this.search()
        },
        callsign: function() {
            this.search()
        }
    },
    methods: {
        map: function(id) {
            this.flightId = id
            this.version++

            $('#map').modal('show')
        },
        search: function() {
            var icao = this.icao
            var callsign = this.callsign

            if(icao.length >= 3 || callsign.length >= 3) {
                let data = {
                    icao: icao,
                    callsign: callsign,
                    startDate: '',
                    endDate: ''
                }

                axios({
                    method: 'post',
                    url: 'adsb/search',
                    data: data
                })
                .then(response => {
                    this.tracks = response.data.tracks
                })
                .catch(error => {
                    console.log('error',error)
                })
            } else if(icao == '' && callsign == '') {
                this.tracks = []
            }
        }
    }
}
</script>