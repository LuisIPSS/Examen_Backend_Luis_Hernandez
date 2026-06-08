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
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('nombre_comercial')->after('id');
            $table->string('rut')->unique()->after('nombre_comercial');
            $table->string('direccion')->after('rut');
            $table->string('categoria')->after('direccion');
            $table->string('contacto')->after('categoria');
            $table->unsignedInteger('procentaje_oferta')->after('contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropUnique(['rut']);
            $table->dropColumn([
                'nombre_comercial',
                'rut',
                'direccion',
                'categoria',
                'contacto',
                'procentaje_oferta',
            ]);
        });
    }
};

