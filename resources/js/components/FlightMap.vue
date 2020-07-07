<template>
    <div>
        <div class="flight-map" id="flight-map"></div>
    </div>
</template>

<script>
import L from 'leaflet'

export default {
    props: {
        version: null,
        coordinates: Array
    },
    watch: {
        version: function(newValue, oldValue) {
            var that = this
            setTimeout(function() {
                that.map.invalidateSize() 
                that.refresh()
            }, 500)
        }
    },
    data() {
        return {
            map: null,
            tileLayer: null
        }
    },
    mounted() {
        this.initMap()
    },
    methods: {
        refresh: function() {
            if(this.coordinates[0] !== undefined) {
                this.map.setView(this.coordinates[0], 10)
            }

            var polyline = L.polyline(this.coordinates, {color: 'red'}).addTo(this.map)

            /*var latlngs = [
                [-23.39076, -51.067],
                [-23.39127, -51.06805],
                [-23.39539, -51.07664],
                [-23.39557, -51.07707],
                [-23.39837, -51.08287]
            ]
            var polyline = L.polyline(latlngs, {color: 'red'}).addTo(this.map)*/
        },
        initMap: function() {
            this.map = L.map('flight-map').setView([-23.39076, -51.067], 10)

            this.tileLayer = L.tileLayer(
                'https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png',
                {
                    maxZoom: 18,
                    //attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>',
                }
            )

            this.tileLayer.addTo(this.map)

            //var marker = L.marker([38.63, -90.23]).addTo(this.map);

            /*var latlngs = [
                [38.742302, -90.203934],
                [38.754886, -90.191746],
                [38.63, -90.23]
            ]*/

            //var polyline = L.polyline(latlngs, {color: 'red'}).addTo(this.map)
        }
    }
}
</script>

<style scoped>
    .flight-map {
        height: 70vh;
        /*width: 100%;*/
    }
</style>