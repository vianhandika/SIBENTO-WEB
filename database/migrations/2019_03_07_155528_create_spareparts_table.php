<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->string('id_sparepart',30)->primary();
            $table->string('name_sparepart',25);
            $table->string('brand_sparepart',25);
            $table->integer('stock_sparepart');
            $table->integer('minimal_stock_sparepart');
            $table->double('buy_price');
            $table->double('sell_price');
            $table->string('placement',50);
            $table->string('image_sparepart');
            $table->integer('id_sparepart_type')->unsigned();
            $table->foreign('id_sparepart_type')->references('id_sparepart_type')->on('sparepart_types')->onUpdate('cascade');
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
        Schema::dropIfExists('spareparts');
    }
}
