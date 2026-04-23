<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SetupController extends Controller
{
    public function index()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        // Ensure .env exists
        if (!File::exists(base_path('.env'))) {
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), base_path('.env'));
                Artisan::call('key:generate', ['--force' => true]);
            }
        }

        $requirements = [
            'PHP Version (>= 8.2)' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'BCMath Extension' => extension_loaded('bcmath'),
            'Ctype Extension' => extension_loaded('ctype'),
            'Fileinfo Extension' => extension_loaded('fileinfo'),
            'JSON Extension' => extension_loaded('json'),
            'Mbstring Extension' => extension_loaded('mbstring'),
            'OpenSSL Extension' => extension_loaded('openssl'),
            'PDO Extension' => extension_loaded('pdo'),
            'Tokenizer Extension' => extension_loaded('tokenizer'),
            'XML Extension' => extension_loaded('xml'),
            'CURL Extension' => extension_loaded('curl'),
        ];

        $permissions = [
            'storage/framework' => is_writable(storage_path('framework')),
            'storage/logs' => is_writable(storage_path('logs')),
            'bootstrap/cache' => is_writable(base_path('bootstrap/cache')),
            '.env file' => is_writable(base_path('.env')),
        ];

        $allRequirementsMet = !in_array(false, $requirements);
        $allPermissionsMet = !in_array(false, $permissions);

        return view('setup.step1', compact('requirements', 'permissions', 'allRequirementsMet', 'allPermissionsMet'));
    }

    public function step2()
    {
        return view('setup.step2');
    }

    public function configureDatabase(Request $request)
    {
        $request->validate([
            'db_connection' => 'required',
            'db_name' => 'required',
        ]);

        $envFile = base_path('.env');
        $envContent = File::get($envFile);

        $dbConnection = $request->db_connection;
        $dbHost = $request->db_host ?? '127.0.0.1';
        $dbPort = $request->db_port ?? ($dbConnection === 'pgsql' ? '5432' : '3306');
        $dbName = $request->db_name;
        $dbUser = $request->db_user ?? '';
        $dbPass = $request->db_pass ?? '';

        $replacements = [
            'DB_CONNECTION=' . env('DB_CONNECTION') => 'DB_CONNECTION=' . $dbConnection,
            'DB_HOST=' . env('DB_HOST') => 'DB_HOST=' . $dbHost,
            'DB_PORT=' . env('DB_PORT') => 'DB_PORT=' . $dbPort,
            'DB_DATABASE=' . env('DB_DATABASE') => 'DB_DATABASE=' . $dbName,
            'DB_USERNAME=' . env('DB_USERNAME') => 'DB_USERNAME=' . $dbUser,
            'DB_PASSWORD=' . env('DB_PASSWORD') => 'DB_PASSWORD=' . $dbPass,
        ];

        foreach ($replacements as $old => $new) {
            $envContent = str_replace($old, $new, $envContent);
        }

        File::put($envFile, $envContent);

        // Test connection
        try {
            config([
                "database.connections.{$dbConnection}.host" => $dbHost,
                "database.connections.{$dbConnection}.port" => $dbPort,
                "database.connections.{$dbConnection}.database" => $dbName,
                "database.connections.{$dbConnection}.username" => $dbUser,
                "database.connections.{$dbConnection}.password" => $dbPass,
                "database.default" => $dbConnection
            ]);
            DB::reconnect();
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi Gagal: ' . $e->getMessage());
        }

        return redirect()->route('setup.step3');
    }

    public function step3()
    {
        return view('setup.step3');
    }

    public function install(Request $request)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:8|confirmed',
        ]);

        try {
            // 1. Migrate
            Artisan::call('migrate:fresh', ['--force' => true]);

            // 2. Create Admin
            User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'role' => 'admin',
                'is_active' => true, // Admin from setup is always active
            ]);

            // 3. Set to Production Mode & Security Key
            $envFile = base_path('.env');
            if (File::exists($envFile)) {
                Artisan::call('key:generate', ['--force' => true]);
                $envContent = File::get($envFile);
                $envContent = str_replace('APP_ENV=local', 'APP_ENV=production', $envContent);
                $envContent = str_replace('APP_DEBUG=true', 'APP_DEBUG=false', $envContent);
                File::put($envFile, $envContent);
            }

            // 4. Link Storage & Optimize for Production
            Artisan::call('storage:link', ['--force' => true]);
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            // 5. Mark as installed
            File::put(storage_path('installed'), date('Y-m-d H:i:s'));

            return redirect()->route('setup.finished');
        } catch (\Exception $e) {
            return back()->with('error', 'Instalasi Gagal: ' . $e->getMessage());
        }
    }

    public function finished()
    {
        return view('setup.finished');
    }

    private function isInstalled()
    {
        return File::exists(storage_path('installed'));
    }
}
