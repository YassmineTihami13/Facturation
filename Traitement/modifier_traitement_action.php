<?php
include '../BD/connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['email'])) {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $adresse = $_POST['adresse'];
        $email = $_POST['email'];

        $query = "UPDATE client SET Nom = :nom, Prenom = :prenom, Adresse = :adresse, Email = :email WHERE ID_Client = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo "Client mis à jour avec succès.";
            header("Location: ../IHM/dashboard.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
