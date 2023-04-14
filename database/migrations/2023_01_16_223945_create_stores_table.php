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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->integer('average_star')->length(5)->nullable($value=true);
            $table->string('store_address');
            $table->timeTz('start_time', $precision=0)->nullable($value=true);
            $table->timeTz('end_time', $precision=0)->nullable($value=true);
            $table->string('regular_holiday', 5);
            $table->string('store_phone');
            $table->integer('genre_id');
            $table->integer('lunchprice_min')->length(10)->nullable($value=true);
            $table->integer('lunchprice_max')->length(10)->nullable($value=true);
            $table->integer('dinnerprice_min')->length(10)->nullable($value=true);
            $table->integer('dinnerprice_max')->length(10)->nullable($value=true);
            $table->string('access');
            $table->string('description_about');
            $table->text('description_detail');
            $table->string('cash_way');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('stores');
    }
};
