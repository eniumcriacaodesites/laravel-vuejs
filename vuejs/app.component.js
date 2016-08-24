window.appComponent = Vue.extend({
    components: {
        'menu-component': menuComponent,
        'bill-list-component': billListComponent,
        'bill-create-component': billCreateComponent,
    },
    template: `
        <style type="text/css">
            .green, .green a {
                color: green;
            }
    
            .red, .red a {
                color: red;
            }
    
            .gray, .gray a {
                color: gray;
            }
    
            .my-class {
                background-color: burlywood;
            }
        </style>
        <h1>{{ title }}</h1>
        <h2 v-html="status | statusLabel"></h2>
        
        <menu-component></menu-component>
        
        <router-view></router-view>
        
        <!--<div v-show="activedView == 0">
            <bill-list-component v-ref:bill-list-component></bill-list-component>
        </div>
        
        <div v-show="activedView == 1">
            <bill-create-component></bill-create-component>
        </div>-->
    `,
    data: function () {
        return {
            title: "Contas a pagar",
            activedView: 0
        };
    },
    computed: {
        status: function () {
            var count = 0, billListCompoment = this.$refs.billListComponent;
            if (!billListCompoment.bills.length) {
                return false;
            }
            for (var i in billListCompoment.bills) {
                if (!billListCompoment.bills[i].done) {
                    count++;
                }
            }
            return count;
        }
    },
    methods: {},
    events: {
        'change-actived-view': function (activedView) {
            this.activedView = activedView;
        },
        'change-form-type': function (formType) {
            this.$broadcast('change-form-type', formType);
        },
        'change-bill': function (bill) {
            this.$broadcast('change-bill', bill);
        },
        'new-bill': function (bill) {
            this.$broadcast('new-bill', bill);
        }
    }
});
