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
        Schema::create('tbl_food', function (Blueprint $table) {
            $table->Increments('food_id');
            $table->integer('category_id');
            $table->text('food_name');
            $table->text('food_desc');
            $table->text('food_content');
            $table->string('food_price');
            $table->string('food_img');
            $table->integer('food_status');
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
        Schema::dropIfExists('tbl_food');
    }
};
