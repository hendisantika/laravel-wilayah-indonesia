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
        Schema::create('regencies', function (Blueprint $table) {
            $table->char('code', 4)->primary();
            $table->char('province_code', 2);
            $table->string('name');
            $table->enum('type', ['kabupaten', 'kota'])->default('kabupaten');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('elevation', 8, 2)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->decimal('area', 12, 2)->nullable();
            $table->bigInteger('population')->nullable();
            $table->text('boundaries')->nullable();
            $table->timestamps();

            $table->foreign('province_code')->references('code')->on('provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regencies');
    }
};
