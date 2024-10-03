<?php
include 'database.php';

$pdo = $database->connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Optional: Insert example data (run this only once)s
$exampleData = [
    "INSERT INTO recipient (email, password, usertype) VALUES ('scholar1', 'password1', 'scholar') ON DUPLICATE KEY UPDATE email=email",
    "INSERT INTO employees (email, password, usertype) VALUES ('employee1', 'password1', 'employee') ON DUPLICATE KEY UPDATE email=email",
    "INSERT INTO admin_login (username, password, usertype) VALUES ('admin1', 'password1', 'admin') ON DUPLICATE KEY UPDATE username=username"
];

foreach ($exampleData as $sql) {
    $pdo->exec($sql);
}

echo "Data insertion completed.";
