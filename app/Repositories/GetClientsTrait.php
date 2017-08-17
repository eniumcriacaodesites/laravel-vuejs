<?php

namespace CodeBills\Repositories;

trait GetClientsTrait
{
    private function getClients()
    {
        /** @var \CodeBills\Repositories\BankRepository $repository */
        $repository = app(\CodeBills\Repositories\ClientRepository::class);
        $repository->skipPresenter(true);

        return $repository->all();
    }
}
