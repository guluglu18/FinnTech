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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('fund_category_id');
            $table->unsignedBigInteger('fund_sub_category_id');
            $table->string('ISIN', 12)->unique();
            $table->string('WKN', 6)->unique();
            $table->timestamps();


            $table->foreign('fund_category_id')->references('id')->on('fund_categories')->cascadeOnDelete();
            $table->foreign('fund_sub_category_id')->references('id')->on('fund_sub_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funds');
    }
};
