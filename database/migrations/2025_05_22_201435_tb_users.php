<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tb_users', function (Blueprint $table) {
            $table->bigIncrements('id_usuario'); // Clave primaria
            $table->string('nombre', 255);
            $table->string('correo', 255)->unique();
            $table->string('password', 255);
            $table->integer('tipo_usuario');
            $table->string('foto_usuario')->nullable();
            $table->unsignedBigInteger('id_lugar')->nullable(); // Clave foránea
            $table->timestamps();

            // Clave foránea corregida
            $table->foreign('id_lugar')
                ->references('id_lugar')
                ->on('tb_lugares')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_users');
    }
};
