@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card-panel green lighten-3">
                <span class="green-text text-darken-2">
                    <h5>{{ empty($bank) ? 'Adicionar Banco' : 'Atualizar Banco' }}</h5>
                </span>
            </div>

            <div class="card-panel z-depth-2">
                @if(!empty($bank))
                    {!! Form::model($bank, ['route' => ['admin.banks.update', $bank->id], 'method' => 'PUT', 'files' => true]) !!}
                @else
                    {!! Form::open(['route' => 'admin.banks.store', 'files' => true]) !!}
                @endif

                @if (count($errors) > 0)
                    <div class="card-panel red white-text lighten-2">
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="row">
                    <div class="input-field col s12">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Informe o banco']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Logo</span>
                                <input type="file" id="logo" name="logo">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Selecione a logo do banco">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 right-align">
                        {!! Form::submit('Enviar', ['class'=>'btn btn-primary btn-sm']) !!}
                        <a class="btn-cancel" href="{{ route('admin.banks.index') }}"
                           role="button">Cancelar</a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
