
/**
* Vue is a modern JavaScript library for building interactive web interfaces
* using reactive data binding and reusable components. Vue's API is clean
* and simple, leaving you to focus on building your next great project.
*/

window.Vue = require('vue');
require('vue-resource');

/**
* We'll register a HTTP interceptor to attach the "CSRF" header to each of
* the outgoing requests issued by this application. The CSRF middleware
* included with Laravel will automatically verify the header's value.
*/

Vue.http.interceptors.push((request, next) => {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

    next();
});

require('./vue-components')
require('./vue-directives')

Vue.config.debug = true

Vue.component('select-group', {
    component: "<div><slot></slot></div>",
    events: {
        'synced-select:changed': function (name, val) {
            this.$broadcast('synced-select:updated', name, val)
        }
    }
})
