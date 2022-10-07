<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('delegate_id')->nullable()->constrained('users');
            $table->foreignId('receiving_address_id')->nullable()->constrained('user_addresses');
            $table->foreignId('delivery_address_id')->constrained('user_addresses');
            $table->integer('type');
            $table->integer('is_schedule')->default(0);
            $table->dateTime('schedule_date')->nullable();
            $table->foreignId('shop_id')->nullable()->constrained('shops');
            $table->integer('status')->default(1);
            $table->string('reference_number');
            $table->text('order_description');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->double('rate')->default(0);
            $table->boolean('notified')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
