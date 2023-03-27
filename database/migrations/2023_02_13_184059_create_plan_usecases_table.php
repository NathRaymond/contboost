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
        Schema::create('caseables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usecase_id');
            $table->morphs('caseable');
            $table->foreign('usecase_id')->references('id')->on('usecases')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caseables');
    }
};
