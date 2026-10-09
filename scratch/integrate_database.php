<?php
/**
 * Database Integration Script
 * Integrates u425316205_hisab into hisabmittra_crm and updates database.sql
 */

$pdoHisab = new PDO("mysql:host=127.0.0.1;dbname=u425316205_hisab;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$pdoCrm = new PDO("mysql:host=127.0.0.1;dbname=hisabmittra_crm;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "Connected to both databases successfully.\n";

// ========================================================
// STEP 1: Copy tables from u425316205_hisab into hisabmittra_crm
// ========================================================
$pdoCrm->exec("SET FOREIGN_KEY_CHECKS = 0;");
$skipTables = ['cache', 'cache_locks', 'failed_jobs', 'jobs', 'job_batches', 'migrations', 'password_reset_tokens', 'sessions', 'users'];
$tablesStmt = $pdoHisab->query("SHOW TABLES");
$hisabTables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

echo "Found " . count($hisabTables) . " tables in u425316205_hisab.\n";

foreach ($hisabTables as $tbl) {
    if (in_array($tbl, $skipTables)) {
        continue;
    }
    
    // Get create table statement
    $cStmt = $pdoHisab->query("SHOW CREATE TABLE `{$tbl}`");
    $createRow = $cStmt->fetch(PDO::FETCH_NUM);
    $createSql = $createRow[1];
    
    // Create in hisabmittra_crm if not exists
    $pdoCrm->exec("DROP TABLE IF EXISTS `{$tbl}`");
    $pdoCrm->exec($createSql);
    
    // Copy all data
    $pdoCrm->exec("INSERT INTO `hisabmittra_crm`.`{$tbl}` SELECT * FROM `u425316205_hisab`.`{$tbl}`");
    
    $cntStmt = $pdoCrm->query("SELECT count(*) FROM `{$tbl}`");
    $cnt = $cntStmt->fetchColumn();
    echo "  Copied table `{$tbl}`: {$cnt} rows\n";
}
$pdoCrm->exec("SET FOREIGN_KEY_CHECKS = 1;");

// Clean empty statuses in `leads` based on remarks
$emptyLeadsStmt = $pdoCrm->query("SELECT id, remarks FROM leads WHERE status = '' OR status IS NULL");
$emptyLeads = $emptyLeadsStmt->fetchAll(PDO::FETCH_ASSOC);
$updatedStatusCount = 0;
foreach ($emptyLeads as $el) {
    $detectedStatus = 'New';
    if (preg_match_all("/Status changed from '[^']*' to '([^']+)'/i", $el['remarks'], $m)) {
        $detectedStatus = end($m[1]);
    }
    $uStmt = $pdoCrm->prepare("UPDATE leads SET status = ? WHERE id = ?");
    $uStmt->execute([$detectedStatus, $el['id']]);
    $updatedStatusCount++;
}
echo "Cleaned status for {$updatedStatusCount} leads in `leads` table.\n";

// ========================================================
// STEP 2: Add RAVI BAIRWA and Ashok Chhapola to users & crm_employees
// ========================================================
$now = date('Y-m-d H:i:s');

// 1. RAVI BAIRWA
$stmtUserRavi = $pdoCrm->prepare("SELECT id FROM users WHERE email = ?");
$stmtUserRavi->execute(['ravimadhukar302@gmail.com']);
$raviUserId = $stmtUserRavi->fetchColumn();
if (!$raviUserId) {
    $ins = $pdoCrm->prepare("INSERT INTO users (name, email, password, mobile, type, created_at, updated_at) VALUES (?, ?, ?, ?, 'employee', ?, ?)");
    $ins->execute(['RAVI BAIRWA', 'ravimadhukar302@gmail.com', '$2y$10$J0JV/E1PgbUkKSQVSmOxDOGzrcsl6TjTYLpjX2JPcJb1v7jzGXR9q', '+91 98765 00000', '2026-10-06 10:36:22', '2026-10-06 10:36:22']);
    $raviUserId = $pdoCrm->lastInsertId();
}

$stmtEmpRavi = $pdoCrm->prepare("SELECT id FROM crm_employees WHERE email = ? OR employee_code = 'EMP-011'");
$stmtEmpRavi->execute(['ravimadhukar302@gmail.com']);
$raviEmpId = $stmtEmpRavi->fetchColumn();
if (!$raviEmpId) {
    $ins = $pdoCrm->prepare("INSERT INTO crm_employees (id, user_id, employee_code, name, email, phone, designation, role, joining_date, target_amount, status, created_at, updated_at) VALUES (11, ?, 'EMP-011', 'RAVI BAIRWA', 'ravimadhukar302@gmail.com', '+91 98765 00000', 'Field Executive', 'Sales', '2026-10-06', 100000.00, 'Active', '2026-10-06 10:36:22', '2026-10-06 10:36:22')");
    $ins->execute([$raviUserId]);
    $raviEmpId = 11;
}
echo "RAVI BAIRWA active as employee ID: {$raviEmpId} (User ID: {$raviUserId})\n";

// 2. Ashok Chhapola
$stmtUserAshok = $pdoCrm->prepare("SELECT id FROM users WHERE email = ?");
$stmtUserAshok->execute(['ashokmohamchhapola@gmail.com']);
$ashokUserId = $stmtUserAshok->fetchColumn();
if (!$ashokUserId) {
    $ins = $pdoCrm->prepare("INSERT INTO users (name, email, password, mobile, type, created_at, updated_at) VALUES (?, ?, ?, ?, 'employee', ?, ?)");
    $ins->execute(['Ashok Chhapola', 'ashokmohamchhapola@gmail.com', '$2y$10$b5RF0.9smK0Nc4K2qnAKPuDdsUk6Ib65OZHCPXAqr9Vik/oJ56lUy', '+91 98765 00000', '2026-10-06 10:37:06', '2026-10-06 10:37:06']);
    $ashokUserId = $pdoCrm->lastInsertId();
}

$stmtEmpAshok = $pdoCrm->prepare("SELECT id FROM crm_employees WHERE email = ? OR employee_code = 'EMP-012'");
$stmtEmpAshok->execute(['ashokmohamchhapola@gmail.com']);
$ashokEmpId = $stmtEmpAshok->fetchColumn();
if (!$ashokEmpId) {
    $ins = $pdoCrm->prepare("INSERT INTO crm_employees (id, user_id, employee_code, name, email, phone, designation, role, joining_date, target_amount, status, created_at, updated_at) VALUES (12, ?, 'EMP-012', 'Ashok Chhapola', 'ashokmohamchhapola@gmail.com', '+91 98765 00000', 'Field Executive', 'Sales', '2026-10-06', 100000.00, 'Active', '2026-10-06 10:37:06', '2026-10-06 10:37:06')");
    $ins->execute([$ashokUserId]);
    $ashokEmpId = 12;
}
echo "Ashok Chhapola active as employee ID: {$ashokEmpId} (User ID: {$ashokUserId})\n";

// Update Rahul Sharma (id 6/user 141) and Nandkishor (id 8/user 142) passwords
$uStmt = $pdoCrm->prepare("UPDATE users SET password = ? WHERE id = ?");
$uStmt->execute(['$2y$10$u7JyEEsnCG5cMf3IeVZzVOe5fEw3ym6rh2oGCRm8dGir0TMm2/dG2', 141]);
$uStmt->execute(['$2y$10$fphgK/lfZ4rcEJHOnY8UguhhWNNeL8BvAgWi7.X627Yx5pBgkKwiW', 142]);

// Map employee IDs from production to CRM
// Prod ID 1 (Rahul Sharma) -> CRM 6
// Prod ID 2 (Nandkishor)   -> CRM 8
// Prod ID 4 (Ravi Bairwa)  -> CRM 11
// Prod ID 5 (Ashok Chhapola)-> CRM 12
$empMap = [
    1 => ['id' => 6, 'name' => 'Rahul Sharma'],
    2 => ['id' => 8, 'name' => 'Nandkishor Chouhan'],
    4 => ['id' => 11, 'name' => 'RAVI BAIRWA'],
    5 => ['id' => 12, 'name' => 'Ashok Chhapola']
];

// ========================================================
// STEP 3: Integrate 125 leads into crm_leads
// ========================================================
$allLeadsStmt = $pdoCrm->query("SELECT * FROM leads ORDER BY id ASC");
$allLeads = $allLeadsStmt->fetchAll(PDO::FETCH_ASSOC);

$leadInsertCount = 0;
$leadUpdateCount = 0;
$leadIdMap = []; // prod_lead_id => crm_lead_id

$insCrmLeadStmt = $pdoCrm->prepare("INSERT INTO crm_leads (
    lead_code, name, email, phone, city, company, status, priority,
    basic, pro, assigned_to, agent, expected_value, follow_up_date,
    notes, created_at, updated_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($allLeads as $l) {
    $prodId = (int)$l['id'];
    $leadCode = 'LEAD-' . str_pad($prodId, 4, '0', STR_PAD_LEFT);
    
    // Check if exists in crm_leads by lead_code
    $chkStmt = $pdoCrm->prepare("SELECT id FROM crm_leads WHERE lead_code = ?");
    $chkStmt->execute([$leadCode]);
    $existingCrmId = $chkStmt->fetchColumn();
    
    $name = trim($l['customer_name'] ?? 'Unnamed Lead');
    $phone = trim($l['mobile'] ?? '');
    $company = trim($l['business_name'] ?? '');
    $city = trim($l['city'] ?? '');
    
    // Determine status
    $status = trim($l['status'] ?? '');
    if (empty($status) || $status === 'NULL') {
        if (preg_match_all("/Status changed from '[^']*' to '([^']+)'/i", $l['remarks'], $m)) {
            $status = end($m[1]);
        } else {
            $status = 'New';
        }
    }
    
    $priority = !empty($l['priority']) ? $l['priority'] : 'Medium';
    $basic = !empty($l['basic_amount']) ? (float)$l['basic_amount'] : 0.00;
    $pro = !empty($l['pro_amount']) ? (float)$l['pro_amount'] : 0.00;
    $expectedValue = ($pro > 0) ? $pro : (($basic > 0) ? $basic : 0.00);
    
    // Assigned to mapping
    $prodAssigned = !empty($l['assigned_to']) ? (int)$l['assigned_to'] : 0;
    $crmAssigned = $empMap[$prodAssigned]['id'] ?? null;
    $agent = $empMap[$prodAssigned]['name'] ?? ($l['emp'] ?? null);
    
    $followUpDate = !empty($l['callback_date']) ? $l['callback_date'] : null;
    
    $notesParts = [];
    if (!empty($l['remarks'])) $notesParts[] = $l['remarks'];
    if (!empty($l['response_note'])) $notesParts[] = "Response: " . $l['response_note'];
    $notes = !empty($notesParts) ? implode("\n\n", $notesParts) : null;
    
    $createdAt = !empty($l['created_at']) ? $l['created_at'] : $now;
    $updatedAt = !empty($l['updated_at']) ? $l['updated_at'] : $now;
    
    if (!$existingCrmId) {
        $insCrmLeadStmt->execute([
            $leadCode, $name, null, $phone, $city, $company, $status, $priority,
            $basic, $pro, $crmAssigned, $agent, $expectedValue, $followUpDate,
            $notes, $createdAt, $updatedAt
        ]);
        $crmId = $pdoCrm->lastInsertId();
        $leadInsertCount++;
        $leadIdMap[$prodId] = $crmId;
    } else {
        $leadIdMap[$prodId] = $existingCrmId;
        $leadUpdateCount++;
    }
}
echo "Integrated leads into crm_leads: {$leadInsertCount} inserted, {$leadUpdateCount} already present.\n";

// ========================================================
// STEP 4: Integrate lead_closures into crm_customers, crm_deals, crm_payments
// ========================================================
$closuresStmt = $pdoCrm->query("SELECT * FROM lead_closures ORDER BY id ASC");
$closures = $closuresStmt->fetchAll(PDO::FETCH_ASSOC);

$closureCount = 0;
foreach ($closures as $c) {
    $prodLeadId = (int)$c['lead_id'];
    $crmLeadId = $leadIdMap[$prodLeadId] ?? null;
    
    // Fetch lead info
    $lInfoStmt = $pdoCrm->prepare("SELECT * FROM leads WHERE id = ?");
    $lInfoStmt->execute([$prodLeadId]);
    $leadInfo = $lInfoStmt->fetch(PDO::FETCH_ASSOC);
    
    $custCode = 'CUST-' . str_pad($c['id'], 4, '0', STR_PAD_LEFT);
    $custName = trim($leadInfo['customer_name'] ?? 'Customer');
    $compName = trim($leadInfo['business_name'] ?? '');
    $phone = trim($leadInfo['mobile'] ?? '');
    $city = trim($leadInfo['city'] ?? '');
    
    $prodAssigned = !empty($leadInfo['assigned_to']) ? (int)$leadInfo['assigned_to'] : 0;
    $crmAssigned = $empMap[$prodAssigned]['id'] ?? 1;
    
    // Check if customer exists
    $chkCust = $pdoCrm->prepare("SELECT id FROM crm_customers WHERE customer_code = ?");
    $chkCust->execute([$custCode]);
    $custId = $chkCust->fetchColumn();
    
    if (!$custId) {
        $insCust = $pdoCrm->prepare("INSERT INTO crm_customers (
            customer_code, name, company, phone, address, assigned_to, lead_id,
            status, total_spent, notes, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, 'Active', ?, ?, ?, ?)");
        $insCust->execute([
            $custCode, $custName, $compName, $phone, $city, $crmAssigned, $crmLeadId,
            (float)$c['amount_received'], "Closed sale converted from lead #{$prodLeadId}",
            $c['created_at'], $c['created_at']
        ]);
        $custId = $pdoCrm->lastInsertId();
    }
    
    // Check deal
    $dealTitle = !empty($compName) ? "{$compName} - License" : "{$custName} - Enterprise Setup";
    $chkDeal = $pdoCrm->prepare("SELECT id FROM crm_deals WHERE customer_id = ? OR (lead_id = ? AND lead_id IS NOT NULL)");
    $chkDeal->execute([$custId, $crmLeadId]);
    $dealId = $chkDeal->fetchColumn();
    if (!$dealId) {
        $stage = ((float)$c['amount_pending'] > 0) ? 'Partial Sale' : 'Won';
        $insDeal = $pdoCrm->prepare("INSERT INTO crm_deals (
            title, customer_id, lead_id, value, stage, probability,
            expected_closing_date, assigned_to, priority, notes, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, 100, ?, ?, 'High', ?, ?, ?)");
        $insDeal->execute([
            $dealTitle, $custId, $crmLeadId, (float)$c['total_amount'], $stage,
            $c['closing_date'], $crmAssigned,
            "Received: ₹{$c['amount_received']}, Pending: ₹{$c['amount_pending']}",
            $c['created_at'], $c['created_at']
        ]);
    }
    
    // Check payment
    $payNo = 'REC-' . date('Y', strtotime($c['closing_date'])) . '-' . str_pad($c['id'], 4, '0', STR_PAD_LEFT);
    $chkPay = $pdoCrm->prepare("SELECT id FROM crm_payments WHERE payment_no = ?");
    $chkPay->execute([$payNo]);
    $payId = $chkPay->fetchColumn();
    if (!$payId) {
        $insPay = $pdoCrm->prepare("INSERT INTO crm_payments (
            payment_no, customer_id, amount, payment_date, payment_method,
            status, notes, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, 'Paid', ?, ?, ?)");
        $insPay->execute([
            $payNo, $custId, (float)$c['amount_received'], $c['closing_date'],
            $c['payment_mode'] ?? 'Online',
            "Payment for lead #{$prodLeadId} closure",
            $c['created_at'], $c['created_at']
        ]);
    }
    $closureCount++;
}
echo "Integrated {$closureCount} sales closures into crm_customers, crm_deals, crm_payments.\n";

// ========================================================
// STEP 5: Integrate activity_logs into crm_activity_logs
// ========================================================
$logsStmt = $pdoCrm->query("SELECT * FROM activity_logs ORDER BY id ASC");
$logs = $logsStmt->fetchAll(PDO::FETCH_ASSOC);

$logInsertCount = 0;
$insLogStmt = $pdoCrm->prepare("INSERT INTO crm_activity_logs (
    user_id, user_name, module, action, description, created_at, updated_at
) VALUES (?, ?, ?, ?, ?, ?, ?)");

$crmLogCount = $pdoCrm->query("SELECT count(*) FROM crm_activity_logs")->fetchColumn();
if ($crmLogCount < 100) {
    foreach ($logs as $l) {
        $uName = ($l['user_type'] === 'admin') ? 'Admin' : 'Employee';
        $act = (stripos($l['action'], 'Added') !== false) ? 'Created' : 'Updated';
        $insLogStmt->execute([
            $l['user_id'], $uName, 'Leads', $act, $l['action'], $l['created_at'], $l['created_at']
        ]);
        $logInsertCount++;
    }
    echo "Integrated {$logInsertCount} activity logs into crm_activity_logs.\n";
} else {
    echo "crm_activity_logs already populated ({$crmLogCount} entries).\n";
}

// Summary of hisabmittra_crm tables
echo "\n=== Verification of hisabmittra_crm ===\n";
$tablesToCheck = ['leads', 'employees', 'lead_closures', 'activity_logs', 'crm_leads', 'crm_employees', 'crm_customers', 'crm_deals', 'crm_payments', 'crm_activity_logs', 'users'];
foreach ($tablesToCheck as $tc) {
    $c = $pdoCrm->query("SELECT count(*) FROM `{$tc}`")->fetchColumn();
    echo "  {$tc}: {$c} rows\n";
}
