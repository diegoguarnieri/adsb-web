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
        configs: Object
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
            if(this.configs.coordinates !== undefined) {

                this.map.eachLayer((layer) => {
                    console.log(layer)
                    //layer.remove()
                })

                this.map.setView(this.configs.coordinates[0], 10)

                //start point
                var cicle = L.circle(
                    this.configs.coordinates[0],
                    {
                        radius: 100,
                        color: this.configs.properties.color
                    }
                ).addTo(this.map)

                //end point
                var width = 0.001
                var bounds = [
                    [
                        this.configs.coordinates[this.configs.coordinates.length - 1][0] - width,
                        this.configs.coordinates[this.configs.coordinates.length - 1][1] - width
                    ],
                    [
                        this.configs.coordinates[this.configs.coordinates.length - 1][0] + width,
                        this.configs.coordinates[this.configs.coordinates.length - 1][1] + width
                    ]
                ]
                var rectangle = L.rectangle(
                    bounds,
                    this.configs.properties
                ).addTo(this.map);

                var polyline = L.polyline(
                    this.configs.coordinates,
                    this.configs.properties
                ).addTo(this.map)
                
                this.map.fitBounds(polyline.getBounds());
            }
        },
        initMap: function() {
            this.map = L.map('flight-map').setView([-23.39076, -51.067], 10)

            this.tileLayer = L.tileLayer(
                'https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png',
                {
                    maxZoom: 18,
                    attribution: '&copy; OpenStreetMap',
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