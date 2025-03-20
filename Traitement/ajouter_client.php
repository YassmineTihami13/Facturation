<?php
session_start();
include '../BD/connexion.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Si non connecté, rediriger vers la page de connexion
    exit();
}

// Gérer l'ajout d'un client
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $adresse = trim($_POST['adresse']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    // Vérification que les champs ne sont pas vides
    if (empty($nom) || empty($prenom) || empty($adresse) || empty($email) || empty($mot_de_passe)) {
        $error_message = "Tous les champs doivent être remplis.";
    } else {
        // Hash du mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Préparation de la requête SQL pour ajouter un client
        $sql = "INSERT INTO client (Nom, Prenom, Adresse, Email, Mot_de_passe) 
                VALUES (:nom, :prenom, :adresse, :email, :mot_de_passe)";
        $stmt = $pdo->prepare($sql);
        
        // Lier les paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);

        // Exécution de la requête
        if ($stmt->execute()) {
            $success_message = "Client ajouté avec succès !";
        } else {
            $error_message = "Erreur lors de l'ajout du client.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Client</title>
</head>
<body>
    <h1>Ajouter un Client</h1>
    <form method="POST" action="ajouter_client.php">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required><br><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" required><br><br>

        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" required><br><br>

        <label for="email">Email :</label>
        <input type="email" name="email" required><br><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" required><br><br>

        <input type="submit" value="Ajouter le client">
    </form>

    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    if (isset($success_message)) {
        echo "<p style='color: green;'>$success_message</p>";
    }
    ?>
    
    <!-- Lien pour retourner au Dashboard -->
    <a href="../IHM/dashboard.php">Retour au Dashboard</a>
</body>
</html>
