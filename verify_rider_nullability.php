<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=wheninba_MercifulGod', 'root', '');
    $stmt = $pdo->query("SELECT IS_NULLABLE, COLUMN_DEFAULT FROM information_schema.columns WHERE table_schema = 'wheninba_MercifulGod' AND table_name = 'fm_delivery_breakdowns' AND column_name = 'rider'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row, JSON_UNESCAPED_UNICODE) . PHP_EOL;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
