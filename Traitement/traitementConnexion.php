<?php
session_start();
include('../BD/login.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $user = verifierConnexion($email, $mot_de_passe);

    if ($user) {
        // Récupération des informations de l'utilisateur
        $_SESSION['client_id'] = $user['ID_Client'];
        $_SESSION['nom'] = $user['Nom'];
        $_SESSION['prenom'] = $user['Prenom'];
        // Redirection vers la page des factures après la connexion
        header("Location: traitementDashboard.php");
        exit();
    } else {
        $error_message = "Email ou mot de passe incorrect.";
        echo $error_message;
    }
}
?>