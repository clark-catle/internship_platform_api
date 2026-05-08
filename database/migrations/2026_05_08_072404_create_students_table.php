<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Course;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('profile_picture_path');
            $table->string('school');
            $table->string('region');
            $table->string('city');
            $table->string('resume_path')->nullable();
            $table->string('cellphone_number');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Course::class)->nullable()->constrained();
            $table->string('course_other')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
