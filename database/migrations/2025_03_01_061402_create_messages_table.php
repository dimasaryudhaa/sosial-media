<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pengirim pesan
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // Penerima pesan
            $table->text('message');
            $table->timestamps();
        });        
    }

    public function down() {
        Schema::dropIfExists('messages');
    }
};

