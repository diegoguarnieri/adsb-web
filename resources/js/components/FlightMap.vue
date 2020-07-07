<template>
    <google-map-loader :mapConfig="mapConfig" :apiKey="apiKey">
        <template slot-scope="{ google, map }">
            <!--<google-map-marker
                v-for="marker in markers"
                :key="marker.id"
                :marker="marker"
                :google="google"
                :map="map"
            />-->

            <google-map-line
                v-for="line in lines"
                :key="line.id"
                :path.sync="line.path"
                :google="google"
                :map="map"
            />
        </template>
    </google-map-loader>
</template>

<script>
export default {
    props: {
        lines: Array
    },
    data() {
        return {
            apiKey: 'AIzaSyBZBnpFW9t9Y13wdYc7j0XXQ1igkfPMIYc',
            /*markers: [
                { id: 'a', position: { lat: 3, lng: 101 } },
                { id: 'b', position: { lat: 5, lng: 99 } },
                { id: 'c', position: { lat: 6, lng: 97 } },
            ],*/
            /*lines: [
                { id: '1', path: [{ lat: 3, lng: 101 }, { lat: 5, lng: 99 }] },
                { id: '2', path: [{ lat: 5, lng: 99 }, { lat: 6, lng: 97 }] }
            ],*/
        }
    },
    computed: {
        mapConfig () {
            return {
                //...mapSettings,
                //center: { lat: 0, lng: 0 }
                //center: this.mapCenter,
                center: { lat: -23.5686, lng: -51.3655},
                zoom: 10
            }
        },
        /*mapCenter () {
            return this.lines[1].position
        }*/
    },
}
</script>