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
                            <label class="active">Nome:</label>
                            <input type="text" v-model="bill.name" placeholder="Informe um nome">
                        </div>
                        <div class="input-field col s6">
                            <label class="active">Banco:</label>
                            <select v-model="bill.bank_id" class="browser-default">
                                <option value="" disabled selected>Escolha um banco</option>
                                <option v-for="o in banks" :value="o.id">{{ o.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label class="active">Agência:</label>
                            <input type="text" v-model="bill.agency" placeholder="Informe a agência">
                        </div>
                        <div class="input-field col s6">
                            <label class="active">Conta:</label>
                            <input type="text" v-model="bill.account" placeholder="Informe o numero da conta">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 right-align">
                            <button type="submit" class="btn-save">Salvar</button>
                            <a v-link="{name: 'bank-accounts.list'}" class="btn-cancel">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import BankAccount from "./BankAccount";
    import {BankResource} from '../../services/resource';
    import {BankAccountResource} from '../../services/resource';
    import PageTitleComponent from '../PageTitle.vue';

    export default {
        components: {
            pageTitle: PageTitleComponent
        },
        data() {
            return {
                title: 'Adicionar conta bancaria',
                formType: 'insert',
                banks: [],
                bill: new BankAccount()
            };
        },
        created() {
            BankResource.get().then((response) => {
                this.banks = response.data.data;
            });

            if (this.$route.name == 'bank-accounts.update') {
                this.title = 'Atualizar conta';
                this.formType = 'update';
                this.getBill(this.$route.params.id);
            }
        },
        methods: {
            submit() {
                let bill = this.bill.toJSON();
                if (this.formType == 'insert') {
                    BankAccountResource.save({}, bill).then((response) => {
                        this.$dispatch('change-info');
                        Materialize.toast('Conta cadastrada com sucesso!', 4000);
                        this.$router.go({name: 'bank-accounts.list'});
                    });
                } else {
                    BankAccountResource.update({id: this.bill.id}, bill).then((response) => {
                        this.$dispatch('change-info');
                        Materialize.toast('Conta alterada com sucesso!', 4000);
                        this.$router.go({name: 'bank-accounts.list'});
                    });
                }
            },
            getBill(id) {
                BankAccountResource.get({id: id}).then((response) => {
                    this.bill = new BankAccount(response.data.data);
                });
            }
        }
    };
</script>
