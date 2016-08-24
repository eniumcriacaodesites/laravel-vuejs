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
                    <a v-link="{name: 'bill-receive.update', params: {index: index}}">Editar</a> |
                    <a href="#" @click.prevent="deleteBill(o)">Excluir</a>
                </td>
            </tr>
            </tbody>
        </table>
    `,
    data: function () {
        return {
            billsReceive: this.$root.$children[0].billsReceive
        };
    },
    methods: {
        deleteBill: function (bill) {
            if (confirm('Deseja excluir está conta?')) {
                this.$root.$children[0].billsReceive.$remove(bill);
            }
        },
        receiveBill: function (bill) {
            if (confirm("Deseja alterar o status desta conta?")) {
                bill.done = !bill.done;
            }
        }
    }
});
