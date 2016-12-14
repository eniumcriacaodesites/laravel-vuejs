<?php

$config = [
    'name' => \Illuminate\Support\Facades\Auth::user()->name,
    'menus' => [
        ['name' => 'Bancos', 'url' => route('admin.banks.index'), 'active' => isRouteActive('admin.banks.index')],
        ['name' => 'Contas a pagar', 'url' => 'bill-pay.list', 'dropdownId' => 'bill-pay'],
        ['name' => 'Contas a receber', 'url' => 'bill-receive.list', 'dropdownId' => 'bill-receive']
    ],
    'menusDropdown' => [
        [
            'id' => 'bill-pay',
            'items' => [
                [
                    'name' => 'Listar contas',
                    'url' => route('admin.banks.create'),
                    'active' => isRouteActive('admin.banks.create')
                ],
                [
                    'name' => 'Criar conta',
                    'url' => route('admin.banks.index'),
                    'active' => isRouteActive('admin.banks.index')
                ],
            ]
        ],
        [
            'id' => 'bill-receive',
            'items' => [
                ['name' => 'Listar contas', 'url' => 'bill-receive'],
                ['name' => 'Criar conta', 'url' => 'bill-receive/create']
            ]
        ]
    ],
    'urlLogout' => env('URL_ADMIN_LOGOUT'),
    'csrfToken' => csrf_token()
];

?>

<menu-component :config="{{ json_encode($config) }}"></menu-component>
