<?php

namespace CodeBills\Presenters;

use CodeBills\Transformers\StatementSerializerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StatementSerializerPresenter
 *
 * @package namespace CodeBills\Presenters;
 */
class StatementSerializerPresenter extends FractalPresenter
{
    /**
     * @var StatementPresenter
     */
    private $statementPresenter;

    /**
     * StatementSerializerPresenter constructor.
     *
     * @param StatementPresenter $statementPresenter
     */
    public function __construct(StatementPresenter $statementPresenter)
    {
        parent::__construct();
        $this->statementPresenter = $statementPresenter;
    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StatementSerializerTransformer($this->statementPresenter);
    }
}
