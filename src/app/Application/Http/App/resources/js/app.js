var Vue = require('vue');
var VueRouter = require('vue-router');
var VueResource = require('vue-resource');

Vue.use(VueResource);
Vue.use(VueRouter);

var App = Vue.extend({
    ready: function () {
        Vue.http.headers.common['AuthorizationToken'] = document.querySelector('#token').getAttribute('value');
    },

    data: function () {
        return {
            defaultErrorHandler: function (response) {

                if (response.status == 401) {
                    alert('You don\'t have permission to do that');
                    return;
                }

                alert('An unexpected error occurred. Please wait a few moments and try again.');
            }
        }
    },

    components: {
        'app-layout': require('./components/Layout.vue')
    }
});

// Bind routes
var router = new VueRouter();
router.map({
    '/': { component: require('./components/Homepage.vue') }
});

// Hit it
router.start(App, '#app');
