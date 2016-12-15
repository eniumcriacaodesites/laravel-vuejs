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
                <th>Logo</th>
                <th>Name</th>
                <th width="10%">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($banks as $bank)
                <tr>
                    <td>{{ $bank->id }}</td>
                    <td width="5%">
                        <img src="{{ asset("storage/banks/images/{$bank->logo}") }}"
                             class="responsive-img"
                             alt="{{ $bank->name }}">
                    </td>
                    <td>{{ $bank->name }}</td>
                    <td nowrap="nowrap">
                        <a href="{{ route('admin.banks.edit', ['id' => $bank->id]) }}"
                           class="btn btn-primary btn-xs">Editar</a>
                        <delete-action action="{{ route('admin.banks.destroy', ['id' => $bank->id]) }}"
                                       action-element="link-delete-{{ $bank->id }}"
                                       csrf-token="{{ csrf_token() }}">
                            <a id="link-modal-{{ $bank->id }}"
                               href="#{{ 'modal-delete-' . $bank->id }}"
                               class="btn btn-danger btn-xs">Deletar</a>
                            <modal :modal="{{ json_encode(['id' => 'modal-delete-' . $bank->id]) }}"
                                   style="display: none;">
                                <div slot="content">
                                    <h5>Deseja excluir este banco?</h5>
                                    <table class="bordered">
                                        <tr>
                                            <td>Nome:</td>
                                            <td>{{ $bank->name }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div slot="footer">
                                    <button class="btn-cancel modal-close modal-action">Cancel</button>
                                    <button id="link-delete-{{ $bank->id }}" class="btn-ok modal-close modal-action">
                                        Ok
                                    </button>
                                </div>
                            </modal>
                        </delete-action>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $banks->links() !!}
    </div>
@endsection
