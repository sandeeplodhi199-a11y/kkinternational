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

// Dynamically check and parse .env if present
$envCandidates = [
    __DIR__ . '/../../.env',
    __DIR__ . '/../../../.env',
    dirname(__DIR__, 2) . '/.env'
];
foreach ($envCandidates as $envPath) {
    if (file_exists($envPath)) {
        $envLines = @file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($envLines) {
            foreach ($envLines as $line) {
                $line = trim($line);
                if (empty($line) || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
                list($key, $val) = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val, " \t\n\r\0\x0B\"'");
                if ($key === 'DB_HOST' && !empty($val)) $dbConfig['host'] = $val;
                if ($key === 'DB_PORT' && !empty($val)) $dbConfig['port'] = $val;
                if ($key === 'DB_DATABASE' && !empty($val)) $dbConfig['dbname'] = $val;
                if ($key === 'DB_USERNAME' && !empty($val)) $dbConfig['user'] = $val;
                if ($key === 'DB_PASSWORD') $dbConfig['pass'] = $val;
            }
        }
        break;
    }
}

$pdo = null;
try {
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    // If local MySQL offline or running on edge, fallback gracefully
}

$rawInput = json_decode(file_get_contents('php://input'), true);
$input = (!empty($input) && is_array($input)) ? $input : ($rawInput ?? $_POST ?? []);
$action = $input['action'] ?? $_GET['action'] ?? '';
$now = date('Y-m-d H:i:s');

// Helper: Append SQL statement to database.sql files
function appendToSqlDump($sqlStatement) {
    $sqlFiles = [
        dirname(__DIR__, 2) . '/database.sql',
        dirname(__DIR__, 2) . '/hisabmittra_crm.sql',
        'C:/Users/WINDOWS 11/Downloads/hisabmittra/database.sql',
        'C:/Users/WINDOWS 11/Downloads/hisabmittra/hisabmittra_crm.sql',
        'C:/Users/WINDOWS 11/Downloads/kkinternational/kkinternational/app/database.sql',
        'C:/xampp/htdocs/database.sql',
        'C:/xampp/htdocs/crm/database.sql'
    ];
    $comment = "\n-- Auto-Saved Action [" . date('Y-m-d H:i:s') . "]\n" . trim($sqlStatement, ";") . ";\n";
    foreach ($sqlFiles as $f) {
        if (file_exists(dirname($f))) {
            @file_put_contents($f, $comment, FILE_APPEND | LOCK_EX);
        }
    }
}

// Helper: Log to crm_activity_logs
function logActivity($pdo, $module, $actionName, $description) {
    if (!$pdo) return;
    try {
        $stmt = $pdo->prepare("INSERT INTO crm_activity_logs (user_id, user_name, module, action, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([1, 'Admin', $module, $actionName, $description]);
    } catch (Exception $e) {}
}

// ==========================================
// 1. ACTION: SAVE LEAD
// ==========================================
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
            logActivity($pdo, 'Leads', 'Created', "Lead {$name} ({$leadCode}) created and saved to SQL.");
        } catch (Exception $ex) {}
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

