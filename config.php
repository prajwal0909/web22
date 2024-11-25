<?php
$host = 'sql104.infinityfree.com';  // Database host
$dbname = 'if0_37782894_website';  // Database name
$username = 'if0_37782894';   // Database username
$password = 'aJhp87YY93bU0';       // Database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
