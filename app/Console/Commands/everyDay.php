<?php

namespace App\Console\Commands;

use App\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class everyDay extends Command
{

    protected $signature = 'days:update';


    protected $description = 'this will transfer delivered product from order to deliveries table';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Order::query()
            ->where('created_at','<', Carbon::now()->subDays(1))
            ->where('status','=',4)
            ->each(function ($oldOrder) {
                $newOrder = $oldOrder->replicate();
                $newOrder->setTable('deliveries');
                $newOrder->save();
                $oldOrder->delete();
            });
    }
}
