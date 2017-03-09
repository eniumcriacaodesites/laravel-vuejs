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
        ];
    }
}
