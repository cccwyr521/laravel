<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoShopCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto_shop';

    /**
     * The console command description.
     *
     * @var string
     */
    //描述
    protected $description = '商品自动上架的功能';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //查询出来所有未上架的商品，并且上架时间小于等于当前时间的

        $goods = \DB::table('jy_goods')
                    ->select('id')
                    ->where('is_shop',2)
                    ->where('shop_time',"<=",date("Y-m-d H:i:s"))
                    ->get();

        //封装自动上架的商品
        $goodIds = [];

        foreach ($goods as $k => $v) {
            $goodIds[] = $v->id;
        }

        try{

             \DB::table('jy_goods')->whereIn('id',$goodIds)->update(['is_shop'=>1]);
             \Log::info('商品自动化上架成功');
        }catch(\Exception $e){

            \Log::error('商品自动化上架失败',$e->getMessage());
        }

      
    }
}
