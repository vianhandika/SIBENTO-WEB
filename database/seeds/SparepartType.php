<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SparepartType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sparepart_types')->insert([
            [
                'name_sparepart_type'      => 'Sparepart Roda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_sparepart_type'      => 'Sparepart Kelistrikan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_sparepart_type'      => 'Sparepart Mesin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
