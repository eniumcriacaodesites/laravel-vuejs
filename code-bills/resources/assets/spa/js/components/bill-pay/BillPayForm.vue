<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>{{ title }}</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <form name="form" @submit.prevent="submit">
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" v-model="bill.date_due" placeholder="Informe a data">
                            <label class="active">Vencimento:</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" v-model="bill.value">
                            <label class="active">Valor:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" v-model="bill.name" placeholder="Informe o nome">
                            <label class="active">Nome:</label>
                        </div>
                        <div class="input-field col s6">
                            <div class="switch">
                                <label>
                                    Off
                                    <input type="checkbox" v-model="bill.done">
                                    <span class="lever"></span>
                                    On
                                </label>
                            </div>
                            <label class="active">Pago?</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 right-align">
                            <button type="submit" class="btn-save">Salvar</button>
                            <a v-link="{name: 'bill-pays.list'}" class="btn-cancel">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import BillPay from "./BillPay";
    import {BillPayResource} from '../../services/resource';
    import PageTitleComponent from '../PageTitle.vue';

    export default {
        components: {
            pageTitle: PageTitleComponent
        },
        data() {
            return {
                title: '',
                formType: '',
                bill: new BillPay()
            };
        },
        created() {
            if (this.$route.name == 'bill-pays.update') {
                this.title = 'Atualizar conta a receber';
                this.formType = 'update';
                this.getBill(this.$route.params.id);
            } else {
                this.title = 'Adicionar conta a receber';
                this.formType = 'insert';
            }
        },
        methods: {
            submit() {
                let bill = this.bill.toJSON();

                if (this.formType == 'insert') {
                    BillPayResource.save({}, bill).then((response) => {
                        Materialize.toast('Conta cadastrada com sucesso!', 4000);
                        this.$router.go({name: 'bill-pays.list'});
                    });
                } else {
                    BillPayResource.update({id: this.bill.id}, bill).then((response) => {
                        Materialize.toast('Conta alterada com sucesso!', 4000);
                        this.$router.go({name: 'bill-pays.list'});
                    });
                }
            },
            getBill(id) {
                BillPayResource.get({id: id}).then((response) => {
                    this.bill = new BillPay(response.data.data);
                });
            }
        }
    };
</script>
