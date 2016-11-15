window.billReceiveCreateComponent = Vue.extend({
    template: `
        <div class="container">
            <form name="form" @submit.prevent="submit">
                <div class="row">
                    <div class="input-field col s6">
                        <label class="active">Recebimento:</label>
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
                        <label class="active">Recebeu?</label>
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
                        <button class="btn waves-effect waves-light right" type="submit" name="action">Enviar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
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
