<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->index()->comment("Delivery")->nullable()->constrained('delivery_orders')->onDelete('cascade');
            $table->date('approved')->nullable();
            $table->date('processing')->nullable();
            $table->date('shipped')->nullable();
            $table->date('delivered')->nullable();
            $table->date('rejected')->nullable();
            $table->foreignId('created_by')->index()->comment("Created by")->nullable()->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('delivery_order_statuses');
    }
}
