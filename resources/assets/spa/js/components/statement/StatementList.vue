<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>Extrato</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <search @on-submit="filter" :model.sync="search"></search>
                <table class="bordered striped highlight responsive-table">
                    <thead>
                    <tr>
                        <th v-for="(key, o) in table.headers" :width="o.width">
                            <a href="#" @click.prevent="sortBy(key)">
                                {{ o.label }}
                                <i class="material-icons right" v-if="searchOptions.order.key == key">
                                    {{ searchOptions.order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                </i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(index, o) in statements">
                        <td>{{ o.created_at | dateFormat }}</td>
                        <td>{{ o.bankAccount.data.name }}</td>
                        <td>{{{ o.value | currencyFormat }}}</td>
                        <td>{{{ o.balance | currencyFormat }}}</td>
                    </tr>
                    </tbody>
                </table>
                <pagination :current-page.sync="searchOptions.pagination.current_page"
                            :per-page="searchOptions.pagination.per_page"
                            :total-records="searchOptions.pagination.total"></pagination>
                <table class="grey-text text-darken-2">
                    <tbody class="left">
                    <tr>
                        <td>Total de Recebimentos</td>
                        <td>{{ statementData.revenues.total | numberFormat true }}</td>
                    </tr>
                    <tr>
                        <td>Total de Pagamentos</td>
                        <td>{{ statementData.expenses.total | numberFormat true }}</td>
                    </tr>
                    <tr>
                        <td>Número de Lançamentos</td>
                        <td>{{ statementData.count }}</td>
                    </tr>
                    <tr>
                        <td>Total do Período</td>
                        <td>{{ statementData.revenues.total + statementData.expenses.total | numberFormat true}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import PaginationComponent from '../Pagination.vue';
    import PageTitleComponent from '../PageTitle.vue';
    import SearchComponent from '../Search.vue';
    import store from '../../store/store';
    import moment from 'moment';

    export default {
        components: {
            pagination: PaginationComponent,
            pageTitle: PageTitleComponent,
            search: SearchComponent
        },
        data() {
            return {
                table: {
                    headers: {
                        created_at: {
                            label: 'Data',
                            width: '10%'
                        },
                        'bank_accounts:bank_account_id|bank_accounts.name': {
                            label: 'Conta bancária'
                        },
                        value: {
                            label: 'Valor',
                            width: '10%'
                        },
                        balance: {
                            label: 'Saldo',
                            width: '10%'
                        },
                    }
                }
            };
        },
        computed: {
            statements() {
                return store.state.statement.statements;
            },
            statementData() {
                return store.state.statement.statementData;
            },
            searchOptions() {
                return store.state.statement.searchOptions;
            },
            search: {
                get() {
                    return store.state.statement.searchOptions.search;
                },
                set(value) {
                    store.commit('statement/setFilter', value);
                }
            },
        },
        created() {
            store.commit('statement/setFilter', `${this.dateFilterStart()} - ${this.dateFilterEnd()}`);
            store.dispatch('statement/query');
        },
        methods: {
            sortBy(key) {
                store.dispatch('statement/queryWithSortBy', key);
            },
            filter() {
                store.dispatch('statement/queryWithFilter');
            },
            dateFilterStart() {
                let date = (new Date()).setDate(1);
                return moment(date).format('DD/MM/YYYY');
            },
            dateFilterEnd() {
                return moment(new Date).endOf('month').format('DD/MM/YYYY');
            }
        },
        events: {
            'pagination::changed'(page) {
                store.dispatch('statement/queryWithPagination', page);
            }
        }
    };
</script>
