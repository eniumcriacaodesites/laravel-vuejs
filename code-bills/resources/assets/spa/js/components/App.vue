<template>
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
        data() {
            return {
                year: new Date().getFullYear()
            }
        },
        events: {
            'change-menu'() {
                this.$broadcast('refresh-menu');
            }
        }
    };
</script>
