<?php

namespace CodeBills\Iugu;

use CodeBills\Iugu\Exceptions\IuguCustomerException;
use CodeBills\Repositories\ClientRepository;

class IuguCustomerClient
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * IuguCustomerClient constructor.
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function create(array $attributes)
    {
        $result = \Iugu_Customer::create(array_only($attributes, ['name', 'email']));

        if (isset($result['errors'])) {
            throw new IuguCustomerException($result['errors']);
        }

        $this->clientRepository->update(['code' => $result['id']], $attributes['id']);

        return $result;
    }
}
