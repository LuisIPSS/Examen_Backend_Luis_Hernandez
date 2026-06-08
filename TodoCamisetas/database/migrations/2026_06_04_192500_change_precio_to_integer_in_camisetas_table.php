<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('UPDATE camisetas SET precio = ROUND(precio)');
        DB::statement('ALTER TABLE camisetas MODIFY precio INT UNSIGNED NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE camisetas MODIFY precio DECIMAL(10,2) NOT NULL');
    }
};

