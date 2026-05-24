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
        Schema::create('penilaian_suppliers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supplier_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('kriteria_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('nilai', 8, 4);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_suppliers');
    }
};
