import LoginComponent from "./components/Login.vue";
import LogoutComponent from "./components/Logout.vue";
import DashboardComponent from "./components/Dashboard.vue";
import BankAccountFormComponent from "./components/bank-accounts/BankAccountForm.vue";
import BankAccountListComponent from "./components/bank-accounts/BankAccountList.vue";
import BillPayFormComponent from "./components/bill-pay/BillPayForm.vue";
import BillPayListComponent from "./components/bill-pay/BillPayList.vue";
import BillReceiveFormComponent from "./components/bill-receive/BillReceiveForm.vue";
import BillReceiveListComponent from "./components/bill-receive/BillReceiveList.vue";

export default {
    '/login': {
        name: 'auth.login',
        component: LoginComponent,
        auth: false
    },
    '/logout': {
        name: 'auth.logout',
        component: LogoutComponent,
        auth: true
    },
    '/dashboard': {
        name: 'dashboard',
        component: DashboardComponent,
        auth: true
    },
    '/bank-accounts': {
        component: {
            template: '<router-view></router-view>'
        },
        subRoutes: {
            '/': {
                name: 'bank-accounts.list',
                component: BankAccountListComponent
            },
            '/create': {
                name: 'bank-accounts.create',
                component: BankAccountFormComponent
            },
            '/:id/update': {
                name: 'bank-accounts.update',
                component: BankAccountFormComponent
            }
        }
    },
    '/bill-pays': {
        component: {
            template: '<router-view></router-view>'
        },
        subRoutes: {
            '/': {
                name: 'bill-pays.list',
                component: BillPayListComponent
            },
            '/create': {
                name: 'bill-pays.create',
                component: BillPayFormComponent
            },
            '/:id/update': {
                name: 'bill-pays.update',
                component: BillPayFormComponent
            }
        }
    },
    '/bill-receives': {
        component: {
            template: '<router-view></router-view>'
        },
        subRoutes: {
            '/': {
                name: 'bill-receives.list',
                component: BillReceiveListComponent
            },
            '/create': {
                name: 'bill-receives.create',
                component: BillReceiveFormComponent
            },
            '/:id/update': {
                name: 'bill-receives.update',
                component: BillReceiveFormComponent
            }
        }
    }
}
