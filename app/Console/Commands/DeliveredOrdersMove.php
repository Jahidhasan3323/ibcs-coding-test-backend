<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeliveredOrdersMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivered-orders-move';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'move those  order in delivery_order table which order"s status is delivered  ';

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
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        Order::query()->status('Delivered')
            ->each(function ($oldOrder) {
                $newOrder = $oldOrder->replicate();
                $newOrder->setTable('delivery_orders');
                $newOrder->save();
                $this->deliveredOrderItems($oldOrder);
                $this->deliveredOrderStatusHistory($oldOrder);
                $oldOrder->delete();
            });
        DB::commit();
    }


    /**
     * Delivered Order items store in delivery_items table and removed Delivered order items
     *
     * @param Order $oldOrder
     */

    public function deliveredOrderItems(Order $oldOrder)
    {
        foreach ($oldOrder->orderItems as $oldOrderItem) {
            $newOrderItem = $oldOrderItem->replicate();
            $newOrderItem->setTable('delivery_order_items');
            $newOrderItem->save();
            $oldOrderItem->delete();
        }
    }


    /**
     * Delivered Order status history store in delivery_status_histories table and removed Delivered order status history
     *
     * @param Order $oldOrder
     */
    public function deliveredOrderStatusHistory(Order $oldOrder)
    {
        $oldOrderStatus = $oldOrder->orderStatus;
        $newOrderStatus = $oldOrderStatus->replicate();
        $newOrderStatus->setTable('delivery_order_statuses');
        $newOrderStatus->save();
        $oldOrderStatus->delete();
    }
}
