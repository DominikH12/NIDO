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
    $_SESSION["username"] = $_POST['username'];
    $_SESSION["passwort"] = $_POST['password'];

    try {
        // Benutzer aus Datenbank holen
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION["username"]);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prüfen ob Benutzer gefunden und Passwort korrekt
        if ($user && password_verify($_SESSION["passwort"], $user['passwort'])) {
            $_SESSION['username'] = $_SESSION["username"];

            if (isset($_POST['remember'])) {
                // Cookie setzen
                setcookie('remember_me', $_SESSION["username"], time() + (60 * 10), "/");
            }

            // Links nach erfolgreichem Login anzeigen
            echo '<a href="Feedback.php">Gehe zur Admin-Seite</a>' . "<br>";
            echo "<br>";
            echo '<a href="index.php">Gehe zur Zielseite</a>' . "<br>";
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
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .remember {
            margin-bottom: 10px;
        }

        .error-message {
            color: red;
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Login (ADMIN)</h2>
    <form action="login_a.php" method="POST">
        <label for="username">Benutzername:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Passwort:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Einloggen</button>

        <div class="remember">
            <label>
                <input type="checkbox" name="remember" value="1"> Eingeloggt bleiben
            </label>
        </div>

        <p>Du hast noch keinen Account? <a href="register_a.php">Registrierung</a></p>
    </form> 
</body>
</html>