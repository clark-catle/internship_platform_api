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
        Schema::table('internships', function (Blueprint $table) {
            $table->timestamp('admin_deleted_at')->nullable()->after('deleted_at');
            $table->foreignId('admin_deleted_by')->nullable()->after('admin_deleted_at')->constrained('users')->nullOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropForeign(['admin_deleted_by']);
            $table->dropColumn([
                'admin_deleted_at',
                'admin_deleted_by',
            ]);
        });
    }
};
