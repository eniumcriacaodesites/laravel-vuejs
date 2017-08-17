@extends('layouts.site')

@section('content')
    <div class="container page-login">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card z-depth-2">
                    <div class="card-content">
                        <div class="card-title">
                            <h4 class="center-align">Login</h4>
                        </div>

                        <form role="form" method="POST" action="{{ url(env('URL_SITE_LOGIN')) }}">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="email" name="email"
                                           class="{{ $errors->has('email') ? 'invalid validate' : 'validate' }}"
                                           placeholder="Informe seu e-mail">
                                    <label for="email" class="active"
                                           data-error="{{ $errors->has('email') ? $errors->first('email') : null }}">E-mail:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="password" name="password"
                                           class="{{ $errors->has('password') ? 'invalid' : 'validate' }}"
                                           placeholder="Informe sua senha">
                                    <label for="password" class="active"
                                           data-error="{{ $errors->has('password') ? $errors->first('password') : null }}">Senha:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s5">
                                    <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked"
                                           name="remember">
                                    <label for="filled-in-box">Lembrar-me</label>
                                </div>
                                <div class="input-field col s7 right-align">
                                    <button type="submit" class="btn-ok">
                                        Login
                                    </button>

                                    <a class="btn-cancel" href="{{ route('site.auth.register.create') }}">
                                        Registre-se aqui
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
