<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('channel_type');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('e_wallet_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('IFSC_code')->nullable();
            $table->decimal('min_amount')->nullable();
            $table->decimal('fee')->nullable();
            $table->string('fee_type')->nullable();
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
        Schema::dropIfExists('deposit_channels');
    }
}
