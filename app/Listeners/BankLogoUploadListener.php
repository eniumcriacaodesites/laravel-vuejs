<?php

namespace CodeBills\Listeners;

use CodeBills\Events\BankStoredEvent;
use CodeBills\Models\Bank;
use CodeBills\Repositories\BankRepository;
use Illuminate\Support\Facades\Storage;

class BankLogoUploadListener
{
    /**
     * @var BankRepository
     */
    private $bankRepository;

    /**
     * Create the event listener.
     *
     * @param BankRepository $bankRepository
     */
    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
        $this->bankRepository->skipPresenter(true);
    }

    /**
     * Handle the event.
     *
     * @param  BankStoredEvent $event
     * @return void
     */
    public function handle(BankStoredEvent $event)
    {
        $bank = $event->getBank();
        $logo = $event->getLogo();

        if ($logo) {
            if ($bank->created_at != $bank->updated_at) {
                $name = $bank->logo;
            } else {
                $name = md5(time() . $logo->getClientOriginalName()) . '.' . $logo->guessExtension();
            }

            $result = Storage::disk('public')->putFileAs(Bank::logosDir(), $logo, $name);

            if ($result && $bank->created_at == $bank->updated_at) {
                $this->bankRepository->update(['logo' => $name], $bank->id);
            }
        }
    }
}
