<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=hisabmittra_crm', 'root', '');
$cols = $pdo->query('DESCRIBE crm_leads')->fetchAll(PDO::FETCH_ASSOC);
echo "crm_leads columns:\n";
foreach ($cols as $c) {
    echo "- " . $c['Field'] . " (" . $c['Type'] . ", Null: " . $c['Null'] . ", Default: " . ($c['Default'] ?? 'none') . ")\n";
}
