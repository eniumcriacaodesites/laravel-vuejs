<?php

namespace CodeBills\Listeners;

use CodeBills\Repositories\BankAccountRepository;
use Prettus\Repository\Events\RepositoryEventBase;

class BankAccountSetDefaultListener
{
    /**
     * @var BankAccountRepository
     */
    private $accountRepository;

    /**
     * Create the event listener.
     *
     * @param BankAccountRepository $accountRepository
     */
    public function __construct(BankAccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->accountRepository->skipPresenter(true);
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEventBase $event
     * @return void
     */
    public function handle(RepositoryEventBase $event)
    {
        $model = $event->getModel();

        if (!$model->default) {
            return;
        }

        $collection = $this->accountRepository
            ->findByField('default', true)
            ->filter(function ($value, $key) use ($model) {
                return $model->id != $value->id;
            });

        $bankAccountDefault = $collection->first();

        if ($bankAccountDefault) {
            $this->accountRepository->update(['default' => false], $bankAccountDefault->id);
        }
    }
}
