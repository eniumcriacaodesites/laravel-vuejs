<?php

use CodeBills\Models\Bank;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateBankLogoDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $logo = new UploadedFile(storage_path('app/files/banks/logos/no_image.png'), 'no_image.png');

        Storage::disk('public')->putFileAs(Bank::logosDir(), $logo, env('BANK_LOGO_DEFAULT'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Storage::disk('public')->delete(Bank::logosDir() . '/' . env('BANK_LOGO_DEFAULT'));
    }
}
