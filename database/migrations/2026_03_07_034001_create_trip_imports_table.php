<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_imports', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('status')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('nama_driver')->nullable();
            $table->string('layanan')->nullable();           // Paket Trip / Sewa Mobil
            $table->string('plat_mobil')->nullable();
            $table->string('jenis_mobil')->nullable();
            $table->boolean('drone')->default(false);
            $table->integer('jumlah_hari')->default(1);
            $table->integer('penumpang')->nullable();
            $table->string('hotel_1')->nullable();
            $table->string('hotel_2')->nullable();
            $table->string('hotel_3')->nullable();
            $table->string('hotel_4')->nullable();
            $table->decimal('harga', 15, 2)->default(0);
            $table->decimal('deposit', 15, 2)->default(0);
            $table->decimal('pelunasan', 15, 2)->default(0);
            $table->string('tiba')->nullable();
            $table->string('flight_balik')->nullable();
            $table->string('source_file')->nullable();       // nama file CSV yang diimport
            $table->integer('bulan')->nullable();            // 1-12
            $table->integer('tahun')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_imports');
    }
};
