<?php

namespace CodeBills\Presenters;

use CodeBills\Transformers\StatementTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StatementPresenter
 *
 * @package namespace CodeBills\Presenters;
 */
class StatementPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StatementTransformer();
    }
}
