<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ShowAuditLog extends Command
{
    protected $signature = 'audit:show {lines=50 : Cantidad de líneas a mostrar}';
    protected $description = 'Muestra el audit log de seguridad';

    public function handle()
    {
        $path = storage_path('logs/audit.log');

        if (!file_exists($path)) {
            $this->error('No hay audit log aún');
            return;
        }

        $lines = file($path);
        $lastLines = array_slice($lines, -$this->argument('lines'));

        $this->info('=== ÚLTIMAS ACCIONES DE SEGURIDAD ===');
        foreach ($lastLines as $line) {
            $this->line($line);
        }
    }
}