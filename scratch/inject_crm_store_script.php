<?php
$dirs = [
    'C:/Users/WINDOWS 11/Downloads/hisabmittra/public/crm'
];

$scriptTag = '<script src="/crm/js/crm-leads-store.js"></script>';
$modifiedCount = 0;

function injectScript($dir, $scriptTag, &$modifiedCount) {
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            injectScript($path, $scriptTag, $modifiedCount);
        } elseif (preg_match('/\.html$/i', $item)) {
            $content = file_get_contents($path);
            if (strpos($content, 'crm-leads-store.js') === false && strpos($content, '</body>') !== false) {
                $newContent = str_replace('</body>', "    $scriptTag\n</body>", $content);
                file_put_contents($path, $newContent);
                $modifiedCount++;
            }
        }
    }
}

foreach ($dirs as $d) {
    injectScript($d, $scriptTag, $modifiedCount);
}

echo "Injected crm-leads-store.js into $modifiedCount HTML files!\n";
