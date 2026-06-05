<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('homework_requests')) return;
        Schema::create('homework_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('original_filename');
            $table->string('file_path', 500);
            $table->text('instructions');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->longText('homework_content')->nullable();
            $table->string('result_pdf_path', 500)->nullable();
            $table->string('result_docx_path', 500)->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homework_requests');
    }
};
