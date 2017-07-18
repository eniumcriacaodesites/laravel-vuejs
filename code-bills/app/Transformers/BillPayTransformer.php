<?php

namespace CodeBills\Transformers;

use CodeBills\Models\BillPay;
use League\Fractal\TransformerAbstract;

/**
 * Class BillPayTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class BillPayTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category', 'bankAccount'];

    /**
     * Transform the \BankAccount entity
     *
     * @param \CodeBills\Models\BillPay $model
     *
     * @return array
     */
    public function transform(BillPay $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'value' => (double) $model->value,
            'done' => (boolean) $model->done,
            'date_due' => $model->date_due,
            'category_id' => (int) $model->category_id,
            'bank_account_id' => (int) $model->bank_account_id,
        ];
    }

    public function includeCategory(BillPay $model)
    {
        $transformer = new CategoryTransformer();
        $transformer->setDefaultIncludes([]);

        return $this->item($model->category, $transformer);
    }

    public function includeBankAccount(BillPay $model)
    {
        return $this->item($model->bankAccount, new BankAccountTransformer());
    }
}
