<?php

namespace CodeBills\Transformers;

use CodeBills\Models\Category;
use League\Fractal\TransformerAbstract;

/**
 * Class CategoryTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['children'];

    /**
     * Transform the \Category entity
     *
     * @param Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }

    public function includeChildren(Category $model)
    {
        if ($model->children) {
            return $this->collection($model->children, new CategoryTransformer());
        }
    }
}
