<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void {
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('output_kode', 10);   
            $table->timestamps();
        });
 
        // Pivot: rule memiliki banyak gejala
        Schema::create('rule_gejala', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_id')->constrained('rules')->onDelete('cascade');
            $table->string('gejala_kode', 10);
            $table->boolean('is_negasi')->default(false); 
        });
    }
 
    public function down(): void {
        Schema::dropIfExists('rule_gejala');
        Schema::dropIfExists('rules');
    }
};