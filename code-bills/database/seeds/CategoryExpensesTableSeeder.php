<?php

use CodeBills\Repositories\GetClientsTrait;
use Illuminate\Database\Seeder;

class CategoryExpensesTableSeeder extends Seeder
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

        factory(\CodeBills\Models\CategoryExpense::class, 30)
            ->make()
            ->each(function ($category) use ($clients) {
                $client = $clients->random();
                $category->client_id = $client->id;
                $category->save();
            });

        $categoriesRoot = $this->getCategoriesRoot();

        foreach ($categoriesRoot as $root) {
            factory(\CodeBills\Models\CategoryExpense::class, 3)
                ->make()
                ->each(function ($child) use ($root) {
                    $child->client_id = $root->client_id;
                    $child->save();
                    $child->parent()->associate($root);
                    $child->save();
                });
        }
    }

    private function getCategoriesRoot()
    {
        /** @var \CodeBills\Repositories\CategoryExpenseRepository $repository */
        $repository = app(\CodeBills\Repositories\CategoryExpenseRepository::class);
        $repository->skipPresenter(true);

        return $repository->all();
    }
}
