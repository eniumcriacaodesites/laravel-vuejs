var router = new VueRouter();

var mainComponent = Vue.extend({
    components: {
        'app-component': appComponent
    },
    template: `<app-component></app-component>`,
    data: function () {
        return {
            bills: [
                {date_due: '11/08/16', name: 'Conta de água', value: 55.99, done: true},
                {date_due: '11/08/16', name: 'Conta de luz', value: 130.95, done: false},
                {date_due: '15/08/16', name: 'Conta de telefone', value: 75.95, done: false},
                {date_due: '15/08/16', name: 'Cartão de crédito', value: 1350.85, done: false},
                {date_due: '20/08/16', name: 'Empréstimo', value: 2000.15, done: false},
                {date_due: '20/08/16', name: 'Supermecado', value: 650.45, done: false},
                {date_due: '20/08/16', name: 'Gasolina', value: 150.25, done: false},
            ]
        };
    }
});

router.map({
    '/bills': {
        name: 'bill.list',
        component: billListComponent
    },
    '/bill/create': {
        name: 'bill.create',
        component: billCreateComponent
    },
    '*': {
        component: billListComponent
    }
});

router.start({
    components: {
        'main-component': mainComponent
    }
}, '#app');

router.redirect({
    '*': '/bills'
});
