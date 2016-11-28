<template>
    <header>

    </header>

    <main>
        <router-view></router-view>
    </main>

    <footer>
        <h6 class="center-align">&copy; {{ year }} - CodeBills</h6>
    </footer>
</template>

<script>
    export default {
        data() {
            return {
                year: new Date().getFullYear()
            }
        }
    };
</script>
