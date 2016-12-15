@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3>Bancos</h3>

        <a href="{{ route('admin.banks.create') }}" class="btn btn-default btn-sm pull-right">Novo Banco</a>

        <br><br>

        <table class="bordered highlight responsive-table z-depth-1">
            <thead>
            <tr>
                <th width="5%">Id</th>
                <th>Name</th>
                <th width="10%">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($banks as $bank)
                <tr>
                    <td>{{ $bank->id }}</td>
                    <td>{{ $bank->name }}</td>
                    <td nowrap="nowrap">
                        <a href="{{ route('admin.banks.edit', ['id' => $bank->id]) }}"
                           class="btn btn-primary btn-xs">Editar</a>
                        <delete-action action="{{ route('admin.banks.destroy', ['id' => $bank->id]) }}"
                                       action-element="link-delete-{{ $bank->id }}"
                                       csrf-token="{{ csrf_token() }}">
                            <a id="link-delete-{{ $bank->id }}"
                               href="{{ route('admin.banks.destroy', ['id' => $bank->id]) }}"
                               class="btn btn-danger btn-xs">Deletar</a>
                        </delete-action>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $banks->links() !!}
    </div>
@endsection
