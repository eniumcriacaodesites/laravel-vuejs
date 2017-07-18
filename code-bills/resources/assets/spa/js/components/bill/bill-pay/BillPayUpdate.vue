<template src="../_form.html"></template>

<script type="text/javascript">
    import billMixin from '../../../mixins/bill-mixin';
    import BillPay from '../../../models/bill-pay';
    import store from '../../../store/store';

    export default {
        mixins: [billMixin],
        ready() {
            this.initSelect2();
        },
        created() {
            let self = this;
            this.modalOptions.options = {};
            this.modalOptions.options.ready = () => {
                self.getBill();
            };
        },
        methods: {
            namespace() {
                return 'billPay';
            },
            title() {
                return 'Editar pagamento';
            },
            categoryNamespace() {
                return 'categoryExpense';
            },
            getBill() {
                this.resetScope();
                let bill = store.getters[`${this.namespace()}/billByIndex`](this.index);
                this.bill = new BillPay(bill);
                let text = store.getters['bankAccount/textAutocomplete'](bill.bankAccount.data);
                this.bankAccount.text = text;
            }
        }
    };
</script>
