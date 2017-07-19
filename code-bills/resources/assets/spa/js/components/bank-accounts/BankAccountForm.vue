<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>{{ title }}</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <form :id="formId()" name="form" @submit.prevent="submit">
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" v-model="bankAccount.name" id="name" name="name"
                                   placeholder="Informe um nome"
                                   class="validate" v-validate data-vv-as="nome" data-vv-rules="required"
                                   :class="{'invalid': errors.has('name')}">
                            <label class="active" for="name" :data-error="errors.first('name')">Nome:</label>
                        </div>
                        <div class="input-field col s6">
                            <!--<select v-model="bankAccount.bank_id" class="browser-default">
                                <option value="" disabled selected>Escolha um banco</option>
                                <option v-for="o in banks" :value="o.id">{{ o.name }}</option>
                            </select>-->
                            <input type="text" :id="bankTextId()" placeholder="Procure o banco"
                                   class="validate" :class="{'invalid': errors.has('bank_id')}" autocomplete="off"
                                   :data-activates="bankDropdownId()" data-beloworigin="true"
                                   :value="bank.text" @blur="blurBank">
                            <label class="active" :data-error="errors.first('bank_id')">Banco:</label>
                            <input type="hidden" name="bank_id" :id="bankHiddenId()"
                                   :value="bankAccount.bank_id" v-validate data-vv-rules="required"
                                   data-vv-as="banco">
                            <ul :id="bankDropdownId()" class="dropdown-content ac-dropdown"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" v-model="bankAccount.agency" id="agency" name="agency"
                                   placeholder="Informe a agência"
                                   class="validate" v-validate data-vv-as="agência" data-vv-rules="required"
                                   :class="{'invalid': errors.has('agency')}">
                            <label class="active" for="name" :data-error="errors.first('agency')">Agência:</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" v-model="bankAccount.account" id="account" name="account"
                                   placeholder="Informe o numero da conta"
                                   class="validate" v-validate data-vv-as="conta" data-vv-rules="required"
                                   :class="{'invalid': errors.has('account')}">
                            <label class="active" for="name" :data-error="errors.first('account')">Conta:</label>
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
                            <button type="submit" class="btn-save" :disabled="fields.dirty() && errors.any()">Salvar
                            </button>
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
    import validatorOffRemoveMixin from '../../mixins/validator-off-remove-mixin';
    import store from '../../store/store';

    export default {
        mixins: [validatorOffRemoveMixin],
        components: {
            pageTitle: PageTitleComponent
        },
        data() {
            return {
                title: '',
                formType: '',
                bankAccount: new BankAccount(),
                bank: {
                    text: ''
                }
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
            bankTextId() {
                return `bank-text-${this._uid}`;
            },
            bankDropdownId() {
                return `bank-dropdown-${this._uid}`;
            },
            bankHiddenId() {
                return `bank-hidden-${this._uid}`;
            },
            formId() {
                return `form-bank-account-${this._uid}`;
            },
            blurBank($event) {
                let el = $($event.target);
                let text = this.bank.text;

                if (el.val() != text) {
                    el.val(text);
                }

                this.validateBank();
            },
            validateBank() {
                this.$validator.validate('bank_id', this.bankAccount.bank_id);
            },
            submit() {
                this.$validator.validateAll().then(success => {
                    if (success) {
                        store.dispatch('bankAccount/save', this.bankAccount).then(() => {
                            let msg = (this.formType == 'insert')
                                ? 'Conta bancária cadastrada com sucesso!' : 'Conta bancária alterada com sucesso!';
                            Materialize.toast(msg, 4000);
                            this.$router.go({name: 'bank-accounts.list'});
                        });
                    }
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
                    this.bank.text = this.bankAccount.bank.data.name;
                });
            },
            initAutocomplete() {
                let self = this;

                $(document).ready(() => {
                    $(`#${this.bankTextId()}`).materialize_autocomplete({
                        limit: 10,
                        multiple: {
                            enable: false
                        },
                        appender: {
                            el: '.ac-dropdown'
                        },
                        hidden: {
                            el: `#${this.bankHiddenId()}`
                        },
                        dropdown: {
                            el: `#${this.bankDropdownId()}`
                        },
                        getData: (value, callback) => {
                            let mapBanks = store.getters['bank/mapBanks'];
                            let banks = mapBanks(value);
                            callback(value, banks);
                        },
                        onSelect(item) {
                            self.bankAccount.bank_id = item.id;
                            self.bank.text = item.text;
                            self.validateBank();
                        }
                    });
                });

                $(`#${this.bankTextId()}`).parent().find('label').insertAfter($(`#${this.bankTextId()}`));
            },
        }
    };
</script>
