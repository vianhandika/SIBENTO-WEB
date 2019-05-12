<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTransactionServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaction_services', function (Blueprint $table) {
            $table->increments('id_detail_service');
            $table->integer('amount_transaction_service');
            $table->double('price_transaction_service');
            $table->double('subtotal_transaction_service');
            $table->string('id_transaction',30);
            $table->foreign('id_transaction')->references('id_transaction')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('id_service')->unsigned();
            $table->foreign('id_service')->references('id_service')->on('services')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('id_employee')->unsigned();
            $table->foreign('id_employee')->references('id_employee')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('id_motorcycle')->unsigned();
            $table->foreign('id_motorcycle')->references('id_motorcycle')->on('motorcycle_customers')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detail_transaction_services');
    }
}
