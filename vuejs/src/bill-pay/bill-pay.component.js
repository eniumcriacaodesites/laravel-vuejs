window.billPayComponent = Vue.extend({
    template: `
        <div class="section">
            <div class="container">
                <h4>{{ title }}</h4>
                <div class="row">
                    <div class="col s6">
                        <div class="card z-depth-2" :class="{'green': status === 0, 'red': status >= 1}">
                            <div class="card-content white-text">
                                <p class="card-title">
                                    <i class="material-icons">account_balance</i>
                                </p>
                                <h5>{{ status | statusBillPay }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col s6">
                        <div class="card z-depth-2">
                            <div class="card-content">
                                <p class="card-title">
                                    <i class="material-icons">payment</i>
                                </p>
                                <h5>{{ total | numberFormat 'pt-br' }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <router-view></router-view>
    `,
    data() {
        return {
            title: "Contas a pagar",
            status: false,
            total: 0
        };
    },
    created() {
        this.updateStatus();
        this.updateTotal();
    },
    methods: {
        calculateStatus(billsPay) {
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
        updateStatus() {
            BillPayResource.query().then((response) => {
                this.calculateStatus(response.data);
            });
        },
        updateTotal() {
            BillPayResource.total().then((response) => {
                this.total = response.data.total;
            })
        }
    },
    events: {
        'change-info'() {
            this.updateStatus();
            this.updateTotal();
        }
    }
});
