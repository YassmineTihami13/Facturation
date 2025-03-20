<?php
session_start(); // Démarrer la session

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion après la déconnexion
header("Location: ../IHM/login.php");
exit();
?>
