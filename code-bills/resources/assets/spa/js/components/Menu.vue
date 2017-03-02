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
    import Auth from '../services/auth';

    export default {
        data() {
            return {
                menus: [
                    {name: "Contas bancárias", routeName: '', dropdownId: 'bank-accounts'},
                    {name: "Contas a pagar", routeName: 'dashboard', dropdownId: 'bill-pay'},
                    {name: "Contas a receber", routeName: 'dashboard', dropdownId: 'bill-receive'}
                ],
                menusDropdown: [
                    {
                        id: 'bank-accounts',
                        items: [
                            {name: "Listar contas", routeName: 'bank-accounts.list'},
                            {name: "Criar conta", routeName: 'bank-accounts.create'}
                        ]
                    },
                    {
                        id: 'bill-pay',
                        items: [
                            {name: "Listar contas", routeName: 'dashboard'},
                            {name: "Criar conta", routeName: 'dashboard'}
                        ]
                    },
                    {
                        id: 'bill-receive',
                        items: [
                            {name: "Listar contas", routeName: 'dashboard'},
                            {name: "Criar conta", routeName: 'dashboard'}
                        ]
                    }
                ],
                user: Auth.user
            };
        },
        computed: {
            name() {
                return this.user.data ? this.user.data.name : '';
            }
        },
        ready() {
            $('.button-collapse').sideNav();
            $('.dropdown-button').dropdown();
        }
    };
</script>
