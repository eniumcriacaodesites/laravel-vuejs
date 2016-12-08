@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3>{{ empty($bank) ? 'Adicionar Banco' : 'Atualizar Banco' }}</h3>

        @if(!empty($bank))
            {!! Form::model($bank, ['route' => ['admin.banks.update', $bank->id], 'method' => 'PUT']) !!}
        @else
            {!! Form::open(['route' => 'admin.banks.store']) !!}
        @endif

        @if (count($errors) > 0)
            <div class="card-panel red white-text lighten-2">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
        @endif

        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {{--{!! Form::label('logo', 'Logo:') !!}--}}
            {!! Form::hidden('logo', 'no-image.png', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group text-right">
            {!! Form::submit('Enviar', ['class'=>'btn btn-primary btn-sm']) !!}
            <a class="btn btn-warning btn-sm" href="{{ route('admin.banks.index') }}" role="button">Cancelar</a>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
