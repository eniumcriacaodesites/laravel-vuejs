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
                <td>{{ o.date_due }}</td>
                <td>{{ o.name }}</td>
                <td>{{ o.value | currency 'R$ ' 2 }}</td>
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
    data: function () {
        return {
            billsPay: []
        };
    },
    created: function () {
        var self = this;
        BillPay.query().then(function (response) {
            self.billsPay = response.data;
        });
    },
    methods: {
        deleteBill: function (bill) {
            var self = this;
            if (confirm('Deseja excluir está conta?')) {
                BillPay.delete({id: bill.id}).then(function (response) {
                    self.$dispatch('change-info');
                    self.billsPay.$remove(bill);
                });
            }
        },
        payBill: function (bill) {
            var self = this;
            if (confirm("Deseja alterar o status desta conta?")) {
                bill.done = !bill.done;
                BillPay.update({id: bill.id}, bill).then(function (response) {
                    self.$dispatch('change-info');
                });
            }
        }
    }
});
