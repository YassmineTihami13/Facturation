<?php
// Inclure la connexion à la base de données
include '../BD/connexion.php'; 

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Aucun ID fourni.";
    exit();
}

$id = $_GET['id'];

// Requête pour récupérer les informations du client
$query = "SELECT * FROM client WHERE ID_Client = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// Vérifier si un client a été trouvé
$client = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$client) {
    echo "Aucun client trouvé avec cet ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client</title>
</head>
<body>
    <h1>Modifier les informations du client</h1>
    
    <form action="modifier_traitement_action.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['ID_Client']); ?>">
        
        <label for="nom">Nom:</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($client['Nom']); ?>" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($client['Prenom']); ?>" required><br><br>

        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" value="<?php echo htmlspecialchars($client['Adresse']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($client['Email']); ?>" required><br><br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
