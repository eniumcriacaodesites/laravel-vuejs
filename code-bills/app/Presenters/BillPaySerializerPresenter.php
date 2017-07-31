<?php

namespace CodeBills\Presenters;

use CodeBills\Transformers\BillSerializerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BillPaySerializerPresenter
 *
 * @package namespace CodeBills\Presenters;
 */
class BillPaySerializerPresenter extends FractalPresenter
{
    /**
     * @var BillPayPresenter
     */
    private $billPayPresenter;

    /**
     * BillPaySerializerPresenter constructor.
     *
     * @param BillPayPresenter $billPayPresenter
     */
    public function __construct(BillPayPresenter $billPayPresenter)
    {
        parent::__construct();
        $this->billPayPresenter = $billPayPresenter;
    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BillSerializerTransformer($this->billPayPresenter);
    }
}
