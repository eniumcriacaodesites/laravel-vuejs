<?php

namespace CodeBills\Presenters;

use CodeBills\Transformers\CategoryRevenueTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CategoryRevenuePresenter
 *
 * @package namespace CodeBills\Presenters;
 */
class CategoryRevenuePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CategoryRevenueTransformer();
    }
}
