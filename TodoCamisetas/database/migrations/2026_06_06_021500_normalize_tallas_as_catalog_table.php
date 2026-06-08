<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('tallas', 'camiseta_id')) {
            // Move existing talla-to-camiseta links into the pivot table.
            DB::statement("
                INSERT IGNORE INTO camiseta_tallas (camiseta_id, talla_id, stock, created_at, updated_at)
                SELECT camiseta_id, id, 0, COALESCE(created_at, NOW()), COALESCE(updated_at, NOW())
                FROM tallas
            ");

            // Point pivot rows to the canonical talla id (first id per talla name).
            DB::statement("
                UPDATE camiseta_tallas ct
                INNER JOIN tallas t ON ct.talla_id = t.id
                INNER JOIN (
                    SELECT talla, MIN(id) AS keep_id
                    FROM tallas
                    GROUP BY talla
                ) canonical ON canonical.talla = t.talla
                SET ct.talla_id = canonical.keep_id
            ");

            // Remove duplicated talla names from catalog.
            DB::statement("
                DELETE t1
                FROM tallas t1
                INNER JOIN tallas t2
                    ON t1.talla = t2.talla
                   AND t1.id > t2.id
            ");

            $foreignKey = DB::selectOne("
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'tallas'
                  AND CONSTRAINT_TYPE = 'FOREIGN KEY'
                  AND CONSTRAINT_NAME = 'tallas_camiseta_id_foreign'
            ");

            if ($foreignKey) {
                DB::statement("ALTER TABLE tallas DROP FOREIGN KEY tallas_camiseta_id_foreign");
            }

            $compositeIndex = DB::selectOne("
                SELECT INDEX_NAME
                FROM information_schema.STATISTICS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'tallas'
                  AND INDEX_NAME = 'tallas_camiseta_id_talla_unique'
                LIMIT 1
            ");

            if ($compositeIndex) {
                DB::statement("ALTER TABLE tallas DROP INDEX tallas_camiseta_id_talla_unique");
            }

            Schema::table('tallas', function (Blueprint $table) {
                $table->dropColumn('camiseta_id');
            });
        }

        $uniqueTallaIndex = DB::selectOne("
            SELECT INDEX_NAME
            FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'tallas'
              AND INDEX_NAME = 'tallas_talla_unique'
            LIMIT 1
        ");

        if (! $uniqueTallaIndex) {
            Schema::table('tallas', function (Blueprint $table) {
                $table->unique('talla');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tallas', function (Blueprint $table) {
            $table->dropUnique(['talla']);
            $table->foreignId('camiseta_id')->nullable()->after('id')->constrained('camisetas')->cascadeOnDelete();
            $table->unique(['camiseta_id', 'talla']);
        });
    }
};

