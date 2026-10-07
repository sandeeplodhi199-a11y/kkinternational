<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $dbs = $pdo->query('SHOW DATABASES')->fetchAll(PDO::FETCH_COLUMN);
    echo "Databases in MySQL:\n" . implode("\n", $dbs) . "\n\n";

    if (in_array('hisabmittra_crm', $dbs)) {
        echo "Database 'hisabmittra_crm' exists!\n";
        $pdo->query('USE hisabmittra_crm');
        $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
        echo "Tables in hisabmittra_crm (" . count($tables) . "):\n" . implode(", ", $tables) . "\n";
    } else {
        echo "Database 'hisabmittra_crm' NOT found. Will create it if needed.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
