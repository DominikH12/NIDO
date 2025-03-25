<?php
session_start();
include('db.php'); // Verbindung zur Datenbank herstellen

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['name1'];
    $produkt = $_POST['produkt'];
    $produktqualität = $_POST['produkt_bewertung'];
    $service = $_POST['service_bewertung'];
    $lieferung = $_POST['lieferung_bewertung'];
    $sonstige_anmerkungen = $_POST['sonstige_anmerkungen'];

    try {
        // SQL-Anweisung vorbereiten
        $stmt = $conn->prepare("INSERT INTO nido (username, produkt, produktqualität, service, lieferung, sonstige_anmerkungen) 
        VALUES (:username, :produkt, :produktqualität, :service, :lieferung, :sonstige_anmerkungen)");

        // Parameter binden
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':produkt', $produkt);
        $stmt->bindParam(':produktqualität', $produktqualität);
        $stmt->bindParam(':service', $service);
        $stmt->bindParam(':lieferung', $lieferung);
        $stmt->bindParam(':sonstige_anmerkungen', $sonstige_anmerkungen);

        // SQL ausführen
        $stmt->execute();
        $message = "Daten erfolgreich gespeichert!";
    } catch (PDOException $e) {
        $message = "Fehler: " . $e->getMessage();
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

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 24px;
            cursor: pointer;
            color: gray;
        }

        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            color: gold;
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

    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

    <form action="index.php" method="POST">
        <label for="name1">Username:</label>
        <input type="text" id="name1" name="name1" required>

        <label for="produkt">Wähle ein Produkt:</label>
        <select id="produkt" name="produkt" required>
            <option value="" disabled selected>Bitte wählen...</option>
            <option value="fanta_strawberry_kiwi">Fanta Strawberry & Kiwi</option>
            <option value="haribo_goldbaeren">Haribo Goldbären</option>
            <option value="jana_eistee">Jana Eistee</option>
            <option value="reeses_minis">Reese's Minis</option>
            <option value="haribo_saure_tuete">Haribo Saure Tüte</option>
            <option value="warheads_extreme_sour">Warheads Extreme Sour</option>
        </select>

        <label>Produktqualität:</label>
        <div class="rating">
            <input type="radio" id="produkt5" name="produkt_bewertung" value="5"><label for="produkt5">★</label>
            <input type="radio" id="produkt4" name="produkt_bewertung" value="4"><label for="produkt4">★</label>
            <input type="radio" id="produkt3" name="produkt_bewertung" value="3"><label for="produkt3">★</label>
            <input type="radio" id="produkt2" name="produkt_bewertung" value="2"><label for="produkt2">★</label>
            <input type="radio" id="produkt1" name="produkt_bewertung" value="1"><label for="produkt1">★</label>
        </div>

        <label>Service:</label>
        <div class="rating">
            <input type="radio" id="service5" name="service_bewertung" value="5"><label for="service5">★</label>
            <input type="radio" id="service4" name="service_bewertung" value="4"><label for="service4">★</label>
            <input type="radio" id="service3" name="service_bewertung" value="3"><label for="service3">★</label>
            <input type="radio" id="service2" name="service_bewertung" value="2"><label for="service2">★</label>
            <input type="radio" id="service1" name="service_bewertung" value="1"><label for="service1">★</label>
        </div>

        <label>Lieferung:</label>
        <div class="rating">
            <input type="radio" id="lieferung5" name="lieferung_bewertung" value="5"><label for="lieferung5">★</label>
            <input type="radio" id="lieferung4" name="lieferung_bewertung" value="4"><label for="lieferung4">★</label>
            <input type="radio" id="lieferung3" name="lieferung_bewertung" value="3"><label for="lieferung3">★</label>
            <input type="radio" id="lieferung2" name="lieferung_bewertung" value="2"><label for="lieferung2">★</label>
            <input type="radio" id="lieferung1" name="lieferung_bewertung" value="1"><label for="lieferung1">★</label>
        </div>

        <label for="sonstige_anmerkungen">Sonstige Anmerkungen:</label>
        <textarea id="sonstige_anmerkungen" name="sonstige_anmerkungen"></textarea>

        <button type="submit">Absenden</button>
    </form>

</body>
</html>
