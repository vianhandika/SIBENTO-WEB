<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->insert([
            [
                'name_sales'      => 'Leo',
                'id_supplier'      => '1',
                'phone_number_sales'      => '082245504410',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_sales'      => 'Theo',
                'id_supplier'      => '2',
                'phone_number_sales'      => '082245504411',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_sales'      => 'Nathaniel',
                'id_supplier'      => '3',
                'phone_number_sales'      => '082245504412',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
