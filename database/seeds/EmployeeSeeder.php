<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            [
                'name_employee'      => 'Admin',
                'salary'      => 1000000,
                'phone_number'      => '082245504410',
                'address' => 'Sleman',
                'id_user' => 1,
                'id_branch' => 1,
                'id_role' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_employee'      => 'Vian Handika',
                'salary'      => 1000000,
                'phone_number'      => '082245504410',
                'address' => 'Sleman',
                'id_user' => 2,
                'id_branch' => 1,
                'id_role' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_employee'      => 'Dewa Agung',
                'salary'      => 1200000,
                'phone_number'      => '082245504412',
                'address' => 'Barbasari',
                'id_user' => 3,
                'id_branch' => 1,
                'id_role' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_employee'      => 'Daud Joan',
                'salary'      => 1600000,
                'phone_number'      => '082245504416',
                'address' => 'Babarsari',
                'id_user' => null,
                'id_branch' => 1,
                'id_role' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_employee'      => 'Jose Revalen',
                'salary'      => 1500000,
                'phone_number'      => '082245504415',
                'address' => 'Sleman',
                'id_user' => null,
                'id_branch' => 1,
                'id_role' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_employee'      => 'Yuri Chandra',
                'salary'      => 1400000,
                'phone_number'      => '082245504414',
                'address' => 'Babarsari',
                'id_user' => 4,
                'id_branch' => 2,
                'id_role' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name_employee'      => 'Edy Predator',
                'salary'      => 1300000,
                'phone_number'      => '082245504413',
                'address' => 'Seturan',
                'id_user' => 5,
                'id_branch' => 2,
                'id_role' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
