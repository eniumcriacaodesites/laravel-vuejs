<?php

namespace CodeBills\Repositories;

use CodeBills\Models\Category;
use CodeBills\Presenters\CategoryPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CategoryRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    public function create(array $attributes)
    {
        if (isset($attributes['parent_id'])) { // child
            $skipPresenter = $this->skipPresenter;
            $this->skipPresenter(true);
            $parent = $this->find($attributes['parent_id']);
            $this->skipPresenter = $skipPresenter;
            $child = $parent->children()->create($attributes);

            return $this->parserResult($child);
        } else { // parent
            return parent::create($attributes);
        }
    }

    public function update(array $attributes, $id)
    {
        if (isset($attributes['parent_id'])) { // child
            $skipPresenter = $this->skipPresenter;
            $this->skipPresenter(true);
            $child = $this->find($id);
            $child->name = $attributes['name'];
            $child->parent_id = $attributes['parent_id'];
            $child->save();
            $this->skipPresenter = $skipPresenter;

            return $this->parserResult($child);
        } else { // parent
            $attributes['parent_id'] = null;

            return parent::update($attributes, $id);
        }
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
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
        return CategoryPresenter::class;
    }
}
