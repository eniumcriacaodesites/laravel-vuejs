<?php

namespace CodeBills\Transformers;

use CodeBills\Models\BillReceive;
use League\Fractal\TransformerAbstract;

/**
 * Class BillReceiveTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class BillReceiveTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category', 'bankAccount'];

    /**
     * Transform the \BankAccount entity
     *
     * @param \CodeBills\Models\BillReceive $model
     *
     * @return array
     */
    public function transform(BillReceive $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'value' => $model->value,
            'done' => $model->done,
            'date_due' => $model->date_due,
            'category_id' => (int) $model->category_id,
            'bank_account_id' => (int) $model->bank_account_id,
        ];
    }

    public function includeCategory(BillReceive $model)
    {
        $transformer = new CategoryTransformer();
        $transformer->setDefaultIncludes([]);

        return $this->item($model->category, $transformer);
    }

    public function includeBankAccount(BillReceive $model)
    {
        return $this->item($model->bankAccount, new BankAccountTransformer());
    }
}
