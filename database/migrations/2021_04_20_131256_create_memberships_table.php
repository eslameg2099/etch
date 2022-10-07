<?php

use App\Models\Membership;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('rates_count');
            $table->timestamps();
            $table->softDeletes();
        });
        /** @var Membership $membership */
        $membership = Membership::forceCreate([
            'name' => 'برونزية',
            'rates_count' => 10,
        ]);

        $membership->addMedia(public_path('assets/images/01.png'))->preservingOriginal()->toMediaCollection();

        $membership = Membership::forceCreate([
            'name' => 'فضية',
            'rates_count' => 20,
        ]);
        $membership->addMedia(public_path('assets/images/02.png'))->preservingOriginal()->toMediaCollection();

        $membership = Membership::forceCreate([
            'name' => 'ذهبية',
            'rates_count' => 50,
        ]);

        $membership->addMedia(public_path('assets/images/03.png'))->preservingOriginal()->toMediaCollection();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memberships');
    }
}
