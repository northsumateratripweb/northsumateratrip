<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('bulan')->default('Januari')->comment('Nama bulan / sheet');
            $table->date('tanggal')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->string('nomor_hp')->nullable();
            $table->string('nama_driver')->nullable();
            $table->string('layanan')->nullable();
            $table->string('plat_mobil')->nullable();
            $table->string('jenis_mobil')->nullable();
            $table->boolean('drone')->default(false);
            $table->unsignedTinyInteger('jumlah_hari')->nullable();
            $table->string('penumpang')->nullable();
            $table->string('hotel_1')->nullable();
            $table->string('hotel_2')->nullable();
            $table->string('hotel_3')->nullable();
            $table->string('hotel_4')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('deposit')->nullable();
            $table->bigInteger('pelunasan')->nullable();
            $table->string('tiba')->nullable();
            $table->string('flight_balik')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
