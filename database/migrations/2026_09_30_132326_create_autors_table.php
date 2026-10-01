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
        Schema::create('autor', function (Blueprint $table) {
            $table->id('idautor');
            $table->string('nome', 45);
            $table->string('nacionalidade', 45)->nullable();
            $table->date('nascimento')->nullable();
            $table->text('biografia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autor');
    }
};
