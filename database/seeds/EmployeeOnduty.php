<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeeOnduty extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_onduties')->insert([
            [
                'id_employee'      => 1,
                'id_transaction'      => 'SV-031119-1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 2,
                'id_transaction'      => 'SV-031119-1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 1,
                'id_transaction'      => 'SS-031119-2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 2,
                'id_transaction'      => 'SS-031119-2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 1,
                'id_transaction'      => 'SP-031119-3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 2,
                'id_transaction'      => 'SP-031119-3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 1,
                'id_transaction'      => 'SV-031119-4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_employee'      => 2,
                'id_transaction'      => 'SV-031119-4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
        ]);
    }
}
