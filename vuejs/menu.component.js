window.menuComponent = Vue.extend({
    template: `
        <nav>
            <ul>
                <li v-for="o in menus">
                    <a href="#" v-on:click.prevent="viewShow(o.id)">{{ o.name }}</a>
                </li>
            </ul>
        </nav>
    `,
    data: function () {
        return {
            menus: [
                {id: 0, name: "Listar contas"},
                {id: 1, name: "Criar conta"}
            ]
        };
    },
    methods: {
        viewShow: function (id) {
            this.$dispatch('change-actived-view', id);
            if (id == 1) {
                this.$dispatch('change-form-type', 'insert');
            }
        }
    }
});
