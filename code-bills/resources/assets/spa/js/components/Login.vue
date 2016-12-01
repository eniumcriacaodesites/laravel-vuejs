<template>
    <div class="section page-login">
        <div class="container">
            <div class="row">
                <div class="col s12 m8 offset-m2">
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <div class="card-title">
                                <h4 class="center-align">Login</h4>
                            </div>

                            <h5 class="red-text center-align" v-if="error.error">{{ error.message }}</h5>

                            <form role="form" @submit.prevent="login()">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="email" name="email" class="validate"
                                               placeholder="Informe seu e-mail"
                                               v-model="user.email">
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
    import Auth from '../services/auth';

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
                },
            }
        },
        methods: {
            login() {
                Auth.login(this.user.email, this.user.password)
                        .then((response) => {
                            this.$dispatch('change-menu');
                            this.$router.go({name: 'dashboard'});
                        })
                        .catch((responseError) => {
                            switch (responseError.status) {
                                case 400:
                                case 401:
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
