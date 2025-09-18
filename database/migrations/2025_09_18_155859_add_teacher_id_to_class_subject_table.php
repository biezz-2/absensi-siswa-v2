<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_subject', function (Blueprint $table) {
            $table->foreignId('teacher_id')->after('subject_id')->constrained('teachers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('class_subject', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }
};