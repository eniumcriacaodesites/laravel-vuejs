<template>
    <div class="container">
        <div class="row">
            <div class="col s8">
                <!-- left -->
                <div class="row">
                    <div class="col s6">
                        <div class="card-panel z-depth-2">
                            <div class="center" v-show="loadingRevenue">
                                <div class="preloader-wrapper big active">
                                    <div class="spinner-layer spinner-blue-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-show="!loadingRevenue">
                                <div>A receber hoje</div>
                                <h3 id="revenue-number" class="green-text center">R$0,00</h3>
                                <div class="left">Restante do mês</div>
                                <div class="right">{{ totalRestOfMonthReceive | numberFormat true }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col s6">
                        <div class="card-panel z-depth-2">
                            <div class="center" v-show="loadingExpense">
                                <div class="preloader-wrapper big active">
                                    <div class="spinner-layer spinner-blue-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-show="!loadingExpense">
                                <div>A pagar hoje</div>
                                <h3 id="expense-number" class="red-text center">R$0,00</h3>
                                <div class="left">Restante do mês</div>
                                <div class="right">{{ totalRestOfMonthPay | numberFormat true }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="card-panel z-depth-2">
                            <div class="center" v-show="loadingChart">
                                <div class="preloader-wrapper big active">
                                    <div class="spinner-layer spinner-blue-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="hasCashFlowsMonthly">
                                <vue-chart :chart-type="chartOptions.chartType"
                                           :chart-events="chartOptions.chartEvents"
                                           :columns="chartOptions.columns"
                                           :rows="chartOptions.rows"
                                           :options="chartOptions.options">
                                </vue-chart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s4">
                <!-- right -->
                <div class="card-panel z-depth-2">
                    <div class="center" v-show="loadingBankAccountList">
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul id="bank-account-list" class="collection" v-show="!loadingBankAccountList">
                        <li class="collection-item avatar" v-for="o in bankAccounts">
                            <img :src="o.bank.data.logo" :alt="o.bank.data.name" class="circle z-depth-1">
                            <span class="title"><strong>{{ o.name }}</strong></span>
                            <p>{{{ o.balance | currencyFormat }}}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import store from "../store/store";
    import VueCharts from "vue-charts";
    import "jquery.animate-number";

    Vue.use(VueCharts);

    export default {
        data() {
            return {
                loadingBankAccountList: true,
                loadingChart: true,
                loadingRevenue: true,
                loadingExpense: true,
            }
        },
        computed: {
            bankAccounts() {
                return store.state.bankAccount.bankAccounts;
            },
            clientId() {
                return store.state.auth.user.client_id;
            },
            cashFlowsMonthly() {
                return store.state.cashFlow.cashFlowsMonthly;
            },
            hasCashFlowsMonthly() {
                return store.getters['cashFlow/hasCashFlowsMonthly'];
            },
            totalTodayReceive() {
                return store.state.billReceive.total_today;
            },
            totalRestOfMonthReceive() {
                return store.state.billReceive.total_rest_of_month;
            },
            totalTodayPay() {
                return store.state.billPay.total_today;
            },
            totalRestOfMonthPay() {
                return store.state.billPay.total_rest_of_month;
            },
            chartOptions() {
                let self = this;
                let obj = {
                    chartType: 'ColumnChart',
                    chartEvents: {
                        ready() {
                            self.loadingChart = false;
                        }
                    },
                    columns: [
                        {'type': 'string', 'label': 'Dia'},
                        {'type': 'number', 'label': 'Receita'},
                        {'type': 'string', 'role': 'style'},
                        {'type': 'number', 'label': 'Despesa'},
                        {'type': 'string', 'role': 'style'}
                    ],
                    rows: [],
                    options: {
                        title: 'Fluxo de Caixa Mensal',
                        isStacked: true,
                        bar: {groupWidth: '40%'},
                        legend: {position: 'top'},
                        colors: ['green', 'red'],
                        animation: {
                            duration: 3000,
                            easing: 'out',
                            startup: true
                        }
                    }
                };

                for (let period of this.cashFlowsMonthly.period_list) {
                    obj.rows.push([
                        this.$options.filters.dayMonth(period.period),
                        period.revenues.total == 0 ? null : period.revenues.total,
                        'green',
                        period.expenses.total == 0 ? null : -period.expenses.total,
                        'red'
                    ]);
                }

                return obj;
            }
        },
        created() {
            this.store();
            this.echo();
        },
        methods: {
            store() {
                store.commit('bankAccount/setOrder', 'balance');
                store.commit('bankAccount/setSort', 'desc');
                store.commit('bankAccount/setLimit', 5);
                store.dispatch('bankAccount/query').then(() => {
                    this.loadingBankAccountList = false;
                    Materialize.showStaggeredList('#bank-account-list');
                });

                store.dispatch('cashFlow/monthly');

                let self = this;

                store.dispatch('billReceive/totalRestOfMonth');
                store.dispatch('billReceive/totalToday').then(() => {
                    this.loadingRevenue = false;
                    $('#revenue-number').animateNumber({
                        number: self.totalTodayReceive,
                        numberStep(now, twee) {
                            let number = self.$options.filters.numberFormat.read(now, true);
                            $(twee.elem).text(number);
                        }
                    }, 1000);
                });

                store.dispatch('billPay/totalRestOfMonth');
                store.dispatch('billPay/totalToday').then(() => {
                    this.loadingExpense = false;
                    $('#expense-number').animateNumber({
                        number: self.totalTodayPay,
                        numberStep(now, twee) {
                            let number = self.$options.filters.numberFormat.read(now, true);
                            $(twee.elem).text(number);
                        }
                    }, 1000);
                });
            },
            echo() {
                let self = this;

                Echo.private(`client.${this.clientId}`)
                    .listen('.CodeBills.Events.BankAccountBalanceUpdatedEvent', (e) => {
                        self.updateBalance(e.bankAccount);
                    });
            },
            findIndexBankAccount(id) {
                let index = this.bankAccounts.findIndex(item => {
                    return item.id == id;
                });

                return index;
            },
            updateBalance(bankAccount) {
                let index = this.findIndexBankAccount(bankAccount.id);

                if (index != -1) {
                    store.commit('bankAccount/updateBalance', {index, balance: bankAccount.balance});
                }

                let balance = this.$options.filters.numberFormat.read(bankAccount.balance, true);
                let message = `Novo saldo de ${bankAccount.name}: ${balance}`;

                Materialize.toast(message, 4000);
            }
        },
    }
</script>

<style type="text/css" scoped>
    .collection, .collection-item {
        border: none;
        margin: 0;
    }

    .card-panel:after {
        content: "";
        display: table;
        clear: both;
    }
</style>
