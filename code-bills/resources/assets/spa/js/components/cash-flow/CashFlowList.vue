<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>Fluxo de caixa</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <div v-if="hasCashFlows">
                    <table class="bordered highlight responsive-table grey-text text-darken-3">
                        <thead>
                        <tr class="blue lighten-4">
                            <th class="text-csv"></th>
                            <th v-if="!hasFirstMonthYear" class="text-csv">
                                {{ firstMonthYear | monthYear }}
                            </th>
                            <th v-for="o in monthsList" :class="{'blue lighten-2': isCurrentMonthYear(o.month_year)}"
                                class="text-csv">
                                {{ o.month_year | monthYear }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="blue lighten-2">
                            <td class="tb-title text-csv">Saldo final</td>
                            <td class="text-csv">{{ firstBalance }}</td>
                            <td class="text-csv">{{ secondBalance }}</td>
                            <td v-for="(key, o) in monthsListBalanceFinal" class="text-csv">
                                {{ balance(key) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-csv">Saldo mês anterior</td>
                            <td class="text-csv">{{ balanceBeforeFirstMonth }}</td>
                            <td class="text-csv">{{ firstBalance }}</td>
                            <td class="text-csv">{{ secondBalance }}</td>
                            <td v-for="(key, o) in monthsListBalancePrevious" class="text-csv">
                                {{ balance(key) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-csv">Geração de caixa</td>
                            <td v-if="!hasFirstMonthYear" class="text-csv">0</td>
                            <td v-for="(key, o) in monthsList" class="text-csv">
                                {{ o.revenues.total - o.expenses.total }}
                            </td>
                        </tr>
                        <tr class="blue lighten-4">
                            <td class="tb-title text-csv">Recebimentos</td>
                            <td v-if="!hasFirstMonthYear" class="text-csv">0</td>
                            <td v-for="(key, o) in monthsList" class="text-csv">
                                {{ o.revenues.total }}
                            </td>
                        </tr>
                        <tr v-for="o in categoriesMonths.revenues.data">
                            <td class="text-csv">{{ o.name }}</td>
                            <td v-if="!hasFirstMonthYear" class="text-csv"></td>
                            <td v-for="v in monthsList" class="text-csv">
                                {{ categoryTotal(o, v.month_year).total }}
                            </td>
                        </tr>
                        <tr class="blue lighten-4">
                            <td class="tb-title text-csv">Pagamentos</td>
                            <td v-if="!hasFirstMonthYear" class="text-csv">0</td>
                            <td v-for="(key, o) in monthsList" class="text-csv">
                                {{ o.expenses.total }}
                            </td>
                        </tr>
                        <tr v-for="o in categoriesMonths.expenses.data">
                            <td class="text-csv">{{ o.name }}</td>
                            <td v-if="!hasFirstMonthYear" class="text-csv"></td>
                            <td v-for="v in monthsList" class="text-csv">
                                {{ categoryTotal(o, v.month_year).total }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="fixed-action-btn">
                        <a class="btn-floating btn-large" @click="downloadCsv">
                            <i class="large material-icons">file_download</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import store from '../../store/store';
    import PapaParse from 'papaparse';

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
            },
            getCsv() {
                let csvResult = [];
                csvResult.push([]);

                $('table thead .text-csv').each((key, item) => {
                    csvResult[0].push($(item).text().trim());
                });

                $('table tbody tr').each((key, tr) => {
                    csvResult.push([]);

                    $(tr).find('.text-csv').each((k, element) => {
                        csvResult[csvResult.length - 1].push($(element).text().trim());
                    });
                });

                return PapaParse.unparse(csvResult);
            },
            downloadCsv() {
                let anchor = $('<a/>');
                anchor.css('display', 'none');
                anchor.attr('download', 'fluxo-de-caixa.csv')
                    .attr('target', '_blank')
                    .attr('href', `data:text/csv;charset=UTF-8,${encodeURIComponent(this.getCsv())}`);
                anchor.html('Download CSV');
                $('body').append(anchor);
                anchor[0].click();
                anchor.remove();
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
