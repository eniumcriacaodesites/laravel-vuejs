@extends('layouts.admin')

@section('content')
    <div class="container">
        @if(Session::has('error'))
            <div class="row">
                <div class="col s12">
                    <div class="card-panel red">
                        <span class="white-text">{{ Session::get('error') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(Session::has('success'))
            <div class="row">
                <div class="col s12">
                    <div class="card-panel green">
                        <span class="white-text">{{ Session::get('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col s12">
                <div class="card-panel green lighten-3">
                    <span class="green-text text-darken-2">
                        <h5>Assinaturas</h5>
                    </span>
                </div>

                <div class="card-panel z-depth-2">
                    <form name="form-search" method="get" action="{{ route('admin.subscriptions.index') }}">
                        <div class="row">
                            <div class="col s11">
                                <div class="row">
                                    <div class="col s4">
                                        <label for="">Buscar por</label>
                                        <div class="row">
                                            <div class="col s12">
                                                <input type="text" name="search" value="{{ $search }}"
                                                       placeholder="Digite aqui a sua busca">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s3">
                                        <label for="">Expira em</label>
                                        <div class="row">
                                            <div class="col s6">
                                                <input type="text" name="expires_from" id="expires_from"
                                                       value="{{ $expiresFrom }}"
                                                       placeholder="De">
                                            </div>
                                            <div class="col s6">
                                                <input type="text" name="expires_to" id="expires_to"
                                                       value="{{ $expiresTo }}"
                                                       placeholder="Até">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s3">
                                        <label for="">Cancelado em</label>
                                        <div class="row">
                                            <div class="col s6">
                                                <input type="text" name="canceled_from" id="canceled_from"
                                                       value="{{ $canceledFrom }}"
                                                       placeholder="De">
                                            </div>
                                            <div class="col s6">
                                                <input type="text" name="canceled_to" id="canceled_to"
                                                       value="{{ $canceledTo }}"
                                                       placeholder="Até">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s2">
                                        <label for="">Status</label>
                                        <div class="row">
                                            <div class="col s12">
                                                <select name="status" id="status">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Ativas</option>
                                                    <option value="2">Inativas</option>
                                                    <option value="3">Expiradas</option>
                                                </select>
                                            </div>
                                            <script>document.getElementById('status').value = {{ $status }};</script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col s1">
                                <label>&nbsp;</label>
                                <div class="row">
                                    <div class="col s12">
                                        <button type="submit" class="btn waves-effect">
                                            <i class="material-icons">search</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="bordered striped highlight responsive-table">
                        <thead>
                        <tr>
                            <th width="15%">
                                <a href="{{ route('admin.subscriptions.index', ['orderBy' => 'plan_id', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Plano
                                    @if($orderBy == 'plan_id')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="15%">
                                <a href="{{ route('admin.subscriptions.index', ['orderBy' => 'code', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Código
                                    @if($orderBy == 'code')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="15%">
                                <a href="{{ route('admin.subscriptions.index', ['orderBy' => 'user_id', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Usuário
                                    @if($orderBy == 'user_id')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="15%">
                                <a href="{{ route('admin.subscriptions.index', ['orderBy' => 'expires_at', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Expira em
                                    @if($orderBy == 'expires_at')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="15%">
                                <a href="{{ route('admin.subscriptions.index', ['orderBy' => 'canceled_at', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Cancelado em
                                    @if($orderBy == 'canceled_at')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="10%">
                                <a href="{{ route('admin.subscriptions.index', ['orderBy' => 'status', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Status
                                    @if($orderBy == 'status')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->plan->name }}</td>
                                <td>{{ $subscription->code }}</td>
                                <td>{{ $subscription->user->name }}</td>
                                <td>{{ dateEnToBr($subscription->expires_at) }}</td>
                                <td>{{ dateEnToBr($subscription->canceled_at) }}</td>
                                <td>{{ $subscription->status == 1 ? 'Ativo' : 'Inativo' }}</td>
                                @if($subscription->status == 1)
                                    <td>
                                        <a href="{{ route('admin.subscriptions.cancel', $subscription->id) }}">Cancelar</a>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">&raquo; Nenhum registro encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {!! $subscriptions->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
