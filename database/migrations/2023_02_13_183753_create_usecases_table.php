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
        Schema::create('usecases', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->integer('order')->nullable();
            $table->string('color')->nullable();
            $table->longText('command')->nullable();
            $table->text('fields')->nullable();
            $table->boolean('icon')->nullable();
            $table->string('icon_type')->default('class');
            $table->string('icon_class')->nullable();
            $table->timestamps();
        });

        Schema::create('usecase_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->index();
            $table->unsignedBigInteger('usecase_id');
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
        Schema::dropIfExists('usecases');
        Schema::dropIfExists('usecase_translations');
    }
};
