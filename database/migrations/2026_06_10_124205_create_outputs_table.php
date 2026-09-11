<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void {
        Schema::create('output_stres', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); 
            $table->string('tingkat');            
            $table->text('deskripsi');
            $table->text('rekomendasi');
            $table->string('warna', 20)->default('#6c757d');
            $table->timestamps();
        });
    }
 
    public function down(): void {
        Schema::dropIfExists('output_stres');
    }
};