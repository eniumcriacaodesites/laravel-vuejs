@extends('layouts.site')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <subscription-create :plan="{{ json_encode($plan->toArray()) }}"
                                     csrf-token="{{ csrf_token() }}"
                                     action="{{ route('site.subscriptions.store') }}"></subscription-create>
            </div>
        </div>
    </div>
@endsection
