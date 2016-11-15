window.billReceiveListComponent = Vue.extend({
    components: {
        modal: modalComponent
    },
    template: `
        <div class="container">
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
                    <td :class="{'green': o.done, 'red': !o.done}">
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
            <div slot="content">
                <h4>Mensagem de confirmação</h4>
                <p><strong>Deseja excluir esta conta?</strong></p>
                <div class="divider"></div>
                <p>Nome: <strong>{{ billToDelete.name }}</strong></p>
                <p>Valor: <strong>{{ billToDelete.value | numberFormat 'pt-br' }}</strong></p>
                <p>Vencimento: <strong>{{ billToDelete.date_due | dateFormat 'pt-br' }}</strong></p>
            </div>
            <div slot="footer">
                <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancel</button>
                <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action" @click="deleteBill()">Ok</button>
            </div>
        </modal>
        <modal :modal="modalReceive">
            <div slot="content">
                <h4>Mensagem de confirmação</h4>
                <p><strong>Deseja alterar o status desta conta?</strong></p>
                <div class="divider"></div>
                <p>Nome: <strong>{{ billToReceive.name }}</strong></p>
                <p>Valor: <strong>{{ billToReceive.value | numberFormat 'pt-br' }}</strong></p>
                <p>Vencimento: <strong>{{ billToReceive.date_due | dateFormat 'pt-br' }}</strong></p>
            </div>
            <div slot="footer">
                <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancel</button>
                <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action" @click="receiveBill()">Ok</button>
            </div>
        </modal>
    `,
    data() {
        return {
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
});
