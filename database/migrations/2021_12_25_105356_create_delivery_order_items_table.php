<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('delivery_orders');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->float('price', 22, 4);
            $table->integer('quantity');
            $table->float('sub_total', 22, 4);
            $table->json('item_details')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_order_items');
    }
}
