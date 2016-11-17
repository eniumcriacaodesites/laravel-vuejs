require('../sass/app.scss');

require('./filters');
require('./resources');

require([
    './bill.component',
    './dashboard.component',

    './bill-pay/bill-pay.component',
    './bill-pay/bill-pay-list.component',
    './bill-pay/bill-pay-create.component',

    './bill-receive/bill-receive.component',
    './bill-receive/bill-receive-list.component',
    './bill-receive/bill-receive-create.component'
], function (billComponent,
             dashboardComponent,
             billPayComponent,
             billPayListComponent,
             billPayCreateComponent,
             billReceiveComponent,
             billReceiveListComponent,
             billReceiveCreateComponent) {

    let router = new VueRouter();

    router.map({
        '/': {
            name: 'dashboard',
            component: dashboardComponent
        },
        '/bill-pays': {
            component: billPayComponent,
            subRoutes: {
                '/': {
                    name: 'bill-pay.list',
                    component: billPayListComponent
                },
                '/create': {
                    name: 'bill-pay.create',
                    component: billPayCreateComponent
                },
                '/:id/update': {
                    name: 'bill-pay.update',
                    component: billPayCreateComponent
                }
            }

        },
        '/bill-receive': {
            component: billReceiveComponent,
            subRoutes: {
                '/': {
                    name: 'bill-receive.list',
                    component: billReceiveListComponent
                },
                '/create': {
                    name: 'bill-receive.create',
                    component: billReceiveCreateComponent
                },
                '/:id/update': {
                    name: 'bill-receive.update',
                    component: billReceiveCreateComponent
                }
            }
        },
        '*': {
            component: dashboardComponent
        }
    });

    router.start({
        components: {
            'bill-component': billComponent
        }
    }, '#app');

    router.redirect({
        '*': '/'
    });

});
