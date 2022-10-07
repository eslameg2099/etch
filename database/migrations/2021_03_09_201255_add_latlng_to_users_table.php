<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatlngToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
        });
        /** @var \App\Models\Users\User $user */
        $user = \App\Models\Users\User::where('type', \App\Models\Users\User::Delegate)
            ->has('delegateLocations')
            ->latest()
            ->limit(1)
            ->first();
        if ($user) {
            $user->forceFill([
                'lat' => optional($user->delegateLocations()->latest()->first())->lat,
                'lng' => optional($user->delegateLocations()->latest()->first())->lng,
            ])->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['lat', 'lng']);
        });
    }
}
