window.billReceiveListComponent = Vue.extend({
    template: `
        <table border="1" cellpadding="10">
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
                <td>{{ o.date_due }}</td>
                <td>{{ o.name }}</td>
                <td>{{ o.value | numberFormat }}</td>
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
    `,
    data() {
        return {
            billsReceive: []
        };
    },
    created() {
        BillReceive.query().then((response) => {
            this.billsReceive = response.data;
        });
    },
    methods: {
        deleteBill(bill) {
            if (confirm('Deseja excluir está conta?')) {
                BillReceive.delete({id: bill.id}).then((response) => {
                    this.$dispatch('change-info');
                    this.billsReceive.$remove(bill);
                });
            }
        },
        receiveBill(bill) {
            if (confirm("Deseja alterar o status desta conta?")) {
                bill.done = !bill.done;
                BillReceive.update({id: bill.id}, bill).then((response) => {
                    this.$dispatch('change-info');
                });
            }
        }
    }
});
