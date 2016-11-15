window.billPayListComponent = Vue.extend({
    components: {
        modal: modalComponent
    },
    template: `
        <div class="container">
            <h4>{{ title }}</h4>
            <table class="bordered centered highlight responsive-table z-depth-1">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Vencimento</th>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Paga?</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(index, o) in billsPay">
                    <td>{{ index + 1 }}</td>
                    <td>{{ o.date_due | dateFormat 'pt-br' }}</td>
                    <td>{{ o.name | textFormat }}</td>
                    <td>{{ o.value | numberFormat 'pt-br' }}</td>
                    <td :class="{'bg-yes': o.done, 'bg-not': !o.done}">
                        <div v-if="o.done === 1">
                            <a href="#" @click.prevent="openModalPay(o)">{{ o.done | doneLabel }}</a>
                        </div>
                        <div v-else>
                            <a href="#" @click.prevent="openModalPay(o)">{{ o.done | doneLabel }}</a>
                        </div>
                    </td>
                    <td>
                        <a v-link="{name: 'bill-pay.update', params: {id: o.id}}">Editar</a> |
                        <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <modal :modal="modalDelete">
            <div slot="content">
                <h4>Deseja excluir esta conta?</h4>
                <table class="bordered">
                    <tr>
                        <td>Vencimento:</td>
                        <td>{{ billToDelete.date_due | dateFormat 'pt-br' }}</td>
                    </tr>
                    <tr>
                        <td>Nome:</td>
                        <td>{{ billToDelete.name }}</td>
                    </tr>
                    <tr>
                        <td>Valor:</td>
                        <td>{{ billToDelete.value | numberFormat 'pt-br' }}</td>
                    </tr>
                </table>
            </div>
            <div slot="footer">
                <button class="btn-cancel modal-close modal-action">Cancel</button>
                <button class="btn-ok modal-close modal-action" @click="deleteBill()">Ok</button>
            </div>
        </modal>
        <modal :modal="modalPay">
            <div slot="content">
                <h4>Deseja alterar o status desta conta?</h4>
                <table class="bordered">
                    <tr>
                        <td>Vencimento:</td>
                        <td>{{ billToPay.date_due | dateFormat 'pt-br' }}</td>
                    </tr>
                    <tr>
                        <td>Nome:</td>
                        <td>{{ billToPay.name }}</td>
                    </tr>
                    <tr>
                        <td>Valor:</td>
                        <td>{{ billToPay.value | numberFormat 'pt-br' }}</td>
                    </tr>
                </table>
            </div>
            <div slot="footer">
                <button class="btn-cancel modal-close modal-action">Cancel</button>
                <button class="btn-ok modal-close modal-action" @click="payBill()">Ok</button>
            </div>
        </modal>
    `,
    data() {
        return {
            title: 'Minhas contas a pagar',
            billsPay: [],
            billToDelete: null,
            billToPay: null,
            modalDelete: {
                id: 'modal-delete'
            },
            modalPay: {
                id: 'modal-pay'
            }
        };
    },
    created() {
        BillPayResource.query().then((response) => {
            this.billsPay = response.data;
        });
    },
    methods: {
        deleteBill() {
            BillPayResource.delete({id: this.billToDelete.id}).then((response) => {
                this.billsPay.$remove(this.billToDelete);
                this.billToDelete = null;
                Materialize.toast('Conta excluída com sucesso!', 4000);
                this.$dispatch('change-info');
            });
        },
        payBill() {
            this.billToPay.done = !this.billToPay.done;
            BillPayResource.update({id: this.billToPay.id}, this.billToPay).then((response) => {
                Materialize.toast('Conta alterada com sucesso!', 4000);
                this.$dispatch('change-info');
            });
        },
        openModalDelete(bill) {
            this.billToDelete = bill;
            $('#modal-delete').modal();
            $('#modal-delete').modal('open');
        },
        openModalPay(bill) {
            this.billToPay = bill;
            $('#modal-pay').modal();
            $('#modal-pay').modal('open');
        }
    }
});
