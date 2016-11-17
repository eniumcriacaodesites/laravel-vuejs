Vue.http.options.root = 'http://0.0.0.0:8888/api';

let BillPayResource = Vue.resource('bills-pay{/id}', {}, {
    total: {
        method: 'GET',
        url: 'bills-pay/total'
    }
});

let BillReceiveResource = Vue.resource('bills-receive{/id}', {}, {
    total: {
        method: 'GET',
        url: 'bills-receive/total'
    }
});

export {BillPayResource, BillReceiveResource};
