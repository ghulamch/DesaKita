<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'ghulaminchalimalwi170507@gmail.com';
$user = \App\Models\User::where('email', $email)->first();
if ($user) {
    $user->is_active = true;
    $user->activation_token = null;
    $user->save();
    echo "SUCCESS: User $email activated.";
} else {
    echo "ERROR: User $email not found.";
}
