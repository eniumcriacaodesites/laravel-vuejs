<template>
    <div class="section bill-info">
        <div class="container">
            <h4>{{ title }}</h4>
            <div class="row">
                <div class="col s12 m6">
                    <div class="card z-depth-2" :class="{'bg-green': status === 0, 'bg-red': status >= 1}">
                        <div class="card-content">
                            <div class="card-title">
                                <i class="material-icons">account_balance</i>
                                {{ status | statusBillPay }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card z-depth-2 bg-orange">
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
</template>

<script>
    import {BillPayResource} from '../resources';

    export default {
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
    };
</script>
