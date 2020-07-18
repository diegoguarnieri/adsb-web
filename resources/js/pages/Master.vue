<template>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">ADS-B Dashboard</div>

            <div class="list-group list-group-flush">
                <a href="#" @click="loadPage('dashboard')" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                <a href="#" @click="loadPage('adsb')" class="list-group-item list-group-item-action bg-light">Realtime</a>
                <a href="#" @click="loadPage('console')" class="list-group-item list-group-item-action bg-light">Console</a>
                <a href="#" @click="loadPage('search')" class="list-group-item list-group-item-action bg-light">Search</a>
                <!--<a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>-->
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom" id="navbar">
                <button class="navbar-toggler" id="menu-toggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>

            <div class="container-fluid" style="margin-top: 1rem">

                <component :key="version" v-bind:is="page"></component>

                <!--<h1 class="mt-4">Simple Sidebar</h1>

                <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>

                <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>-->
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            version: 1,
            //page: 'dashboard'
            page: 'search'
        }
    },
    methods: {
        loadPage: function(page) {
            this.page = page
            this.version++
        }
    }
}
</script>

<style scoped>

#wrapper {
    overflow-x: hidden;
}

#sidebar-wrapper {
    min-height: 100vh;
    margin-left: -15rem;
    -webkit-transition: margin .25s ease-out;
    -moz-transition: margin .25s ease-out;
    -o-transition: margin .25s ease-out;
    transition: margin .25s ease-out;
}

#sidebar-wrapper .sidebar-heading {
    padding: 0.875rem 1.25rem;
    font-size: 1.2rem;
}

#sidebar-wrapper .list-group {
    width: 15rem;
}

#page-content-wrapper {
    min-width: 100vw;
}

#wrapper.toggled #sidebar-wrapper {
    margin-left: 0;
}

#navbar {
    display: none;
}

@media (max-width: 768px) {
    #navbar {
        display: block;
    }
}

@media (min-width: 768px) {

    #sidebar-wrapper {
        margin-left: 0;
    }

    #page-content-wrapper {
        min-width: 0;
        width: 100%;
    }

    #wrapper.toggled #sidebar-wrapper {
        margin-left: -15rem;
    }
}

</style>