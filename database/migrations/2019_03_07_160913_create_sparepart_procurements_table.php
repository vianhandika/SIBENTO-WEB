<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparepartProcurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sparepart_procurements', function (Blueprint $table) {
            $table->increments('id_procurement');
            $table->timestamp('date_procurement');
            $table->string('status_procurement',50);
            $table->integer('id_sales')->unsigned();
            $table->foreign('id_sales')->references('id_sales')->on('sales')->onUpdate('cascade');
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
        Schema::dropIfExists('sparepart_procurements');
    }
}
