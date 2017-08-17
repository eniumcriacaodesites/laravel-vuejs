<?php

namespace CodeBills\Transformers;

use CodeBills\Models\CategoryExpense;
use League\Fractal\TransformerAbstract;

/**
 * Class CategoryExpenseTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class CategoryExpenseTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['children'];

    /**
     * Transform the CategoryExpense entity
     *
     * @param CategoryExpense $model
     *
     * @return array
     */
    public function transform(CategoryExpense $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'parent_id' => $model->parent_id,
            'depth' => $model->depth,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }

    public function includeChildren(CategoryExpense $model)
    {
        return $this->collection($model->children()->withDepth()->get(), new CategoryExpenseTransformer());
    }
}
