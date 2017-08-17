<?php

namespace CodeBills\Repositories;

use CodeBills\Models\CategoryRevenue;
use CodeBills\Presenters\CategoryRevenuePresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CategoryRevenueRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class CategoryRevenueRepositoryEloquent extends BaseRepository implements CategoryRevenueRepository
{
    public function create(array $attributes)
    {
        CategoryRevenue::$enableTenant = false;

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

        CategoryRevenue::$enableTenant = true;

        return $result;
    }

    public function update(array $attributes, $id)
    {
        CategoryRevenue::$enableTenant = false;

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

        CategoryRevenue::$enableTenant = true;

        return $result;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CategoryRevenue::class;
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
        return CategoryRevenuePresenter::class;
    }
}
