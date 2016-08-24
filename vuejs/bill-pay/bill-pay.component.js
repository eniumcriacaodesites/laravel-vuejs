window.billPayComponent = Vue.extend({
    components: {
        'menu-component': billPayMenuComponent
    },
    template: `
        <h1>{{ title }}</h1>
        <h2 v-html="status | statusBillPay"></h2>
        <menu-component></menu-component>
        <router-view></router-view>
    `,
    data: function () {
        return {
            title: "Contas a pagar"
        };
    },
    computed: {
        status: function () {
            var count = 0, billsPay = this.$root.$children[0].billsPay;
            if (!billsPay.length) {
                return false;
            }
            for (var i in billsPay) {
                if (!billsPay[i].done) {
                    count++;
                }
            }
            return count;
        }
    }
});
