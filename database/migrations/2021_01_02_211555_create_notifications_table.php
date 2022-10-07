<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->jsonb('data');
            $table->timestamp('read_at')->nullable();
            $table->foreignId('user_id')->storedAs("data->'$.user_id'")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->storedAs("data->'$.order_id'")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('offer_id')->storedAs("data->'$.offer_id'")->nullable()->constrained('order_offers')->cascadeOnDelete();
            $table->foreignId('shop_id')->storedAs("data->'$.shop_id'")->nullable()->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('notifications');
    }
}
