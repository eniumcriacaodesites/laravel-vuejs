window.billListComponent = Vue.extend({
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
            <tr v-for="(index, o) in bills">
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
                    <a href="#" @click.prevent="loadBill(o)">Editar</a> |
                    <a href="#" @click.prevent="deleteBill(o)">Excluir</a>
                </td>
            </tr>
            </tbody>
        </table>
    `,
    data: function () {
        return {
            bills: [
                {date_due: '11/08/16', name: 'Conta de água', value: 55.99, done: true},
                {date_due: '11/08/16', name: 'Conta de luz', value: 130.95, done: false},
                {date_due: '15/08/16', name: 'Conta de telefone', value: 75.95, done: false},
                {date_due: '15/08/16', name: 'Cartão de crédito', value: 1350.85, done: false},
                {date_due: '20/08/16', name: 'Empréstimo', value: 2000.15, done: false},
                {date_due: '20/08/16', name: 'Supermecado', value: 650.45, done: false},
                {date_due: '20/08/16', name: 'Gasolina', value: 150.25, done: false},
            ]
        };
    },
    methods: {
        loadBill: function (bill) {
            this.$dispatch('change-bill', bill);
            this.$dispatch('change-actived-view', 1);
            this.$dispatch('change-form-type', 'update');
        },
        deleteBill: function (bill) {
            if (confirm('Deseja excluir está conta?')) {
                this.bills.$remove(bill);
            }
        },
        payBill: function (bill) {
            var message = (bill.done == 1) ? "Deseja mudar o status desta conta para 'Não paga'?"
                : "Deseja mudar o status desta conta para 'Paga'?";
            if (confirm(message)) {
                bill.done = !bill.done;
            }
        }
    },
    events: {
        'new-bill': function (bill) {
            this.bills.push(bill);
        }
    }
});
