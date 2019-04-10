<?php

use Illuminate\Database\Seeder;

class InitUserData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('bs_user')->insert([
           'username'=>'guoweisj'

        ]);
        DB::table('bs_user')->insert([
            'username'=>'guoweisj1'

        ]);
        DB::table('bs_user')->insert([
            'username'=>'guoweisj2'

        ]);
    }
}
