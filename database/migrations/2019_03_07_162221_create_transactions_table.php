<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id_transaction',30)->primary();;
            $table->timestamp('date_transaction');
            $table->string('status_paid',10);
            $table->string('status_process',10);
            $table->string('type_transaction',50);
            $table->double('discount_transaction');
            $table->double('total_transaction');
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onUpdate('cascade');
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
        Schema::dropIfExists('transactions');
    }
}
