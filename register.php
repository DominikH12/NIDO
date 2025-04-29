<?php
session_start();
include('db.php'); // Verbindung zur Datenbank einbinden

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $passwort = $_POST['passwort'];
    $passwort_bestaetigung = $_POST['passwort_bestaetigung'];

    // Überprüfen, ob die Passwörter übereinstimmen
    if ($passwort !== $passwort_bestaetigung) {
        $meldung = "❌ Die Passwörter stimmen nicht überein.";
    } else {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT); // Passwort hashen

        try {
            $stmt = $conn->prepare("INSERT INTO benutzer (username, passwort) VALUES (:username, :passwort)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':passwort', $passwort_hash);
            $stmt->execute();

            $meldung = "✅ Registrierung erfolgreich!";
        } catch (PDOException $e) {
            $meldung = "Fehler: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
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

        input {
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
            color: #d32f2f;
            font-weight: bold;
        }

        .meldung.success {
            color: #388e3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registriere dich</h2>
        <?php if (!empty($meldung)): ?>
            <div class="meldung <?= strpos($meldung, 'erfolgreich') !== false ? 'success' : '' ?>">
                <?= htmlspecialchars($meldung) ?>
            </div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <label for="username">Benutzername:</label>
            <input type="text" name="username" id="username" required>

            <label for="passwort">Passwort:</label>
            <input type="password" name="passwort" id="passwort" required>

            <label for="passwort_bestaetigung">Passwort bestätigen:</label>
            <input type="password" name="passwort_bestaetigung" id="passwort_bestaetigung" required>

            <button type="submit">Registrieren</button>
        </form>
        <div class="link">
            Bereits registriert? <a href="login.php">Hier einloggen</a>
        </div>
    </div>
</body>
</html>
