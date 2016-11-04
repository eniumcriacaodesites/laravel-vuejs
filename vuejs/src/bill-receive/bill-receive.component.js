window.billReceiveComponent = Vue.extend({
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
                                <h5>{{ status | statusBillReceive }}</h5>
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
            title: "Contas a receber",
            status: false,
            total: 0
        };
    },
    created() {
        this.updateStatus();
        this.updateTotal();
    },
    methods: {
        calculateStatus(billsReceive) {
            let count = 0;
            if (!billsReceive.length) {
                this.status = false;
            } else {
                for (let i in billsReceive) {
                    if (!billsReceive[i].done) {
                        count++;
                    }
                }
                this.status = count;
            }
        },
        updateStatus() {
            BillReceiveResource.query().then((response) => {
                this.calculateStatus(response.data);
            });
        },
        updateTotal() {
            BillReceiveResource.total().then((response) => {
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
