let BillPay = require('./bill-pay');

module.exports = {
    template: `
        <div class="container">
            <h4>{{ title }}</h4>
            <form name="form" @submit.prevent="submit">
                <div class="row">
                    <div class="input-field col s6">
                        <label class="active">Vencimento:</label>
                        <input type="text" v-model="bill.date_due | dateFormat 'pt-br'" placeholder="Informe a data">
                    </div>
                    <div class="input-field col s6">
                        <label class="active">Valor:</label>
                        <input type="text" v-model="bill.value | numberFormat 'pt-br'">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <label class="active">Nome:</label>
                        <select v-model="bill.name" class="browser-default">
                            <option value="" disabled selected>Escolha um nome</option>
                            <option v-for="o in names" :value="o">{{ o | textFormat }}</option>
                        </select>
                    </div>
                    <div class="input-field col s6">
                        <label class="active">Pago?</label>
                        <div class="switch">
                            <label>
                                Off
                                <input type="checkbox" v-model="bill.done">
                                <span class="lever"></span>
                                On
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button class="btn-send" type="submit" name="action">Enviar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    `,
    data() {
        return {
            title: 'Adicionar conta',
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
            this.title = 'Atualizar conta';
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
                    Materialize.toast('Conta cadastrada com sucesso!', 4000);
                    this.$router.go({name: 'bill-pay.list'});
                });
            } else {
                BillPayResource.update({id: this.bill.id}, bill).then((response) => {
                    this.$dispatch('change-info');
                    Materialize.toast('Conta alterada com sucesso!', 4000);
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
};
