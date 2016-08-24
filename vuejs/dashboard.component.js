window.dashboardComponent = Vue.extend({
    template: `
        <h1>{{ title }}</h1>
        <h2>Total a receber: R$ {{ totalReceive }}</h2>
        <h2>Total a pagar: R$ {{ totalPay }}</h2>
    `,
    data: function () {
        return {
            title: "Dashboard"
        };
    },
    computed: {
        totalReceive: function () {
            var total = 0, billsReceive = this.$root.$children[0].billsReceive;
            for (var i in billsReceive) {
                if (!billsReceive[i].done) {
                    total += billsReceive[i].value;
                }
            }
            return total;
        },
        totalPay: function () {
            var total = 0, billsPay = this.$root.$children[0].billsPay;
            for (var i in billsPay) {
                if (!billsPay[i].done) {
                    total += billsPay[i].value;
                }
            }
            return total;
        }
    }
});
