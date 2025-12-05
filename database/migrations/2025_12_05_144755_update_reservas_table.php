<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            // Agregar hora_fin si no existe
            if (!Schema::hasColumn('reservas', 'hora_fin')) {
                $table->time('hora_fin')->nullable()->after('hora_reserva');
            }

            // Agregar servicio_id si no existe
            if (!Schema::hasColumn('reservas', 'servicio_id')) {
                $table->foreignId('servicio_id')
                      ->constrained('servicios')
                      ->onDelete('cascade')
                      ->onUpdate('cascade')
                      ->after('duracion');
            }

            // Agregar precio si no existe
            if (!Schema::hasColumn('reservas', 'precio')) {
                $table->integer('precio')->nullable()->after('servicio_id');
            }

            // Quitar tipo_servicio si existe
            if (Schema::hasColumn('reservas', 'tipo_servicio')) {
                $table->dropColumn('tipo_servicio');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            // Revertir los cambios
            if (Schema::hasColumn('reservas', 'hora_fin')) {
                $table->dropColumn('hora_fin');
            }

            if (Schema::hasColumn('reservas', 'servicio_id')) {
                $table->dropForeign(['servicio_id']); // quitar la FK primero
                $table->dropColumn('servicio_id');
            }

            if (Schema::hasColumn('reservas', 'precio')) {
                $table->dropColumn('precio');
            }

            // Volver a agregar tipo_servicio
            if (!Schema::hasColumn('reservas', 'tipo_servicio')) {
                $table->string('tipo_servicio')->after('duracion');
            }
        });
    }
};
