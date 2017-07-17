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

        factory(\CodeBills\Models\BillPay::class, 200)
            ->make()
            ->each(function ($billPay) use ($clients) {
                $client = $clients->random();
                $billPay->client_id = $client->id;
                $billPay->save();
            });
    }
}
