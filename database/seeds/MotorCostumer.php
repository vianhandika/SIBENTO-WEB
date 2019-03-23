<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MotorCostumer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motorcycle_customers')->insert([
            [
                'plate_number'      => 'AB 8975 EE',
                'id_motorcycle_type'      => 1,
                'id_customer'      => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'plate_number'      => 'AB 8976 DD',
                'id_motorcycle_type'      => 2,
                'id_customer'      => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'plate_number'      => 'AB 8977 FF',
                'id_motorcycle_type'      => 3,
                'id_customer'      => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'plate_number'      => 'AB 8978 GG',
                'id_motorcycle_type'      => 4,
                'id_customer'      => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
