<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'id_transaction' => 'SV-031119-1',
                'status_process'      => 'Finish',
                'date_transaction' => Carbon::now(),
                'status_paid' => 'Paid',
                'type_transaction' => 'Service',
                'discount_transaction' => 0,
                'total_transaction' => 50000,
                'id_customer' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_transaction' => 'SS-031119-2',
                'status_process'      => 'Finish',
                'date_transaction' => Carbon::now(),
                'status_paid' => 'Paid',
                'type_transaction' => 'Sparepart & Service',
                'discount_transaction' => 0,
                'total_transaction' => 160000,
                'id_customer' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_transaction' => 'SP-031119-3',
                'status_process'      => 'Finish',
                'date_transaction' => Carbon::now(),
                'status_paid' => 'Paid',
                'type_transaction' => 'Sparepart',
                'discount_transaction' => 0,
                'total_transaction' => 165000,
                'id_customer' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_transaction' => 'SV-031119-4',
                'status_process'      => 'On Process',
                'date_transaction' => Carbon::now(),
                'status_paid' => 'UnPaid',
                'type_transaction' => 'Service',
                'discount_transaction' => 0,
                'total_transaction' => 50000,
                'id_customer' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
           
        ]);
    }
}
