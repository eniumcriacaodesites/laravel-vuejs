<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankAccountToBillPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_pays', function (Blueprint $table) {
            $table->integer('bank_account_id')->nullable()->unsigned();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_pays', function (Blueprint $table) {
            $table->dropForeign('bill_pays_bank_account_id_foreign');
            $table->dropColumn('bank_account_id');
        });
    }
}
