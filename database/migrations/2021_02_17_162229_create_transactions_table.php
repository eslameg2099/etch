<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('checkout_id')->index();
            $table->string('transaction_identifier');
            $table->decimal('amount');
            $table->string('payment_type');
            $table->string('status');
            $table->timestamps();
        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->comment('Any transaction carrying the parent_id value is just for details and not charged')
                ->constrained('transactions')
                ->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('identifier');
            $table->foreignId('checkout_id')->nullable()->constrained('checkouts')->nullOnDelete();
            $table->decimal('amount');
            $table->string('status'); // hold | balance
            $table->string('type');
            $table->text('notes')->nullable();
            $table->timestamp('date');
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('account_name')->nullable()->comment('In Withdrawal Case');
            $table->string('bank_name')->nullable()->comment('In Withdrawal Case');
            $table->string('account_number')->nullable()->comment('In Withdrawal Case');
            $table->string('iban_number')->nullable()->comment('In Withdrawal Case');
            $table->timestamps();
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('transaction_id')->after('shop_id')->storedAs("data->'$.transaction_id'")->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
