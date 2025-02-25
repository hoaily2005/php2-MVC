<?php
function loadEnv($filePath = '.env')
{
    if (!file_exists($filePath)) {
        throw new Exception("File .env không tồn tại tại đường dẫn: $filePath");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Bỏ qua comment
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}