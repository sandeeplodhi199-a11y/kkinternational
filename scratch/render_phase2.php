<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$consoleKernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$consoleKernel->bootstrap();

auth()->loginUsingId(1);
$outBase = 'C:/Users/WINDOWS 11/Downloads/hisabmittra/public';

function saveRouteHtml($routePath, $html, $outBase) {
    // Replace hardcoded localhost
    $html = str_replace('http://localhost/crm/', '/crm/', $html);
    $html = str_replace('http://localhost/crm', '/crm', $html);
    $html = str_replace('http://127.0.0.1:8000/crm/', '/crm/', $html);
    $html = str_replace('http://127.0.0.1:8000/crm', '/crm', $html);
    $html = str_replace('http://localhost/', '/', $html);
    $html = str_replace('http://localhost"', '/"', $html);
    $html = str_replace('http://localhost\'', '/\'', $html);
    
    if (strpos($html, 'crm-leads-store.js') === false && strpos($html, '</body>') !== false) {
        $html = str_replace('</body>', "    <script src=\"/crm/js/crm-leads-store.js\"></script>\n</body>", $html);
    }

    $filePathHtml = $outBase . $routePath . '.html';
    $dirIndex = $outBase . $routePath . '/index.html';

    @mkdir(dirname($filePathHtml), 0777, true);
    @mkdir(dirname($dirIndex), 0777, true);

    file_put_contents($filePathHtml, $html);
    file_put_contents($dirIndex, $html);
    echo "Saved: $routePath (" . strlen($html) . " bytes)\n";
}

function makeRedirectHtml($target) {
    return "<!DOCTYPE html><html><head><meta http-equiv=\"refresh\" content=\"0;url={$target}\"><script>window.location.replace('{$target}');</script></head><body><p>Redirecting to <a href=\"{$target}\">{$target}</a>...</p></body></html>";
}

// 1. Quotations create
try {
    $c = new App\Http\Controllers\Crm\Admin\CrmQuotationController();
    $res = $c->create();
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/quotations/create', $res->render(), $outBase);
    }
} catch (Exception $e) { echo "Quote create: " . $e->getMessage() . "\n"; }

// 2. Employee Notifications & Performance
if (file_exists($outBase . '/crm/admin/notifications.html')) {
    $notifContent = file_get_contents($outBase . '/crm/admin/notifications.html');
    saveRouteHtml('/crm/employee/notifications', $notifContent, $outBase);
}
if (file_exists($outBase . '/crm/admin/performance.html')) {
    $perfContent = file_get_contents($outBase . '/crm/admin/performance.html');
    saveRouteHtml('/crm/employee/performance', $perfContent, $outBase);
}

// 3. Lead 29
saveRouteHtml('/crm/admin/leads/29', makeRedirectHtml('/crm/admin/leads'), $outBase);
saveRouteHtml('/crm/admin/leads/28/assign', makeRedirectHtml('/crm/admin/leads/28'), $outBase);
saveRouteHtml('/crm/admin/leads/39/assign', makeRedirectHtml('/crm/admin/leads/39'), $outBase);

// 4. Demo status
saveRouteHtml('/crm/admin/demos/2/status', makeRedirectHtml('/crm/admin/demos'), $outBase);

// 5. Reports export
saveRouteHtml('/crm/admin/reports/export', makeRedirectHtml('/crm/admin/reports'), $outBase);

// 6. Notification actions & individual IDs
saveRouteHtml('/crm/admin/notifications/sync', makeRedirectHtml('/crm/admin/notifications'), $outBase);
saveRouteHtml('/crm/admin/notifications/mark-read', makeRedirectHtml('/crm/admin/notifications'), $outBase);
saveRouteHtml('/crm/admin/notifications/clear-all', makeRedirectHtml('/crm/admin/notifications'), $outBase);

for ($i = 1; $i <= 30; $i++) {
    saveRouteHtml('/crm/admin/notifications/' . $i, makeRedirectHtml('/crm/admin/notifications'), $outBase);
}

// 7. Super admin actions
saveRouteHtml('/crm/admin/super/approvals/4/approve', makeRedirectHtml('/crm/admin/super/approvals'), $outBase);
saveRouteHtml('/crm/admin/super/rbac/4', makeRedirectHtml('/crm/admin/super/rbac'), $outBase);
saveRouteHtml('/crm/admin/super/recycle-bin/lead/29/restore', makeRedirectHtml('/crm/admin/super/recycle-bin'), $outBase);
saveRouteHtml('/crm/admin/super/recycle-bin/lead/29/force', makeRedirectHtml('/crm/admin/super/recycle-bin'), $outBase);
saveRouteHtml('/crm/admin/super/recycle-bin/employee/10/restore', makeRedirectHtml('/crm/admin/super/recycle-bin'), $outBase);
saveRouteHtml('/crm/admin/super/recycle-bin/employee/10/force', makeRedirectHtml('/crm/admin/super/recycle-bin'), $outBase);
saveRouteHtml('/crm/admin/super/security/session/5/revoke', makeRedirectHtml('/crm/admin/super/security'), $outBase);

echo "Phase 2 rendering complete!\n";
