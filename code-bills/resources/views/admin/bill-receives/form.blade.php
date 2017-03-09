@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card-panel green lighten-3">
                <span class="green-text text-darken-2">
                    <h5>{{ empty($bank) ? 'Adicionar conta a receber' : 'Atualizar conta a receber' }}</h5>
                </span>
            </div>

            <div class="card-panel z-depth-2">
                @if(!empty($bank))
                    {!! Form::model($bank, ['route' => ['admin.bill-receives.update', $bank->id], 'method' => 'PUT']) !!}
                @else
                    {!! Form::open(['route' => 'admin.bill-receives.store', 'method' => 'POST']) !!}
                @endif

                @if (count($errors) > 0)
                    <div class="card-panel red white-text lighten-2">
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="row">
                    <div class="input-field col s6">
                        {!! Form::label('date_due', 'Vencimento:') !!}
                        {!! Form::text('date_due', null, ['class' => 'form-control', 'placeholder' => 'Informe a data']) !!}
                    </div>
                    <div class="input-field col s6">
                        {!! Form::label('value', 'Valor:') !!}
                        {!! Form::text('value', null, ['class' => 'form-control', 'placeholder' => 'Informe o valor']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        {!! Form::label('name', 'Nome:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Informe o nome']) !!}
                    </div>
                    <div class="input-field col s6">
                        <div class="switch">
                            <label>
                                Off
                                {!! Form::checkbox('done') !!}
                                <span class="lever"></span>
                                On
                            </label>
                        </div>
                        <label class="active">Pago?</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 right-align">
                        {!! Form::submit('Enviar', ['class'=>'btn btn-primary btn-sm']) !!}
                        <a class="btn-cancel" href="{{ route('admin.bill-receives.index') }}"
                           role="button">Cancelar</a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
