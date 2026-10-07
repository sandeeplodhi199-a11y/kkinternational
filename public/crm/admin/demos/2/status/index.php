<?php
// Handle demo status update directly
$status = $_POST['status'] ?? $_GET['status'] ?? 'Completed';
$demoId = 2;
$now = date('Y-m-d H:i:s');

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=hisabmittra_crm;charset=utf8mb4', 'root', '');
    $stmt = $pdo->prepare("UPDATE crm_demos SET status = ?, updated_at = ? WHERE id = ?");
    $stmt->execute([$status, $now, $demoId]);

    // Log
    $logStmt = $pdo->prepare("INSERT INTO crm_activity_logs (user_id, user_name, module, action, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $logStmt->execute([1, 'Admin', 'Demos', 'Status Updated', "Demo #{$demoId} marked as {$status}.", $now, $now]);
} catch(Exception $e) {}

// Return JSON if AJAX, else redirect
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'status' => $status]);
    exit;
}

header('Location: /crm/admin/demos');
exit;
