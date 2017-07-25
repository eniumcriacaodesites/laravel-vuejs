<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>Fluxo de caixa</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <div v-if="hasCashFlows">
                    <table class="bordered highlight responsive-table">
                        <thead>
                        <tr class="blue lighten-4">
                            <th></th>
                            <th v-if="!hasFirstMonthYear">
                                {{ firstMonthYear | monthYear }}
                            </th>
                            <th v-for="o in monthsList" :class="{'blue lighten-2': isCurrentMonthYear(o.month_year)}">
                                {{ o.month_year | monthYear }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="blue lighten-2">
                            <td class="tb-title">Saldo final</td>
                            <td>{{ firstBalance }}</td>
                            <td>{{ secondBalance }}</td>
                            <td v-for="(key, o) in monthsListBalanceFinal">
                                {{ balance(key) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Saldo mês anterior</td>
                            <td>{{ balanceBeforeFirstMonth }}</td>
                            <td>{{ firstBalance }}</td>
                            <td>{{ secondBalance }}</td>
                            <td v-for="(key, o) in monthsListBalancePrevious">
                                {{ balance(key) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Geração de caixa</td>
                            <td v-if="!hasFirstMonthYear">0</td>
                            <td v-for="(key, o) in monthsList">
                                {{ o.revenues.total - o.expenses.total }}
                            </td>
                        </tr>
                        <tr class="blue lighten-4">
                            <td class="tb-title">Recebimentos</td>
                            <td v-if="!hasFirstMonthYear">0</td>
                            <td v-for="(key, o) in monthsList">
                                {{ o.revenues.total }}
                            </td>
                        </tr>
                        <tr v-for="o in categoriesMonths.revenues.data">
                            <td>{{ o.name }}</td>
                            <td v-if="!hasFirstMonthYear"></td>
                            <td v-for="v in monthsList">
                                {{ categoryTotal(o, v.month_year).total }}
                            </td>
                        </tr>
                        <tr class="blue lighten-4">
                            <td class="tb-title">Pagamentos</td>
                            <td v-if="!hasFirstMonthYear">0</td>
                            <td v-for="(key, o) in monthsList">
                                {{ o.expenses.total }}
                            </td>
                        </tr>
                        <tr v-for="o in categoriesMonths.expenses.data">
                            <td>{{ o.name }}</td>
                            <td v-if="!hasFirstMonthYear"></td>
                            <td v-for="v in monthsList">
                                {{ categoryTotal(o, v.month_year).total }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import store from '../../store/store';

    export default {
        components: {
            pageTitle: PageTitleComponent,
        },
        computed: {
            cashFlows() {
                return store.state.cashFlow.cashFlows;
            },
            monthsList() {
                return this.cashFlows.months_list;
            },
            categoriesMonths() {
                return this.cashFlows.categories_months;
            },
            hasFirstMonthYear() {
                return store.getters['cashFlow/hasFirstMonthYear'];
            },
            firstMonthYear() {
                return store.state.cashFlow.firstMonthYear;
            },
            firstBalance() {
                return store.getters['cashFlow/firstBalance'];
            },
            secondBalance() {
                return store.getters['cashFlow/secondBalance'];
            },
            monthsListBalanceFinal() {
                return store.getters['cashFlow/monthsListBalanceFinal'];
            },
            monthsListBalancePrevious() {
                return store.getters['cashFlow/monthsListBalancePrevious'];
            },
            hasCashFlows() {
                return store.getters['cashFlow/hasCashFlows'];
            },
            balanceBeforeFirstMonth() {
                return this.cashFlows.balance_before_first_month;
            }
        },
        created() {
            store.commit('cashFlow/setFirstMonthYear', new Date());
            store.dispatch('cashFlow/query');
        },
        methods: {
            balance(index) {
                return store.getters['cashFlow/balance'](index);
            },
            categoryTotal(category, monthYear) {
                return store.getters['cashFlow/categoryTotal'](category, monthYear);
            },
            isCurrentMonthYear(monthYear) {
                return this.$options.filters.monthYear(new Date) == this.$options.filters.monthYear(monthYear);
            }
        }
    };
</script>

<style type="text/css" scoped>
    th {
        border-radius: 0;
        text-align: center;
    }

    td {
        padding: 10px;
        text-align: center;
    }

    td:first-child {
        text-align: left;
    }

    .tb-title {
        text-transform: uppercase;
        font-weight: bold;
        text-align: left;
    }
</style>
