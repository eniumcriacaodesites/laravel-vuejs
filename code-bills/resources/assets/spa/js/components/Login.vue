<template>
    <div class="section page-login">
        <div class="container">
            <div class="row">
                <div class="col s12 m6 offset-m3">
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <div class="card-title">
                                <h4 class="center-align">Login</h4>
                            </div>

                            <div class="row" v-if="error.error">
                                <div class="col s12">
                                    <div class="card-panel red">
                                        <span class="white-text">{{ error.message }}</span>
                                    </div>
                                </div>
                            </div>

                            <form role="form" @submit.prevent="login()">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="email" name="email" class="validate"
                                               placeholder="Informe seu e-mail"
                                               v-model="user.email" autofocus>
                                        <label for="email" class="active">E-mail:</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="password" name="password" class="validate"
                                               placeholder="Informe sua senha"
                                               v-model="user.password">
                                        <label for="password" class="active">Senha:</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 right-align">
                                        <button type="submit" class="btn-ok">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>

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
        data() {
            return {
                user: {
                    email: '',
                    password: ''
                },
                error: {
                    error: false,
                    message: ''
                }
            }
        },
        methods: {
            login() {
                this.error.error = false;
                this.error.message = '';
                store.dispatch('login', this.user)
                    .then(() => this.$router.go({name: 'dashboard'}))
                    .catch((responseError) => {
                        switch (responseError.status) {
                            case 400:
                            case 401:
                            case 403:
                                this.error.message = responseError.data.message;
                                break;
                            default:
                                this.error.message = 'Login failed.';
                        }
                        this.error.error = true;
                    });
            }
        }
    }
</script>
