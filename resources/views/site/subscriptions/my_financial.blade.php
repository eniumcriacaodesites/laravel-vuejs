@extends('layouts.site')

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
                <h4>Meu Financeiro</h4>

                <div class="card-panel">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="15%">Plano</th>
                            <th width="15%">Código</th>
                            <th width="15%">Expira em</th>
                            <th width="15%">Cancelado em</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->plan->name }}</td>
                                <td>{{ $subscription->code }}</td>
                                <td>{{ $subscription->expires_at }}</td>
                                <td>{{ $subscription->canceled_at }}</td>
                                <td>{{ $subscription->status == 1 ? 'Ativo' : 'Inativo' }}</td>
                                @if($subscription->status == 1)
                                    <td>
                                        <a href="{{ route('site.my_financial.cancel', $subscription->id) }}">Cancelar</a>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $subscriptions->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
