<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GoodsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $database=file_get_contents(base_path('database/seeds')."/goods_type.sql");
        DB::connection()->getPdo()->exec($database);
    }
}
