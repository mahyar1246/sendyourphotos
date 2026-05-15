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
    Schema::create('photos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID pemilik foto
        
        // --- DUA KOLOM INI YANG TADI KURANG ---
        $table->unsignedBigInteger('category_id')->nullable(); // Menyimpan ID kategori
        $table->string('file_path'); // Menyimpan lokasi file foto di server
        // --------------------------------------

        $table->string('title');
        $table->text('description');
        $table->decimal('price', 15, 2); // Harga (Rupiah bisa mencapai jutaan/miliaran)
        $table->string('file_original')->nullable();
        $table->string('file_watermark')->nullable();
        $table->string('status')->default('pending');
        $table->timestamps();
    });
}
};
