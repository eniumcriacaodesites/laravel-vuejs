<template>
    <div class="container">
        <div class="row">
            <div class="card-panel blue lighten-3">
                <span class="blue-text text-darken-2">
                    <h5>{{ title}}</h5>
                </span>
            </div>

            <div class="card-panel z-depth-2">
                <table class="bordered striped highlight responsive-table">
                    <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Nome</th>
                        <th>Agência</th>
                        <th>C/C</th>
                        <th width="10%">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(index, o) in bankAccounts">
                        <td>{{ o.id }}</td>
                        <td>{{ o.name }}</td>
                        <td>{{ o.agency }}</td>
                        <td>{{ o.account }}</td>
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

    export default {
        components: {
            modal: ModalComponent,
            pagination: PaginationComponent
        },
        data() {
            return {
                title: 'Minhas contas bancarias',
                bankAccounts: [],
                bankAccountToDelete: null,
                modalDelete: {
                    id: 'modal-delete'
                },
                pagination: {
                    current_page: 0,
                    per_page: 0,
                    total: 0
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
                    page: this.pagination.current_page + 1
                }).then((response) => {
                    this.bankAccounts = response.data.data;
                    let pagination = response.data.meta.pagination;
                    pagination.current_page--;
                    this.pagination = pagination;
                });
            }
        },
        events: {
            'pagination::changed'(page) {
                this.getBankAccounts();
            }
        }
    };
</script>
