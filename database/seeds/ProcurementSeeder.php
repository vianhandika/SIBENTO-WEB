<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sparepart_procurements')->insert([
            [
                'status_procurement'      => 'Finish',
                'id_sales'      => 1,
                'date_procurement'      => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status_procurement'      => 'Finish',
                'id_sales'      => 2,
                'date_procurement'      => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status_procurement'      => 'On Process',
                'id_sales'      => 3,
                'date_procurement'      => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
