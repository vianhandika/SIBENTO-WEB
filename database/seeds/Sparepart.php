<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Sparepart extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('spareparts')->insert([
            [
                'id_sparepart' => '1111-ASTRA-101',
                'name_sparepart'      => 'Ban Belakang',
                'brand_sparepart' => 'Astra',
                'stock_sparepart' => 10,
                'minimal_stock_sparepart' => 4,
                'placement' => 'DPN-BAN-01',
                'image_sparepart' => '',
                'id_sparepart_type' => 1,
                'buy_price' => '200000',
                'sell_price'      => '250000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_sparepart' => '1111-ASTRA-102',
                'name_sparepart'      => 'Busi',
                'brand_sparepart' => 'Astra',
                'stock_sparepartock' => 10,
                'minimal_stock_sparepart' => 6,
                'placement' => 'DPN-KACA-01',
                'image_sparepart' => '',
                'id_sparepart_type' => 2,
                'buy_price' => '50000',
                'sell_price'      => '55000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_sparepart' => '1111-ASTRA-103',
                'name_sparepart'      => 'Stang Seker',
                'brand_sparepart' => 'Astra',
                'stock_sparepartock' => 10,
                'minimal_stock_sparepart' => 4,
                'placement' => 'TGH-KACA-01',
                'image_sparepart' => '',
                'id_sparepart_type' => 3,
                'buy_price' => '100000',
                'sell_price'      => '110000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
