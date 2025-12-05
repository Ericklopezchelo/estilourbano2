<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Usamos Schema::table para modificar una tabla existente.
        Schema::table('barberos', function (Blueprint $table) {
            // Esto previene el error: si la columna 'estado' ya existe (porque la agregaste manual), Laravel la ignorará.
            if (!Schema::hasColumn('barberos', 'estado')) { 
                $table->string('estado')->default('activo')->after('biografia');
            }
        });
    }

    public function down(): void
    {
        Schema::table('barberos', function (Blueprint $table) {
            if (Schema::hasColumn('barberos', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};