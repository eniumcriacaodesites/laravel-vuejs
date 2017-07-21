<?php

namespace CodeBills\Listeners;

use CodeBills\Events\BillStoredEvent;
use CodeBills\Events\CodeBillsEventsBillStoredEvent;
use CodeBills\Models\BillPay;
use CodeBills\Repositories\BankAccountRepository;
use CodeBills\Repositories\StatementRepository;

class BankAccountUpdateBalanceListener
{
    /**
     * @var BankAccountRepository
     */
    private $bankAccountRepository;

    /**
     * @var StatementRepository
     */
    private $statementRepository;

    /**
     * Create the event listener.
     *
     * @param BankAccountRepository $bankAccountRepository
     * @param StatementRepository $statementRepository
     */
    public function __construct(
        BankAccountRepository $bankAccountRepository,
        StatementRepository $statementRepository
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->bankAccountRepository->skipPresenter(true);
        $this->statementRepository = $statementRepository;
    }

    /**
     * Handle the event.
     *
     * @param  BillStoredEvent $event
     * @return void
     */
    public function handle(BillStoredEvent $event)
    {
        $model = $event->getModel();
        $bankAccountId = $model->bank_account_id;
        $value = $this->getValue($event);

        if ($value) {
            $bankAccount = $this->bankAccountRepository->addBalance($bankAccountId, $value);

            $this->statementRepository->create([
                'statementable' => $model,
                'value' => $value,
                'balance' => $bankAccount->balance,
                'bank_account_id' => $bankAccount->id,
            ]);
        }
    }

    protected function getValue(BillStoredEvent $event)
    {
        $model = $event->getModel();
        $modelOld = $event->getModelOld();

        $value = $model->value;
        $valueOld = $modelOld ? $modelOld->value : $model->value;
        $doneOld = $modelOld ? $modelOld->done : false;

        if ($value != $valueOld) { // valor da conta alterado
            if ($model->done == $modelOld->done && $model->done) { // conta coninua paga
                return $model instanceof BillPay ? $valueOld - $value : $value - $valueOld;
            }
        }

        if ($model->done != $doneOld) {
            if ($model->done) {
                return $model instanceof BillPay ? -$value : $value;
            } else {
                return $model instanceof BillPay ? $valueOld : -$valueOld;
            }
        }

        return false;
    }
}
