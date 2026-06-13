<?php
// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = env('GEMINI_API_KEY');
$model = "gemini-1.5-flash";
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$response = Http::post($url, [
    'contents' => [
        ['role' => 'user', 'parts' => [['text' => 'Hello, reply with one word: Hello!']]]
    ]
]);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
