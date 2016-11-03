window.billPayCreateComponent = Vue.extend({
    template: `
        <div class="container">
            <form name="form" @submit.prevent="submit">
                <label>Vencimento:</label>
                <input type="text" v-model="bill.date_due | dateFormat 'pt-br'">
                <br><br>
                <label>Nome:</label>
                <select v-model="bill.name">
                    <option v-for="o in names" :value="o">{{ o | textFormat }}</option>
                </select>
                <br><br>
                <label>Valor:</label>
                <input type="text" v-model="bill.value | numberFormat 'pt-br'">
                <br><br>
                <label>Pago?</label>
                <input type="checkbox" v-model="bill.done">
                <br><br>
                <input type="submit" value="Enviar">
            </form>
        </div>
    `,
    data() {
        return {
            formType: 'insert',
            names: [
                'Conta de luz',
                'Conta de água',
                'Conta de telefone',
                'Supermecado',
                'Cartão de crédito',
                'Empréstimo',
                'Gasolina'
            ],
            bill: new BillPay()
        };
    },
    created() {
        if (this.$route.name == 'bill-pay.update') {
            this.formType = 'update';
            this.getBill(this.$route.params.id);
        }
    },
    methods: {
        submit() {
            let bill = this.bill.toJSON();
            if (this.formType == 'insert') {
                BillPayResource.save({}, bill).then((response) => {
                    this.$dispatch('change-info');
                    this.$router.go({name: 'bill-pay.list'});
                });
            } else {
                BillPayResource.update({id: this.bill.id}, bill).then((response) => {
                    this.$dispatch('change-info');
                    this.$router.go({name: 'bill-pay.list'});
                });
            }
        },
        getBill(id) {
            BillPayResource.get({id: id}).then((response) => {
                this.bill = new BillPay(response.data);
            });
        }
    }
});
