window.billPayComponent = Vue.extend({
    components: {
        'menu-component': billPayMenuComponent
    },
    template: `
        <h1>{{ title }}</h1>
        <h2 v-html="status | statusBillPay"></h2>
        <h3>{{ total | currency 'R$ ' }}</h3>
        <menu-component></menu-component>
        <router-view></router-view>
    `,
    data: function () {
        return {
            title: "Contas a pagar",
            status: false,
            total: 0
        };
    },
    created: function () {
        this.updateStatus();
        this.updateTotal();
    },
    methods: {
        calculateStatus: function (billsPay) {
            let count = 0;
            if (!billsPay.length) {
                this.status = false;
            } else {
                for (let i in billsPay) {
                    if (!billsPay[i].done) {
                        count++;
                    }
                }
                this.status = count;
            }
        },
        updateStatus: function () {
            let self = this;
            BillPay.query().then(function (response) {
                self.calculateStatus(response.data);
            });
        },
        updateTotal: function () {
            let self = this;
            BillPay.total().then(function (response) {
                self.total = response.data.total;
            })
        }
    },
    events: {
        'change-info': function () {
            this.updateStatus();
            this.updateTotal();
        }
    }
});
