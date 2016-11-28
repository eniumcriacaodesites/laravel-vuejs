window.Vue = require('vue');
require('materialize-css');
require('vue-resource');

Vue.http.options.root = "http://192.168.1.2:8000/api"; // app laravel

require('./router');
