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
        Schema::create('islands', function (Blueprint $table) {
            $table->char('code', 9)->primary();
            $table->char('regency_code', 4)->nullable();
            $table->string('name');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('area', 12, 2)->nullable();
            $table->enum('is_outermost', ['ya', 'tidak'])->default('tidak');
            $table->enum('is_populated', ['ya', 'tidak'])->default('ya');
            $table->timestamps();

            $table->foreign('regency_code')->references('code')->on('regencies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('islands');
    }
};
