<?php
// Quick check script
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

// Check owners
$owners = DB::table('users')->where('role', 'owner')->get();

echo "=== OWNER USERS IN DATABASE ===\n";
echo "Total owners: " . count($owners) . "\n\n";

if(count($owners) > 0) {
    foreach($owners as $owner) {
        echo "ID: {$owner->id}, Name: {$owner->name}, Email: {$owner->email}, Role: {$owner->role}\n";
    }
} else {
    echo "NO OWNERS FOUND IN DATABASE!\n";
    echo "Creating test owner...\n";
    
    // Insert test owner
    $id = DB::table('users')->insertGetId([
        'name' => 'Test Owner',
        'email' => 'owner@test.com',
        'password' => bcrypt('password'),
        'phone' => '08123456789',
        'role' => 'owner',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    echo "Test owner created with ID: $id\n";
    echo "Try accessing: http://127.0.0.1:8000/owner/$id\n";
}

// Check all users
echo "\n=== ALL USERS IN DATABASE ===\n";
$allUsers = DB::table('users')->get();
foreach($allUsers as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Role: {$user->role}\n";
}
?>
