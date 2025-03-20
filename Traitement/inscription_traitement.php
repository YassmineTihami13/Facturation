<?php
session_start();

// Inclure la connexion à la base de données
require_once('../BD/connexion.php'); 

// Vérifier si les données du formulaire sont envoyées
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'];

    // Vérifier si les mots de passe correspondent
    if ($mot_de_passe != $confirm_mot_de_passe) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        header("Location: ../IHM/login.php");
        exit();
    }

    // Hacher le mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT * FROM fournisseur WHERE Email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $fournisseur = $stmt->fetch();

    if ($fournisseur) {
        $_SESSION['error'] = "Cet email est déjà utilisé.";
        header("Location: ../IHM/login.php");
        exit();
    }

    try {
        // Insérer le fournisseur dans la base de données
        $stmt = $pdo->prepare("INSERT INTO fournisseur (Nom, Prenom, Email, Mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hache);

        if ($stmt->execute()) {
            // Message de succès dans la session
            $_SESSION['success'] = "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";
            // Rediriger vers la page de connexion
            header("Location: ../IHM/login.php");
            exit();
        } else {
            $_SESSION['error'] = "Une erreur est survenue. Veuillez réessayer.";
            header("Location: ../IHM/login.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur : " . $e->getMessage();
        header("Location: ../IHM/login.php");
        exit();
    }
}
?>
