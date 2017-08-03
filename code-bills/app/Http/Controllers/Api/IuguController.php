<?php

namespace CodeBills\Http\Controllers\Api;

use CodeBills\Http\Controllers\Controller;
use CodeBills\Iugu\OrderManager;
use Illuminate\Http\Request;

class IuguController extends Controller
{
    /**
     * @var OrderManager
     */
    private $orderManager;

    /**
     * IuguController constructor.
     *
     * @param OrderManager $orderManager
     */
    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    public function hooks(Request $request)
    {
        $event = $request->get('event');
        $data = $request->get('data', []);

        switch ($event) {
            case 'invoice.created':
                $this->orderManager->create($data);
                break;
            case 'invoice.status_changed':
                if ($data['status'] == 'paid') {
                    $this->orderManager->paid($data);
                }
                break;
        }
    }
}
