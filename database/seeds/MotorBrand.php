<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MotorBrand extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motorcycle_brands')->insert([
            [
                'name_motorcycle_brand'      => 'Honda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_motorcycle_brand'      => 'Yamaha',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_motorcycle_brand'      => 'Kawasaki',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_motorcycle_brand'      => 'Suzuki',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
