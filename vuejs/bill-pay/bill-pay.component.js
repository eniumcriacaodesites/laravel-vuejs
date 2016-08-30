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
            title: "Contas a pagar",
            status: false
        };
    },
    created: function () {
        this.updateStatus();
    },
    methods: {
        calculateStatus: function (billsPay) {
            var count = 0;
            if (!billsPay.length) {
                this.status = false;
            } else {
                for (var i in billsPay) {
                    if (!billsPay[i].done) {
                        count++;
                    }
                }
                this.status = count;
            }
        },
        updateStatus: function () {
            var self = this;
            BillPay.query().then(function (response) {
                self.calculateStatus(response.data);
            });
        }
    },
    events: {
        'change-status': function () {
            this.updateStatus();
        }
    }
});
