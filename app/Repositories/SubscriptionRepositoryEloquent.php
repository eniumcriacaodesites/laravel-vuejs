<?php

namespace CodeBills\Repositories;

use CodeBills\Models\Subscription;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class SubscriptionRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class SubscriptionRepositoryEloquent extends BaseRepository implements SubscriptionRepository
{
    protected $fieldSearchable = [
        'code' => 'like',
        'user.name' => 'like',
        'plan.name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subscription::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
