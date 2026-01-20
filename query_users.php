<?php
$pdo = new PDO('mysql:host=localhost;dbname=adakamar', 'root', '');
$stmt = $pdo->query('SELECT id, name, email, role FROM users');
echo "=== ALL USERS IN DATABASE ===\n";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . $row['id'] . " | Name: " . $row['name'] . " | Email: " . $row['email'] . " | Role: " . $row['role'] . "\n";
}
?>