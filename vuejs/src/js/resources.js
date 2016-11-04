Vue.http.options.root = 'http://192.168.1.2:8888/api';

window.BillPayResource = Vue.resource('bills-pay{/id}', {}, {
    total: {
        method: 'GET',
        url: 'bills-pay/total'
    }
});

window.BillReceiveResource = Vue.resource('bills-receive{/id}', {}, {
    total: {
        method: 'GET',
        url: 'bills-receive/total'
    }
});
