<?php
// Inclure la connexion à la base de données
include '../BD/connexion.php'; 

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Requête pour récupérer les informations du client
    $query = "SELECT * FROM client WHERE ID_Client = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Récupérer les données du client
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Vérifier si un client a été trouvé
    if (!$client) {
        echo "Aucun client trouvé avec cet ID.";
        exit();
    }
} else {
    echo "Aucun ID fourni.";
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
    
    <!-- Formulaire de modification avec les valeurs du client pré-remplies -->
    <form action="../Traitement/modifier_traitement_client.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $client['ID_Client']; ?>">

        <label for="nom">Nom:</label>
        <input type="text" name="nom" value="<?php echo $client['Nom']; ?>" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" value="<?php echo $client['Prenom']; ?>" required><br><br>

        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" value="<?php echo $client['Adresse']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $client['Email']; ?>" required><br><br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
