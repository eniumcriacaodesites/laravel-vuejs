<?php

namespace CodeBills\Transformers;

use CodeBills\Serializer\BillSerializer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Contracts\PresenterInterface;

/**
 * Class BillSerializerTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class BillSerializerTransformer extends TransformerAbstract
{
    /**
     * @var PresenterInterface
     */
    private $billPresenter;

    /**
     * BillSerializerTransformer constructor.
     *
     * @param PresenterInterface $billPresenter
     */
    public function __construct(PresenterInterface $billPresenter)
    {
        $this->billPresenter = $billPresenter;
    }

    /**
     * Transform the \BillSerializer entity
     *
     * @param BillSerializer $serializer
     * @return array
     */
    public function transform(BillSerializer $serializer)
    {
        return [
            'bills' => $this->billPresenter->present($serializer->getBills()),
            'bill_data' => $serializer->getBillData(),
        ];
    }
}
