export class Jwt {
    static accessToken(email, password) {
        return Vue.http.post('access_token', {
            email: email,
            password: password
        });
    }

    static refreshToken() {
        return Vue.http.post('refresh_token');
    }

    static logout() {
        return Vue.http.post('logout');
    }
}

let User = Vue.resource('user');
let BankResource = Vue.resource('banks');
let BankAccountResource = Vue.resource('bank_accounts{/id}', {}, {
    lists: {method: 'GET', url: 'bank_accounts/lists'}
});
let BillPayResource = Vue.resource('bill_pays{/id}', {}, {
    totalToday: {method: 'GET', url: 'bill_pays/total_today'},
    totalRestOfMonth: {method: 'GET', url: 'bill_pays/total_rest_of_month'}
});
let BillReceiveResource = Vue.resource('bill_receives{/id}', {}, {
    totalToday: {method: 'GET', url: 'bill_receives/total_today'},
    totalRestOfMonth: {method: 'GET', url: 'bill_receives/total_rest_of_month'}
});
let CategoryResource = Vue.resource('categories{/id}');
let CategoryExpenseResource = Vue.resource('category_expenses{/id}');
let CategoryRevenueResource = Vue.resource('category_revenues{/id}');
let CashFlow = Vue.resource('cash_flow', {}, {
    monthly: {method: 'GET', url: 'cash_flow/monthly'}
});
let StatementResource = Vue.resource('statements');

export {
    User,
    BankResource,
    BankAccountResource,
    BillPayResource,
    BillReceiveResource,
    CategoryResource,
    CategoryExpenseResource,
    CategoryRevenueResource,
    CashFlow,
    StatementResource,
};
