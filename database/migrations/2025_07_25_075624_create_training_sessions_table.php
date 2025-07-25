<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->nullable()->constrained('users');
            $table->string('session_name');
            $table->longText('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location');
            $table->integer('max_capacity')->default(10);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->enum('session_type', ['group', 'private', 'competition'])->default('group');
            $table->enum('skill_level', ['beginner', 'intermediate', 'advanced', 'all'])->default('all');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index('start_time');
            $table->index('coach_id');
            $table->index(['start_time', 'end_time']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_sessions');
    }
};
