<?php

use CodeBills\Models\Bank;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateBanksData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var \CodeBills\Repositories\BankRepository $bankRepository */
        $bankRepository = app(\CodeBills\Repositories\BankRepository::class);

        foreach ($this->getData() as $bankArray) {
            $bankRepository->create($bankArray);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var \CodeBills\Repositories\BankRepository $bankRepository */
        $bankRepository = app(\CodeBills\Repositories\BankRepository::class);
        $bankRepository->skipPresenter(true);
        $count = count($this->getData());

        foreach (range(1, $count) as $value) {
            $model = $bankRepository->find($value);

            Storage::disk('public')->delete(Bank::logosDir() . '/' . $model->logo);

            $model->delete();
        }
    }

    private function getData()
    {
        return [
            [
                'name' => 'Banco do Brasil',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/bb.png'), 'bb.png'),
            ],
            [
                'name' => 'Bradesco',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/bradesco.png'), 'bradesco.png'),
            ],
            [
                'name' => 'Caixa',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/caixa.png'), 'caixa.png'),
            ],
            [
                'name' => 'Itaú',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/itau.png'), 'itau.png'),
            ],
            [
                'name' => 'Santander',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/santander.png'), 'santander.png'),
            ],
        ];
    }
}
