<?php

$config = [
    'name' => \Illuminate\Support\Facades\Auth::user()->name,
    'menus' => [
        ['name' => 'Bancos', 'dropdownId' => 'banks'],
        ['name' => 'Assinaturas', 'url' => route('admin.subscriptions.index')],
        ['name' => 'Contas a pagar', 'dropdownId' => 'bill-pays'],
        ['name' => 'Contas a receber', 'dropdownId' => 'bill-receives']
    ],
    'menusDropdown' => [
        [
            'id' => 'banks',
            'items' => [
                [
                    'name' => 'Listar bancos',
                    'url' => route('admin.banks.index'),
                    'active' => isRouteActive('admin.banks.index')
                ],
                [
                    'name' => 'Criar banco',
                    'url' => route('admin.banks.create'),
                    'active' => isRouteActive('admin.banks.create')
                ],
            ]
        ],
        [
            'id' => 'bill-pays',
            'items' => [
                [
                    'name' => 'Listar contas',
                    'url' => route('admin.bill-pays.index'),
                    'active' => isRouteActive('admin.bill-pays.index')
                ],
                [
                    'name' => 'Criar conta',
                    'url' => route('admin.bill-pays.create'),
                    'active' => isRouteActive('admin.bill-pays.create')
                ],
            ]
        ],
        [
            'id' => 'bill-receives',
            'items' => [
                [
                    'name' => 'Listar contas',
                    'url' => route('admin.bill-receives.index'),
                    'active' => isRouteActive('admin.bill-receives.index')
                ],
                [
                    'name' => 'Criar conta',
                    'url' => route('admin.bill-receives.create'),
                    'active' => isRouteActive('admin.bill-receives.create')
                ],
            ]
        ]
    ],
    'urlLogout' => env('URL_ADMIN_LOGOUT'),
    'csrfToken' => csrf_token()
];

?>

<menu-component :config="{{ json_encode($config) }}"></menu-component>
