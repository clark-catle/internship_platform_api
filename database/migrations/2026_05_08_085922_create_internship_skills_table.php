<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Internship;
use App\Models\Skill;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('internship_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Internship::class)->constrained();
            $table->foreignIdFor(Skill::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_skills');
    }
};
