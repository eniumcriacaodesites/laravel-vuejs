<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CodeBills\Models\Plan::create([
            'name' => 'Plano Empresarial',
            'description' => 'Plano Empresarial para CodeBills',
            'value' => 40.00,
            'code' => 'plan_business',
        ]);
    }
}
