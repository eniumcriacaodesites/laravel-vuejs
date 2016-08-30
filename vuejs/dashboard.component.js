window.dashboardComponent = Vue.extend({
    template: `
        <h1>{{ title }}</h1>
        <h2>Total a receber: {{ totalReceive | currency 'R$ ' }}</h2>
        <h2>Total a pagar: {{ totalPay | currency 'R$ ' }}</h2>
    `,
    data: function () {
        return {
            title: "Dashboard",
            totalReceive: 0,
            totalPay: 0
        };
    },
    created: function () {
        this.totalBillsReceive();
        this.totalBillsPay();
    },
    methods: {
        totalBillsReceive: function () {
            var self = this;
            BillReceive.query().then(function (response) {
                var total = 0, billsReceive = response.data;
                for (var i in billsReceive) {
                    if (!billsReceive[i].done) {
                        total += billsReceive[i].value;
                    }
                }
                self.totalReceive = total;
            });
        },
        totalBillsPay: function () {
            var self = this;
            BillPay.query().then(function (response) {
                var total = 0, billsPay = response.data;
                for (var i in billsPay) {
                    if (!billsPay[i].done) {
                        total += billsPay[i].value;
                    }
                }
                self.totalPay = total;
            });
        }
    }
});
