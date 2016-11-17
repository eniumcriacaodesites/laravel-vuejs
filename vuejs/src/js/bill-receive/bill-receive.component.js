import {BillReceiveResource} from '../resources';

export default {
    template: `
        <div class="section bill-info">
            <div class="container">
                <h4>{{ title }}</h4>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card z-depth-2" :class="{'bg-red': status === 0, 'bg-green': status >= 1}">
                            <div class="card-content">
                                <div class="card-title">
                                    <i class="material-icons">account_balance</i>
                                    {{ status | statusBillReceive }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="card z-depth-2 bg-blue">
                            <div class="card-content">
                                <div class="card-title">
                                    <i class="material-icons">payment</i>
                                    {{ total | numberFormat 'pt-br' }}
                                </div>
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
};
