<?php

use CodeBills\Repositories\GetClientsTrait;
use Illuminate\Database\Seeder;

class BillPaysTableSeeder extends Seeder
{
    use GetClientsTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = $this->getClients();
        $repository = app(\CodeBills\Repositories\BillPayRepository::class);

        factory(\CodeBills\Models\BillPay::class, 200)
            ->make()
            ->each(function ($billPay) use ($clients, $repository) {
                $client = $clients->random();
                \Landlord::addTenant($client);
                $bankAccount = $client->bankAccounts->random();
                $category = $client->categoryExpenses->random();

                $billPay->client_id = $client->id;
                $billPay->bank_account_id = $bankAccount->id;
                $billPay->category_id = $category->id;

                $data = $billPay->toArray();
                $repository->create($data);
            });
    }
}
