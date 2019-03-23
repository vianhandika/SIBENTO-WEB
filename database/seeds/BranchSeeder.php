<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            [
                'name_branch'      => 'Sleman',
                'address_branch'      => 'Jalan Sleman',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_branch'      => 'Jakal',
                'address_branch'      => 'Jalan Kaliurang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_branch'      => 'Congcat',
                'address_branch'      => 'Jalan Congcat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_branch'      => 'Barbasari',
                'address_branch'      => 'Jalan Barbasari',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