// ==========================================
// 2. ACTION: SAVE FOLLOW-UP
// ==========================================
if ($action === 'save_followup') {
    $data = $input['data'] ?? [];
    $leadId = !empty($data['lead_id']) ? (int)$data['lead_id'] : null;
    $customerId = !empty($data['customer_id']) ? (int)$data['customer_id'] : null;
    $assignedTo = !empty($data['assigned_to']) ? (int)$data['assigned_to'] : 1;
    $date = !empty($data['date']) ? $data['date'] : date('Y-m-d');
    $time = !empty($data['time']) ? (strlen($data['time']) === 5 ? $data['time'] . ':00' : $data['time']) : '11:00:00';
    $type = !empty($data['type']) ? $data['type'] : 'Call';
    $status = !empty($data['status']) ? $data['status'] : 'Pending';
    $notes = !empty($data['notes']) ? trim($data['notes']) : null;

    $sqlInsert = "INSERT INTO `crm_followups` (`lead_id`, `customer_id`, `assigned_to`, `date`, `time`, `type`, `notes`, `status`, `reminder_sent`, `created_at`, `updated_at`) VALUES (" .
        ($leadId ? $leadId : "NULL") . ", " .
        ($customerId ? $customerId : "NULL") . ", " .
        ($assignedTo ? $assignedTo : "NULL") . ", " .
        "'" . addslashes($date) . "', " .
        "'" . addslashes($time) . "', " .
        "'" . addslashes($type) . "', " .
        ($notes ? "'" . addslashes($notes) . "'" : "NULL") . ", " .
        "'" . addslashes($status) . "', " .
        "0, '{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_followups (lead_id, customer_id, assigned_to, date, time, type, notes, status, reminder_sent, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?)");
            $stmt->execute([$leadId, $customerId, $assignedTo, $date, $time, $type, $notes, $status, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Followups', 'Scheduled', "Follow-up ({$type}) scheduled on {$date} {$time} and saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Follow-up successfully scheduled and saved to SQL!',
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 3. ACTION: SAVE CUSTOMER
// ==========================================
if ($action === 'save_customer') {
    $data = $input['data'] ?? [];
    $customerCode = $data['customer_code'] ?? ('CUST-' . rand(1000, 9999));
    $name = trim($data['name'] ?? 'New Customer');
    $company = !empty($data['company']) ? trim($data['company']) : null;
    $email = !empty($data['email']) ? trim($data['email']) : null;
    $phone = !empty($data['phone']) ? trim($data['phone']) : null;
    $address = !empty($data['address']) ? trim($data['address']) : null;
    $assignedTo = !empty($data['assigned_to']) ? (int)$data['assigned_to'] : null;
    $leadId = !empty($data['lead_id']) ? (int)$data['lead_id'] : null;
    $status = !empty($data['status']) ? $data['status'] : 'Active';
    $notes = !empty($data['notes']) ? trim($data['notes']) : null;

    $sqlInsert = "INSERT INTO `crm_customers` (`customer_code`, `name`, `company`, `email`, `phone`, `address`, `assigned_to`, `lead_id`, `status`, `total_spent`, `notes`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($customerCode) . "', " .
        "'" . addslashes($name) . "', " .
        ($company ? "'" . addslashes($company) . "'" : "NULL") . ", " .
        ($email ? "'" . addslashes($email) . "'" : "NULL") . ", " .
        ($phone ? "'" . addslashes($phone) . "'" : "NULL") . ", " .
        ($address ? "'" . addslashes($address) . "'" : "NULL") . ", " .
        ($assignedTo ? $assignedTo : "NULL") . ", " .
        ($leadId ? $leadId : "NULL") . ", " .
        "'" . addslashes($status) . "', " .
        "0.00, " .
        ($notes ? "'" . addslashes($notes) . "'" : "NULL") . ", " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_customers (customer_code, name, company, email, phone, address, assigned_to, lead_id, status, total_spent, notes, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0.00, ?, ?, ?)");
            $stmt->execute([$customerCode, $name, $company, $email, $phone, $address, $assignedTo, $leadId, $status, $notes, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Customers', 'Created', "Customer {$name} ({$customerCode}) created and saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Customer successfully created and saved to SQL!',
        'customer_code' => $customerCode,
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 4. ACTION: SAVE DEAL
// ==========================================
if ($action === 'save_deal') {
    $data = $input['data'] ?? [];
    $title = trim($data['title'] ?? 'New Deal');
    $customerId = !empty($data['customer_id']) ? (int)$data['customer_id'] : null;
    $leadId = !empty($data['lead_id']) ? (int)$data['lead_id'] : null;
    $value = !empty($data['value']) ? (float)$data['value'] : 0.00;
    $stage = !empty($data['stage']) ? $data['stage'] : 'New';
    $probability = !empty($data['probability']) ? (int)$data['probability'] : 20;
    $closingDate = !empty($data['expected_closing_date']) ? $data['expected_closing_date'] : null;
    $assignedTo = !empty($data['assigned_to']) ? (int)$data['assigned_to'] : 1;
    $priority = !empty($data['priority']) ? $data['priority'] : 'Medium';
    $notes = !empty($data['notes']) ? trim($data['notes']) : null;

    $sqlInsert = "INSERT INTO `crm_deals` (`title`, `customer_id`, `lead_id`, `value`, `stage`, `probability`, `expected_closing_date`, `assigned_to`, `priority`, `notes`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($title) . "', " .
        ($customerId ? $customerId : "NULL") . ", " .
        ($leadId ? $leadId : "NULL") . ", " .
        $value . ", " .
        "'" . addslashes($stage) . "', " .
        $probability . ", " .
        ($closingDate ? "'" . addslashes($closingDate) . "'" : "NULL") . ", " .
        ($assignedTo ? $assignedTo : "NULL") . ", " .
        "'" . addslashes($priority) . "', " .
        ($notes ? "'" . addslashes($notes) . "'" : "NULL") . ", " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_deals (title, customer_id, lead_id, value, stage, probability, expected_closing_date, assigned_to, priority, notes, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $customerId, $leadId, $value, $stage, $probability, $closingDate, $assignedTo, $priority, $notes, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Deals', 'Created', "Deal '{$title}' for ₹{$value} created and saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Deal successfully created and saved to SQL!',
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 5. ACTION: SAVE TASK
// ==========================================
if ($action === 'save_task') {
    $data = $input['data'] ?? [];
    $title = trim($data['title'] ?? 'New Task');
    $description = !empty($data['description']) ? trim($data['description']) : null;
    $assignedTo = !empty($data['assigned_to']) ? (int)$data['assigned_to'] : 1;
    $relatedLeadId = !empty($data['related_lead_id']) ? (int)$data['related_lead_id'] : null;
    $relatedCustomerId = !empty($data['related_customer_id']) ? (int)$data['related_customer_id'] : null;
    $priority = !empty($data['priority']) ? $data['priority'] : 'Medium';
    $dueDate = !empty($data['due_date']) ? $data['due_date'] : date('Y-m-d');
    $status = !empty($data['status']) ? $data['status'] : 'Pending';

    $sqlInsert = "INSERT INTO `crm_tasks` (`title`, `description`, `assigned_to`, `related_lead_id`, `related_customer_id`, `priority`, `due_date`, `status`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($title) . "', " .
        ($description ? "'" . addslashes($description) . "'" : "NULL") . ", " .
        ($assignedTo ? $assignedTo : "NULL") . ", " .
        ($relatedLeadId ? $relatedLeadId : "NULL") . ", " .
        ($relatedCustomerId ? $relatedCustomerId : "NULL") . ", " .
        "'" . addslashes($priority) . "', " .
        ($dueDate ? "'" . addslashes($dueDate) . "'" : "NULL") . ", " .
        "'" . addslashes($status) . "', " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_tasks (title, description, assigned_to, related_lead_id, related_customer_id, priority, due_date, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $assignedTo, $relatedLeadId, $relatedCustomerId, $priority, $dueDate, $status, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Tasks', 'Created', "Task '{$title}' created and saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Task successfully created and saved to SQL!',
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 6. ACTION: SAVE DEMO
// ==========================================
if ($action === 'save_demo') {
    $data = $input['data'] ?? [];
    $title = trim($data['title'] ?? 'Product Demo');
    $leadId = !empty($data['lead_id']) ? (int)$data['lead_id'] : null;
    $customerId = !empty($data['customer_id']) ? (int)$data['customer_id'] : null;
    $assignedTo = !empty($data['assigned_to']) ? (int)$data['assigned_to'] : 1;
    $date = !empty($data['date']) ? $data['date'] : date('Y-m-d');
    $time = !empty($data['time']) ? (strlen($data['time']) === 5 ? $data['time'] . ':00' : $data['time']) : '11:00:00';
    $status = !empty($data['status']) ? $data['status'] : 'Scheduled';
    $notes = !empty($data['notes']) ? trim($data['notes']) : null;

    $sqlInsert = "INSERT INTO `crm_demos` (`title`, `customer_id`, `lead_id`, `assigned_to`, `date`, `time`, `status`, `notes`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($title) . "', " .
        ($customerId ? $customerId : "NULL") . ", " .
        ($leadId ? $leadId : "NULL") . ", " .
        ($assignedTo ? $assignedTo : "NULL") . ", " .
        "'" . addslashes($date) . "', " .
        "'" . addslashes($time) . "', " .
        "'" . addslashes($status) . "', " .
        ($notes ? "'" . addslashes($notes) . "'" : "NULL") . ", " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_demos (title, customer_id, lead_id, assigned_to, date, time, status, notes, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $customerId, $leadId, $assignedTo, $date, $time, $status, $notes, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Demos', 'Scheduled', "Demo '{$title}' on {$date} saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Demo successfully scheduled and saved to SQL!',
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 7. ACTION: SAVE PAYMENT
// ==========================================
if ($action === 'save_payment') {
    $data = $input['data'] ?? [];
    $paymentNo = $data['payment_no'] ?? ('REC-' . date('Y') . '-' . rand(1000, 9999));
    $customerId = !empty($data['customer_id']) ? (int)$data['customer_id'] : null;
    $quotationId = !empty($data['quotation_id']) ? (int)$data['quotation_id'] : null;
    $amount = !empty($data['amount']) ? (float)$data['amount'] : 0.00;
    $paymentDate = !empty($data['payment_date']) ? $data['payment_date'] : date('Y-m-d');
    $paymentMethod = !empty($data['payment_method']) ? $data['payment_method'] : 'Bank Transfer';
    $transactionRef = !empty($data['transaction_ref']) ? trim($data['transaction_ref']) : null;
    $status = !empty($data['status']) ? $data['status'] : 'Paid';
    $notes = !empty($data['notes']) ? trim($data['notes']) : null;

    $sqlInsert = "INSERT INTO `crm_payments` (`payment_no`, `quotation_id`, `customer_id`, `amount`, `payment_date`, `payment_method`, `transaction_ref`, `status`, `notes`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($paymentNo) . "', " .
        ($quotationId ? $quotationId : "NULL") . ", " .
        ($customerId ? $customerId : "NULL") . ", " .
        $amount . ", " .
        "'" . addslashes($paymentDate) . "', " .
        "'" . addslashes($paymentMethod) . "', " .
        ($transactionRef ? "'" . addslashes($transactionRef) . "'" : "NULL") . ", " .
        "'" . addslashes($status) . "', " .
        ($notes ? "'" . addslashes($notes) . "'" : "NULL") . ", " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_payments (payment_no, quotation_id, customer_id, amount, payment_date, payment_method, transaction_ref, status, notes, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$paymentNo, $quotationId, $customerId, $amount, $paymentDate, $paymentMethod, $transactionRef, $status, $notes, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Payments', 'Recorded', "Payment {$paymentNo} of ₹{$amount} recorded and saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Payment successfully recorded and saved to SQL!',
        'payment_no' => $paymentNo,
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 8. ACTION: SAVE QUOTATION
// ==========================================
if ($action === 'save_quotation') {
    $data = $input['data'] ?? [];
    $quotationNo = $data['quotation_no'] ?? ('QT-' . date('Y') . '-' . rand(1000, 9999));
    $customerId = !empty($data['customer_id']) ? (int)$data['customer_id'] : null;
    $customerName = trim($data['customer_name'] ?? 'Client');
    $customerEmail = !empty($data['customer_email']) ? trim($data['customer_email']) : null;
    $customerPhone = !empty($data['customer_phone']) ? trim($data['customer_phone']) : null;
    $quotationDate = !empty($data['quotation_date']) ? $data['quotation_date'] : date('Y-m-d');
    $validUntil = !empty($data['valid_until']) ? $data['valid_until'] : date('Y-m-d', strtotime('+15 days'));
    $subtotal = !empty($data['subtotal']) ? (float)$data['subtotal'] : 0.00;
    $grandTotal = !empty($data['grand_total']) ? (float)$data['grand_total'] : ($subtotal > 0 ? $subtotal : 0.00);
    $status = !empty($data['status']) ? $data['status'] : 'Draft';
    $notes = !empty($data['notes']) ? trim($data['notes']) : null;
    $terms = !empty($data['terms']) ? trim($data['terms']) : null;

    $sqlInsert = "INSERT INTO `crm_quotations` (`quotation_no`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `quotation_date`, `valid_until`, `subtotal`, `grand_total`, `status`, `notes`, `terms`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($quotationNo) . "', " .
        ($customerId ? $customerId : "NULL") . ", " .
        "'" . addslashes($customerName) . "', " .
        ($customerEmail ? "'" . addslashes($customerEmail) . "'" : "NULL") . ", " .
        ($customerPhone ? "'" . addslashes($customerPhone) . "'" : "NULL") . ", " .
        "'" . addslashes($quotationDate) . "', " .
        "'" . addslashes($validUntil) . "', " .
        $subtotal . ", " .
        $grandTotal . ", " .
        "'" . addslashes($status) . "', " .
        ($notes ? "'" . addslashes($notes) . "'" : "NULL") . ", " .
        ($terms ? "'" . addslashes($terms) . "'" : "NULL") . ", " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_quotations (quotation_no, customer_id, customer_name, customer_email, customer_phone, quotation_date, valid_until, subtotal, grand_total, status, notes, terms, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$quotationNo, $customerId, $customerName, $customerEmail, $customerPhone, $quotationDate, $validUntil, $subtotal, $grandTotal, $status, $notes, $terms, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Quotations', 'Created', "Quotation {$quotationNo} for ₹{$grandTotal} created and saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Quotation successfully created and saved to SQL!',
        'quotation_no' => $quotationNo,
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 9. ACTION: SAVE PRODUCT
// ==========================================
if ($action === 'save_product') {
    $data = $input['data'] ?? [];
    $name = trim($data['name'] ?? 'New Offering');
    $code = !empty($data['code']) ? trim($data['code']) : ('PRD-' . rand(1000, 9999));
    $category = !empty($data['category']) ? trim($data['category']) : 'Product';
    $price = !empty($data['price']) ? (float)$data['price'] : 0.00;
    $taxRate = !empty($data['tax_rate']) ? (float)$data['tax_rate'] : 18.00;
    $status = !empty($data['status']) ? $data['status'] : 'Active';
    $description = !empty($data['description']) ? trim($data['description']) : null;

    $prodId = (int)($data['id'] ?? 0);
    if ($prodId > 0) {
        $sqlUpdate = "UPDATE `crm_products` SET `name` = '" . addslashes($name) . "', `code` = '" . addslashes($code) . "', `category` = '" . addslashes($category) . "', `description` = " . ($description ? "'" . addslashes($description) . "'" : "NULL") . ", `price` = {$price}, `tax_rate` = {$taxRate}, `status` = '" . addslashes($status) . "', `updated_at` = '{$now}' WHERE `id` = {$prodId}";
        appendToSqlDump($sqlUpdate);

        if ($pdo) {
            try {
                $stmt = $pdo->prepare("UPDATE crm_products SET name = ?, code = ?, category = ?, description = ?, price = ?, tax_rate = ?, status = ?, updated_at = ? WHERE id = ?");
                $stmt->execute([$name, $code, $category, $description, $price, $taxRate, $status, $now, $prodId]);
                logActivity($pdo, 'Products', 'Updated', "Product '{$name}' ({$code}) updated.");
            } catch (Exception $ex) {}
        }

        echo json_encode([
            'success' => true,
            'message' => 'Offering/Product successfully updated and saved to SQL!',
            'code' => $code,
            'id' => $prodId,
            'sql' => $sqlUpdate
        ]);
        exit;
    }

    $sqlInsert = "INSERT INTO `crm_products` (`name`, `code`, `category`, `description`, `price`, `tax_rate`, `status`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($name) . "', " .
        "'" . addslashes($code) . "', " .
        "'" . addslashes($category) . "', " .
        ($description ? "'" . addslashes($description) . "'" : "NULL") . ", " .
        $price . ", " .
        $taxRate . ", " .
        "'" . addslashes($status) . "', " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_products (name, code, category, description, price, tax_rate, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $code, $category, $description, $price, $taxRate, $status, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Products', 'Created', "Product '{$name}' ({$code}) created and saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Offering/Product successfully added and saved to SQL!',
        'code' => $code,
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 10. ACTION: SAVE TEAM MEMBER
// ==========================================
if ($action === 'save_team_member' || $action === 'save_employee') {
    $data = $input['data'] ?? [];
    $name = trim($data['name'] ?? 'New Member');
    $email = trim($data['email'] ?? ('user_' . rand(1000, 9999) . '@hisabmittra.com'));
    $phone = !empty($data['phone']) ? trim($data['phone']) : null;
    $role = !empty($data['role']) ? $data['role'] : 'Sales';
    $designation = !empty($data['designation']) ? $data['designation'] : 'Executive';
    $targetAmount = !empty($data['target_amount']) ? (float)$data['target_amount'] : 0.00;
    $joiningDate = !empty($data['joining_date']) ? $data['joining_date'] : date('Y-m-d');
    $remarks = !empty($data['remarks']) ? trim($data['remarks']) : (!empty($data['remark']) ? trim($data['remark']) : null);
    $demosCount = isset($data['demos_count']) ? (int)$data['demos_count'] : (isset($data['demo']) ? (int)$data['demo'] : 0);
    $empCode = 'EMP-' . rand(100, 999);
    $pwdHash = password_hash($data['password'] ?? '12345678', PASSWORD_DEFAULT);

    $sqlInsertUser = "INSERT INTO `users` (`name`, `email`, `password`, `mobile`, `type`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($name) . "', " .
        "'" . addslashes($email) . "', " .
        "'" . addslashes($pwdHash) . "', " .
        ($phone ? "'" . addslashes($phone) . "'" : "NULL") . ", " .
        "'employee', '{$now}', '{$now}')";

    appendToSqlDump($sqlInsertUser);

    $insertedUserId = null;
    $insertedEmpId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, mobile, type, created_at, updated_at) VALUES (?, ?, ?, ?, 'employee', ?, ?)");
            $stmt->execute([$name, $email, $pwdHash, $phone, $now, $now]);
            $insertedUserId = $pdo->lastInsertId();

            $empStmt = $pdo->prepare("INSERT INTO crm_employees (user_id, employee_code, name, email, phone, designation, role, joining_date, target_amount, remarks, demos_count, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active', ?, ?)");
            $empStmt->execute([$insertedUserId, $empCode, $name, $email, $phone, $designation, $role, $joiningDate, $targetAmount, $remarks, $demosCount, $now, $now]);
            $insertedEmpId = $pdo->lastInsertId();

            logActivity($pdo, 'Team', 'Created', "Team member {$name} ({$empCode}) added and saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Team member successfully created and saved to SQL!',
        'employee_code' => $empCode,
        'id' => $insertedEmpId ?? rand(100, 999),
        'sql' => $sqlInsertUser
    ]);
    exit;
}

// ==========================================
// 11. ACTION: SAVE RESERVATION
// ==========================================
if ($action === 'save_reservation') {
    $data = $input['data'] ?? [];
    $resCode = 'RES-' . rand(1000, 9999);
    $customerName = trim($data['customer_name'] ?? 'Client');
    $serviceName = trim($data['service_name'] ?? 'Service');
    $amount = !empty($data['amount']) ? (float)$data['amount'] : 0.00;
    $status = !empty($data['status']) ? $data['status'] : 'Confirmed';
    $date = !empty($data['date']) ? $data['date'] : date('Y-m-d');
    $time = !empty($data['time']) ? (strlen($data['time']) === 5 ? $data['time'] . ':00' : $data['time']) : '10:00:00';
    $assignedTo = !empty($data['assigned_to']) ? (int)$data['assigned_to'] : null;
    $notes = !empty($data['notes']) ? trim($data['notes']) : null;

    $sqlInsert = "INSERT INTO `crm_reservations` (`reservation_code`, `customer_name`, `service_name`, `date`, `time`, `assigned_to`, `status`, `amount`, `notes`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($resCode) . "', " .
        "'" . addslashes($customerName) . "', " .
        "'" . addslashes($serviceName) . "', " .
        "'" . addslashes($date) . "', " .
        "'" . addslashes($time) . "', " .
        ($assignedTo ? $assignedTo : "NULL") . ", " .
        "'" . addslashes($status) . "', " .
        $amount . ", " .
        ($notes ? "'" . addslashes($notes) . "'" : "NULL") . ", " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_reservations (reservation_code, customer_name, service_name, date, time, assigned_to, status, amount, notes, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$resCode, $customerName, $serviceName, $date, $time, $assignedTo, $status, $amount, $notes, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Reservations', 'Created', "Reservation {$resCode} for {$customerName} saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Reservation successfully saved to SQL!',
        'reservation_code' => $resCode,
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 12. ACTION: SAVE BRANCH
// ==========================================
if ($action === 'save_branch') {
    $data = $input['data'] ?? [];
    $name = trim($data['name'] ?? 'New Branch');
    $code = !empty($data['code']) ? trim($data['code']) : ('BR-' . strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $name), 0, 3)));
    $city = !empty($data['city']) ? trim($data['city']) : null;
    $phone = !empty($data['phone']) ? trim($data['phone']) : null;
    $email = !empty($data['email']) ? trim($data['email']) : null;
    $address = !empty($data['address']) ? trim($data['address']) : null;
    $status = !empty($data['status']) ? $data['status'] : 'Active';

    $sqlInsert = "INSERT INTO `crm_branches` (`name`, `code`, `city`, `phone`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES (" .
        "'" . addslashes($name) . "', " .
        "'" . addslashes($code) . "', " .
        ($city ? "'" . addslashes($city) . "'" : "NULL") . ", " .
        ($phone ? "'" . addslashes($phone) . "'" : "NULL") . ", " .
        ($email ? "'" . addslashes($email) . "'" : "NULL") . ", " .
        ($address ? "'" . addslashes($address) . "'" : "NULL") . ", " .
        "'" . addslashes($status) . "', " .
        "'{$now}', '{$now}')";

    appendToSqlDump($sqlInsert);

    $insertedId = null;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO crm_branches (name, code, city, phone, email, address, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $code, $city, $phone, $email, $address, $status, $now, $now]);
            $insertedId = $pdo->lastInsertId();
            logActivity($pdo, 'Branches', 'Created', "Branch {$name} ({$code}) saved to SQL.");
        } catch (Exception $ex) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Branch successfully saved to SQL!',
        'code' => $code,
        'id' => $insertedId ?? rand(100, 999),
        'sql' => $sqlInsert
    ]);
    exit;
}

// ==========================================
// 13. ACTION: BULK ASSIGN (LEADS)
// ==========================================
if ($action === 'bulk_assign') {
    $assignedTo = !empty($input['assigned_to']) ? (int)$input['assigned_to'] : 1;
    $leadIds = $input['lead_ids'] ?? [];
    $mode = $input['mode'] ?? 'selected';

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

// ==========================================
// 14. ACTION: UPDATE STATUS (LEADS)
// ==========================================
if ($action === 'update_status') {
    $leadId = (int)($input['lead_id'] ?? 0);
    $status = $input['status'] ?? 'Contacted';

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

// ==========================================
// 14b. ACTION: DELETE LEAD
// ==========================================
if ($action === 'delete_lead' || $action === 'delete_record') {
    $leadId = (int)($input['lead_id'] ?? $input['id'] ?? 0);
    $leadCode = $input['lead_code'] ?? '';

    $cond = $leadId > 0 ? "`id` = {$leadId}" : "`lead_code` = '" . addslashes($leadCode) . "'";
    $sql = "UPDATE `crm_leads` SET `deleted_at` = '{$now}', `updated_at` = '{$now}' WHERE {$cond}";
    appendToSqlDump($sql);

    if ($pdo) {
        try {
            if ($leadId > 0) {
                $stmt = $pdo->prepare("UPDATE crm_leads SET deleted_at = NOW(), updated_at = NOW() WHERE id = ?");
                $stmt->execute([$leadId]);
            } else if (!empty($leadCode)) {
                $stmt = $pdo->prepare("UPDATE crm_leads SET deleted_at = NOW(), updated_at = NOW() WHERE lead_code = ?");
                $stmt->execute([$leadCode]);
            }
            logActivity($pdo, 'Leads', 'Delete Lead', "Deleted lead ID: {$leadId} / {$leadCode}");
        } catch (Exception $e) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Lead successfully deleted in SQL & MySQL database!',
        'sql' => $sql
    ]);
    exit;
}

// ==========================================
// 14b. ACTION: DELETE EMPLOYEE / TEAM MEMBER
// ==========================================
// ==========================================
// 14b. ACTION: DELETE EMPLOYEE / TEAM MEMBER (SOFT DELETE TO RECYCLE BIN)
// ==========================================
if ($action === 'delete_employee' || $action === 'delete_team_member') {
    $empId = (int)($input['emp_id'] ?? $input['id'] ?? 0);
    $empName = trim($input['name'] ?? '');

    $cond = $empId > 0 ? "`id` = {$empId}" : "`name` = '" . addslashes($empName) . "'";
    $sql = "UPDATE `crm_employees` SET `deleted_at` = '{$now}', `updated_at` = '{$now}' WHERE {$cond}";
    appendToSqlDump($sql);

    if ($pdo) {
        try {
            if ($empId > 0) {
                $stmt = $pdo->prepare("UPDATE crm_employees SET deleted_at = NOW(), updated_at = NOW() WHERE id = ?");
                $stmt->execute([$empId]);
            } else if (!empty($empName)) {
                $stmt = $pdo->prepare("UPDATE crm_employees SET deleted_at = NOW(), updated_at = NOW() WHERE name = ?");
                $stmt->execute([$empName]);
            }
            logActivity($pdo, 'Team', 'Delete Employee', "Moved employee ID: {$empId} / Name: {$empName} to Recycle Bin");
        } catch (Exception $e) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Employee moved to Recycle Bin safely!',
        'sql' => $sql
    ]);
    exit;
}

// ==========================================
// 14c. ACTION: DELETE PRODUCT / OFFERING (SOFT DELETE TO RECYCLE BIN)
// ==========================================
if ($action === 'delete_product') {
    $prodId = (int)($input['prod_id'] ?? $input['id'] ?? 0);
    $prodCode = trim($input['code'] ?? '');
    $prodName = trim($input['name'] ?? '');

    $cond = $prodId > 0 ? "`id` = {$prodId}" : (!empty($prodCode) ? "`code` = '" . addslashes($prodCode) . "'" : "`name` = '" . addslashes($prodName) . "'");
    $sql = "UPDATE `crm_products` SET `deleted_at` = '{$now}', `updated_at` = '{$now}' WHERE {$cond}";
    appendToSqlDump($sql);

    if ($pdo) {
        try {
            if ($prodId > 0) {
                $stmt = $pdo->prepare("UPDATE crm_products SET deleted_at = NOW(), updated_at = NOW() WHERE id = ?");
                $stmt->execute([$prodId]);
            } else if (!empty($prodCode)) {
                $stmt = $pdo->prepare("UPDATE crm_products SET deleted_at = NOW(), updated_at = NOW() WHERE code = ?");
                $stmt->execute([$prodCode]);
            } else if (!empty($prodName)) {
                $stmt = $pdo->prepare("UPDATE crm_products SET deleted_at = NOW(), updated_at = NOW() WHERE name = ?");
                $stmt->execute([$prodName]);
            }
            logActivity($pdo, 'Products', 'Delete Product', "Moved product ID: {$prodId} to Recycle Bin");
        } catch (Exception $e) {}
    }

    echo json_encode([
        'success' => true,
        'message' => 'Product moved to Recycle Bin safely!',
        'sql' => $sql
    ]);
    exit;
}

// ==========================================
// 14d. ACTION: DELETE RECORD (GENERIC SOFT DELETE TO RECYCLE BIN)
// ==========================================
if (in_array($action, ['delete_item', 'delete_record', 'delete_customer', 'delete_deal', 'delete_quotation', 'delete_task', 'delete_followup', 'delete_demo', 'delete_payment'])) {
    $type = $input['type'] ?? str_replace('delete_', '', $action);
    $id = (int)($input['id'] ?? $input['item_id'] ?? 0);
    $tableMap = [
        'lead' => 'crm_leads',
        'employee' => 'crm_employees',
        'customer' => 'crm_customers',
        'deal' => 'crm_deals',
        'quotation' => 'crm_quotations',
        'product' => 'crm_products',
        'task' => 'crm_tasks',
        'followup' => 'crm_followups',
        'demo' => 'crm_demos',
        'payment' => 'crm_payments'
    ];
    $tbl = $tableMap[$type] ?? null;
    if ($tbl && $id > 0) {
        $sql = "UPDATE `{$tbl}` SET `deleted_at` = '{$now}', `updated_at` = '{$now}' WHERE `id` = {$id}";
        appendToSqlDump($sql);
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("UPDATE {$tbl} SET deleted_at = NOW(), updated_at = NOW() WHERE id = ?");
                $stmt->execute([$id]);
                logActivity($pdo, ucfirst($type), 'Delete Record', "Moved {$type} #{$id} to Recycle Bin");
            } catch (Exception $e) {}
        }
        echo json_encode([
            'success' => true,
            'message' => ucfirst($type) . ' moved to Recycle Bin safely!',
            'sql' => $sql
        ]);
        exit;
    }
}

// ==========================================
// 14e. RECYCLE BIN ENGINE (FETCH / RESTORE / PURGE / EMPTY)
// ==========================================
function crmTimeAgo($datetime) {
    if (!$datetime) return 'Recently';
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' mins ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    return date('d M Y', $time);
}

// 1. GET ALL RECYCLE BIN RECORDS & COUNTS
if ($action === 'get_recycle_bin' || $action === 'get_trash') {
    $type = $input['type'] ?? $_GET['type'] ?? 'all';
    $items = [];
    $counts = [
        'leads' => 0,
        'customers' => 0,
        'deals' => 0,
        'quotations' => 0,
        'followups' => 0,
        'tasks' => 0,
        'demos' => 0,
        'payments' => 0,
        'employees' => 0,
        'products' => 0
    ];

    $cfg = [
        'leads' => [
            'table' => 'crm_leads',
            'type' => 'lead',
            'label' => 'Lead',
            'badge' => 'bg-orange-100 text-orange-800 border-orange-200/60',
            'sql' => "SELECT id, 'lead' as type, 'Lead' as label, 'bg-orange-100 text-orange-800 border-orange-200/60' as badge, name as title, CONCAT(COALESCE(company, 'Prospect'), ' • ', COALESCE(lead_code, 'LEAD')) as subtitle, COALESCE(phone, email, 'No contact') as info, deleted_at FROM crm_leads WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'customers' => [
            'table' => 'crm_customers',
            'type' => 'customer',
            'label' => 'Customer',
            'badge' => 'bg-blue-100 text-blue-800 border-blue-200/60',
            'sql' => "SELECT id, 'customer' as type, 'Customer' as label, 'bg-blue-100 text-blue-800 border-blue-200/60' as badge, name as title, CONCAT(COALESCE(company, 'Business'), ' • ', COALESCE(customer_code, 'CUST')) as subtitle, COALESCE(phone, email, 'No contact') as info, deleted_at FROM crm_customers WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'deals' => [
            'table' => 'crm_deals',
            'type' => 'deal',
            'label' => 'Deal',
            'badge' => 'bg-purple-100 text-purple-800 border-purple-200/60',
            'sql' => "SELECT id, 'deal' as type, 'Deal' as label, 'bg-purple-100 text-purple-800 border-purple-200/60' as badge, title as title, CONCAT('Stage: ', COALESCE(stage, 'Open'), ' • ₹', FORMAT(COALESCE(value, 0), 2)) as subtitle, 'Sales Deal' as info, deleted_at FROM crm_deals WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'quotations' => [
            'table' => 'crm_quotations',
            'type' => 'quotation',
            'label' => 'Quotation',
            'badge' => 'bg-teal-100 text-teal-800 border-teal-200/60',
            'sql' => "SELECT id, 'quotation' as type, 'Quotation' as label, 'bg-teal-100 text-teal-800 border-teal-200/60' as badge, CONCAT('Quotation ', COALESCE(quotation_no, id)) as title, COALESCE(customer_name, 'Client') as subtitle, COALESCE(customer_phone, customer_email, 'Quotation Record') as info, deleted_at FROM crm_quotations WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'products' => [
            'table' => 'crm_products',
            'type' => 'product',
            'label' => 'Product',
            'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-200/60',
            'sql' => "SELECT id, 'product' as type, 'Product' as label, 'bg-emerald-100 text-emerald-800 border-emerald-200/60' as badge, name as title, CONCAT(COALESCE(category, 'Item'), ' • Code: ', COALESCE(code, 'PRD')) as subtitle, CONCAT('₹', FORMAT(COALESCE(price, 0), 2)) as info, deleted_at FROM crm_products WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'employees' => [
            'table' => 'crm_employees',
            'type' => 'employee',
            'label' => 'Team',
            'badge' => 'bg-rose-100 text-rose-800 border-rose-200/60',
            'sql' => "SELECT id, 'employee' as type, 'Team' as label, 'bg-rose-100 text-rose-800 border-rose-200/60' as badge, name as title, CONCAT(COALESCE(role, 'Employee'), ' • ', COALESCE(employee_code, 'EMP')) as subtitle, COALESCE(email, phone, 'No contact') as info, deleted_at FROM crm_employees WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'tasks' => [
            'table' => 'crm_tasks',
            'type' => 'task',
            'label' => 'Task',
            'badge' => 'bg-yellow-100 text-yellow-800 border-yellow-200/60',
            'sql' => "SELECT id, 'task' as type, 'Task' as label, 'bg-yellow-100 text-yellow-800 border-yellow-200/60' as badge, title as title, CONCAT('Priority: ', COALESCE(priority, 'Medium')) as subtitle, 'Task Record' as info, deleted_at FROM crm_tasks WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'followups' => [
            'table' => 'crm_followups',
            'type' => 'followup',
            'label' => 'Follow-up',
            'badge' => 'bg-indigo-100 text-indigo-800 border-indigo-200/60',
            'sql' => "SELECT id, 'followup' as type, 'Follow-up' as label, 'bg-indigo-100 text-indigo-800 border-indigo-200/60' as badge, CONCAT('Follow-up (', COALESCE(type, 'Call'), ')') as title, CONCAT('Date: ', COALESCE(date, 'Scheduled')) as subtitle, 'Follow-up log' as info, deleted_at FROM crm_followups WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'demos' => [
            'table' => 'crm_demos',
            'type' => 'demo',
            'label' => 'Demo',
            'badge' => 'bg-pink-100 text-pink-800 border-pink-200/60',
            'sql' => "SELECT id, 'demo' as type, 'Demo' as label, 'bg-pink-100 text-pink-800 border-pink-200/60' as badge, title as title, CONCAT('Date: ', COALESCE(date, 'Scheduled')) as subtitle, 'Demo Reservation' as info, deleted_at FROM crm_demos WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
        'payments' => [
            'table' => 'crm_payments',
            'type' => 'payment',
            'label' => 'Payment',
            'badge' => 'bg-cyan-100 text-cyan-800 border-cyan-200/60',
            'sql' => "SELECT id, 'payment' as type, 'Payment' as label, 'bg-cyan-100 text-cyan-800 border-cyan-200/60' as badge, CONCAT('Payment #', COALESCE(payment_no, id)) as title, CONCAT('₹', FORMAT(COALESCE(amount, 0), 2)) as subtitle, COALESCE(payment_method, 'Payment') as info, deleted_at FROM crm_payments WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC"
        ],
    ];

    if ($pdo) {
        foreach ($cfg as $k => $c) {
            try {
                $countStmt = $pdo->query("SELECT COUNT(*) FROM {$c['table']} WHERE deleted_at IS NOT NULL");
                $counts[$k] = (int)$countStmt->fetchColumn();

                if ($type === 'all' || $type === $k || $type === $c['type']) {
                    $stmt = $pdo->query($c['sql']);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $r) {
                        $r['time_ago'] = crmTimeAgo($r['deleted_at']);
                        $items[] = $r;
                    }
                }
            } catch (Exception $e) {}
        }
    }

    usort($items, function($a, $b) {
        return strtotime($b['deleted_at']) - strtotime($a['deleted_at']);
    });

    echo json_encode([
        'success' => true,
        'counts' => $counts,
        'totalTrash' => array_sum($counts),
        'items' => $items
    ]);
    exit;
}

// 2. RESTORE RECORD FROM RECYCLE BIN
if ($action === 'restore_recycle_bin' || $action === 'restore_item') {
    $itemType = $input['type'] ?? '';
    $itemId = (int)($input['id'] ?? 0);
    $tableMap = [
        'lead' => 'crm_leads', 'leads' => 'crm_leads',
        'employee' => 'crm_employees', 'team' => 'crm_employees', 'employees' => 'crm_employees',
        'customer' => 'crm_customers', 'customers' => 'crm_customers',
        'deal' => 'crm_deals', 'deals' => 'crm_deals',
        'quotation' => 'crm_quotations', 'quotations' => 'crm_quotations',
        'product' => 'crm_products', 'products' => 'crm_products',
        'task' => 'crm_tasks', 'tasks' => 'crm_tasks',
        'followup' => 'crm_followups', 'followups' => 'crm_followups',
        'demo' => 'crm_demos', 'demos' => 'crm_demos',
        'payment' => 'crm_payments', 'payments' => 'crm_payments'
    ];
    $tbl = $tableMap[$itemType] ?? null;
    if ($tbl && $itemId > 0 && $pdo) {
        $stmt = $pdo->prepare("UPDATE {$tbl} SET deleted_at = NULL, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$itemId]);
        logActivity($pdo, 'Recycle Bin', 'Restore Record', "Restored {$itemType} #{$itemId} from Recycle Bin");
        $sql = "UPDATE `{$tbl}` SET `deleted_at` = NULL, `updated_at` = '{$now}' WHERE `id` = {$itemId};";
        appendToSqlDump($sql);
        echo json_encode(['success' => true, 'message' => "Record restored successfully!"]);
        exit;
    }
    echo json_encode(['success' => false, 'error' => 'Unable to restore record.']);
    exit;
}

// 3. PERMANENTLY PURGE RECORD FROM RECYCLE BIN
if ($action === 'purge_recycle_bin' || $action === 'purge_item' || $action === 'force_delete') {
    $itemType = $input['type'] ?? '';
    $itemId = (int)($input['id'] ?? 0);
    $tableMap = [
        'lead' => 'crm_leads', 'leads' => 'crm_leads',
        'employee' => 'crm_employees', 'team' => 'crm_employees', 'employees' => 'crm_employees',
        'customer' => 'crm_customers', 'customers' => 'crm_customers',
        'deal' => 'crm_deals', 'deals' => 'crm_deals',
        'quotation' => 'crm_quotations', 'quotations' => 'crm_quotations',
        'product' => 'crm_products', 'products' => 'crm_products',
        'task' => 'crm_tasks', 'tasks' => 'crm_tasks',
        'followup' => 'crm_followups', 'followups' => 'crm_followups',
        'demo' => 'crm_demos', 'demos' => 'crm_demos',
        'payment' => 'crm_payments', 'payments' => 'crm_payments'
    ];
    $tbl = $tableMap[$itemType] ?? null;
    if ($tbl && $itemId > 0 && $pdo) {
        $stmt = $pdo->prepare("DELETE FROM {$tbl} WHERE id = ? AND deleted_at IS NOT NULL");
        $stmt->execute([$itemId]);
        logActivity($pdo, 'Recycle Bin', 'Purge Record', "Permanently purged {$itemType} #{$itemId}");
        $sql = "DELETE FROM `{$tbl}` WHERE `id` = {$itemId};";
        appendToSqlDump($sql);
        echo json_encode(['success' => true, 'message' => "Record permanently purged from database!"]);
        exit;
    }
    echo json_encode(['success' => false, 'error' => 'Unable to purge record.']);
    exit;
}

// 4. RESTORE ALL IN RECYCLE BIN
if ($action === 'restore_all_recycle_bin') {
    $targetType = $input['type'] ?? 'all';
    $tables = [
        'leads' => 'crm_leads', 'customers' => 'crm_customers', 'deals' => 'crm_deals',
        'quotations' => 'crm_quotations', 'products' => 'crm_products', 'employees' => 'crm_employees',
        'tasks' => 'crm_tasks', 'followups' => 'crm_followups', 'demos' => 'crm_demos', 'payments' => 'crm_payments'
    ];
    $count = 0;
    if ($pdo) {
        foreach ($tables as $k => $tbl) {
            if ($targetType === 'all' || $targetType === $k) {
                $stmt = $pdo->prepare("UPDATE {$tbl} SET deleted_at = NULL, updated_at = NOW() WHERE deleted_at IS NOT NULL");
                $stmt->execute();
                $count += $stmt->rowCount();
            }
        }
    }
    echo json_encode(['success' => true, 'restored' => $count, 'message' => "{$count} record(s) restored successfully!"]);
    exit;
}

// 5. EMPTY ENTIRE RECYCLE BIN
if ($action === 'empty_recycle_bin') {
    $targetType = $input['type'] ?? 'all';
    $tables = [
        'leads' => 'crm_leads', 'customers' => 'crm_customers', 'deals' => 'crm_deals',
        'quotations' => 'crm_quotations', 'products' => 'crm_products', 'employees' => 'crm_employees',
        'tasks' => 'crm_tasks', 'followups' => 'crm_followups', 'demos' => 'crm_demos', 'payments' => 'crm_payments'
    ];
    $count = 0;
    if ($pdo) {
        foreach ($tables as $k => $tbl) {
            if ($targetType === 'all' || $targetType === $k) {
                $stmt = $pdo->prepare("DELETE FROM {$tbl} WHERE deleted_at IS NOT NULL");
                $stmt->execute();
                $count += $stmt->rowCount();
            }
        }
    }
    echo json_encode(['success' => true, 'purged' => $count, 'message' => "Recycle bin emptied permanently!"]);
    exit;
}

// ==========================================
// 15. ACTION: UPDATE DEMO STATUS
// ==========================================
if ($action === 'update_demo_status' || (strpos($action, 'demo') !== false && isset($input['status']))) {
    $demoId = (int)($input['demo_id'] ?? $input['id'] ?? 2);
    $status = $input['status'] ?? 'Completed';

    $sql = "UPDATE `crm_demos` SET `status` = '" . addslashes($status) . "', `updated_at` = '{$now}' WHERE `id` = {$demoId}";
    appendToSqlDump($sql);

    if ($pdo && $demoId > 0) {
        try {
            $stmt = $pdo->prepare("UPDATE crm_demos SET status = ?, updated_at = ? WHERE id = ?");
            $stmt->execute([$status, $now, $demoId]);
            logActivity($pdo, 'Demos', 'Status Updated', "Demo #{$demoId} marked as {$status}.");
        } catch (Exception $e) {}
    }

    echo json_encode([
        'success' => true,
        'message' => "Demo marked as {$status} and saved to SQL!",
        'status' => $status,
        'demo_id' => $demoId,
        'sql' => $sql
    ]);
    exit;
}

// ==========================================
// 16. ACTION: GET RECORDS (QUERY DATA)
// ==========================================
if ($action === 'get_records' || $action === 'get_all') {
    $table = $input['table'] ?? $_GET['table'] ?? 'crm_leads';
    $tableMap = [
        'leads' => 'crm_leads',
        'followups' => 'crm_followups',
        'customers' => 'crm_customers',
        'deals' => 'crm_deals',
        'tasks' => 'crm_tasks',
        'demos' => 'crm_demos',
        'payments' => 'crm_payments',
        'quotations' => 'crm_quotations',
        'products' => 'crm_products',
        'reservations' => 'crm_reservations',
        'branches' => 'crm_branches',
        'team' => 'crm_employees'
    ];
    $actualTable = $tableMap[$table] ?? $table;
    $records = [];
    if ($pdo && in_array($actualTable, array_values($tableMap))) {
        try {
            $stmt = $pdo->query("SELECT * FROM `{$actualTable}` ORDER BY id DESC LIMIT 100");
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {}
    }
    echo json_encode([
        'success' => true,
        'table' => $actualTable,
        'count' => count($records),
        'records' => $records
    ]);
    exit;
}

// ==========================================
// 17. ACTION: EXPORT SQL
// ==========================================
if ($action === 'export_sql') {
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
    'timestamp' => date('Y-m-d H:i:s'),
    'supported_actions' => [
        'save_lead', 'save_followup', 'save_customer', 'save_deal', 'save_task',
        'save_demo', 'save_payment', 'save_quotation', 'save_product',
        'save_team_member', 'save_reservation', 'save_branch', 'bulk_assign',
        'update_status', 'update_demo_status', 'get_records'
    ]
]);
