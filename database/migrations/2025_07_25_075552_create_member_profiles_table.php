<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 15)->nullable();
            $table->enum('membership_status', ['active', 'inactive', 'suspended', 'pending'])->default('pending');
            $table->date('joined_at')->nullable();
            $table->text('medical_notes')->nullable();
            $table->timestamps();
            
            $table->index('membership_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_profiles');
    }
};