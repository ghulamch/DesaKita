<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Emergency .env restoration
        if (!file_exists(base_path('.env'))) {
            if (file_exists(base_path('.env.example'))) {
                $content = file_get_contents(base_path('.env.example'));
                // Change default session & cache to file to avoid DB driver errors before install
                $content = str_replace('SESSION_DRIVER=database', 'SESSION_DRIVER=file', $content);
                $content = str_replace('CACHE_STORE=database', 'CACHE_STORE=file', $content);
                $content = str_replace('DB_CONNECTION=sqlite', 'DB_CONNECTION=mysql', $content);
                
                file_put_contents(base_path('.env'), $content);
                
                // Run key:generate silently
                \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
            }
        }

        $isInstalled = file_exists(storage_path('installed'));
        $isSetupRoute = $request->is('setup*');

        if (!$isInstalled && !$isSetupRoute) {
            return redirect('/setup');
        }

        if ($isInstalled && $isSetupRoute && !$request->is('setup/finished')) {
            return redirect('/');
        }

        return $next($request);
    }
}
