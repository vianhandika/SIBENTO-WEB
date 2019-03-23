<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MotorType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motorcycle_types')->insert([
            [
                'name_motorcycle_type'      => 'Beat',
                'id_motorcycle_brand'      => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_motorcycle_type'      => 'Ninja',
                'id_motorcycle_brand'      => '3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_motorcycle_type'      => 'Mio',
                'id_motorcycle_brand'      => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_motorcycle_type'      => 'Tiger',
                'id_motorcycle_brand'      => '4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
