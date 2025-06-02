<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tb_materiales', function (Blueprint $table) {
            $table->bigIncrements('id_material'); // Clave primaria
            $table->string('clave_material')->unique();
            $table->text('descripcion');
            $table->string('generico')->nullable();
            $table->string('clasificacion')->nullable();
            $table->integer('existencia')->default(0);
            $table->decimal('costo_promedio', 10, 2);
            $table->unsignedBigInteger('id_lugar')->nullable(); // Clave foránea corregida
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
        Schema::dropIfExists('tb_materiales');
    }
};
