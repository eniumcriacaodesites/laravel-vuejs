window.billPayComponent = Vue.extend({
    components: {
        'menu-component': billPayMenuComponent
    },
    template: `
        <div class="section">
            <div class="container">
                <h1>{{ title }}</h1>
                <h2 v-html="status | statusBillPay"></h2>
                <h3>{{ total | numberFormat 'pt-br' }}</h3>
                <menu-component></menu-component>
            </div>    
        </div>
        <router-view></router-view>
    `,
    data() {
        return {
            title: "Contas a pagar",
            status: false,
            total: 0
        };
    },
    created() {
        this.updateStatus();
        this.updateTotal();
    },
    methods: {
        calculateStatus(billsPay) {
            let count = 0;
            if (!billsPay.length) {
                this.status = false;
            } else {
                for (let i in billsPay) {
                    if (!billsPay[i].done) {
                        count++;
                    }
                }
                this.status = count;
            }
        },
        updateStatus() {
            BillPayResource.query().then((response) => {
                this.calculateStatus(response.data);
            });
        },
        updateTotal() {
            BillPayResource.total().then((response) => {
                this.total = response.data.total;
            })
        }
    },
    events: {
        'change-info'() {
            this.updateStatus();
            this.updateTotal();
        }
    }
});
