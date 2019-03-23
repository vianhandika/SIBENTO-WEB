<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'name_supplier'      => 'PT Astra',
                'address_supplier'      => 'Jalan Barbasari',
                'phone_number_supplier'      => '023792991',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_supplier'      => 'PT Honda',
                'address_supplier'      => 'Jalan Sleman',
                'phone_number_supplier'      => '023792992',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_supplier'      => 'PT Jaya',
                'address_supplier'      => 'Jalan Seturan',
                'phone_number_supplier'      => '023792992',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
