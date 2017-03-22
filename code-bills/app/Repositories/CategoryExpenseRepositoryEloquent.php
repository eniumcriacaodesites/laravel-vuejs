<?php

namespace CodeBills\Repositories;

use CodeBills\Models\CategoryExpense;
use CodeBills\Presenters\CategoryExpensePresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CategoryExpenseRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class CategoryExpenseRepositoryEloquent extends BaseRepository implements CategoryExpenseRepository
{
    public function create(array $attributes)
    {
        CategoryExpense::$enableTenant = false;

        if (isset($attributes['parent_id'])) { // child
            $skipPresenter = $this->skipPresenter;
            $this->skipPresenter(true);
            $parent = $this->find($attributes['parent_id']);
            $this->skipPresenter = $skipPresenter;
            $child = $parent->children()->create($attributes);
            $result = $this->parserResult($child);
        } else { // parent
            $result = parent::create($attributes);
        }

        CategoryExpense::$enableTenant = true;

        return $result;
    }

    public function update(array $attributes, $id)
    {
        CategoryExpense::$enableTenant = false;

        if (isset($attributes['parent_id'])) { // child
            $skipPresenter = $this->skipPresenter;
            $this->skipPresenter(true);
            $child = $this->find($id);
            $child->parent_id = $attributes['parent_id'];
            $child->fill($attributes);
            $child->save();
            $this->skipPresenter = $skipPresenter;

            $result = $this->parserResult($child);
        } else { // parent
            $result = parent::update($attributes, $id);
            $result->makeRoot()->save();
        }

        CategoryExpense::$enableTenant = true;

        return $result;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CategoryExpense::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return CategoryExpensePresenter::class;
    }
}
