<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('session_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('registered_at')->useCurrent();
            $table->enum('attendance_status', ['registered', 'attended', 'absent', 'cancelled'])->default('registered');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Prevent duplicate registrations
            $table->unique(['training_session_id', 'user_id']);

            // Indexes
            $table->index('training_session_id');
            $table->index('user_id');
            $table->index('attendance_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('session_registrations');
    }
};
