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
let BillPayResource = Vue.resource('bill_pays{/id}');
let BillReceiveResource = Vue.resource('bill_receives{/id}');
let CategoryResource = Vue.resource('categories{/id}');
let CategoryExpenseResource = Vue.resource('category_expenses{/id}');
let CategoryRevenueResource = Vue.resource('category_revenues{/id}');

export {
    User,
    BankResource,
    BankAccountResource,
    BillPayResource,
    BillReceiveResource,
    CategoryResource,
    CategoryExpenseResource,
    CategoryRevenueResource
};
