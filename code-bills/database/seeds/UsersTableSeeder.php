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
        $repository = app(\CodeBills\Repositories\ClientRepository::class);
        $clients = $repository->all();

        factory(\CodeBills\Models\User::class, 1)->states('admin')->create([
            'name' => 'Admin',
            'email' => 'admin@codebills.com',
        ]);

        foreach (range(1, 50) as $value) {
            factory(\CodeBills\Models\User::class, 1)
                ->create([
                    'name' => "Client {$value}",
                    'email' => "client{$value}@codebills.com",
                ])->each(function ($user) use ($clients) {
                    $client = $clients->random();
                    $user->client()->associate($client);
                    $user->save();
                });
        }
    }
}
