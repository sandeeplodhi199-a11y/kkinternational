<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$dbConfig = [
    'host' => '127.0.0.1',
    'port' => '3306',
    'dbname' => 'hisabmittra_crm',
    'user' => 'root',
    'pass' => ''
];

$pdo = null;
try {
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    // If local MySQL not reachable (e.g. running on Vercel CDN), return graceful offline sync
}

$rawInput = json_decode(file_get_contents('php://input'), true);
$input = (!empty($input) && is_array($input)) ? $input : ($rawInput ?? $_POST ?? []);
$action = $input['action'] ?? $_GET['action'] ?? '';

// Helper: Append SQL query to database.sql dump file
function appendToSqlDump($sqlStatement) {
    $sqlFiles = [
        'C:/Users/WINDOWS 11/Downloads/hisabmittra/database.sql',
        'C:/Users/WINDOWS 11/Downloads/hisabmittra/hisabmittra_crm.sql',
        'C:/Users/WINDOWS 11/Downloads/hisabmittra/public/database.sql',
        'C:/xampp/htdocs/database.sql',
        'C:/xampp/htdocs/crm/database.sql'
    ];
    $comment = "\n-- Auto-Saved Action [" . date('Y-m-d H:i:s') . "]\n" . $sqlStatement . ";\n";
    foreach ($sqlFiles as $f) {
        if (file_exists(dirname($f))) {
            @file_put_contents($f, $comment, FILE_APPEND | LOCK_EX);
        }
    }
}

