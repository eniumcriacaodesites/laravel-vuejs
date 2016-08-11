var app = new Vue({
    el: "#app",
    data: {
        title: "Contas a pagar",
        menus: [
            {id: 0, name: "Listar contas"},
            {id: 1, name: "Criar conta"}
        ],
        activedView: 0,
        formType: 'insert',
        bill: {
            date_due: '',
            name: '',
            value: 0,
            done: 0
        },
        names: [
            'Conta de luz',
            'Conta de água',
            'Conta de telefone',
            'Supermecado',
            'Cartão de crédito',
            'Empréstimo',
            'Gasolina'
        ],
        bills: [
            {date_due: '11/08/16', name: 'Conta de água', value: 55.99, done: 1},
            {date_due: '11/08/16', name: 'Conta de luz', value: 130.95, done: 0},
            {date_due: '15/08/16', name: 'Conta de telefone', value: 75.95, done: 0},
            {date_due: '15/08/16', name: 'Cartão de crédito', value: 1350.85, done: 0},
            {date_due: '20/08/16', name: 'Empréstimo', value: 2000.15, done: 0},
            {date_due: '20/08/16', name: 'Supermecado', value: 650.45, done: 0},
            {date_due: '20/08/16', name: 'Gasolina', value: 150.25, done: 0},
        ]
    },
    computed: {
        status: function () {
            var count = 0;
            for (var i in this.bills) {
                if (!this.bills[i].done) {
                    count++;
                }
            }
            return !count ? "Nenhuma conta a pagar." : "Existem " + count + " contas a serem pagas.";
        }
    },
    methods: {
        viewShow: function (id) {
            this.activedView = id;
            if (id == 1) {
                this.formType = 'insert';
            }
        },
        submit: function () {
            if (this.formType == 'insert') {
                this.bills.push(this.bill);
            }
            this.bill = {
                date_due: '',
                name: '',
                value: 0,
                done: 0
            };
            this.activedView = 0;
        },
        loadBill: function (bill) {
            this.bill = bill;
            this.activedView = 1;
            this.formType = 'update';
        }
    }
});
