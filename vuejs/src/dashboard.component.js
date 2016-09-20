window.dashboardComponent = Vue.extend({
    template: `
        <h1>{{ title }}</h1>
        <h2>Total a receber: {{ totalReceive | numberFormat }}</h2>
        <h2>Total a pagar: {{ totalPay | numberFormat }}</h2>
    `,
    data() {
        return {
            title: "Dashboard",
            totalReceive: 0,
            totalPay: 0
        };
    },
    created() {
        this.totalBillsReceive();
        this.totalBillsPay();
    },
    methods: {
        totalBillsReceive() {
            BillReceiveResource.query().then((response) => {
                let total = 0, billsReceive = response.data;
                for (let i in billsReceive) {
                    if (!billsReceive[i].done) {
                        total += billsReceive[i].value;
                    }
                }
                this.totalReceive = total;
            });
        },
        totalBillsPay() {
            BillPayResource.query().then((response) => {
                let total = 0, billsPay = response.data;
                for (let i in billsPay) {
                    if (!billsPay[i].done) {
                        total += billsPay[i].value;
                    }
                }
                this.totalPay = total;
            });
        }
    }
});
