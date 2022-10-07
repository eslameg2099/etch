<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('national_id');
            $table->string('national_id_front_image')->nullable();
            $table->string('national_id_back_image')->nullable();
            $table->string('vehicle_type');
            $table->string('vehicle_model');
            $table->string('vehicle_number');
            $table->string('vehicle_number_image')->nullable();
            $table->integer('is_available')->default(1);
            $table->integer('is_approved')->default(0);
            $table->integer('can_receive_cash_orders')->default(0);
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
        Schema::dropIfExists('delegates');
    }
}
