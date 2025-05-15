<?php
session_start();
include('db.php');  // Verbindung zur Datenbank einbinden

$meldung = "";

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
        $stmt = $conn->prepare("SELECT * FROM benutzer WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['passwort'])) {
            $_SESSION['username'] = $username;

            if (isset($_POST['remember'])) {
                setcookie('remember_me', $username, time() + (86400 * 30), "/"); // 30 Tage
            }

            header("Location: index.php");
            exit;
        } else {
            $meldung = "❌ Falscher Benutzername oder falsches Passwort!";
        }
    } catch (PDOException $e) {
        $meldung = "❌ Ein Fehler ist aufgetreten. Bitte versuche es später erneut.";
        // Optional: error_log($e->getMessage());
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
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ffc1cc, #e1bee7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 2rem 3rem;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #26a69a;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background-color: #00796b;
        }

        .link {
            text-align: center;
            margin-top: 1rem;
        }

        .link a {
            color: #00796b;
            text-decoration: none;
        }

        .meldung {
            text-align: center;
            margin-bottom: 1rem;
            font-weight: bold;
            color: #d32f2f;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($meldung)): ?>
            <div class="meldung">
                <?= $meldung ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="username">Benutzername:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Passwort:</label>
            <input type="password" name="password" id="password" required>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember" value="1">
                <label for="remember">Eingeloggt bleiben</label>
            </div>

            <button type="submit">Einloggen</button>
        </form>
        <div class="link">
            Du hast noch keinen Account? <a href="register.php">Registrieren</a>
        </div>
    </div>
</body>
</html>
