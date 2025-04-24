<?php
session_start();
include('db.php');  // Verbindung zur Datenbank einbinden

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Suche den Benutzer in der korrekten Tabelle 'benutzer'
        $stmt = $conn->prepare("SELECT * FROM benutzer WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Überprüfe, ob der Benutzer existiert und ob das Passwort korrekt ist
        if ($user && password_verify($password, $user['passwort'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");  // Automatische Weiterleitung
            exit;
        } else {
            echo "<p style='color: red;'>Falscher Benutzername oder falsches Passwort!</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Fehler: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Benutzername:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Passwort:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Einloggen</button>
    </form>

    <p>Du hast noch keinen Account? <a href="register.php">Registrierung</a></p>
</body>
</html>
