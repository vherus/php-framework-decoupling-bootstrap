<template>

    <header id="header-primary">

        <div>
            <div id="logo" class="float-left">
                <!-- a logo should go here -->
                <span>
                    Framework &nbsp; <i class="fa fa-star" aria-hidden="true"></i>
                </span>
            </div>

            <div id="links" class="float-right">
                <a href="#">You are logged in.</a>
                <button class="btn btn-outline-light" @click="logout" style="padding: 8px; margin-right: 20px">Logout</button>
            </div>

            <div class="clear-both"></div>
        </div>
    </header>

</template>
<script>
    module.exports = {

        data: function () {
            return {
                links: []
            };
        },

        ready: function() {
            var vue = this;
        },

        methods: {
            logout: function () {
                window.location = '/app';
            }
        }

    };
</script>