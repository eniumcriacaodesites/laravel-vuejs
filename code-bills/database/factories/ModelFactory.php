<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\CodeBills\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(\CodeBills\Models\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'role' => \CodeBills\Models\User::ROLE_ADMIN,
    ];
});

$factory->define(\CodeBills\Models\Bank::class, function (Faker\Generator $faker) {
    return [
        'name' => ucfirst($faker->word),
        'logo' => env('BANK_LOGO_DEFAULT'),
    ];
});

$factory->define(\CodeBills\Models\BankAccount::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
        'agency' => rand(10000, 60000) . '-' . rand(0, 9),
        'account' => rand(70000, 90000) . '-' . rand(0, 9),
    ];
});

$factory->define(\CodeBills\Models\BillPay::class, function (Faker\Generator $faker) {
    return [
        'date_due' => $faker->date('Y-m-d'),
        'name' => $faker->city,
        'value' => $faker->randomFloat(2),
        'done' => $faker->boolean(),
    ];
});

$factory->define(\CodeBills\Models\BillReceive::class, function (Faker\Generator $faker) {
    return [
        'date_due' => $faker->date('Y-m-d'),
        'name' => $faker->city,
        'value' => $faker->randomFloat(2),
        'done' => $faker->boolean(),
    ];
});

$factory->define(\CodeBills\Models\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(\CodeBills\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
