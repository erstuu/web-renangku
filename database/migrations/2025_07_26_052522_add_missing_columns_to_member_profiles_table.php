<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('member_profiles', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->after('date_of_birth');
            $table->string('emergency_contact_relationship')->nullable()->after('emergency_contact_phone');
            $table->text('medical_conditions')->nullable()->after('emergency_contact_relationship');
            $table->enum('swimming_experience', ['beginner', 'intermediate', 'advanced'])->nullable()->after('medical_conditions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_profiles', function (Blueprint $table) {
            $table->dropColumn(['gender', 'emergency_contact_relationship', 'medical_conditions', 'swimming_experience']);
        });
    }
};
