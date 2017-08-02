<?php

namespace CodeBills\Http\Controllers\Site;

use CodeBills\Http\Controllers\Controller;

class SubscriptionsController extends Controller
{
    public function create()
    {
        return view('site.subscriptions.create');
    }
}
