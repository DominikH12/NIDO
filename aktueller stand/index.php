<?php
session_start();
include('db.php'); // Verbindung zur Datenbank herstellen

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username'] ?? $_POST['name1'];

    $produkt = $_POST['produkt'];
    $produktqualitaet = $_POST['produkt_bewertung'];
    $service = $_POST['service_bewertung'];
    $lieferung = $_POST['lieferung_bewertung'];
    $sonstige_anmerkungen = $_POST['sonstige_anmerkungen'];

    try {
        $stmt = $conn->prepare("INSERT INTO nido (username, produkt, produktqualitaet, service, lieferung, sonstige_anmerkungen) 
        VALUES (:username, :produkt, :produktqualitaet, :service, :lieferung, :sonstige_anmerkungen)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':produkt', $produkt);
        $stmt->bindParam(':produktqualitaet', $produktqualitaet);
        $stmt->bindParam(':service', $service);
        $stmt->bindParam(':lieferung', $lieferung);
        $stmt->bindParam(':sonstige_anmerkungen', $sonstige_anmerkungen);

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
    <title>Produktbewertung</title>
    <style>
        body {
            background: linear-gradient(to right, #ffe6e6, #ffe0f7);
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 80px 40px 40px 40px;
        }

        h2 {
            color: #d63384;
        }

        form {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 3px 3px 12px rgba(0, 0, 0, 0.1);
            width: 320px;
        }

        label {
            font-size: 15px;
            margin-bottom: 5px;
            color: #d63384;
            display: block;
            text-align: left;
        }

        input, select, textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #d63384;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 12px;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
            gap: 5px;
            margin-bottom: 12px;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 22px;
            cursor: pointer;
            color: gray;
        }

        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            color: gold;
        }

        button {
            padding: 10px 15px;
            border: none;
            background-color: #d63384;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #b12a6d;
        }

        .message {
            margin-top: 15px;
            font-size: 16px;
            color: green;
        }

        .impressum {
            max-width: 700px;
            margin-top: 80px;
            align-self: flex-start;
        }

        .impressum h1 {
            margin-bottom: 15px;
            color: #333;
        }

        .impressum p {
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <h2>Produktbewertung</h2>

    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

    <form action="index.php" method="POST">
        <?php if (!isset($_SESSION['username'])): ?>
            <label for="name1">Username:</label>
            <input type="text" id="name1" name="name1" required>
        <?php endif; ?>

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
        <!-- <p><a href="Feedback.php">Weiter zu den Feedbacks</a></p> -->
        
        <p>Willst du die Admin-Seite sehen? </p>
        <p>Logge dich hier als Admin ein</p>
        <a href="login_a.php">Admin-login</a>

    </form>

    <div class="impressum">
        <h1>Impressum</h1>
        <p><strong>Medieninhaber und verantwortlich für den Inhalt:</strong><br>
        Dominik Hartlieb<br>
        Musterstraße 12<br>
        1234 Musterstadt<br>
        Österreich</p>

        <p><strong>Kontakt:</strong><br>
        E-Mail: dominik@example.com<br>
        Telefon: +43 123 456789</p>
    </div>

</body>
</html>