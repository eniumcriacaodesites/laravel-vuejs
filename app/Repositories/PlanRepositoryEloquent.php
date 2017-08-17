<?php

namespace CodeBills\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeBills\Repositories\PlanRepository;
use CodeBills\Models\Plan;
use CodeBills\Validators\PlanValidator;

/**
 * Class PlanRepositoryEloquent
 * @package namespace CodeBills\Repositories;
 */
class PlanRepositoryEloquent extends BaseRepository implements PlanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plan::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
