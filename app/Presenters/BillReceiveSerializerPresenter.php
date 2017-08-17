<?php

namespace CodeBills\Presenters;

use CodeBills\Transformers\BillSerializerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BillReceiveSerializerPresenter
 *
 * @package namespace CodeBills\Presenters;
 */
class BillReceiveSerializerPresenter extends FractalPresenter
{
    /**
     * @var BillReceivePresenter
     */
    private $billReceivePresenter;

    /**
     * BillReceiveSerializerPresenter constructor.
     *
     * @param BillReceivePresenter $billReceivePresenter
     */
    public function __construct(BillReceivePresenter $billReceivePresenter)
    {
        parent::__construct();
        $this->billReceivePresenter = $billReceivePresenter;
    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BillSerializerTransformer($this->billReceivePresenter);
    }
}
