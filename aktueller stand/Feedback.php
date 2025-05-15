<?php
session_start();
include('db.php'); // Verbindung zur Datenbank

// Alle Feedbacks aus der Datenbank abrufen
$sql = "SELECT rid, username, produkt, produktqualitaet, service, lieferung, sonstige_anmerkungen FROM nido";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle Bewertungen</title>
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #d63384;
        }

        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }

        .ausgabe-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
            margin: 20px auto;
            width: 60%;
        }

        .ausgabe-box p {
            margin: 5px 0;
        }

        .label {
            font-weight: bold;
            color: #d63384;
        }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['username'])): ?>
    <h2>Bitte Passwort eingeben</h2>
    <form action="index.php" method="POST">
        <label for="passwort">Geben Sie ein Passwort ein:</label>
        <input type="password" name="p1" id="p1" required>
        <input type="submit" value="Einloggen">
    </form>
    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
<?php else: ?>
    <h1>Alle abgegebenen Feedbacks</h1>

    <?php
    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="ausgabe-box">';
            echo '<p><span class="label">Rezession-ID:</span> ' . htmlspecialchars($row["rid"]) . '</p>';
            echo '<p><span class="label">Username:</span> ' . htmlspecialchars($row["username"]) . '</p>';
            echo '<p><span class="label">Produkt:</span> ' . htmlspecialchars($row["produkt"]) . '</p>';
            echo '<p><span class="label">Produktqualität:</span> ' . htmlspecialchars($row["produktqualitaet"]) . '</p>';
            echo '<p><span class="label">Service:</span> ' . htmlspecialchars($row["service"]) . '</p>';
            echo '<p><span class="label">Lieferung:</span> ' . htmlspecialchars($row["lieferung"]) . '</p>';
            echo '<p><span class="label">Sonstige Anmerkungen:</span> ' . nl2br(htmlspecialchars($row["sonstige_anmerkungen"])) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>Keine Feedbacks gefunden.</p>";
    }

?>

<p style="margin-top: 60px; text-align: center;">
    <a href="Impressum.php" style="color: #d63384; text-decoration: none; font-weight: bold; font-size: 16px;">
        ➤ Zum Impressum
    </a>
</p>




<?php endif; ?>

</body>
</html>