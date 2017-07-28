<?php

namespace CodeBills\Transformers;

use CodeBills\Models\Statement;
use League\Fractal\TransformerAbstract;

/**
 * Class StatementTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class StatementTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['bankAccount'];

    /**
     * Transform the \Statement entity
     *
     * @param \CodeBills\Models\Statement $model
     *
     * @return array
     */
    public function transform(Statement $model)
    {
        return [
            'id' => (int) $model->id,
            'value' => (float) $model->value,
            'balance' => (float) $model->balance,
            'bank_account_id' => (int) $model->bank_account_id,
            'created_at' => $model->created_at->format('Y-m-d'),
            'updated_at' => $model->updated_at->format('Y-m-d'),
        ];
    }

    public function includeBankAccount(Statement $model)
    {
        return $this->item($model->bankAccount, new BankAccountTransformer());
    }
}
