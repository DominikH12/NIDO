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

        h2 {
            text-align: center;
            color: #d63384;
            text-align: left;
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

<div class="impressum">
        <h2>Impressum</h2>
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
