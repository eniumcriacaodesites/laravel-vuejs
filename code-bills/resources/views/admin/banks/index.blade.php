@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card-panel green lighten-3">
                <span class="green-text text-darken-2">
                    <h5>Bancos</h5>
                </span>
            </div>

            <div class="card-panel z-depth-2">
                <form name="form-search" method="get" action="{{ route('admin.banks.index') }}">
                    <div class="filter-group">
                        <button type="submit" class="btn waves-effect">
                            <i class="material-icons">search</i>
                        </button>
                        <div class="filter-wrapper">
                            <input type="text" name="search" value="{{ $search }}"
                                   placeholder="Digite aqui a sua busca">
                        </div>
                    </div>
                </form>

                <table class="bordered striped highlight responsive-table">
                    <thead>
                    <tr>
                        <th width="5%">
                            <a href="{{ route('admin.banks.index', ['orderBy' => 'id', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                ID
                                @if($orderBy == 'id')
                                    <i class="material-icons right">
                                        {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                    </i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.banks.index', ['orderBy' => 'name', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                Nome
                                @if($orderBy == 'name')
                                    <i class="material-icons right">
                                        {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                    </i>
                                @endif
                            </a>
                        </th>
                        <th width="10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($banks as $bank)
                        <tr>
                            <td>{{ $bank->id }}</td>
                            <td>
                                <table>
                                    <tr>
                                        <td width="22">
                                            <img src="{{ asset("storage/banks/images/{$bank->logo}") }}"
                                                 class="bank-logo">
                                        </td>
                                        <td>{{ $bank->name }}</td>
                                    </tr>
                                </table>
                            </td>
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
                                            <button id="link-delete-{{ $bank->id }}"
                                                    class="btn-ok modal-close modal-action">
                                                Ok
                                            </button>
                                        </div>
                                    </modal>
                                </delete-action>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">&raquo; Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {!! $banks->links() !!}
            </div>
        </div>
    </div>
@endsection
