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
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form role="form" method="POST" action="{{ url(env('URL_ADMIN_RESET_PASSWORD')) }}">
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
                                    <div class="input-field col s12 right-align">
                                        <button type="submit" class="btn-ok">
                                            Send Password Reset Link
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
