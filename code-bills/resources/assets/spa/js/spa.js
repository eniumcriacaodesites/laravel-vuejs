import LocalStorage from "./services/localStorage";
import appConfig from "./services/appConfig";

window.Vue = require('vue');
require('materialize-css');
require('vue-resource');

Vue.http.options.root = appConfig.api_url; // app laravel

require('./services/interceptors');
require('./router');

// Testing service of LocalStorage
console.log(LocalStorage.set('name', 'Laravel with Vue'));
console.log(LocalStorage.get('name'));
console.log(LocalStorage.get('name1'));
console.log(LocalStorage.get('name1', 'Value not found!'));
console.log(LocalStorage.remove('name'));

console.log(LocalStorage.setObject('obj', {name: 'Laravel with Vue', version: '1.0.0'}));
console.log(LocalStorage.getObject('obj'));
console.log(LocalStorage.getObject('obj1'));
console.log(LocalStorage.getObject('obj1', 'Object not found!'));
