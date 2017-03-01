<template>
    <div class="spinner-fixed" v-if="loading">
        <div class="spinner">
            <div class="indeterminate"></div>
        </div>
    </div>
    <header>
        <menu-component></menu-component>
    </header>

    <main>
        <router-view></router-view>
    </main>

    <footer>
        <h6 class="center-align">&copy; {{ year }} - CodeBills</h6>
    </footer>
</template>

<script type="text/javascript">
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
            }
        },
        events: {
            'change-menu'() {
                this.$broadcast('refresh-menu');
            }
        }
    };
</script>
