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
            $table->string('school');
            $table->string('region');
            $table->string('city');
            $table->string('cellphone_number');
            $table->foreignId('avatar_id')->nullable()->constrained('files');
            $table->foreignId('resume_id')->nullable()->constrained('files');
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
