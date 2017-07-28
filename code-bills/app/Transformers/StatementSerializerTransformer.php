<?php

namespace CodeBills\Transformers;

use CodeBills\Presenters\StatementPresenter;
use CodeBills\Serializer\StatementSerializer;
use League\Fractal\TransformerAbstract;

/**
 * Class StatementSerializerTransformer
 *
 * @package namespace CodeBills\Transformers;
 */
class StatementSerializerTransformer extends TransformerAbstract
{
    /**
     * @var StatementPresenter
     */
    private $statementPresenter;

    /**
     * StatementSerializerTransformer constructor.
     *
     * @param StatementPresenter $statementPresenter
     */
    public function __construct(StatementPresenter $statementPresenter)
    {
        $this->statementPresenter = $statementPresenter;
    }

    /**
     * Transform the \StatementSerializer entity
     *
     *
     * @param StatementSerializer $serializer
     * @return array
     */
    public function transform(StatementSerializer $serializer)
    {
        return [
            'statements' => $this->statementPresenter->present($serializer->getStatements()),
            'statement_data' => $serializer->getStatementData(),
        ];
    }
}
