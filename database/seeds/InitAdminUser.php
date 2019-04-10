<?php

use Illuminate\Database\Seeder;

class InitAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
        	'username'=>'admin',
           'password'=>md5('123qwe'),
           'image_url'=>'',
           'is_super'=>'2',
           'status'=>'1',
        ];
        DB::table('admin_users')->insert($data);

    }
}
