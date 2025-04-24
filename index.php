<?php
session_start();
include('db.php'); // Verbindung zur Datenbank herstellen

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['username'] = $_POST['name1'];
    $_SESSION['produkt'] = $_POST['produkt'];
    $_SESSION['produktqualitaet'] = $_POST['produkt_bewertung'];
    $_SESSION['service'] = $_POST['service_bewertung'];
    $_SESSION['lieferung'] = $_POST['lieferung_bewertung'];
    $_SESSION['sonstige_anmerkungen'] = $_POST['sonstige_anmerkungen'];

    try {
        // SQL-Anweisung vorbereiten
        $stmt = $conn->prepare("INSERT INTO nido (username, produkt, produktqualitaet, lieferung, sonstige_anmerkungen) 
        VALUES (:username, :produkt, :produktqualitaet, :lieferung, :sonstige_anmerkungen)");

        // Parameter binden
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->bindParam(':produkt', $_SESSION['produkt']);
        $stmt->bindParam(':produktqualität', $_SESSION['produktqualitaet']);
     //   $stmt->bindParam(':service', $_SESSION['service']);
        $stmt->bindParam(':lieferung', $_SESSION['lieferung']);
        $stmt->bindParam(':sonstige_anmerkungen', $_SESSION['sonstige_anmerkungen']);

        // SQL ausführen
        $stmt->execute();
        $_SESSION['message'] = "Daten erfolgreich gespeichert!";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Fehler: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formular</title>
    <style>
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            color: #d63384;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #d63384;
        }

        input, select, textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #d63384;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        button {
            margin-top: 10px;
            padding: 10px 15px;
            border: none;
            background-color: #d63384;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #b12a6d;
        }

        .message {
            margin-top: 15px;
            font-size: 16px;
            color: green;
        }
    </style>
</head>
<body>

    <h2>Persönliche Daten</h2>

    <?php 
    if (!empty($_SESSION['message'])) {
        echo "<p class='message'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']); // Löscht die Nachricht nach dem Anzeigen
    }
    ?>

    <form action="index.php" method="POST">
        <label for="name1">Username:</label>
        <input type="text" id="name1" name="name1" value="<?= $_SESSION['username'] ?? '' ?>" required>

        <label for="produkt">Wähle ein Produkt:</label>
        <select id="produkt" name="produkt" required>
            <option value="" disabled <?= !isset($_SESSION['produkt']) ? 'selected' : '' ?>>Bitte wählen...</option>
            <option value="fanta_strawberry_kiwi" <?= ($_SESSION['produkt'] ?? '') == 'fanta_strawberry_kiwi' ? 'selected' : '' ?>>Fanta Strawberry & Kiwi</option>
            <option value="haribo_goldbaeren" <?= ($_SESSION['produkt'] ?? '') == 'haribo_goldbaeren' ? 'selected' : '' ?>>Haribo Goldbären</option>
            <option value="jana_eistee" <?= ($_SESSION['produkt'] ?? '') == 'jana_eistee' ? 'selected' : '' ?>>Jana Eistee</option>
            <option value="reeses_minis" <?= ($_SESSION['produkt'] ?? '') == 'reeses_minis' ? 'selected' : '' ?>>Reese's Minis</option>
            <option value="haribo_saure_tuete" <?= ($_SESSION['produkt'] ?? '') == 'haribo_saure_tuete' ? 'selected' : '' ?>>Haribo Saure Tüte</option>
            <option value="warheads_extreme_sour" <?= ($_SESSION['produkt'] ?? '') == 'warheads_extreme_sour' ? 'selected' : '' ?>>Warheads Extreme Sour</option>
        </select>

        <label for="produkt_bewertung">Produktqualität:</label>
        <input type="number" id="produkt_bewertung" name="produkt_bewertung" min="1" max="5" value="<?= $_SESSION['produktqualität'] ?? '' ?>" required>

        <label for="service_bewertung">Service:</label>
        <input type="number" id="service_bewertung" name="service_bewertung" min="1" max="5" value="<?= $_SESSION['service'] ?? '' ?>" required>

        <label for="lieferung_bewertung">Lieferung:</label>
        <input type="number" id="lieferung_bewertung" name="lieferung_bewertung" min="1" max="5" value="<?= $_SESSION['lieferung'] ?? '' ?>" required>

        <label for="sonstige_anmerkungen">Sonstige Anmerkungen:</label>
        <textarea id="sonstige_anmerkungen" name="sonstige_anmerkungen"><?= $_SESSION['sonstige_anmerkungen'] ?? '' ?></textarea>

        <button type="submit">Absenden</button>
    </form>

</body>
</html>
