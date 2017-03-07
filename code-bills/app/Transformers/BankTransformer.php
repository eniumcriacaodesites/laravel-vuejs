<?php

namespace CodeBills\Transformers;

use CodeBills\Models\Bank;
use League\Fractal\TransformerAbstract;

/**
 * Class BankTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class BankTransformer extends TransformerAbstract
{
    /**
     * Transform the \Bank entity
     *
     * @param \CodeBills\Models\Bank $model
     *
     * @return array
     */
    public function transform(Bank $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
