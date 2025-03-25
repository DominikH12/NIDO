<?php
$servername = "localhost";
$username = "root";
$password = "";  // Wenn ein Passwort vorhanden ist, hier eintragen
$dbname = "nido";

try {
    // PDO-Verbindung zu MySQL
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Setze den Fehlermodus auf Exception, um Fehler zu fangen
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Verbindung fehlgeschlagen: " . $e->getMessage();
}
?>
