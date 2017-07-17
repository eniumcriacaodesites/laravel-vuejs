import ModalComponent from "../../../_default/components/Modal.vue";
import store from "../store/store";

export default {
    components: {
        modal: ModalComponent
    },
    props: {
        index: {
            type: Number,
            required: false,
            'default': -1
        },
        modalOptions: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            bill: {
                id: 0,
                date_due: '',
                name: '',
                value: '',
                done: false,
                bank_account_id: 0
            }
        };
    },
    computed: {
        bankAccounts() {
            return store.state.bankAccount.lists;
        }
    },
    watch: {
        bankAccounts(bankAccounts) {
            if (bankAccounts.length > 0) {
                this.initAutocomplete();
            }
        }
    },
    methods: {
        doneId() {
            return `done-${this._uid}`;
        },
        bankAccountTextId() {
            return `bank-account-text-${this._uid}`;
        },
        bankAccountDropdownId() {
            return `bank-account-dropdown-${this._uid}`;
        },
        initAutocomplete() {
            let self = this;

            $(document).ready(() => {
                $(`#${this.bankAccountTextId()}`).materialize_autocomplete({
                    limit: 10,
                    multiple: {
                        enable: false
                    },
                    appender: {
                        el: '.ac-dropdown'
                    },
                    dropdown: {
                        el: `#${this.bankAccountDropdownId()}`
                    },
                    getData: (value, callback) => {
                        let mapBankAccounts = store.getters['bankAccount/mapBankAccounts'];
                        let bankAccounts = mapBankAccounts(value);
                        callback(value, bankAccounts);
                    },
                    onSelect(item) {
                        self.bill.bank_account_id = item.id;
                    }
                });
            });
        },
        submit() {
            if (this.bill.id !== 0) {
                store.dispatch(`${this.namespace()}/edit`, {index: this.index, bill: this.bill}).then(() => {
                    Materialize.toast('Conta atualizada com sucesso!', 4000);
                    this.resetScope();
                });
            } else {
                store.dispatch(`${this.namespace()}/save`, this.bill).then(() => {
                    Materialize.toast('Conta criada com sucesso!', 4000);
                    this.resetScope();
                });
            }
        },
        resetScope() {
            this.bill = {
                id: 0,
                date_due: '',
                name: '',
                value: '',
                done: false,
                bank_account_id: 0
            }
        }
    }
};
