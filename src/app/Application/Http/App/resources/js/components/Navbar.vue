<template>

    <nav id="navbar-primary">

        <ul>
            <li v-for="link in links">
                <a v-link="{path:link.uri}">{{link.title}}</a>
            </li>
        </ul>

    </nav>

</template>

<script>
    module.exports = {

        data: function () {
            return {
                links: [
                    {title:'Home', uri:'/'}
                ]
            };
        }

    };
</script>
