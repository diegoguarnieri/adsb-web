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
                            <tr>
                                <td></td>
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

        }
    },
    beforeMount() {
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
    }
}
</script>

<style scoped>

</style>
