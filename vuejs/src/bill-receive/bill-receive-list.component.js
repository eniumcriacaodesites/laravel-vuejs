window.billReceiveListComponent = Vue.extend({
    template: `
        <div class="container">
            <table class="bordered centered highlight responsive-table">
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
                    <td class="my-class" :class="{'green': o.done, 'red': !o.done}">
                        <div v-if="o.done === 1">
                            <a href="#" @click.prevent="receiveBill(o)">{{ o.done | doneLabel }}</a>
                        </div>
                        <div v-else>
                            <a href="#" @click.prevent="receiveBill(o)">{{ o.done | doneLabel }}</a>
                        </div>
                    </td>
                    <td>
                        <a v-link="{name: 'bill-receive.update', params: {id: o.id}}">Editar</a> |
                        <a href="#" @click.prevent="deleteBill(o)">Excluir</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    `,
    data() {
        return {
            billsReceive: []
        };
    },
    created() {
        BillReceiveResource.query().then((response) => {
            this.billsReceive = response.data;
        });
    },
    methods: {
        deleteBill(bill) {
            if (confirm('Deseja excluir está conta?')) {
                BillReceiveResource.delete({id: bill.id}).then((response) => {
                    this.$dispatch('change-info');
                    this.billsReceive.$remove(bill);
                });
            }
        },
        receiveBill(bill) {
            if (confirm("Deseja alterar o status desta conta?")) {
                bill.done = !bill.done;
                BillReceiveResource.update({id: bill.id}, bill).then((response) => {
                    this.$dispatch('change-info');
                });
            }
        }
    }
});
