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
        Schema::table('camisetas', function (Blueprint $table) {
            $table->string('titulo')->after('id');
            $table->string('club')->after('titulo');
            $table->string('pais')->after('club');
            $table->string('tipo')->after('pais');
            $table->string('color')->after('tipo');
            $table->decimal('precio', 10, 2)->after('color');
            $table->json('tallas_disponibles')->after('precio');
            $table->text('detalles')->nullable()->after('tallas_disponibles');
            $table->string('sku')->nullable()->unique()->after('detalles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camisetas', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn([
                'titulo',
                'club',
                'pais',
                'tipo',
                'color',
                'precio',
                'tallas_disponibles',
                'detalles',
                'sku',
            ]);
        });
    }
};

