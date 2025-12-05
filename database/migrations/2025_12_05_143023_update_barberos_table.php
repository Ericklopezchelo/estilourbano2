<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barberos', function (Blueprint $table) {
            // Agregar las columnas de fecha si no existen
            if (!Schema::hasColumn('barberos', 'fecha_inicio_permiso')) {
                $table->date('fecha_inicio_permiso')->nullable()->after('estado');
            }
            if (!Schema::hasColumn('barberos', 'fecha_fin_permiso')) {
                $table->date('fecha_fin_permiso')->nullable()->after('fecha_inicio_permiso');
            }

            // Quitar la columna 'biografia' si existe
            if (Schema::hasColumn('barberos', 'biografia')) {
                $table->dropColumn('biografia');
            }
        });
    }

    public function down(): void
    {
        Schema::table('barberos', function (Blueprint $table) {
            // Eliminar las columnas de fecha
            if (Schema::hasColumn('barberos', 'fecha_inicio_permiso')) {
                $table->dropColumn('fecha_inicio_permiso');
            }
            if (Schema::hasColumn('barberos', 'fecha_fin_permiso')) {
                $table->dropColumn('fecha_fin_permiso');
            }

            // Volver a agregar 'biografia'
            if (!Schema::hasColumn('barberos', 'biografia')) {
                $table->text('biografia')->nullable()->after('especialidad');
            }
        });
    }
};
