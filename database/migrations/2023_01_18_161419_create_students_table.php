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
        Schema::create('students', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->unsignedBigInteger('father_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('first_name', 45);
            $table->double('score');
            $table->string('image', 255)->nullable();
            $table->tinyInteger('class');
            $table->tinyInteger('is_approved')->default(0);
            $table->foreign('father_id')->references('father_id')->on('fathers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
