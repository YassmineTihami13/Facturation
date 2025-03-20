<?php
include '../BD/connexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer la requête SQL pour supprimer le client
    $sql = "DELETE FROM client WHERE ID_Client = ?";
    $stmt = $pdo->prepare($sql);
    
    // Exécuter la requête
    if ($stmt->execute([$id])) {
        echo "Client supprimé avec succès.";
        header("Location: ../IHM/dashboard.php"); // Rediriger après suppression
        exit();
    } else {
        echo "Erreur lors de la suppression : " . $stmt->errorInfo()[2];
    }
}
?>
