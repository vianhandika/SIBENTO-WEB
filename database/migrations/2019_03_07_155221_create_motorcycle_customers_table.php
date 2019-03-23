<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotorcycleCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motorcycle_customers', function (Blueprint $table) {
            $table->increments('id_motorcycle');
            $table->string('plate_number',25);
            $table->integer('id_motorcycle_type')->unsigned();
            $table->foreign('id_motorcycle_type')->references('id_motorcycle_type')->on('motorcycle_types')->onUpdate('cascade');
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('motorcycle_customers');
    }
}
