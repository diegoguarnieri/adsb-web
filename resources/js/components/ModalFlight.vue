<template>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Flight Route</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <flight-map :configs="configs" :versionA="versionA" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        flightId: {
            type: String,
            required: true
        },
        version: {
            type: Number,
            required: true
        }
    },
    watch: {
        /*flightId: function(newValue, oldValue) {
            if(newValue != '') {
                this.getCoordinates()
                this.version++
            }
        },*/
        version: function(newValue, oldValue) {
            this.getCoordinates()
        }
    },
    data() {
        return {
            configs: {},
            versionA: 0
        }
    },
    methods: {
        getCoordinates: function() {
            axios({
                method: 'get',
                url: 'adsb/coordinate/' + this.flightId
            })
            .then(response => {
                this.configs = {
                    coordinates: response.data.coordinates,
                    properties: {
                        color: '#' + Math.floor(Math.random()*16777215).toString(16)
                    }
                }

                this.versionA++
            })
            .catch(error => {
                console.log('error',error)
            })
        }
    }
}
</script>