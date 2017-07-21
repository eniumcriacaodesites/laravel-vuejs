<?php

namespace CodeBills\Repositories;

use CodeBills\Models\Statement;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class StatementRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class StatementRepositoryEloquent extends BaseRepository implements StatementRepository
{
    public function create(array $attributes)
    {
        $statementable = $attributes['statementable'];

        return $statementable->statements()->create(array_except($attributes, 'statementable'));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Statement::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
