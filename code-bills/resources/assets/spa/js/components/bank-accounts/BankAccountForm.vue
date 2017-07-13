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
                            <!--<select v-model="bankAccount.bank_id" class="browser-default">
                                <option value="" disabled selected>Escolha um banco</option>
                                <option v-for="o in banks" :value="o.id">{{ o.name }}</option>
                            </select>-->
                            <input type="text" id="bank-id" :value="bankAccount.bank.data.name"
                                   placeholder="Procure o banco" autocomplete="off"
                                   data-activates="bank-id-dropdown" data-beloworigin="true">
                            <ul id="bank-id-dropdown" class="dropdown-content ac-dropdown"></ul>
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
    import PageTitleComponent from '../PageTitle.vue';
    import 'materialize-autocomplete';
    import store from '../../store/store';

    export default {
        components: {
            pageTitle: PageTitleComponent
        },
        data() {
            return {
                title: '',
                formType: '',
                bankAccount: new BankAccount()
            };
        },
        computed: {
            banks() {
                return store.state.bank.banks;
            }
        },
        created() {
            this.getBanks();

            if (this.$route.name == 'bank-accounts.update') {
                this.title = 'Atualizar conta';
                this.formType = 'update';
                this.getBankAccount(this.$route.params.id);
            } else {
                this.title = 'Adicionar conta bancaria';
                this.formType = 'insert';
            }
        },
        methods: {
            submit() {
                store.dispatch('bankAccount/save', this.bankAccount).then(() => {
                    let msg = (this.formType == 'insert') ? 'Conta bancária cadastrada com sucesso!' : 'Conta bancária alterada com sucesso!';
                    Materialize.toast(msg, 4000);
                    this.$router.go({name: 'bank-accounts.list'});
                });
            },
            getBanks() {
                store.dispatch('bank/query').then(() => {
                    this.initAutocomplete();
                });
            },
            getBankAccount(id) {
                store.dispatch('bankAccount/find', id).then((response) => {
                    this.bankAccount = new BankAccount(response.data.data);
                });
            },
            initAutocomplete() {
                let self = this;

                $(document).ready(() => {
                    $('#bank-id').materialize_autocomplete({
                        limit: 10,
                        multiple: {
                            enable: false
                        },
                        appender: {
                            el: '.ac-dropdown'
                        },
                        dropdown: {
                            el: '#bank-id-dropdown'
                        },
                        getData: (value, callback) => {
                            let mapBanks = store.getters['bank/mapBanks'];
                            let banks = mapBanks(value);
                            callback(value, banks);
                        },
                        onSelect(item) {
                            self.bankAccount.bank_id = item.id;
                        }
                    });
                });
            },
        }
    };
</script>
