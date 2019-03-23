<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class sessionseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sessions')->insert([
            [
                'encrypt_username'      => bcrypt('admin'),
                'encrypt_password'      => bcrypt('admin'),
                'generated_at'       =>Carbon::now(),
                'lastused_at'       =>Carbon::now(),
                'id_user'           =>1
            ],
            [
                'encrypt_username'      => bcrypt('vian2'),
                'encrypt_password'      => bcrypt('vian2'),
                'generated_at'       =>Carbon::now(),
                'lastused_at'       =>Carbon::now(),
                'id_user'           =>2
            ],
            [
                'encrypt_username'      => bcrypt('dewa3'),
                'encrypt_password'      => bcrypt('dewa3'),
                'generated_at'       =>Carbon::now(),
                'lastused_at'       =>Carbon::now(),
                'id_user'           =>3
            ],
        ]);
    }
}
