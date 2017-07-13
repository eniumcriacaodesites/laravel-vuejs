<template>
    <div class="section page-login">
        <div class="container">
            <div class="row">
                <div class="col s12 m8 offset-m2">
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <div class="card-title">
                                <h4 class="center-align">Efetuando logout...</h4>
                            </div>

                            <div class="progress">
                                <div class="indeterminate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import store from '../store/store';

    export default {
        ready() {
            setTimeout(() => {
                this.logout()
            }, 1000);
        },
        methods: {
            logout() {
                let goToLogin = () => this.$router.go({name: 'auth.login'});

                store.dispatch('logout')
                    .then(goToLogin)
                    .catch(goToLogin);
            }
        }
    }
</script>
