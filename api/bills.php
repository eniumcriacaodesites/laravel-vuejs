<?php

function writeBillsPay($bills)
{
    $data = ['bills' => $bills];
    $json = json_encode($data);
    file_put_contents(__DIR__ . '/bills-pay.json', $json);
}

function writeBillsReceive($bills)
{
    $data = ['bills' => $bills];
    $json = json_encode($data);
    file_put_contents(__DIR__ . '/bills-receive.json', $json);
}

$billsPay = [
    ['id' => 1, 'date_due' => '11/08/16', 'name' => 'Conta de água', 'value' => 55.99, 'done' => true],
    ['id' => 2, 'date_due' => '11/08/16', 'name' => 'Conta de luz', 'value' => 130.95, 'done' => false],
    ['id' => 3, 'date_due' => '15/08/16', 'name' => 'Conta de telefone', 'value' => 75.95, 'done' => false],
    ['id' => 4, 'date_due' => '15/08/16', 'name' => 'Cartão de crédito', 'value' => 1350.85, 'done' => false],
    ['id' => 5, 'date_due' => '20/08/16', 'name' => 'Empréstimo', 'value' => 2000.15, 'done' => false],
    ['id' => 6, 'date_due' => '20/08/16', 'name' => 'Supermecado', 'value' => 650.45, 'done' => false],
    ['id' => 7, 'date_due' => '20/08/16', 'name' => 'Gasolina', 'value' => 150.25, 'done' => false],
];

$billsReceive = [
    ['id' => 1, 'date_due' => '15/08/16', 'name' => 'Freelance', 'value' => 450.85, 'done' => true],
    ['id' => 2, 'date_due' => '27/08/16', 'name' => 'Seguro desemprego', 'value' => 1543.00, 'done' => false],
    ['id' => 3, 'date_due' => '15/09/16', 'name' => 'Freelance', 'value' => 1250.45, 'done' => false],
    ['id' => 4, 'date_due' => '15/10/16', 'name' => 'Freelance', 'value' => 1250.45, 'done' => false],
    ['id' => 5, 'date_due' => '20/10/16', 'name' => 'Outros', 'value' => 250.95, 'done' => false],
];

writeBillsPay($billsPay);
writeBillsReceive($billsReceive);
