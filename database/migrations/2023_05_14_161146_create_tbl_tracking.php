<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id');
            $table->string('tracking_code');
            $table->foreign('ship_id')->references('id')->on('tbl_ship');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_tracking');
    }
};
