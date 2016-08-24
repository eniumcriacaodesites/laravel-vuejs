window.appComponent = Vue.extend({
    components: {
        'menu-component': menuComponent
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
    `,
    data: function () {
        return {
            title: "Contas a pagar"
        };
    },
    computed: {
        status: function () {
            var count = 0, bills = this.$root.$children[0].bills;
            if (!bills.length) {
                return false;
            }
            for (var i in bills) {
                if (!bills[i].done) {
                    count++;
                }
            }
            return count;
        }
    }
});
