<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Saya sarankan rename tabelnya jadi player_transfer_histories agar lebih relevan
        Schema::create('player_transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Menggunakan string biasa, bukan ID relasi
            $table->string('from_team')->nullable(); // cth: "EVOS", "Elite"
            $table->string('to_team')->nullable();   // cth: "Luxury Elite", "HVFN"

            // Bisa tambahkan tipe transfer (in/out/internal)
            $table->enum('transfer_type', ['in', 'out', 'internal'])->default('in');

            $table->text('notes')->nullable(); // cth: "Buyout clause activated"
            $table->foreignId('recorded_by')->nullable()->constrained('users'); // Admin yg nyatet
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_transfer_histories');
    }
};
