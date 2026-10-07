<?php
$baseDir = 'C:/Users/WINDOWS 11/Downloads/hisabmittra/public';
$crmDir = $baseDir . '/crm';

$files = [];
function getFiles($dir, &$files) {
    if (!is_dir($dir)) return;
    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) getFiles($path, $files);
        elseif (preg_match('/\.html$/i', $item)) $files[] = $path;
    }
}
getFiles($crmDir, $files);

$missingRoutes = [];

foreach ($files as $file) {
    $content = file_get_contents($file);
    // Find all href and action attributes
    preg_match_all('/(?:href|action)=["\'](\/crm\/[^"\']+)["\']/i', $content, $matches);
    foreach ($matches[1] as $url) {
        $cleanUrl = strtok($url, '?');
        $cleanUrl = strtok($cleanUrl, '#');
        $cleanUrl = rtrim($cleanUrl, '/');

        // Check if file exists:
        // 1. $baseDir . $cleanUrl . '.html'
        // 2. $baseDir . $cleanUrl . '/index.html'
        // 3. $baseDir . $cleanUrl (as file)
        $f1 = $baseDir . $cleanUrl . '.html';
        $f2 = $baseDir . $cleanUrl . '/index.html';
        $f3 = $baseDir . $cleanUrl;

        if (!file_exists($f1) && !file_exists($f2) && !file_exists($f3)) {
            if (!isset($missingRoutes[$cleanUrl])) {
                $missingRoutes[$cleanUrl] = [];
            }
            $missingRoutes[$cleanUrl][] = str_replace($crmDir, '', $file);
        }
    }
}

echo "Found " . count($missingRoutes) . " unique broken internal routes:\n";
foreach ($missingRoutes as $route => $foundIn) {
    echo "BROKEN: $route (in " . count($foundIn) . " pages: e.g. " . $foundIn[0] . ")\n";
}
