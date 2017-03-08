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
                            <input type="text" v-model="bankAccount.name" placeholder="Informe um nome">
                            <label class="active">Nome:</label>
                        </div>
                        <div class="input-field col s6">
                            <select v-model="bankAccount.bank_id" class="browser-default">
                                <option value="" disabled selected>Escolha um banco</option>
                                <option v-for="o in banks" :value="o.id">{{ o.name }}</option>
                            </select>
                            <label class="active">Banco:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" v-model="bankAccount.agency" placeholder="Informe a agência">
                            <label class="active">Agência:</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" v-model="bankAccount.account" placeholder="Informe o numero da conta">
                            <label class="active">Conta:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="checkbox" id="account_default" class="filled-in" v-model="bankAccount.default">
                            <label for="account_default">Padrão?</label>
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
                title: '',
                formType: '',
                banks: [],
                bankAccount: new BankAccount()
            };
        },
        created() {
            this.getBanks();

            if (this.$route.name == 'bank-accounts.update') {
                this.title = 'Atualizar conta';
                this.formType = 'update';
                this.getBill(this.$route.params.id);
            } else {
                this.title = 'Adicionar conta bancaria';
                this.formType = 'insert';
            }
        },
        methods: {
            submit() {
                let bankAccount = this.bankAccount.toJSON();

                if (this.formType == 'insert') {
                    BankAccountResource.save({}, bankAccount).then((response) => {
                        Materialize.toast('Conta cadastrada com sucesso!', 4000);
                        this.$router.go({name: 'bank-accounts.list'});
                    });
                } else {
                    BankAccountResource.update({id: this.bankAccount.id}, bankAccount).then((response) => {
                        Materialize.toast('Conta alterada com sucesso!', 4000);
                        this.$router.go({name: 'bank-accounts.list'});
                    });
                }
            },
            getBanks() {
                BankResource.get().then((response) => {
                    this.banks = response.data.data;
                });
            },
            getBill(id) {
                BankAccountResource.get({id: id}).then((response) => {
                    this.bankAccount = new BankAccount(response.data.data);
                });
            }
        }
    };
</script>
