<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->double('rate')->default(0);
            $table->time('open_at')->nullable();
            $table->time('closed_at')->nullable();
            $table->string('except_days')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('address')->nullable();
            $table->integer('by_user')->nullable();
            $table->integer('is_active')->default(1);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('shop_translations', function(Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained('shops')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->unique(['shop_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
