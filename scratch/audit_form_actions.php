<?php
$dir = 'C:/Users/WINDOWS 11/Downloads/hisabmittra/public/crm';
$actions = [];

function checkForms($dir, &$actions) {
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            checkForms($path, $actions);
        } elseif (preg_match('/\.html$/i', $item)) {
            $content = file_get_contents($path);
            if (preg_match_all('/<form\b[^>]*\baction=["\']([^"\']+)["\'][^>]*\bmethod=["\']([^"\']+)["\']/i', $content, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $m) {
                    $act = $m[1];
                    $method = strtoupper($m[2]);
                    $key = "$method $act";
                    if (!isset($actions[$key])) {
                        $actions[$key] = [];
                    }
                    $actions[$key][] = str_replace('C:/Users/WINDOWS 11/Downloads/hisabmittra/public/crm', '', $path);
                }
            }
        }
    }
}

checkForms($dir, $actions);
foreach ($actions as $act => $files) {
    echo "$act (found in " . count($files) . " files)\n";
}
