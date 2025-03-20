<?php
// Démarre la session
session_start();

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil (index.php)
header("Location: ../index.php");
exit();
?>
