<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWithdrawalMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_withdrawal_methods', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('method_id');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('bank_name')->nullable();
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
        Schema::dropIfExists('user_withdrawal_methods');
    }
}
