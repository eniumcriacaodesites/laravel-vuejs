<?php

namespace CodeBills\Repositories;

use Carbon\Carbon;
use CodeBills\Models\BillPay;
use CodeBills\Models\BillReceive;
use CodeBills\Models\CategoryExpense;
use CodeBills\Models\CategoryRevenue;

trait CashFlowRepositoryTrait
{
    public function getCashFlow(Carbon $dateStart, Carbon $dateEnd)
    {
        $datePrevious = $dateStart->copy()->day(1)->subMonths(2);
        $datePrevious->day($datePrevious->daysInMonth);
        $balancePreviousMonth = $this->getBalanceByMonth($datePrevious);

        $revenuesCollection = $this->getCategoriesValuesCollection(
            new CategoryRevenue(),
            (new BillReceive())->getTable(),
            $dateStart,
            $dateEnd
        );

        $expensesCollection = $this->getCategoriesValuesCollection(
            new CategoryExpense(),
            (new BillPay())->getTable(),
            $dateStart,
            $dateEnd
        );

        return $this->formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth);
    }

    public function getBalanceByMonth(Carbon $date)
    {
        $dateString = $date->copy()->day($date->daysInMonth)->format('Y-m-d');
        $modelClass = $this->model();

        $subQuery = (new $modelClass)
            ->toBase()
            ->selectRaw("bank_account_id, MAX(statements.id) AS maxId")
            ->whereRaw("statements.created_at <= '{$dateString}'")
            ->groupBy("bank_account_id");

        $result = (new $modelClass)
            ->selectRaw("SUM(statements.balance) AS total")
            ->join(\DB::raw("({$subQuery->toSql()}) AS s"), 'statements.id', '=', 's.maxId')
            ->mergeBindings($subQuery)
            ->get();

        return $result->first()->total == null ? 0 : $result->first()->total;
    }

    protected function formatCategories($collection)
    {
        /**
         * id: 0
         * name: Category X
         * months: [
         *  {total: 10, month_year: '2017-02},
         *  {total: 40, month_year: '2017-04},
         * ]
         */
        $categories = $collection->unique('name')->pluck('name', 'id')->all();
        $arrayResult = [];

        foreach ($categories as $id => $name) {
            $filtered = $collection->where('id', $id)->where('name', $name);
            $months_year = [];

            $filtered->each(function ($category) use (&$months_year) {
                $months_year[] = [
                    'total' => $category->total,
                    'month_year' => $category->month_year,
                ];
            });

            $arrayResult[] = [
                'id' => $id,
                'name' => $name,
                'months' => $months_year,
            ];
        }

        return $arrayResult;
    }

    protected function formatMonthsYear($expensesCollection, $revenuesCollection)
    {
        /**
         * months_lists: {
         *  { month_year: '2017-02', receives: { total: 10 }, expenses: { total: 5 } }
         * }
         */
        $monthsYearExpensesCollection = $expensesCollection->pluck('month_year');
        $monthsYearRevenuesCollection = $revenuesCollection->pluck('month_year');
        $monthsYearsCollection = $monthsYearExpensesCollection->merge($monthsYearRevenuesCollection)->unique()->sort();
        $monthsYearList = [];

        $monthsYearsCollection->each(function ($monthYear) use (&$monthsYearList) {
            $monthsYearList[$monthYear] = [
                'month_year' => $monthYear,
                'revenues' => ['total' => 0],
                'expenses' => ['total' => 0],
            ];
        });

        foreach ($monthsYearRevenuesCollection as $monthYear) {
            $monthsYearList[$monthYear]['revenues']['total'] = $revenuesCollection
                ->where('month_year', $monthYear)->sum('total');
        }

        foreach ($monthsYearExpensesCollection as $monthYear) {
            $monthsYearList[$monthYear]['expenses']['total'] = $expensesCollection
                ->where('month_year', $monthYear)->sum('total');
        }

        return array_values($monthsYearList);
    }

    protected function formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth)
    {
        $monthsYearList = $this->formatMonthsYear($expensesCollection, $revenuesCollection);
        $expensesCollection = $this->formatCategories($expensesCollection);
        $revenuesCollection = $this->formatCategories($revenuesCollection);

        $collectionFormatted = [
            'months_list' => $monthsYearList,
            'balance_before_first_month' => $balancePreviousMonth,
            'categories_months' => [
                'expenses' => [
                    'data' => $expensesCollection,
                ],
                'revenues' => [
                    'data' => $revenuesCollection,
                ],
            ],
        ];

        return $collectionFormatted;
    }

    protected function getCategoriesValuesCollection($model, $billTable, Carbon $dateStart, Carbon $dateEnd)
    {
        $dateStartStr = $dateStart->copy()->day(1)->format('Y-m-d');
        $dateEndStr = $dateEnd->copy()->day($dateEnd->daysInMonth)->format('Y-m-d');

        $firstDateStart = $dateStart->copy()->subMonth(1);
        $firstDateStartStr = $firstDateStart->format('Y-m-d');

        $firstDateEnd = $dateEnd->copy()->subMonth(1);
        $firstDateEndStr = $firstDateEnd->format('Y-m-d');

        $firstCollection = $this->getQueryCategoriesValuesByPeriodDone(
            $model,
            $billTable,
            $firstDateStartStr,
            $firstDateEndStr
        )->get();

        $mainCollection = $this->getQueryCategoriesValuesByPeriodDone(
            $model,
            $billTable,
            $dateStartStr,
            $dateEndStr
        )->get();

        $firstCollection->reverse()->each(function ($value) use ($mainCollection) {
            $mainCollection->prepend($value);
        });

        return $mainCollection;
    }

    protected function getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd)
    {
        $table = $model->getTable();
        list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];

        return $model
            ->addSelect("{$table}.id")
            ->addSelect("{$table}.name")
            ->selectRaw("SUM(value) AS total")
            ->selectRaw("DATE_FORMAT(date_due, '%Y-%m') AS month_year")
            ->selectSub($this->getQueryWithDepth($model), "depth")
            ->join("{$table} AS childOrSelf", function ($join) use ($table, $lft, $rgt) {
                $join->on("{$table}.{$lft}", "<=", "childOrSelf.{$lft}")
                     ->whereRaw("{$table}.{$rgt} >= childOrSelf.{$rgt}");
            })
            ->join($billTable, "{$billTable}.category_id", "=", "childOrSelf.id")
            ->whereBetween("date_due", [$dateStart, $dateEnd])
            ->groupBy("{$table}.id", "{$table}.name", "month_year")
            // ->havingRaw("depth = 0")
            ->orderBy("month_year")
            ->orderBy("{$table}.name");
    }

    protected function getQueryCategoriesValuesByPeriodDone($model, $billTable, $dateStart, $dateEnd)
    {
        return $this->getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd)
                    ->where('done', 1);
    }

    protected function getQueryWithDepth($model)
    {
        $table = $model->getTable();
        list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];

        return $model
            ->toBase()
            ->selectRaw("count(1) - 1")
            ->whereRaw("{$table}.{$lft} BETWEEN {$table}.{$lft} AND {$table}.{$rgt}");
    }
}
