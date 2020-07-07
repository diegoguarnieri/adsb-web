<template>
    <div>
        <div class="google-map" ref="googleMap" id="googleMap"></div>

        <template v-if="Boolean(this.google) && Boolean(this.map)">
            <slot :google="google" :map="map" />
        </template>
    </div>
</template>

<script>
import GoogleMapsApiLoader from 'google-maps-api-loader'

export default {
    props: {
        mapConfig: Object,
        apiKey: String,
    },
    data() {
        return {
            google: null,
            map: null
        }
    },
    mounted() {
        GoogleMapsApiLoader({
            apiKey: this.apiKey
        }).then((google) => {
            this.google = google
            this.initializeMap()
        })
    },
    methods: {
        initializeMap() {
            const mapContainer = this.$refs.googleMap
            this.map = new this.google.maps.Map(mapContainer, this.mapConfig)
            
            console.log(this.map)
        }
    }
}
</script>

<style scoped>
.google-map {
    height: 70vh;
    width: 100%;
}
</style>
