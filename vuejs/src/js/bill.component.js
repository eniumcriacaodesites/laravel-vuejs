export default {
    template: `
        <header>
            <ul v-bind:id="o.id" class="dropdown-content" v-for="o in menusDropdown">
                <li v-for="item in o.items">
                    <a v-link="{name: item.routeName}">{{ item.name }}</a>
                </li>
            </ul>
            <div class="navbar-fixed">
                <nav>
                    <div class="nav-wrapper container">
                        <div class="brand-logo right">CodeBills</div>
                        <a href="#" data-activates="nav-mobile" class="button-collapse">
                            <i class="material-icons">menu</i>
                        </a>
                        <ul class="left hide-on-med-and-down">
                            <li v-for="o in menus">
                                <a v-if="o.dropdownId" class="dropdown-button" href="!#" v-bind:data-activates="o.dropdownId">
                                    {{ o.name }} <i class="material-icons right">arrow_drop_down</i>
                                </a>
                                <a v-else v-link="{name: o.routeName}">{{ o.name }}</a>
                            </li>
                        </ul>
                        <ul id="nav-mobile" class="side-nav">
                            <li v-for="o in menus">
                                <a v-link="{name: o.routeName}">{{ o.name }}</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <main>
            <router-view></router-view>
        </main>
        <footer>
            <h6 class="center-align">&copy; 2016 - CodeBills</h6>
        </footer>
    `,
    ready() {
        $('.button-collapse').sideNav();
        $('.dropdown-button').dropdown();
    },
    data() {
        return {
            menus: [
                {name: "Dashboard", routeName: 'dashboard'},
                {name: "Contas a pagar", routeName: 'bill-pay.list', dropdownId: 'bill-pay'},
                {name: "Contas a receber", routeName: 'bill-receive.list', dropdownId: 'bill-receive'}
            ],
            menusDropdown: [
                {
                    id: 'bill-pay',
                    items: [
                        {name: "Listar contas", routeName: 'bill-pay.list'},
                        {name: "Criar conta", routeName: 'bill-pay.create'}
                    ]
                },
                {
                    id: 'bill-receive',
                    items: [
                        {name: "Listar contas", routeName: 'bill-receive.list'},
                        {name: "Criar conta", routeName: 'bill-receive.create'}
                    ]
                }
            ]
        };
    }
};
