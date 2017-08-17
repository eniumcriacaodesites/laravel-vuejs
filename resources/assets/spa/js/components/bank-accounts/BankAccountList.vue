<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>{{ title }}</h5>
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
                        <th width="5%">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(index, o) in bankAccounts">
                        <td>{{ o.id }}</td>
                        <td>{{ o.name }}</td>
                        <td>{{ o.agency }}</td>
                        <td>{{ o.account }}</td>
                        <td>
                            <table>
                                <tr>
                                    <td width="32">
                                        <img :src="o.bank.data.logo" class="bank-logo">
                                    </td>
                                    <td>
                                        {{ o.bank.data.name }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <i class="material-icons green-text" v-if="o.default">check</i>
                        </td>
                        <td nowrap="nowrap">
                            <a v-link="{name: 'bank-accounts.update', params: {id: o.id}}">Editar</a> |
                            <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination :current-page.sync="searchOptions.pagination.current_page"
                            :per-page="searchOptions.pagination.per_page"
                            :total-records="searchOptions.pagination.total"></pagination>
            </div>
        </div>
    </div>
    <modal :modal="modalDelete">
        <div slot="content" v-if="bankAccountDelete">
            <h4>Deseja excluir esta conta bancaria?</h4>
            <table class="bordered">
                <tr>
                    <td>Nome:</td>
                    <td>{{ bankAccountDelete.name }}</td>
                </tr>
                <tr>
                    <td>Agência:</td>
                    <td>{{ bankAccountDelete.agency }}</td>
                </tr>
                <tr>
                    <td>C/C:</td>
                    <td>{{ bankAccountDelete.account }}</td>
                </tr>
            </table>
        </div>
        <div slot="footer">
            <button class="btn-cancel modal-close modal-action">Cancel</button>
            <button class="btn-ok modal-close modal-action" @click="deleteBankAccount()">Ok</button>
        </div>
    </modal>
</template>

<script type="text/javascript">
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import PaginationComponent from '../Pagination.vue';
    import {BankAccountResource} from '../../services/resource';
    import PageTitleComponent from '../PageTitle.vue';
    import SearchComponent from '../Search.vue';
    import store from '../../store/store';

    export default {
        components: {
            modal: ModalComponent,
            pagination: PaginationComponent,
            pageTitle: PageTitleComponent,
            search: SearchComponent
        },
        data() {
            return {
                title: 'Minhas contas bancárias',
                modalDelete: {
                    id: 'modal-delete'
                },
                table: {
                    headers: {
                        id: {
                            label: '#',
                            width: '5%'
                        },
                        name: {
                            label: 'Nome',
                            width: '40%'
                        },
                        agency: {
                            label: 'Agência',
                            width: '15%'
                        },
                        account: {
                            label: 'C/C',
                            width: '15%'
                        },
                        'banks:bank_id|banks.name': {
                            label: 'Banco',
                            width: '15%'
                        },
                        'default': {
                            label: 'Padrão',
                            width: '10%'
                        },
                    }
                }
            };
        },
        computed: {
            bankAccounts() {
                return store.state.bankAccount.bankAccounts;
            },
            searchOptions() {
                return store.state.bankAccount.searchOptions;
            },
            search: {
                get() {
                    return store.state.bankAccount.searchOptions.search;
                },
                set(value) {
                    store.commit('bankAccount/setFilter', value);
                }
            },
            bankAccountDelete() {
                return store.state.bankAccount.bankAccountDelete;
            },
        },
        created() {
            store.dispatch('bankAccount/query');
        },
        methods: {
            deleteBankAccount() {
                store.dispatch('bankAccount/delete').then((response) => {
                    Materialize.toast('Conta bancária excluída com sucesso!', 4000);
                });
            },
            openModalDelete(bankAccount) {
                store.commit('bankAccount/setDelete', bankAccount);
                $('#modal-delete').modal();
                $('#modal-delete').modal('open');
            },
            sortBy(key) {
                store.dispatch('bankAccount/queryWithSortBy', key);
            },
            filter() {
                store.dispatch('bankAccount/queryWithFilter');
            },
        },
        events: {
            'pagination::changed'(page) {
                store.dispatch('bankAccount/queryWithPagination', page);
            }
        }
    };
</script>
