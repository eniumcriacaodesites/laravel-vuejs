window.billReceiveComponent = Vue.extend({
    components: {
        'menu-component': billReceiveMenuComponent
    },
    template: `
        <h1>{{ title }}</h1>
        <h2 v-html="status | statusBillReceive"></h2>
        <h3>{{ total | currency 'R$ ' }}</h3>
        <menu-component></menu-component>
        <router-view></router-view>
    `,
    data: function () {
        return {
            title: "Contas a receber",
            status: false,
            total: 0
        };
    },
    created: function () {
        this.updateStatus();
        this.updateTotal();
    },
    methods: {
        calculateStatus: function (billsReceive) {
            var count = 0;
            if (!billsReceive.length) {
                this.status = false;
            } else {
                for (var i in billsReceive) {
                    if (!billsReceive[i].done) {
                        count++;
                    }
                }
                this.status = count;
            }
        },
        updateStatus: function () {
            var self = this;
            BillReceive.query().then(function (response) {
                self.calculateStatus(response.data);
            });
        },
        updateTotal: function () {
            var self = this;
            BillReceive.total().then(function (response) {
                self.total = response.data.total;
            })
        }
    },
    events: {
        'change-info': function () {
            this.updateStatus();
            this.updateTotal();
        }
    }
});
