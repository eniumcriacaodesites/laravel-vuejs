<?php

namespace CodeBills\Transformers;

use CodeBills\Models\BankAccount;
use League\Fractal\TransformerAbstract;

/**
 * Class BankAccountTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class BankAccountTransformer extends TransformerAbstract
{
    /**
     * Transform the \BankAccount entity
     *
     * @param \CodeBills\Models\BankAccount $model
     *
     * @return array
     */
    public function transform(BankAccount $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'agency' => $model->agency,
            'account' => $model->account,
            'default' => (bool) $model->default,
            'bank_id' => (int) $model->bank_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
