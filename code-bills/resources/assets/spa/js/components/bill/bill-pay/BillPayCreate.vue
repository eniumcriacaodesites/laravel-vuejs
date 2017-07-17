<template src="../_form.html"></template>

<script type="text/javascript">
    import billMixin from '../../../mixins/bill-mixin';

    export default {
        mixins: [billMixin],
        methods: {
            namespace() {
                return 'billPay';
            },
            categoryNamespace() {
                return 'categoryExpense';
            },
            title() {
                return 'Novo pagamento';
            }
        }
    };
</script>
