<?php

namespace CodeBills\Transformers;

use League\Fractal\TransformerAbstract;
use CodeBills\Models\CategoryRevenue;

/**
 * Class CategoryRevenueTransformer
 * @package namespace CodeBills\Transformers;
 */
class CategoryRevenueTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['children'];

    /**
     * Transform the CategoryRevenue entity
     *
     * @param CategoryRevenue $model
     *
     * @return array
     */
    public function transform(CategoryRevenue $model)
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

    public function includeChildren(CategoryRevenue $model)
    {
        return $this->collection($model->children()->withDepth()->get(), new CategoryRevenueTransformer());
    }
}
