window.billReceiveComponent = Vue.extend({
    template: `
        <h1>{{ title }}</h1>
        <router-view></router-view>
    `,
    data: function () {
        return {
            title: "Contas a receber"
        };
    }
});
