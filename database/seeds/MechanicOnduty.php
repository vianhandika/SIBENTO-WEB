<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MechanicOnduty extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mechanic_onduties')->insert([
            [
                'id_employee'      => 3,
                'id_motorcycle_customer'      => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 4,
                'id_motorcycle_customer'      => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 3,
                'id_motorcycle_customer'      => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
