<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuditLog
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log de acciones críticas
        if ($this->isCriticalAction($request)) {
            $user = Auth::user();
            
            Log::channel('audit')->info('Acción crítica detectada', [
                'user_id' => $user ? $user->id : null,
                'user_email' => $user ? $user->email : 'anonimo',
                'action' => $request->method() . ' ' . $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'status_code' => $response->status(),
                'data' => $this->sanitizeData($request->except('password', '_token', 'password_confirmation')),
            ]);
        }

        return $response;
    }

    private function isCriticalAction($request)
    {
        $criticalPaths = [
            'admin/team',      // gestión de usuarios
            'admin/products',  // gestión de productos
            'login',           // intentos de login
            'register',        // registros nuevos
            'password',        // cambios de contraseña
            'logout',          // logout
        ];

        foreach ($criticalPaths as $path) {
            if (str_contains($request->path(), $path)) {
                return true;
            }
        }
        return false;
    }

    private function sanitizeData($data)
    {
        // Limita el tamaño para no guardar demasiados datos
        $json = json_encode($data);
        if (strlen($json) > 500) {
            return array_slice($data, 0, 3); // Solo primeros 3 campos
        }
        return $data;
    }
}