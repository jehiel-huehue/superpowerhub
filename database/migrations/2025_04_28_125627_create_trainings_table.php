<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('superpower_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('level')->default(1); // Current level of training

            $table->integer('max_level')->default(10); // Maximum achievable level
            $table->integer('trainings_per_day')->default(1); // How many times can train per day

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}
