<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DetailTransactionService extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_transaction_services')->insert([
            [
                'amount_transaction_service'      => 1,
                'price_transaction_service' => 50000,
                'subtotal_transaction_service' => 50000,
                'id_transaction' => 'SV-031119-1',
                'id_service' => 2,
                'id_employee' => 5,
                'id_motorcycle' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'amount_transaction_service'      => 1,
                'price_transaction_service' => 50000,
                'subtotal_transaction_service' => 50000,
                'id_transaction' => 'SS-031119-2',
                'id_service' => 2,
                'id_employee' => 5,
                'id_motorcycle' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'amount_transaction_service'      => 1,
                'price_transaction_service' => 50000,
                'subtotal_transaction_service' => 50000,
                'id_transaction' => 'SP-031119-3',
                'id_service' => 2,
                'id_employee' => 5,
                'id_motorcycle' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
