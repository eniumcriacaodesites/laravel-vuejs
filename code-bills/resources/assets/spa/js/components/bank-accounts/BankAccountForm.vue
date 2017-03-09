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
    import {BankResource} from '../../services/resource';
    import {BankAccountResource} from '../../services/resource';
    import PageTitleComponent from '../PageTitle.vue';
    import 'materialize-autocomplete';
    import _ from 'lodash';

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
                this.getBankAccount(this.$route.params.id);
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
                    this.initAutocomplete();
                });
            },
            getBankAccount(id) {
                BankAccountResource.get({id: id, include: 'bank'}).then((response) => {
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
                            let banks = self.filterBankByName(value);

                            banks = banks.map((o) => {
                                return {id: o.id, text: o.name};
                            });

                            callback(value, banks);
                        },
                        onSelect(item) {
                            self.bankAccount.bank_id = item.id;
                        }
                    });
                });
            },
            filterBankByName(name) {
                let banks = _.filter(this.banks, (o) => {
                    return _.includes(o.name.toLowerCase(), name.toLowerCase());
                });

                return banks;
            }
        }
    };
</script>
