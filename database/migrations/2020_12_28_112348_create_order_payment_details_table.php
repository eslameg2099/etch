<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_payment_id')->constrained('order_payment');
            $table->integer('item_type');
            $table->string('item_name');
            $table->decimal('cost');
            $table->decimal('discount')->nullable();
            $table->integer('discount_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_payment_details');
    }
}
