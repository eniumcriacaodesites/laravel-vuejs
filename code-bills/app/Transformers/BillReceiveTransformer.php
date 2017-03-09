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
            'value' => (double) $model->value,
            'done' => (boolean) $model->done,
            'date_due' => $model->date_due,
        ];
    }
}
