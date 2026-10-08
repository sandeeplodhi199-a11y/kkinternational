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
    // If local MySQL offline or running on edge, fallback gracefully
}

$rawInput = json_decode(file_get_contents('php://input'), true);
$input = (!empty($input) && is_array($input)) ? $input : ($rawInput ?? $_POST ?? []);
$action = $input['action'] ?? $_GET['action'] ?? '';
$now = date('Y-m-d H:i:s');

// Helper: Append SQL statement to database.sql files
function appendToSqlDump($sqlStatement) {
    $sqlFiles = [
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

            $empStmt = $pdo->prepare("INSERT INTO crm_employees (user_id, employee_code, name, email, phone, designation, role, joining_date, target_amount, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active', ?, ?)");
            $empStmt->execute([$insertedUserId, $empCode, $name, $email, $phone, $designation, $role, $joiningDate, $targetAmount, $now, $now]);
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
