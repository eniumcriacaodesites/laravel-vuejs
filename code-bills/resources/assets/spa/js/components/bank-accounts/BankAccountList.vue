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
                                <i class="material-icons right" v-if="order.key == key">
                                    {{ order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
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
                <pagination :current-page.sync="pagination.current_page"
                            :per-page="pagination.per_page"
                            :total-records="pagination.total"></pagination>
            </div>
        </div>
    </div>
    <modal :modal="modalDelete">
        <div slot="content" v-if="bankAccountToDelete">
            <h4>Deseja excluir esta conta bancaria?</h4>
            <table class="bordered">
                <tr>
                    <td>Nome:</td>
                    <td>{{ bankAccountToDelete.name }}</td>
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
                bankAccounts: [],
                bankAccountToDelete: null,
                modalDelete: {
                    id: 'modal-delete'
                },
                pagination: {
                    current_page: 0,
                    per_page: 0,
                    total: 0
                },
                search: '',
                order: {
                    key: 'id',
                    sort: 'asc'
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
        created() {
            this.getBankAccounts();
        },
        methods: {
            deleteBankAccount() {
                BankAccountResource.delete({id: this.bankAccountToDelete.id}).then((response) => {
                    this.bankAccounts.$remove(this.bankAccountToDelete);
                    this.bankAccountToDelete = null;
                    Materialize.toast('Conta bancária excluída com sucesso!', 4000);
                });
            },
            openModalDelete(bankAccount) {
                this.bankAccountToDelete = bankAccount;
                $('#modal-delete').modal();
                $('#modal-delete').modal('open');
            },
            getBankAccounts() {
                BankAccountResource.query({
                    include: 'bank',
                    page: this.pagination.current_page + 1,
                    orderBy: this.order.key,
                    sortedBy: this.order.sort,
                    search: this.search
                }).then((response) => {
                    this.bankAccounts = response.data.data;
                    let pagination = response.data.meta.pagination;
                    pagination.current_page--;
                    this.pagination = pagination;
                });
            },
            sortBy(key) {
                this.order.key = key;
                this.order.sort = this.order.sort == 'desc' ? 'asc' : 'desc';
                this.getBankAccounts();
            },
            filter() {
                this.getBankAccounts();
            }
        },
        events: {
            'pagination::changed'(page) {
                this.getBankAccounts();
            }
        }
    };
</script>
