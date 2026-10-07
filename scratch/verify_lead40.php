<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=hisabmittra_crm', 'root', '');
$lead = $pdo->query('SELECT * FROM crm_leads ORDER BY id DESC LIMIT 1')->fetch(PDO::FETCH_ASSOC);
print_r($lead);
