<?php
session_start();
include('db.php'); // Verbindung zur Datenbank einbinden

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $passwort = password_hash($_POST['passwort'], PASSWORD_DEFAULT); // Passwort hashen

    try {
        // SQL-Statement zum Einfügen der Benutzerdaten
        $stmt = $conn->prepare("INSERT INTO benutzer (username, passwort) VALUES (:username, :passwort)");

        // Parameter binden
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':passwort', $passwort);

        // SQL-Statement ausführen
        $stmt->execute();

        echo "Registrierung erfolgreich!";
    } catch (PDOException $e) {
        echo "Fehler: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
</head>
<body>
    <h2>Registriere dich</h2>
    <form action="register.php" method="POST">
        <label for="username">Benutzername:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="passwort">Passwort:</label>
        <input type="password" name="passwort" id="passwort" required><br><br>

        <button type="submit">Registrieren</button>
    </form>
</body>
</html>
