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

<script>
    import {Jwt} from '../resource';

    export default {
        data() {
            return {
                user: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            login() {
                Jwt.accessToken(this.user.email, this.user.password).then((response) => {
                    console.log(response);
                });
            }
        }
    }
</script>
