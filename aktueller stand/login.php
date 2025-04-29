<?php
session_start();
include('db.php');  // Verbindung zur Datenbank einbinden

// Automatisches Einloggen über Cookie
if (!isset($_SESSION['username']) && isset($_COOKIE['remember_me'])) {
    $_SESSION['username'] = $_COOKIE['remember_me'];
    header("Location: index.php");
    exit;
}

// Wenn Formular gesendet wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Benutzer aus Datenbank holen
        $stmt = $conn->prepare("SELECT * FROM benutzer WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prüfen ob Benutzer gefunden und Passwort korrekt
        if ($user && password_verify($password, $user['passwort'])) {
            $_SESSION['username'] = $username;

            if (isset($_POST['remember'])) {
                // Cookie für 30 Tage setzen
                setcookie('remember_me', $username, time() + (86400 * 30), "/");
            }

            header("Location: index.php");
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

        <label>
    <input type="checkbox" name="remember" value="1"> Eingeloggt bleiben
        </label>

    </form> 

    <p>Du hast noch keinen Account? <a href="register.php">Registrierung</a></p>
</body>
</html>
