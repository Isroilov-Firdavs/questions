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
        Schema::create('user_answers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('test_session_id');
        $table->unsignedBigInteger('question_id');
        $table->string('selected_option'); // 'a', 'b', 'c', 'd'
        $table->boolean('is_correct');
        $table->timestamps();

        $table->foreign('test_session_id')->references('id')->on('test_sessions')->onDelete('cascade');
        $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        $table->unique(['test_session_id', 'question_id']); // bitta savolga 1 ta javob
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
