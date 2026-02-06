<?php
require_once 'bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$homestays = \App\Models\Homestay::limit(10)->get();

echo "=== HOMESTAY DEBUG ===\n\n";

foreach ($homestays as $h) {
    echo "ID: {$h->id}\n";
    echo "Name: {$h->name}\n";
    echo "image_url: {$h->image_url}\n";

    if ($h->image_url) {
        $full_path = "storage/app/public/{$h->image_url}";
        $file_exists = file_exists($full_path);
        echo "File exists: " . ($file_exists ? 'YES' : 'NO') . "\n";
        echo "Full path: {$full_path}\n";
        echo "URL would be: /storage/{$h->image_url}\n";
    } else {
        echo "No image_url in database\n";
    }

    echo "---\n";
}
?>