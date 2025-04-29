<?php
// 
// R-ID	username	uid	produkt	produktqualität	service	lieferung	sonstige anmerkungen	password	

session_start();
include('db.php'); // Verbindung zur Datenbank herstellen

$username = $_SESSION["username"];
$produkt = $_SESSION["produkt"];
$pr = $_SESSION["produktqualitaet"];
$service = $_SESSION["service"];
$lieferung = $_SESSION["lieferung"];
$sonstig = $_SESSION["sonstige_anmerkungen"];

// RID aus der DB holen

$pdo = new PDO("mysql:host=localhost;dbname=nido", "root", "");


$username = $_SESSION['username']; // oder aus einem Formular oder Login
$stmt = $pdo->prepare("SELECT uid FROM nido WHERE username = :username");
$stmt->execute(['username' => $username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$uid = $row['uid']; // Jetzt hast du die UID aus der DB





?>


<html>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deine Bewertung</title>
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
            margin-bottom: 20px;
        }

        .ausgabe-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: left;
        }

        .ausgabe-box p {
            font-size: 16px;
            margin: 10px 0;
        }

        .label {
            color: #d63384;
            font-weight: bold;
        }
    </style>
</head>
<body>


    <div class="ausgabe-box">

    <p><strong style="color: deeppink;">UID:</strong> <?php echo htmlspecialchars($uid); ?></p>

    <p><span class="label">UID:</span>  <?php echo $username ?></p>

        <p><span class="label">Username:</span>  <?php echo $username ?></p>
        <p><span class="label">Produkt: </span><?php echo $produkt ?></p>
        <p><span class="label">Produktqualität:</span> <?php echo $pr ?></p>
        <p><span class="label">Service:</span> <?php echo $service ?></p>
        <p><span class="label">Lieferung:</span><?php echo $lieferung ?></p>
        <p><span class="label">Sonstige Anmerkungen:</span> <?php echo $sonstig ?></p>
    </div>

</body>




</html>



