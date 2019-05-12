<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SparepartCompatibilities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sparepart_compatibilities')->insert([
            [
                'id_motorcycle_type'      => 1,
                'id_sparepart'      => '1111-AST-101',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 1,
                'id_sparepart'      => '1111-AST-102',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 1,
                'id_sparepart'      => '1111-AST-103',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 2,
                'id_sparepart'      => '1111-AST-101',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 2,
                'id_sparepart'      => '1111-AST-102',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 2,
                'id_sparepart'      => '1111-AST-103',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 3,
                'id_sparepart'      => '1111-AST-101',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 3,
                'id_sparepart'      => '1111-AST-102',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_motorcycle_type'      => 3,
                'id_sparepart'      => '1111-AST-103',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
           
        ]);
    }
}
