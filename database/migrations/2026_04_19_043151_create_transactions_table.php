<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        
        // Siapa pembelinya? (Relasi ke tabel users)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Foto apa yang dibeli? (Relasi ke tabel photos)
        $table->foreignId('photo_id')->constrained()->onDelete('cascade');
        
        // Berapa harganya saat itu?
        $table->decimal('amount', 15, 2);
        
        // Status pembayaran (pending, success, failed)
        $table->string('payment_status')->default('pending');
        
        // Catatan waktu (kapan dibeli)
        $table->timestamps();
    });
}
};
