<?php

use Illuminate\Database\Seeder;

class BillReceivesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeBills\Models\BillReceive::class, 50)->create();
    }
}
