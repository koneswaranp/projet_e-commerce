<?php
$dsn = 'mysql:dbname=ydays;host=localhost';
$user = 'root';
$password = '';
try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
?>