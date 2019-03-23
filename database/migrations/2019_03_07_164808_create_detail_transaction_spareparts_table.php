<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTransactionSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaction_spareparts', function (Blueprint $table) {
            $table->increments('id_detail_sparepart');
            $table->integer('amount_transaction_sparepart');
            $table->double('price_transaction_sparepart');
            $table->double('subtotal_transaction_sparepart');
            $table->string('id_transaction',30);
            $table->foreign('id_transaction')->references('id_transaction')->on('transactions')->onUpdate('cascade');
            $table->string('id_sparepart',30);
            $table->foreign('id_sparepart')->references('id_sparepart')->on('spareparts')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('id_mechanic_onduty')->unsigned()->nullable();
            $table->foreign('id_mechanic_onduty')->references('id_mechanic_onduty')->on('mechanic_onduties')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaction_spareparts');
    }
}
