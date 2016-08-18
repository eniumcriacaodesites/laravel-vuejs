var menuComponent = Vue.extend({
    template: `
        <nav>
            <ul>
                <li v-for="o in menus">
                    <a href="#" v-on:click.prevent="viewShow(o.id)">{{ o.name }}</a>
                </li>
            </ul>
        </nav>
    `,
    data: function () {
        return {
            menus: [
                {id: 0, name: "Listar contas"},
                {id: 1, name: "Criar conta"}
            ]
        };
    },
    methods: {
        viewShow: function (id) {
            this.$parent.activedView = id;
            if (id == 1) {
                this.$root.$children[0].formType = 'insert';
            }
        }
    }
});

var billListComponent = Vue.extend({
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
            this.$parent.bill = bill;
            this.$parent.activedView = 1;
            this.$parent.formType = 'update';
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
    }
});

var billCreateComponent = Vue.extend({
    template: `
        <form name="form" @submit.prevent="submit">
            <label>Vencimento:</label>
            <input type="text" v-model="bill.date_due">
            <br><br>
            <label>Nome:</label>
            <select v-model="bill.name">
                <option v-for="o in names" :value="o">{{ o }}</option>
            </select>
            <br><br>
            <label>Valor:</label>
            <input type="text" v-model="bill.value">
            <br><br>
            <label>Pago?</label>
            <input type="checkbox" v-model="bill.done">
            <br><br>
            <input type="submit" value="Enviar">
        </form>
    `,
    props: ['bill', 'formType'],
    data: function () {
        return {
            names: [
                'Conta de luz',
                'Conta de água',
                'Conta de telefone',
                'Supermecado',
                'Cartão de crédito',
                'Empréstimo',
                'Gasolina'
            ]
        };
    },
    methods: {
        submit: function () {
            if (this.formType == 'insert') {
                this.$parent.$children[1].bills.push(this.bill);
            }
            this.bill = {
                date_due: '',
                name: '',
                value: 0,
                done: false
            };
            this.$parent.activedView = 0;
        }
    }
});

var appComponent = Vue.extend({
    components: {
        'menu-component': menuComponent,
        'bill-list-component': billListComponent,
        'bill-create-component': billCreateComponent,
    },
    template: `
        <style type="text/css">
            .green, .green a {
                color: green;
            }
    
            .red, .red a {
                color: red;
            }
    
            .gray, .gray a {
                color: gray;
            }
    
            .my-class {
                background-color: burlywood;
            }
        </style>
        <h1>{{ title }}</h1>
        <h2 v-html="status | statusLabel"></h2>
        
        <menu-component></menu-component>
        
        <div v-show="activedView == 0">
            <bill-list-component></bill-list-component>
        </div>
        
        <div v-show="activedView == 1">
            <bill-create-component :bill.sync="bill" :form-type="formType"></bill-create-component>
        </div>
    `,
    data: function () {
        return {
            title: "Contas a pagar",
            activedView: 0,
            formType: 'insert',
            bill: {
                date_due: '',
                name: '',
                value: 0,
                done: false
            }
        };
    },
    computed: {
        status: function () {
            var count = 0;
            if (!this.bills.length) {
                return false;
            }
            for (var i in this.bills) {
                if (!this.bills[i].done) {
                    count++;
                }
            }
            return count;
        }
    },
    methods: {}
});

Vue.component('app-component', appComponent);

var app = new Vue({
    el: "#app"
});
