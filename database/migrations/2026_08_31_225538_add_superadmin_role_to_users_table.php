<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * MySQL no permite modificar un enum directamente con Schema::table(),
     * así que usamos SQL nativo para redefinir la columna.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'vendedor') NOT NULL DEFAULT 'vendedor'");
    }

    /**
     * Reverse the migrations.
     *
     * Ojo: si ya existen usuarios con role='superadmin' al hacer rollback,
     * esto fallará. Conviene reasignarlos a 'admin' antes de bajar la migración.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'vendedor') NOT NULL DEFAULT 'vendedor'");
    }
};
