<?php

namespace CodeBills\Presenters;

use CodeBills\Transformers\CategoryExpenseTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CategoryExpensePresenter
 *
 * @package namespace CodeBills\Presenters;
 */
class CategoryExpensePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CategoryExpenseTransformer();
    }
}
