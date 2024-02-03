<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRafflePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffle_prizes', function (Blueprint $table) {
            $table->id();
            $table->integer('raffle_id');
            $table->string('prize_name')->nullable();
            $table->string('physical_prize_image')->nullable();
            $table->decimal('cash_prize', 50,2)->nullable();
            $table->string('physical_prize')->nullable();
            $table->decimal('admin_fee', 50,2)->default(0);
            $table->string('prize_type')->nullable();
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
        Schema::dropIfExists('raffle_prizes');
    }
}
