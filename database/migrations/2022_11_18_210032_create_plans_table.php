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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->string('monthly_price')->nullable();
            $table->string('yearly_price')->nullable();
            $table->boolean('is_support')->default(false);
            $table->integer('no_of_words')->default(0);
            $table->integer('usecase_daily_limit')->default(0);
            $table->timestamps();
        });

        Schema::create('plan_translations', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('locale')->index();
            $table->unsignedBigInteger('plan_id');
            $table->string('name', 100)->index('name');
            $table->mediumText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
        Schema::dropIfExists('plan_transalations');
    }
};
