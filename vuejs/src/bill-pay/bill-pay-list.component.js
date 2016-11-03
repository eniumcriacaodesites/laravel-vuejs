window.billPayListComponent = Vue.extend({
    template: `
        <table border="1" cellpadding="10">
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
                <td>{{ o.date_due | dateFormat }}</td>
                <td>{{ o.value | numberFormat }}</td>
                <td>{{ o.name | textFormat }}</td>
                <td class="my-class" :class="{'green': o.done, 'red': !o.done}">
                    <div v-if="o.done === 1">
                        <a href="#" @click.prevent="payBill(o)">{{ o.done | doneLabel }}</a>
                    </div>
                    <div v-else>
                        <a href="#" @click.prevent="payBill(o)">{{ o.done | doneLabel }}</a>
                    </div>
                </td>
                <td>
                    <a v-link="{name: 'bill-pay.update', params: {id: o.id}}">Editar</a> |
                    <a href="#" @click.prevent="deleteBill(o)">Excluir</a>
                </td>
            </tr>
            </tbody>
        </table>
    `,
    data() {
        return {
            billsPay: []
        };
    },
    created() {
        BillPayResource.query().then((response) => {
            this.billsPay = response.data;
        });
    },
    methods: {
        deleteBill(bill) {
            if (confirm('Deseja excluir está conta?')) {
                BillPayResource.delete({id: bill.id}).then((response) => {
                    this.$dispatch('change-info');
                    this.billsPay.$remove(bill);
                });
            }
        },
        payBill(bill) {
            if (confirm("Deseja alterar o status desta conta?")) {
                bill.done = !bill.done;
                BillPayResource.update({id: bill.id}, bill).then((response) => {
                    this.$dispatch('change-info');
                });
            }
        }
    }
});
