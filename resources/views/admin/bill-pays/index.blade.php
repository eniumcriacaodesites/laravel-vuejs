@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card-panel green lighten-3">
                <span class="green-text text-darken-2">
                    <h5>Contas a pagar</h5>
                </span>
            </div>

            <div class="card-panel z-depth-2">
                <form name="form-search" method="get" action="{{ route('admin.bill-pays.index') }}">
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
                            <a href="{{ route('admin.bill-pays.index', ['orderBy' => 'id', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                ID
                                @if($orderBy == 'id')
                                    <i class="material-icons right">
                                        {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                    </i>
                                @endif
                            </a>
                        </th>
                        <th width="10%">
                            <a href="{{ route('admin.bill-pays.index', ['orderBy' => 'date_due', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                Data
                                @if($orderBy == 'date_due')
                                    <i class="material-icons right">
                                        {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                    </i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.bill-pays.index', ['orderBy' => 'name', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                Nome
                                @if($orderBy == 'name')
                                    <i class="material-icons right">
                                        {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                    </i>
                                @endif
                            </a>
                        </th>
                        <th width="15%">
                            <a href="{{ route('admin.bill-pays.index', ['orderBy' => 'value', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                Valor
                                @if($orderBy == 'value')
                                    <i class="material-icons right">
                                        {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                    </i>
                                @endif
                            </a>
                        </th>
                        <th width="15%">
                            <a href="{{ route('admin.bill-pays.index', ['orderBy' => 'done', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                Pago?
                                @if($orderBy == 'done')
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
                    @forelse($bills->getBills() as $bill)
                        <tr>
                            <td>{{ $bill->id }}</td>
                            <td>{{ $bill->date_due }}</td>
                            <td>{{ $bill->name }}</td>
                            <td>{{ $bill->value }}</td>
                            <td>{{ $bill->done }}</td>
                            <td nowrap="nowrap">
                                <a href="{{ route('admin.bill-pays.edit', ['id' => $bill->id]) }}"
                                   class="btn btn-primary btn-xs">Editar</a>
                                <delete-action action="{{ route('admin.bill-pays.destroy', ['id' => $bill->id]) }}"
                                               action-element="link-delete-{{ $bill->id }}"
                                               csrf-token="{{ csrf_token() }}">
                                    <a id="link-modal-{{ $bill->id }}"
                                       href="#{{ 'modal-delete-' . $bill->id }}"
                                       class="btn btn-danger btn-xs">Deletar</a>
                                    <modal :modal="{{ json_encode(['id' => 'modal-delete-' . $bill->id]) }}"
                                           style="display: none;">
                                        <div slot="content">
                                            <h5>Deseja excluir está conta?</h5>
                                            <table class="bordered">
                                                <tr>
                                                    <td>Nome:</td>
                                                    <td>{{ $bill->name }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div slot="footer">
                                            <button class="btn-cancel modal-close modal-action">Cancel</button>
                                            <button id="link-delete-{{ $bill->id }}"
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
                {!! $bills->getBills()->links() !!}
            </div>
        </div>
    </div>
@endsection
