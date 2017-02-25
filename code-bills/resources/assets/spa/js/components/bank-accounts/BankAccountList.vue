<template>
    <div class="container">
        <h4>{{ title }}</h4>
        <table class="bordered highlight responsive-table z-depth-1">
            <thead>
            <tr>
                <th width="5%">#</th>
                <th>Nome</th>
                <th width="10%">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(index, o) in bankAccounts">
                <td>{{ o.id }}</td>
                <td>{{ o.name }}</td>
                <td nowrap="nowrap">
                    <a v-link="{name: 'bank-accounts.update', params: {id: o.id}}">Editar</a> |
                    <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                </td>
            </tr>
            </tbody>
        </table>
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
    import {BankAccountResource} from '../../services/resource';

    export default {
        components: {
            modal: ModalComponent
        },
        data() {
            return {
                title: 'Minhas contas bancarias',
                bankAccounts: [],
                bankAccountToDelete: null,
                modalDelete: {
                    id: 'modal-delete'
                }
            };
        },
        created() {
            BankAccountResource.query().then((response) => {
                this.bankAccounts = response.data;
            });
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
            }
        }
    };
</script>
