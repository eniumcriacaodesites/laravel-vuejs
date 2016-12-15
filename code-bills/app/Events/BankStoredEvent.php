<?php

namespace CodeBills\Events;

use CodeBills\Models\Bank;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BankStoredEvent
{
    /**
     * @var Bank
     */
    private $bank;

    /**
     * @var UploadedFile
     */
    private $logo;

    /**
     * Create a new event instance.
     *
     * @param Bank $bank
     * @param UploadedFile $logo
     */
    public function __construct(Bank $bank, UploadedFile $logo = null)
    {
        $this->bank = $bank;
        $this->logo = $logo;
    }

    /**
     * @return Bank
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @return UploadedFile
     */
    public function getLogo()
    {
        return $this->logo;
    }
}
