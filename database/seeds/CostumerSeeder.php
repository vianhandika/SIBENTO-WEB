<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CostumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'name_customer'      => 'Panda',
                'address_customer'      => 'Jalan Barbasari',
                'phone_number_customer'      => '082245504410',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_customer'      => 'Ryan',
                'address_customer'      => 'Jalan Barbasari',
                'phone_number_customer'      => '082245504411',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_customer'      => 'Yudha',
                'address_customer'      => 'Jalan Babarsari',
                'phone_number_customer'      => '082245504412',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_customer'      => 'Suma',
                'address_customer'      => 'Jalan Babarsari',
                'phone_number_customer'      => '082245504413',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
