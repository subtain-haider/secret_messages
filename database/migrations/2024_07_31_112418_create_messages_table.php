<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('recipient_id')->constrained('users')->onDelete('cascade');
            $table->longText('text');
            $table->enum('status', ['pending', 'read', 'expired'])->default('pending');
            $table->timestamp('read_at')->nullable(); // Tracks when the message is first read
            $table->timestamp('expires_at')->nullable(); // Tracks expiration time
            $table->softDeletes(); // Implements soft delete
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('messages');
    }
};
