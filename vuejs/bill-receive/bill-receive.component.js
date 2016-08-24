window.billReceiveComponent = Vue.extend({
    components: {
        'menu-component': billReceiveMenuComponent
    },
    template: `
        <h1>{{ title }}</h1>
        <h2 v-html="status | statusBillReceive"></h2>
        <menu-component></menu-component>
        <router-view></router-view>
    `,
    data: function () {
        return {
            title: "Contas a receber"
        };
    },
    computed: {
        status: function () {
            var count = 0, billsReceive = this.$root.$children[0].billsReceive;
            if (!billsReceive.length) {
                return false;
            }
            for (var i in billsReceive) {
                if (!billsReceive[i].done) {
                    count++;
                }
            }
            return count;
        }
    }
});
