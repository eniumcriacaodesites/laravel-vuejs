<template>
    <ul :id="o.id" class="dropdown-content" v-for="o in menusDropdown">
        <li v-for="item in o.items">
            <a v-link="{name: item.routeName}">{{ item.name }}</a>
        </li>
    </ul>
    <ul id="dropdown-logout" class="dropdown-content">
        <li>
            <a v-link="{name: 'auth.logout'}">Sair</a>
        </li>
    </ul>
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper container">
                <div class="brand-logo left">
                    <a v-link="{name: 'dashboard'}">
                        CodeBills
                    </a>
                </div>
                <a href="#" data-activates="nav-mobile" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="hide-on-med-and-down right">
                    <li v-for="o in menus">
                        <a v-if="o.dropdownId" class="dropdown-button" href="!#"
                           :data-activates="o.dropdownId">
                            {{ o.name }} <i class="material-icons right">arrow_drop_down</i>
                        </a>
                        <a v-else v-link="{name: o.routeName}">{{ o.name }}</a>
                    </li>
                    <li>
                        <a class="dropdown-button" href="#" data-activates="dropdown-logout">
                            {{ name }} <i class="material-icons right">arrow_drop_down</i>
                        </a>
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
</template>

<script type="text/javascript">
    import store from '../store/store';

    export default {
        data() {
            return {
                menus: [
                    {name: "Plano de contas", routeName: 'plan-account', dropdownId: ''},
                    {name: "Contas bancárias", routeName: '', dropdownId: 'bank-accounts'},
                    {name: "Contas", routeName: '', dropdownId: 'bills-dropdown'},
                    {name: "Fluxo de caixa", routeName: 'cash-flow.list', dropdownId: ''},
                    /*{name: "Categorias", routeName: 'categories.list', dropdownId: ''},
                    {name: "Contas a pagar", routeName: '', dropdownId: 'bill-pays'},
                    {name: "Contas a receber", routeName: '', dropdownId: 'bill-receives'}*/
                ],
                menusDropdown: [
                    {
                        id: 'bills-dropdown',
                        items: [
                            {name: "À pagar", routeName: 'bill-pay.list'},
                            {name: "À receber", routeName: 'bill-receive.list'}
                        ]
                    },
                    {
                        id: 'bank-accounts',
                        items: [
                            {name: "Listar contas", routeName: 'bank-accounts.list'},
                            {name: "Criar conta", routeName: 'bank-accounts.create'}
                        ]
                    },
                    {
                        id: 'bill-pays',
                        items: [
                            {name: "Listar contas", routeName: 'bill-pays.list'},
                            {name: "Criar conta", routeName: 'bill-pays.create'}
                        ]
                    },
                    {
                        id: 'bill-receives',
                        items: [
                            {name: "Listar contas", routeName: 'bill-receives.list'},
                            {name: "Criar conta", routeName: 'bill-receives.create'}
                        ]
                    }
                ],
            };
        },
        computed: {
            name() {
                return store.state.auth.user.name;
            }
        },
        ready() {
            $('.button-collapse').sideNav();
            $('.dropdown-button').dropdown();
        }
    };
</script>
