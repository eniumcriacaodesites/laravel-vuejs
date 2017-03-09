<?php

namespace CodeBills\Presenters;

use CodeBills\Transformers\BillReceiveTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BillReceivePresenter
 *
 * @package namespace CodeBills\Presenters;
 */
class BillReceivePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BillReceiveTransformer();
    }
}
