import LoginComponent from "./components/Login.vue";
import LogoutComponent from "./components/Logout.vue";
import DashboardComponent from "./components/Dashboard.vue";
import BankAccountFormComponent from "./components/bank-accounts/BankAccountForm.vue";
import BankAccountListComponent from "./components/bank-accounts/BankAccountList.vue";
import BillPayFormComponent from "./components/bill-pay/BillPayForm.vue";
import BillPayListComponent from "./components/bill-pay/BillPayList.vue";
import BillReceiveFormComponent from "./components/bill-receive/BillReceiveForm.vue";
import BillReceiveListComponent from "./components/bill-receive/BillReceiveList.vue";
import CategoryListComponent from "./components/category/CategoryList.vue";
import PlanAccountComponent from "./components/category/PlanAccount.vue";
import BillPayList from "./components/bill/bill-pay/BillPayList.vue";
import BillReceiveList from "./components/bill/bill-receive/BillReceiveList.vue";
import CashFlowListComponent from "./components/cash-flow/CashFlowList.vue";
import StatementListComponent from "./components/statement/StatementList.vue";

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
                component: BankAccountListComponent,
                auth: true
            },
            '/create': {
                name: 'bank-accounts.create',
                component: BankAccountFormComponent,
                auth: true
            },
            '/:id/update': {
                name: 'bank-accounts.update',
                component: BankAccountFormComponent,
                auth: true
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
                component: BillPayListComponent,
                auth: true
            },
            '/create': {
                name: 'bill-pays.create',
                component: BillPayFormComponent,
                auth: true
            },
            '/:id/update': {
                name: 'bill-pays.update',
                component: BillPayFormComponent,
                auth: true
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
                component: BillReceiveListComponent,
                auth: true
            },
            '/create': {
                name: 'bill-receives.create',
                component: BillReceiveFormComponent,
                auth: true
            },
            '/:id/update': {
                name: 'bill-receives.update',
                component: BillReceiveFormComponent,
                auth: true
            }
        }
    },
    '/categories': {
        name: 'categories.list',
        component: CategoryListComponent,
        auth: true
    },
    '/plan-account': {
        name: 'plan-account',
        component: PlanAccountComponent,
        auth: true
    },
    '/cash-flow': {
        name: 'cash-flow.list',
        component: CashFlowListComponent,
        auth: true
    },
    '/statement': {
        name: 'statement.list',
        component: StatementListComponent,
        auth: true
    },
    '/bill-pay': {
        component: {
            template: '<router-view></router-view>'
        },
        subRoutes: {
            '/': {
                name: 'bill-pay.list',
                component: BillPayList,
                auth: true
            },
        }
    },
    '/bill-receive': {
        component: {
            template: '<router-view></router-view>'
        },
        subRoutes: {
            '/': {
                name: 'bill-receive.list',
                component: BillReceiveList,
                auth: true
            },
        }
    },
}
