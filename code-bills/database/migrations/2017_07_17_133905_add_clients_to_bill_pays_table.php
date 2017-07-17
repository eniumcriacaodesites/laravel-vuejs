<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientsToBillPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_pays', function (Blueprint $table) {
            $table->integer('client_id')->nullable()->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
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
            $table->dropForeign('bill_pays_client_id_foreign');
            $table->dropColumn('client_id');
        });
    }
}
