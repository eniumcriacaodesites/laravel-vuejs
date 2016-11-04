window.billReceiveCreateComponent = Vue.extend({
    template: `
        <div class="container">
            <form name="form" @submit.prevent="submit">
                <label>Recebimento:</label>
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
                <label>Recebeu?</label>
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
                'Freelance',
                'Salário',
                'Seguro desemprego',
                'Décimo terceiro',
                'Outros'
            ],
            bill: new BillReceive()
        };
    },
    created() {
        if (this.$route.name == 'bill-receive.update') {
            this.formType = 'update';
            this.getBill(this.$route.params.id);
        }
    },
    methods: {
        submit() {
            let bill = this.bill.toJSON();
            if (this.formType == 'insert') {
                BillReceiveResource.save({}, bill).then((response) => {
                    this.$dispatch('change-info');
                    this.$router.go({name: 'bill-receive.list'});
                });
            } else {
                BillReceiveResource.update({id: this.bill.id}, bill).then((response) => {
                    this.$dispatch('change-info');
                    this.$router.go({name: 'bill-receive.list'});
                });
            }
        },
        getBill(id) {
            BillReceiveResource.get({id: id}).then((response) => {
                this.bill = new BillReceive(response.data);
            });
        }
    }
});
