<?php

namespace CodeBills\Repositories;

trait GetBanksTrait
{
    private function getBanks()
    {
        /** @var \CodeBills\Repositories\BankRepository $repository */
        $repository = app(\CodeBills\Repositories\BankRepository::class);
        $repository->skipPresenter(true);

        return $repository->all();
    }
}
