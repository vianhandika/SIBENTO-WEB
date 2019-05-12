<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DetailProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_sparepart_procurements')->insert([
            [
                'price_detail_procurement'      => 200000,
                'subtotal_detail_procurement' => 600000,
                'amount_detail_procurement' => 3,
                'id_procurement' => 1,
                'id_sparepart'      => '1111-AST-101',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'price_detail_procurement'      => 50000,
                'subtotal_detail_procurement' => 100000,
                'amount_detail_procurement' => 2,
                'id_procurement' => 2,
                'id_sparepart'      => '1111-AST-102',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'price_detail_procurement'      => 100000,
                'subtotal_detail_procurement' => 300000,
                'amounamount_detail_procurementt' => 3,
                'id_procurement' => 3,
                'id_sparepart'      => '1111-AST-103',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
