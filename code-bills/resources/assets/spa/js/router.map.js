import LoginComponent from "./components/Login.vue";
import LogoutComponent from "./components/Logout.vue";
import DashboardComponent from "./components/Dashboard.vue";
import BankAccountComponent from "./components/bank-accounts/BankAccount.vue";
import BankAccountCreateComponent from "./components/bank-accounts/BankAccountCreate.vue";
import BankAccountListComponent from "./components/bank-accounts/BankAccountList.vue";

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
        component: BankAccountComponent,
        subRoutes: {
            '/': {
                name: 'bank-accounts.list',
                component: BankAccountListComponent
            },
            '/create': {
                name: 'bank-accounts.create',
                component: BankAccountCreateComponent
            },
            '/:id/update': {
                name: 'bank-accounts.update',
                component: BankAccountCreateComponent
            }
        }
    }
}
