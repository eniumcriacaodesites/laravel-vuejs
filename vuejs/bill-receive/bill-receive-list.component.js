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
                <td>{{ o.value | currency 'R$ ' 2 }}</td>
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
    data: function () {
        return {
            billsReceive: []
        };
    },
    created: function () {
        var self = this;
        BillReceive.query().then(function (response) {
            self.billsReceive = response.data;
        });
    },
    methods: {
        deleteBill: function (bill) {
            var self = this;
            if (confirm('Deseja excluir está conta?')) {
                BillReceive.delete({id: bill.id}).then(function (response) {
                    self.$dispatch('change-info');
                    self.billsReceive.$remove(bill);
                });
            }
        },
        receiveBill: function (bill) {
            var self = this;
            if (confirm("Deseja alterar o status desta conta?")) {
                bill.done = !bill.done;
                BillReceive.update({id: bill.id}, bill).then(function (response) {
                    self.$dispatch('change-info');
                });
            }
        }
    }
});
