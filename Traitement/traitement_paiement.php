<?php
session_start();
include '../BD/connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID de la facture depuis l'URL
    $id_facture = isset($_GET['id']) ? $_GET['id'] : null;

    // Vérification de l'ID de la facture
    if ($id_facture === null || !is_numeric($id_facture)) {
        die("ID de la facture invalide.");
    }

    $numero_carte = $_POST['cc-number'];
    $expiry_month = $_POST['ex_month'];
    $expiry_year = $_POST['ex_year'];
    $date_expiration = $expiry_month . '/' . $expiry_year; // Format MM/AA
    $cvv = $_POST['cvv'];

    // Récupérer le montant de la facture depuis la base de données de manière sécurisée
    $sql_facture = "SELECT Montant_TTC FROM facture WHERE ID_Facture = ?";
    $stmt_facture = $conn->prepare($sql_facture);
    $stmt_facture->bind_param("i", $id_facture); // Bind l'ID pour éviter l'injection
    $stmt_facture->execute();
    $result_facture = $stmt_facture->get_result();

    if ($result_facture->num_rows === 0) {
        die("Facture non trouvée.");
    }

    $facture = $result_facture->fetch_assoc();
    $montant = $facture['Montant_TTC'];

    // Insérer les données dans la table paiements
    $sql = "INSERT INTO paiements (id_facture, montant, numero_carte, date_expiration, cvv, statut)
            VALUES (?, ?, ?, ?, ?, 'Réussi')";
    $stmt = $conn->prepare($sql);

    // Bind des paramètres en tenant compte des types
    // "i" pour l'ID de la facture, "d" pour le montant (DECIMAL), "s" pour les autres (string)
    $stmt->bind_param("idsss", $id_facture, $montant, $numero_carte, $date_expiration, $cvv);

    // Essayer d'exécuter la requête d'insertion
    if ($stmt->execute()) {
        echo "Paiement effectué avec succès !";

        // Mettre à jour le statut de la facture
        $sql_update = "UPDATE facture SET statut = 'Payée' WHERE ID_Facture = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $id_facture);
        if ($stmt_update->execute()) {
            echo " Statut de la facture mis à jour.";
        } else {
            echo " Erreur lors de la mise à jour du statut de la facture.";
        }
    } else {
        echo "Erreur lors du paiement : " . $stmt->error;
    }

    // Fermeture des préparations
    $stmt->close();
    $stmt_facture->close();
    $conn->close();
}
?>
