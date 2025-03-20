<?php
session_start();
include '../BD/connexion.php';

// Vérifier si le paramètre 'id' est présent dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de la facture non valide ou absent.");
}

$id_facture = $_GET['id'];

// Utiliser une requête préparée pour éviter les injections SQL
$sql = "SELECT * FROM facture WHERE ID_Facture = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_facture); // Bind le paramètre pour éviter l'injection
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si la facture existe
if ($result->num_rows === 0) {
    die("Facture non trouvée.");
}

$facture = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
  <link rel="shortcut icon" type="image/jpg" href="img/icon_bell.png"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Karla:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  <title>Paiement de la Facture</title>
  <style>
    body {
      display: flex;
      flex-flow: row nowrap;
      align-items: center;
      justify-content: center;
      font-family: "Karla";
    }

    h1 {
      font-family: "Josefin Sans", sans-serif;
    }

    #main {
      display: flex;
      justify-content: space-between;
      width: 80%;
      margin-top: 20px;
    }

    #left, #right {
      width: 48%;
    }

    label, input, select {
      display: block;
      margin-bottom: 10px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

  </style>
</head>
<body>
  <main id="main">
    <section id="left">
      <h1>Résumé de la Facture</h1>
      <h3>Veuillez vérifier que tout est correct !</h3>
      <p><b>ID Facture:</b> <?php echo htmlspecialchars($facture['ID_Facture']); ?></p>
      <p><b>Date:</b> <?php echo htmlspecialchars($facture['Date_Facture']); ?></p>
      <p><b>Consommation:</b> <?php echo htmlspecialchars($facture['Consommation']); ?> kWh</p>
      <p><b>Montant HT:</b> <?php echo htmlspecialchars($facture['Montant_HT']); ?> MAD</p>
      <p><b>Montant TTC:</b> <?php echo htmlspecialchars($facture['Montant_TTC']); ?> MAD</p>
    </section>
    <section id="right">
      <form method="POST" action="../Traitement/traitement_paiement.php">
        <label for="cc-number">Numéro de carte :</label>
        <input type="text" name="cc-number" id="cc-number" maxlength="16" placeholder="1111 2222 3333 4444" required>

        <label for="expiry-month">Date d'expiration :</label>
        <div id="date-val">
          <select name="ex_month" id="expiry-month" required>
            <option value="" selected="selected" disabled>Mois</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
          <select name="ex_year" id="expiry-year" required>
            <option value="" selected="selected" disabled>Année</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
          </select>
        </div>

        <label for="sec-code">Code de sécurité (CVV) :</label>
        <input type="password" name="cvv" id="sec-code" maxlength="3" placeholder="123" required>

        <input type="submit" name="submit" value="Payer la Facture">
      </form>
    </section>
  </main>
</body>
</html>
