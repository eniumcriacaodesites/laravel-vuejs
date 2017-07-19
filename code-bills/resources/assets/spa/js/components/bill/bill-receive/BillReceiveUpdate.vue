<template src="../_form.html"></template>

<script type="text/javascript">
    import billMixin from '../../../mixins/bill-mixin';
    import validatorOffRemoveMixin from '../../../mixins/validator-off-remove-mixin';
    import BillReceive from '../../../models/bill-receive';
    import store from '../../../store/store';

    export default {
        mixins: [billMixin, validatorOffRemoveMixin],
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
                return 'billReceive';
            },
            title() {
                return 'Editar pagamento';
            },
            categoryNamespace() {
                return 'categoryRevenue';
            },
            getBill() {
                this.resetScope();
                let bill = store.getters[`${this.namespace()}/billByIndex`](this.index);
                this.bill = new BillReceive(bill);
                let text = store.getters['bankAccount/textAutocomplete'](bill.bankAccount.data);
                this.bankAccount.text = text;
            }
        }
    };
</script>
