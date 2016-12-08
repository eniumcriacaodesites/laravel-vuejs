<?php

use Illuminate\Database\Seeder;

class BanksTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeBills\Models\Bank::class, 30)->create();
    }
}
