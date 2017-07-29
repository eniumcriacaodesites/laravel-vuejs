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
         * periods: [
         *  {total: 10, period: '2017-02},
         *  {total: 40, period: '2017-04},
         * ]
         */
        $categories = $collection->unique('name')->pluck('name', 'id')->all();
        $arrayResult = [];

        foreach ($categories as $id => $name) {
            $filtered = $collection->where('id', $id)->where('name', $name);
            $periods = [];

            $filtered->each(function ($category) use (&$periods) {
                $periods[] = [
                    'total' => $category->total,
                    'period' => $category->period,
                ];
            });

            $arrayResult[] = [
                'id' => $id,
                'name' => $name,
                'periods' => $periods,
            ];
        }

        return $arrayResult;
    }

    protected function formatPeriods($expensesCollection, $revenuesCollection)
    {
        /**
         * period_list: {
         *  { period: '2017-02', receives: { total: 10 }, expenses: { total: 5 } }
         * }
         */
        $periodExpensesCollection = $expensesCollection->pluck('period');
        $periodRevenuesCollection = $revenuesCollection->pluck('period');
        $periodsCollection = $periodExpensesCollection->merge($periodRevenuesCollection)->unique()->sort();
        $periodList = [];

        $periodsCollection->each(function ($period) use (&$periodList) {
            $periodList[$period] = [
                'period' => $period,
                'revenues' => ['total' => 0],
                'expenses' => ['total' => 0],
            ];
        });

        foreach ($periodRevenuesCollection as $period) {
            $periodList[$period]['revenues']['total'] = $revenuesCollection
                ->where('period', $period)->sum('total');
        }

        foreach ($periodExpensesCollection as $period) {
            $periodList[$period]['expenses']['total'] = $expensesCollection
                ->where('period', $period)->sum('total');
        }

        return array_values($periodList);
    }

    protected function formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth)
    {
        $periodList = $this->formatPeriods($expensesCollection, $revenuesCollection);
        $expensesCollection = $this->formatCategories($expensesCollection);
        $revenuesCollection = $this->formatCategories($revenuesCollection);

        $collectionFormatted = [
            'period_list' => $periodList,
            'balance_before_first_month' => $balancePreviousMonth,
            'categories_period' => [
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
            ->selectRaw("DATE_FORMAT(date_due, '%Y-%m') AS period")
            ->selectSub($this->getQueryWithDepth($model), "depth")
            ->join("{$table} AS childOrSelf", function ($join) use ($table, $lft, $rgt) {
                $join->on("{$table}.{$lft}", "<=", "childOrSelf.{$lft}")
                     ->whereRaw("{$table}.{$rgt} >= childOrSelf.{$rgt}");
            })
            ->join($billTable, "{$billTable}.category_id", "=", "childOrSelf.id")
            ->whereBetween("date_due", [$dateStart, $dateEnd])
            ->groupBy("{$table}.id", "{$table}.name", "period")
            // ->havingRaw("depth = 0")
            ->orderBy("period")
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
