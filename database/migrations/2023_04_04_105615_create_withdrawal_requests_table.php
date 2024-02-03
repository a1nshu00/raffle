<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('channel_id');
            $table->string('amount');
            $table->string('screenshot');
            $table->string('status');
            $table->string('fee');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('withdrawal_requests');
    }
}
