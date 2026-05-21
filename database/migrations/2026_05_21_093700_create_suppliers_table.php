<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_supplier')->unique();
            $table->string('nama_supplier');
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            // Kriteria SAW
            $table->decimal('harga', 10, 2)->default(0);        // cost: makin rendah makin baik
            $table->decimal('kualitas', 5, 2)->default(0);      // benefit: makin tinggi makin baik (skala 1-10)
            $table->integer('ketepatan_waktu')->default(0);      // benefit: % ketepatan (0-100)
            $table->integer('kapasitas')->default(0);            // benefit: ton/bulan
            $table->decimal('jarak', 8, 2)->default(0);         // cost: km (makin dekat makin baik)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
