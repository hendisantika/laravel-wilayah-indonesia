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
        Schema::create('villages', function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->char('district_code', 6);
            $table->string('name');
            $table->enum('type', ['desa', 'kelurahan'])->default('desa');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('area', 12, 2)->nullable();
            $table->bigInteger('population')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->timestamps();

            $table->foreign('district_code')->references('code')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
