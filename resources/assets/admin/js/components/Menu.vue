<template>
    <ul :id="o.id" class="dropdown-content" v-for="o in config.menusDropdown">
        <li v-for="item in o.items" :class="menuItemClass(item)">
            <a :href="item.url">{{ item.name }}</a>
        </li>
    </ul>
    <ul id="dropdown-logout" class="dropdown-content">
        <li>
            <a :href="config.urlLogout" @click.prevent="goToLogout()">Logout</a>
        </li>
        <form id="logout-form" :action="config.urlLogout" method="POST" style="display: none;">
            <input type="hidden" name="_token" :value="config.csrfToken">
        </form>
    </ul>
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper container">
                <div class="brand-logo left">CodeBills</div>
                <a href="#" data-activates="nav-mobile" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="hide-on-med-and-down right">
                    <li v-for="o in config.menus" :class="menuItemClass(o)">
                        <a v-if="o.dropdownId" class="dropdown-button" href="!#"
                           :data-activates="o.dropdownId">
                            {{ o.name }} <i class="material-icons right">arrow_drop_down</i>
                        </a>
                        <a v-else :href="o.url">{{ o.name }}</a>
                    </li>
                    <li>
                        <a class="dropdown-button" href="#" data-activates="dropdown-logout">
                            {{ config.name }} <i class="material-icons right">arrow_drop_down</i>
                        </a>
                    </li>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <li v-for="o in menus">
                        <a :href="o.url">{{ o.name }}</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        props: {
            config: {
                type: Object,
                default() {
                    return {
                        name: '',
                        menus: [],
                        menusDropdown: [],
                        urlLogout: '/admin/logout',
                        csrfToken: ''
                    }
                }
            }
        },
        ready() {
            $('.button-collapse').sideNav();
            $('.dropdown-button').dropdown();
        },
        methods: {
            goToLogout() {
                $('#logout-form').submit();
            },
            menuItemClass(menu) {
                let menuClass = ['active'];

                if (menu.active) {
                    return menuClass;
                }

                if (menu.dropdownId !== undefined) {
                    let dropdown = this.config.menusDropdown.find((element) => {
                        return element.id == menu.dropdownId;
                    });

                    if (dropdown) {
                        for (let o of dropdown.items) {
                            if (o.active) {
                                return menuClass;
                            }
                        }
                    }
                }
            }
        }
    };
</script>
