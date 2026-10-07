<?php
$dirs = [
    'C:/Users/WINDOWS 11/Downloads/hisabmittra/public/crm',
    'C:/Users/WINDOWS 11/Downloads/hisabmittra/public',
    'C:/Users/WINDOWS 11/Downloads/hisabmittra/resources/views'
];

$replacements = [
    'http://localhost/crm/' => '/crm/',
    'http://localhost/crm' => '/crm',
    'http://127.0.0.1:8000/crm/' => '/crm/',
    'http://127.0.0.1:8000/crm' => '/crm',
    'https://localhost/crm/' => '/crm/',
    'https://localhost/crm' => '/crm',
    'http://localhost/' => '/',
    'http://127.0.0.1:8000/' => '/',
    'http://localhost"' => '/"',
    'http://localhost\'' => '/\'',
    'http://127.0.0.1:8000"' => '/"',
    'http://127.0.0.1:8000\'' => '/\'',
];

$totalReplaced = 0;
$filesModified = 0;

function scanAndReplace($dir, $replacements, &$totalReplaced, &$filesModified) {
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            scanAndReplace($path, $replacements, $totalReplaced, $filesModified);
        } elseif (preg_match('/\.(html|php|js|json|css)$/i', $item)) {
            $content = file_get_contents($path);
            $newContent = $content;
            $changed = false;
            foreach ($replacements as $search => $replace) {
                if (strpos($newContent, $search) !== false) {
                    $count = 0;
                    $newContent = str_replace($search, $replace, $newContent, $count);
                    $totalReplaced += $count;
                    $changed = true;
                }
            }
            if ($changed) {
                file_put_contents($path, $newContent);
                $filesModified++;
            }
        }
    }
}

foreach ($dirs as $d) {
    scanAndReplace($d, $replacements, $totalReplaced, $filesModified);
}

echo "Done! Replaced $totalReplaced instances across $filesModified files.\n";
