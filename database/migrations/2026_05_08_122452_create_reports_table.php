<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Report\ReportStatusEnum;
use App\Models\User;
use App\Models\Student;
use App\Models\Company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('status')->default(ReportStatusEnum::Pending->value);
            $table->string('admin_notes')->nullable();
            $table->foreignId('reporter_user_id')->constrained('users');
            $table->morphs('reportable');
            $table->datetime('read_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
