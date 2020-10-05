<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        More Distant Tracks
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ICAO</th>
                                        <th>Callsign</th>
                                        <th>How Far?</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(track, key) in fartherTracks" :key="key">
                                        <td>
                                            <a href="#" @click="map(track.id)">
                                                <svg class="bi" width="14" height="14" fill="currentColor">
                                                    <use xlink:href="css/bootstrap-icons.svg#map"/>
                                                </svg>
                                            </a>
                                        </td>
                                        <td>{{ track.icao }}</td>
                                        <td>{{ track.callsign }}</td>
                                        <td>{{ track.howFar }}</td>
                                        <td>{{ track.date }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                    </div>

                    <div class="card-body">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                    </div>

                    <div class="card-body">
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
export default {
    data() {
        return {
            fartherTracks: [],
            flightId: '',
            version: 0
        }
    },
    beforeMount() {
        this.getData()
    },
    methods: {
        map: function(id) {
            this.flightId = id
            this.version++

            $('#map').modal('show')
        },
        getData: function() {
            axios({
                method: 'get',
                url: 'dashboard'
            })
            .then(response => {
                this.fartherTracks = response.data.fartherTracks
            })
            .catch(error => {
                console.log('error',error)
            })
        }
    }
}
</script>