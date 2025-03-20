<?php
session_start();
require_once '../IHM/Reclamation.php';
require_once '../BD/connexion.php';
require_once '../BD/gestionRec.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $description = $_POST['description'];
    $id_client = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Appeler la fonction pour insérer la réclamation
    if (insererReclamation($conn, $id_client, $type, $description)) {
        $success_message = "Votre réclamation a été soumise avec succès.";
    } else {
        $error_message = "Une erreur s'est produite lors de la soumission de votre réclamation.";
    }
}
?>
