<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=hisabmittra_crm', 'root', '');
$cols = $pdo->query('SHOW COLUMNS FROM crm_leads')->fetchAll(PDO::FETCH_COLUMN);
echo "Existing cols: " . implode(', ', $cols) . PHP_EOL;

if (!in_array('city', $cols)) {
    $pdo->exec('ALTER TABLE crm_leads ADD COLUMN city VARCHAR(255) NULL AFTER phone');
    echo "Added city col\n";
}
if (!in_array('agent', $cols)) {
    $pdo->exec('ALTER TABLE crm_leads ADD COLUMN agent VARCHAR(255) NULL AFTER assigned_to');
    echo "Added agent col\n";
}
if (!in_array('basic', $cols)) {
    $pdo->exec('ALTER TABLE crm_leads ADD COLUMN basic DECIMAL(12,2) NULL DEFAULT 0.00 AFTER priority');
    echo "Added basic col\n";
}
if (!in_array('pro', $cols)) {
    $pdo->exec('ALTER TABLE crm_leads ADD COLUMN pro DECIMAL(12,2) NULL DEFAULT 0.00 AFTER basic');
    echo "Added pro col\n";
}
echo "Columns successfully upgraded in MySQL!\n";
