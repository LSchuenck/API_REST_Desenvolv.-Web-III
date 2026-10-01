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
        Schema::create('livro', function (Blueprint $table) {
            $table->id('idlivro');
            $table->string('titulo', 255);
            $table->string('isbn', 45)->nullable();
            $table->integer('anopublicacao')->nullable();
            $table->string('descricao', 255)->nullable();
            $table->integer('paginas')->nullable();
            $table->foreignId('idautor')->constrained('autor', 'idautor');
            $table->foreignId('idcategoria')->constrained('categoria', 'idcategoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livro');
    }
};
