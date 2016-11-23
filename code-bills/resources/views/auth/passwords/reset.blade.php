@extends('layouts.admin')

@section('content')
    <div class="section page-login">
        <div class="container">
            <div class="row">
                <div class="col s12 m8 offset-m2">
                    <div class="card z-depth-2">
                        <div class="card-content">
                            <div class="card-title">
                                <h4 class="center-align">Reset Password</h4>
                            </div>

                            <form role="form" method="POST" action="{{ url(env('URL_ADMIN_RESET_PASSWORD')) }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="email" name="email"
                                               class="{{ $errors->has('email') ? 'invalid validate' : 'validate' }}"
                                               placeholder="Informe seu e-mail" value="{{ $email or old('email') }}">
                                        <label for="email" class="active"
                                               data-error="{{ $errors->has('email') ? $errors->first('email') : null }}">E-mail:</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="password" name="password"
                                               class="{{ $errors->has('password') ? 'invalid' : 'validate' }}"
                                               placeholder="Informe sua nova senha">
                                        <label for="password" class="active"
                                               data-error="{{ $errors->has('password') ? $errors->first('email') : null }}">Senha:</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="password" name="password_confirmation"
                                               class="{{ $errors->has('password_confirmation') ? 'invalid' : 'validate' }}"
                                               placeholder="Confirne sua nova senha">
                                        <label for="password_confirmation" class="active"
                                               data-error="{{ $errors->has('password_confirmation') ? $errors->first('email') : null }}">Confirm
                                            Password:</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12 right-align">
                                        <button type="submit" class="btn-ok">
                                            Reset Password
                                        </button>

                                        <a class="btn-cancel" href="{{ url(env('URL_ADMIN_LOGIN')) }}">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
