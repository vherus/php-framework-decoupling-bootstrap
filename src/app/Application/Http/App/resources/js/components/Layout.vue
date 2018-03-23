<template>

    <app-header></app-header>

    <div id="body">
        <app-navbar></app-navbar>

        <div id="body-content">
            <router-view></router-view>
        </div>
    </div>

</template>

<script>
    module.exports = {

        components: {
            'app-header': require('./Header.vue'),
            'app-navbar': require('./Navbar.vue')
        }

    };
</script>
