<template>
    <div class="spinner-fixed" v-if="loading">
        <div class="spinner">
            <div class="indeterminate"></div>
        </div>
    </div>
    <header>
        <div v-if="showMenu">
            <menu-component></menu-component>
        </div>
        <div v-else class="navbar-fixed">
            <nav>
                <div class="nav-wrapper container">
                    <div class="brand-logo center">CodeBills</div>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <router-view></router-view>
    </main>

    <footer>
        <h6 class="center-align">&copy; {{ year }} - CodeBills</h6>
    </footer>
</template>

<script type="text/javascript">
    import store from '../store';
    import MenuComponet from './Menu.vue';

    export default {
        components: {
            'menu-component': MenuComponet
        },
        created() {
            window.Vue.http.interceptors.unshift((request, next) => {
                this.loading = true;
                next(() => this.loading = false);
            });
        },
        data() {
            return {
                year: new Date().getFullYear(),
                loading: false
            };
        },
        computed: {
            isAuth() {
                return store.state.check;
            },
            showMenu() {
                return this.isAuth && this.$route.name != 'auth.login';
            }
        }
    };
</script>
