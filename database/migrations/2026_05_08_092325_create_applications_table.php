<?php

use App\Enum\Application\ApplicationProgressEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Application\ApplicationStatusEnum;
use App\Models\Student;
use App\Models\Internship;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(ApplicationStatusEnum::Pending->value);
            $table->string('progress')->default(ApplicationProgressEnum::Applied->value);
            $table->datetime('applied_at');
            $table->foreignId('resume_id')->nullable()->constrained('files');
            $table->foreignIdFor(Student::class)->constrained();
            $table->foreignIdFor(Internship::class)->constrained();
            $table->unique(['student_id', 'internship_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
