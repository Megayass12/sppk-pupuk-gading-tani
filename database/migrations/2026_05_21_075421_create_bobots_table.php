<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bobots', function (Blueprint $table) {
            $table->id();
            $table->string('kriteria');         // nama kriteria
            $table->string('kode');             // kode unik, misal: C1, C2...
            $table->enum('tipe', ['benefit', 'cost']); // jenis kriteria
            $table->decimal('bobot', 5, 2);     // nilai bobot (total harus = 1)
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bobots');
    }
};
