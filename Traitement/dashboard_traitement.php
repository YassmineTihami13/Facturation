<?php
session_start();
include '../BD/connexion.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Si non connecté, rediriger vers la page de connexion
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenue, <?php echo $_SESSION['user_email']; ?></h1>
    <p>Vous êtes connecté avec succès.</p>

    <!-- Bouton pour ajouter un client, redirige maintenant vers Traitement/ajouter_client.php -->
    <form action="../Traitement/ajouter_client.php" method="get">
        <input type="submit" value="Ajouter un Client">
    </form>

    <!-- Formulaire de déconnexion -->
    <form action="../Traitement/logout.php" method="POST">
        <input type="submit" value="Se déconnecter">
    </form>
</body>
</html>