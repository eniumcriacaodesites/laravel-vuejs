let modalComponent = require('../modal.component');

module.exports = {
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
                    <th>Recebimento</th>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Recebeu?</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(index, o) in billsReceive">
                    <td>{{ index + 1 }}</td>
                    <td>{{ o.date_due | dateFormat 'pt-br' }}</td>
                    <td>{{ o.name | textFormat }}</td>
                    <td>{{ o.value | numberFormat 'pt-br' }}</td>
                    <td :class="{'bg-yes': o.done, 'bg-not': !o.done}">
                        <div v-if="o.done === 1">
                            <a href="#" @click.prevent="openModalReceive(o)" class="white-text">{{ o.done | doneLabel }}</a>
                        </div>
                        <div v-else>
                            <a href="#" @click.prevent="openModalReceive(o)" class="white-text">{{ o.done | doneLabel }}</a>
                        </div>
                    </td>
                    <td>
                        <a v-link="{name: 'bill-receive.update', params: {id: o.id}}">Editar</a> |
                        <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <modal :modal="modalDelete">
            <div slot="content" v-if="billToDelete">
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
                <button class="btn-ok  modal-close modal-action" @click="deleteBill()">Ok</button>
            </div>
        </modal>
        <modal :modal="modalReceive">
            <div slot="content" v-if="billToReceive">
                <h4>Deseja alterar o status desta conta?</h4>
                <table class="bordered">
                    <tr>
                        <td>Vencimento:</td>
                        <td>{{ billToReceive.date_due | dateFormat 'pt-br' }}</td>
                    </tr>
                    <tr>
                        <td>Nome:</td>
                        <td>{{ billToReceive.name }}</td>
                    </tr>
                    <tr>
                        <td>Valor:</td>
                        <td>{{ billToReceive.value | numberFormat 'pt-br' }}</td>
                    </tr>
                </table>
            </div>
            <div slot="footer">
                <button class="btn-cancel modal-close modal-action">Cancel</button>
                <button class="btn-ok  modal-close modal-action" @click="receiveBill()">Ok</button>
            </div>
        </modal>
    `,
    data() {
        return {
            title: 'Minhas contas a receber',
            billsReceive: [],
            billToDelete: null,
            billToReceive: null,
            modalDelete: {
                id: 'modal-delete'
            },
            modalReceive: {
                id: 'modal-receive'
            }
        };
    },
    created() {
        BillReceiveResource.query().then((response) => {
            this.billsReceive = response.data;
        });
    },
    methods: {
        deleteBill() {
            BillReceiveResource.delete({id: this.billToDelete.id}).then((response) => {
                this.billsReceive.$remove(this.billToDelete);
                this.billToDelete = null;
                Materialize.toast('Conta excluída com sucesso!', 4000);
                this.$dispatch('change-info');
            });
        },
        receiveBill() {
            this.billToReceive.done = !this.billToReceive.done;
            BillReceiveResource.update({id: this.billToReceive.id}, this.billToReceive).then((response) => {
                Materialize.toast('Conta alterada com sucesso!', 4000);
                this.$dispatch('change-info');
            });
        },
        openModalDelete(bill) {
            this.billToDelete = bill;
            $('#modal-delete').modal();
            $('#modal-delete').modal('open');
        },
        openModalReceive(bill) {
            this.billToReceive = bill;
            $('#modal-receive').modal();
            $('#modal-receive').modal('open');
        }
    }
};
