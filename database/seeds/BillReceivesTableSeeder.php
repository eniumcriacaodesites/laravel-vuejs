<?php

use CodeBills\Repositories\GetClientsTrait;
use Illuminate\Database\Seeder;

class BillReceivesTableSeeder extends Seeder
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
        $repository = app(\CodeBills\Repositories\BillReceiveRepository::class);

        factory(\CodeBills\Models\BillReceive::class, 200)
            ->make()
            ->each(function ($billReceive) use ($clients, $repository) {
                $client = $clients->random();
                \Landlord::addTenant($client);
                $bankAccount = $client->bankAccounts->random();
                $category = $client->categoryRevenues->random();

                $billReceive->client_id = $client->id;
                $billReceive->bank_account_id = $bankAccount->id;
                $billReceive->category_id = $category->id;

                $data = $billReceive->toArray();
                $repository->create($data);
            });
    }
}
