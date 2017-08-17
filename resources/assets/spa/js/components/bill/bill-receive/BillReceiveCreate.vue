<template src="../_form.html"></template>

<script type="text/javascript">
    import billMixin from '../../../mixins/bill-mixin';
    import validatorOffRemoveMixin from '../../../mixins/validator-off-remove-mixin';

    export default {
        mixins: [billMixin, validatorOffRemoveMixin],
        ready() {
            this.initSelect2();
        },
        methods: {
            namespace() {
                return 'billReceive';
            },
            categoryNamespace() {
                return 'categoryRevenue';
            },
            title() {
                return 'Novo pagamento';
            }
        }
    };
</script>
