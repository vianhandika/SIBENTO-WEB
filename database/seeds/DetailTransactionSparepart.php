<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DetailTransactionSparepart extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_transaction_spareparts')->insert([
            [
                'amount_transaction_sparepart'      => 1,
                'price_transaction_sparepart' => 110000,
                'subtotal_transaction_sparepart' => 110000,
                'id_transaction' => 'SS-031119-2',
                'id_sparepart' => '1111-AST-103',
                'id_employee' => 5,
                'id_motorcycle' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'amount_transaction_sparepart'      => 1,
                'price_transaction_sparepart' => 110000,
                'subtotal_transaction_sparepart' => 110000,
                'id_transaction' => 'SP-031119-3',
                'id_sparepart' => '1111-AST-103',
                'id_employee' => 5,
                'id_motorcycle' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'amount_transaction_sparepart'      => 1,
                'price_transaction_sparepart' => 55000,
                'subtotal_transaction_sparepart' => 55000,
                'id_transaction' => 'SP-031119-3',
                'id_sparepart' => '1111-AST-102',
                'id_employee' => 5,
                'id_motorcycle' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
