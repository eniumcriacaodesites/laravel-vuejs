// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// window.$ = window.jQuery = require('jquery');
// require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

require('materialize-css');

window.Vue = require('vue');
// require('vue-resource');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

// Vue.http.interceptors.push((request, next) => {
//     request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
//
//     next();
// });

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

$(document).ready(function () {

    $('select').material_select();

    $.extend($.fn.pickadate.defaults, {
        monthsFull: ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'],
        monthsShort: ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'],
        weekdaysFull: ['domingo', 'segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'],
        weekdaysShort: ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab'],
        today: 'hoje',
        clear: 'limpar',
        close: 'fechar',
        format: 'dddd, d !de mmmm !de yyyy',
        formatSubmit: 'yyyy/mm/dd',
    });

    // When a date is selected on the "from" picker,
    // get the date and split into an array.
    // Then set the lower limit of the "to" picker.
    let expires_from = $('#expires_from').pickadate({
        format: 'dd/mm/yyyy',
        selectYears: true,
        selectMonths: true,
        onClose: function () {
            let fromDate = createDateArray(this.get('select', 'yyyy-mm-dd'));
            if (fromDate.length === 3) {
                expires_to.data('pickadate').set('min', fromDate);
            } else {
                expires_to.data('pickadate').set('min', false);
            }
        }
    });

    // When a date is selected on the "to" picker,
    // get the date and split into an array.
    // Then set the upper limit of the "from" picker.
    let expires_to = $('#expires_to').pickadate({
        format: 'dd/mm/yyyy',
        selectYears: true,
        selectMonths: true,
        onClose: function () {
            let toDate = createDateArray(this.get('select', 'yyyy-mm-dd'));
            if (toDate.length === 3) {
                expires_from.data('pickadate').set('max', toDate);
            } else {
                expires_from.data('pickadate').set('max', false);
            }
        }
    });

    let canceled_from = $('#canceled_from').pickadate({
        format: 'dd/mm/yyyy',
        selectYears: true,
        selectMonths: true,
        onClose: function () {
            let fromDate = createDateArray(this.get('select', 'yyyy-mm-dd'));
            if (fromDate.length === 3) {
                canceled_to.data('pickadate').set('min', fromDate);
            } else {
                canceled_to.data('pickadate').set('min', false);
            }
        }
    });

    let canceled_to = $('#canceled_to').pickadate({
        format: 'dd/mm/yyyy',
        selectYears: true,
        selectMonths: true,
        onClose: function () {
            let toDate = createDateArray(this.get('select', 'yyyy-mm-dd'));
            if (toDate.length === 3) {
                canceled_from.data('pickadate').set('max', toDate);
            } else {
                canceled_from.data('pickadate').set('max', false);
            }
        }
    });

    // Create an array from the date while parsing each date unit as an integer
    function createDateArray(date) {
        date = date.split('-').map(function (value) {
            return +value;
        });

        date[1] = date[1] - 1; // The month with zero-as-index.

        return date;
    }
});