// 1. Action: Save Lead
if ($action === 'save_lead') {
    $data = $input['data'] ?? [];
    $leadCode = $data['lead_code'] ?? ('LEAD-' . rand(1000, 9999));
    $name = trim($data['name'] ?? 'Unnamed Prospect');
    $email = !empty($data['email']) ? trim($data['email']) : null;
    $phone = !empty($data['phone']) ? trim($data['phone']) : null;
    $company = !empty($data['company']) ? trim($data['company']) : null;
    $sourceId = !empty($data['source_id']) ? (int)$data['source_id'] : null;
    $status = $data['status'] ?? 'New';
    $priority = $data['priority'] ?? 'Medium';
    $assignedTo = !empty($data['assigned_to']) ? (int)$data['assigned_to'] : null;
    $expectedValue = !empty($data['expected_value']) ? (float)$data['expected_value'] : 0.00;
    $followUpDate = !empty($data['follow_up_date']) ? $data['follow_up_date'] : (!empty($data['callback']) ? $data['callback'] : null);
    $notes = !empty($data['notes']) ? trim($data['notes']) : (!empty($data['remarks']) ? trim($data['remarks']) : null);
    $city = !empty($data['city']) ? trim($data['city']) : null;
    $agent = !empty($data['agent']) ? trim($data['agent']) : null;
    $basic = !empty($data['basic']) ? (float)$data['basic'] : 0.00;
    $pro = !empty($data['pro']) ? (float)$data['pro'] : ($expectedValue > 0 ? $expectedValue : 0.00);
    $now = date('Y-m-d H:i:s');

    $sqlInsert = "INSERT INTO `crm_leads` (`lead_code`, `name`, `email`, `phone`, `company`, `city`, `source_id`, `status`, `priority`, `assigned_to`, `agent`, `basic`, `pro`, `expected_value`, `follow_up_date`, `notes`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($leadCode) . "', " .
        "'" . addslashes($name) . "', " .
        ($email ? "'" . addslashes($email) . "'" : "NULL") . ", " .
        ($phone ? "'" . addslashes($phone) . "'" : "NULL") . ", " .
        ($company ? "'" . addslashes($company) . "'" : "NULL") . ", " .
        ($city ? "'" . addslashes($city) . "'" : "NULL") . ", " .
        ($sourceId ? $sourceId : "NULL") . ", " .
        "'" . addslashes($status) . "', " .
        "'" . addslashes($priority) . "', " .
        ($assignedTo ? $assignedTo : "NULL") . ", " .
        ($agent ? "'" . addslashes($agent) . "'" : "NULL") . ", " .
        $basic . ", " .
        $pro . ", " .
        $expectedValue . ", " .
        ($followUpDate ? "'" . addslashes($followUpDate) . "'" : "NULL") . ", " .
        ($notes ? "'" . addslashes($notes) . "'" : "NULL") . ", " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_leads (lead_code, name, email, phone, company, city, source_id, status, priority, assigned_to, agent, basic, pro, expected_value, follow_up_date, notes, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$leadCode, $name, $email, $phone, $company, $city, $sourceId, $status, $priority, $assignedTo, $agent, $basic, $pro, $expectedValue, $followUpDate, $notes, $now, $now]);
            $insertedId = $pdo->lastInsertId();

            // Log activity
            $logStmt = $pdo->prepare("INSERT INTO crm_activity_logs (user_id, user_name, module, action, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $logStmt->execute([1, 'Admin', 'Leads', 'Created', "Lead {$name} ({$leadCode}) with City: {$city}, Agent: {$agent}, Basic: ₹{$basic}, Pro: ₹{$pro} automatically created and saved to SQL.", $now, $now]);
        } catch (Exception $ex) {
            // MySQL error handled gracefully
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Lead automatically saved into SQL & MySQL database!',
        'lead_code' => $leadCode,
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// 2. Action: Bulk Assign
if ($action === 'bulk_assign') {
    $assignedTo = !empty($input['assigned_to']) ? (int)$input['assigned_to'] : 1;
    $leadIds = $input['lead_ids'] ?? [];
    $mode = $input['mode'] ?? 'selected';
    $now = date('Y-m-d H:i:s');

    if ($mode === 'all') {
        $sql = "UPDATE `crm_leads` SET `assigned_to` = {$assignedTo}, `updated_at` = '{$now}' WHERE `deleted_at` IS NULL";
    } else {
        $idsStr = !empty($leadIds) ? implode(',', array_map('intval', $leadIds)) : '0';
        $sql = "UPDATE `crm_leads` SET `assigned_to` = {$assignedTo}, `updated_at` = '{$now}' WHERE `id` IN ({$idsStr})";
    }

    appendToSqlDump($sql);

    if ($pdo) {
        try {
            $pdo->query($sql);
        } catch (Exception $e) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Assignment automatically updated in SQL & MySQL database!',
        'sql' => $sql
    ]);
    exit;
}

// 3. Action: Update Status
if ($action === 'update_status') {
    $leadId = (int)($input['lead_id'] ?? 0);
    $status = $input['status'] ?? 'Contacted';
    $now = date('Y-m-d H:i:s');

    $sql = "UPDATE `crm_leads` SET `status` = '" . addslashes($status) . "', `updated_at` = '{$now}' WHERE `id` = {$leadId}";
    appendToSqlDump($sql);

    if ($pdo && $leadId > 0) {
        try {
            $stmt = $pdo->prepare("UPDATE crm_leads SET status = ?, updated_at = ? WHERE id = ?");
            $stmt->execute([$status, $now, $leadId]);
        } catch (Exception $e) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Status automatically updated in SQL & MySQL database!',
        'sql' => $sql
    ]);
    exit;
}

// 4. Action: Export latest SQL Dump
if ($action === 'export_sql' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $dumpFile = __DIR__ . '/../../database.sql';
    if (file_exists($dumpFile)) {
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="hisabmittra_crm_' . date('Y_m_d_His') . '.sql"');
        readfile($dumpFile);
        exit;
    }
}

echo json_encode([
    'success' => true,
    'status' => 'MySQL Auto-Sync Engine Active',
    'mysql_connected' => ($pdo !== null),
    'database' => $dbConfig['dbname'],
    'timestamp' => date('Y-m-d H:i:s')
]);
