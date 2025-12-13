<?php
// Script để chạy migration thủ công
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;

try {
    echo "Running migration...\n";
    Artisan::call('migrate', ['--force' => true]);
    echo "Migration completed!\n";
    echo Artisan::output();
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
?>

