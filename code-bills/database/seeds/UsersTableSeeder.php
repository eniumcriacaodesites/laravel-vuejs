<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeBills\User::class, 1)->states('admin')->create([
            'name' => 'Admin',
            'email' => 'admin@codebills.com',
        ]);
    }
}
