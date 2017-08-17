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
                        <h5>Ordens</h5>
                    </span>
                </div>

                <div class="card-panel z-depth-2">
                    <form name="form-search" method="get" action="{{ route('admin.orders.index') }}">
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
                                        <label for="">Vencimaneto</label>
                                        <div class="row">
                                            <div class="col s6">
                                                <input type="text" name="due_from" id="due_from"
                                                       value="{{ $dueFrom }}"
                                                       placeholder="De">
                                            </div>
                                            <div class="col s6">
                                                <input type="text" name="due_to" id="due_to"
                                                       value="{{ $dueTo }}"
                                                       placeholder="Até">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s3">
                                        <label for="">Pagamento</label>
                                        <div class="row">
                                            <div class="col s6">
                                                <input type="text" name="payment_from" id="payment_from"
                                                       value="{{ $paymentFrom }}"
                                                       placeholder="De">
                                            </div>
                                            <div class="col s6">
                                                <input type="text" name="payment_to" id="payment_to"
                                                       value="{{ $paymentTo }}"
                                                       placeholder="Até">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s1">
                                        <label for="">Tipo</label>
                                        <div class="row">
                                            <div class="col s12">
                                                <select name="payment_type" id="payment_type">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Boleto</option>
                                                    <option value="2">Cartão</option>
                                                </select>
                                            </div>
                                            <script>document.getElementById('payment_type').value = {{ $paymentType }};</script>
                                        </div>
                                    </div>
                                    <div class="col s1">
                                        <label for="">Status</label>
                                        <div class="row">
                                            <div class="col s12">
                                                <select name="status" id="status">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Pendente</option>
                                                    <option value="2">Pago</option>
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
                                <a href="{{ route('admin.orders.index', ['orderBy' => 'user_id', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Usuário
                                    @if($orderBy == 'user_id')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="15%">
                                <a href="{{ route('admin.orders.index', ['orderBy' => 'code', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Código
                                    @if($orderBy == 'code')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="15%">
                                <a href="{{ route('admin.orders.index', ['orderBy' => 'value', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Valor
                                    @if($orderBy == 'value')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="15%">
                                <a href="{{ route('admin.orders.index', ['orderBy' => 'date_due', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Vencimento
                                    @if($orderBy == 'date_due')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="15%">
                                <a href="{{ route('admin.orders.index', ['orderBy' => 'payment_date', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Pagamento
                                    @if($orderBy == 'payment_date')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="10%">
                                <a href="{{ route('admin.orders.index', ['orderBy' => 'payment_type', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Tipo
                                    @if($orderBy == 'payment_type')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                            <th width="10%">
                                <a href="{{ route('admin.orders.index', ['orderBy' => 'status', 'sortedBy' => ($sortedBy == 'asc') ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Status
                                    @if($orderBy == 'status')
                                        <i class="material-icons right">
                                            {{ $sortedBy == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                        </i>
                                    @endif
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->subscription->user->name }}</td>
                                <td>{{ $order->code }}</td>
                                <td>{{ currencyBr($order->value) }}</td>
                                <td>{{ dateEnToBr($order->date_due) }}</td>
                                <td>{{ dateEnToBr(str_split($order->payment_date, 10)[0]) }}</td>
                                <td>{{ $order->payment_type == 1 ? 'Boleto' : 'Cartão' }}</td>
                                <td>{{ $order->status == 2 ? 'Pago' : 'Pendente' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">&raquo; Nenhum registro encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {!! $orders->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
