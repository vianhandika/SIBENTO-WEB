<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailSparepartProcurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_sparepart_procurements', function (Blueprint $table) {
            $table->increments('id_detail_procurement');
            $table->double('price_detail_procurement');
            $table->double('subtotal_detail_procurement');
            $table->integer('amount_detail_procurement');
            $table->integer('id_procurement')->unsigned();
            $table->foreign('id_procurement')->references('id_procurement')->on('sparepart_procurements')->onUpdate('cascade')->onDelete('cascade');
            $table->string('id_sparepart',30);
            $table->foreign('id_sparepart')->references('id_sparepart')->on('spareparts')->onUpdate('cascade');
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
        Schema::dropIfExists('detail_sparepart_procurements');
    }
}
