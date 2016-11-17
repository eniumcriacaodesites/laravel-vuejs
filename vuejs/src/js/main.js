import "./bootstrap";
import BillComponent from "./Bill.vue";
import DashboardComponent from "./Dashboard.vue";
import BillPayComponent from "./bill-pay/BillPay.vue";
import BillPayListComponent from "./bill-pay/BillPayList.vue";
import BillPayCreateComponent from "./bill-pay/BillPayCreate.vue";
import BillReceiveComponent from "./bill-receive/BillReceive.vue";
import BillReceiveListComponent from "./bill-receive/BillReceiveList.vue";
import BillReceiveCreateComponent from "./bill-receive/BillReceiveCreate.vue";

let VueRouter = require('vue-router');
let router = new VueRouter();

router.map({
    '/': {
        name: 'dashboard',
        component: DashboardComponent
    },
    '/bill-pays': {
        component: BillPayComponent,
        subRoutes: {
            '/': {
                name: 'bill-pay.list',
                component: BillPayListComponent
            },
            '/create': {
                name: 'bill-pay.create',
                component: BillPayCreateComponent
            },
            '/:id/update': {
                name: 'bill-pay.update',
                component: BillPayCreateComponent
            }
        }

    },
    '/bill-receive': {
        component: BillReceiveComponent,
        subRoutes: {
            '/': {
                name: 'bill-receive.list',
                component: BillReceiveListComponent
            },
            '/create': {
                name: 'bill-receive.create',
                component: BillReceiveCreateComponent
            },
            '/:id/update': {
                name: 'bill-receive.update',
                component: BillReceiveCreateComponent
            }
        }
    },
    '*': {
        component: DashboardComponent
    }
});

router.start({
    components: {
        'bill-component': BillComponent
    }
}, '#app');

router.redirect({
    '*': '/'
});
