<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$consoleKernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$consoleKernel->bootstrap();

auth()->loginUsingId(1);

$outBase = 'C:/Users/WINDOWS 11/Downloads/hisabmittra/public';

function saveRouteHtml($routePath, $html, $outBase) {
    global $outBase;
    // Replace hardcoded localhost
    $html = str_replace('http://localhost/crm/', '/crm/', $html);
    $html = str_replace('http://localhost/crm', '/crm', $html);
    $html = str_replace('http://127.0.0.1:8000/crm/', '/crm/', $html);
    $html = str_replace('http://127.0.0.1:8000/crm', '/crm', $html);
    $html = str_replace('http://localhost/', '/', $html);
    $html = str_replace('http://localhost"', '/"', $html);
    $html = str_replace('http://localhost\'', '/\'', $html);
    
    // Inject crm-leads-store.js if not present
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

// 1. Leads Kanban
try {
    $c = new App\Http\Controllers\Crm\Admin\CrmLeadController();
    $res = $c->kanban();
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/leads/kanban', $res->render(), $outBase);
    }
} catch (Exception $e) { echo "Kanban error: " . $e->getMessage() . "\n"; }

// 2. Billing Calculator
try {
    $c = new App\Http\Controllers\Crm\Admin\CrmQuotationController();
    $res = $c->billingCalculator();
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/tools/billing-calculator', $res->render(), $outBase);
    }
} catch (Exception $e) { echo "Billing Calc error: " . $e->getMessage() . "\n"; }

// 3. Targets
try {
    $c = new App\Http\Controllers\Crm\Admin\CrmTeamController();
    $res = $c->targets(new Illuminate\Http\Request());
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/targets', $res->render(), $outBase);
    }
} catch (Exception $e) { echo "Targets error: " . $e->getMessage() . "\n"; }

// 4. Performance
try {
    $c = new App\Http\Controllers\Crm\Admin\CrmTeamController();
    $res = $c->performance(new Illuminate\Http\Request());
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/performance', $res->render(), $outBase);
    }
} catch (Exception $e) { echo "Performance error: " . $e->getMessage() . "\n"; }

// 5. Notifications (Admin)
try {
    $c = new App\Http\Controllers\Crm\Admin\CrmSystemController();
    $res = $c->notifications(new Illuminate\Http\Request());
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/notifications', $res->render(), $outBase);
    }
} catch (Exception $e) { echo "Admin Notifications error: " . $e->getMessage() . "\n"; }

// 6. Employee Performance
try {
    $c = new App\Http\Controllers\Crm\Employee\CrmEmployeeDashboardController();
    $res = $c->myPerformance();
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/employee/performance', $res->render(), $outBase);
    }
} catch (Exception $e) { echo "Employee Performance error: " . $e->getMessage() . "\n"; }

// 7. Employee Notifications
try {
    auth()->loginUsingId(1);
    $c = new App\Http\Controllers\Crm\Employee\CrmEmployeeDashboardController();
    $res = $c->notifications(new Illuminate\Http\Request());
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/employee/notifications', $res->render(), $outBase);
    }
} catch (Exception $e) { echo "Employee Notifications error: " . $e->getMessage() . "\n"; }

// 8. Lead details
$leadController = new App\Http\Controllers\Crm\Admin\CrmLeadController();
$leadIds = [39, 37, 33, 28, 40];
foreach ($leadIds as $lid) {
    try {
        $res = $leadController->show($lid);
        if ($res instanceof Illuminate\View\View) {
            saveRouteHtml('/crm/admin/leads/' . $lid, $res->render(), $outBase);
        }
    } catch (Exception $e) {
        // Fallback: save clean redirect or leads index
        saveRouteHtml('/crm/admin/leads/' . $lid, makeRedirectHtml('/crm/admin/leads'), $outBase);
    }
}

// 9. Customer details
$custController = new App\Http\Controllers\Crm\Admin\CrmCustomerController();
try {
    $res = $custController->show(9);
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/customers/9', $res->render(), $outBase);
    }
} catch (Exception $e) {
    saveRouteHtml('/crm/admin/customers/9', makeRedirectHtml('/crm/admin/customers'), $outBase);
}

// 10. Quotation details
$quoteController = new App\Http\Controllers\Crm\Admin\CrmQuotationController();
try {
    $res = $quoteController->show(4);
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/quotations/4', $res->render(), $outBase);
    }
} catch (Exception $e) {
    saveRouteHtml('/crm/admin/quotations/4', makeRedirectHtml('/crm/admin/quotations'), $outBase);
}

try {
    $res = $quoteController->printView(4);
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/quotations/4/print', $res->render(), $outBase);
        saveRouteHtml('/crm/admin/quotations/4/pdf', $res->render(), $outBase);
    }
} catch (Exception $e) {
    saveRouteHtml('/crm/admin/quotations/4/print', makeRedirectHtml('/crm/admin/quotations'), $outBase);
    saveRouteHtml('/crm/admin/quotations/4/pdf', makeRedirectHtml('/crm/admin/quotations'), $outBase);
}

// 11. Team edits
$teamController = new App\Http\Controllers\Crm\Admin\CrmTeamController();
foreach ([1, 6, 7, 8, 9] as $tid) {
    try {
        $res = $teamController->edit($tid);
        if ($res instanceof Illuminate\View\View) {
            saveRouteHtml('/crm/admin/team/' . $tid . '/edit', $res->render(), $outBase);
        }
    } catch (Exception $e) {
        saveRouteHtml('/crm/admin/team/' . $tid . '/edit', makeRedirectHtml('/crm/admin/team'), $outBase);
    }
}

// 12. Super Admin Branches
$superController = new App\Http\Controllers\Crm\Admin\CrmSuperAdminController();
try {
    $res = $superController->branches();
    if ($res instanceof Illuminate\View\View) {
        saveRouteHtml('/crm/admin/super/branches/create', $res->render(), $outBase);
        foreach ([1, 2, 3, 4] as $bid) {
            saveRouteHtml('/crm/admin/super/branches/' . $bid, $res->render(), $outBase);
        }
    }
} catch (Exception $e) { echo "Branches error: " . $e->getMessage() . "\n"; }

// 13. Bulk Assign, Upload, Logout, Forgot-Password, Search
saveRouteHtml('/crm/admin/leads/bulk-assign', makeRedirectHtml('/crm/admin/leads'), $outBase);
saveRouteHtml('/crm/admin/leads/upload', makeRedirectHtml('/crm/admin/leads'), $outBase);
saveRouteHtml('/crm/admin/leads-export', makeRedirectHtml('/crm/admin/leads'), $outBase);
saveRouteHtml('/crm/admin/demos/assignments', makeRedirectHtml('/crm/admin/demos'), $outBase);
saveRouteHtml('/crm/admin/search', makeRedirectHtml('/crm/admin/leads'), $outBase);
saveRouteHtml('/crm/logout', makeRedirectHtml('/crm/login'), $outBase);
saveRouteHtml('/crm/forgot-password', makeRedirectHtml('/crm/login'), $outBase);
saveRouteHtml('/crm/admin/super/backup/download', makeRedirectHtml('/crm/admin/super/backup'), $outBase);
saveRouteHtml('/crm/admin/super/recycle-bin/restore-all', makeRedirectHtml('/crm/admin/super/recycle-bin'), $outBase);
saveRouteHtml('/crm/admin/super/recycle-bin/empty', makeRedirectHtml('/crm/admin/super/recycle-bin'), $outBase);

echo "Completed rendering missing routes!\n";
