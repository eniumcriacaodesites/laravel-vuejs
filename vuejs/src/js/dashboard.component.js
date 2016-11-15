window.dashboardComponent = Vue.extend({
    template: `
        <div class="section">
            <div class="container">
                <h4>{{ title }}</h4>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card z-depth-2">
                            <div class="card-content total-receive">
                                <p class="card-title">
                                    <i class="material-icons right">call_received</i>
                                    Total a receber
                                </p>
                                <h3>{{ totalReceive | numberFormat 'pt-br' }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="card z-depth-2">
                            <div class="card-content total-pay">
                                <p class="card-title">
                                    <i class="material-icons right">call_made</i>
                                    Total a pagar
                                </p>
                                <h3>{{ totalPay | numberFormat 'pt-br' }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
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
