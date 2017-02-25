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
let BankAccountResource = Vue.resource('bank_accounts{/id}');

export {User, BankResource, BankAccountResource};
