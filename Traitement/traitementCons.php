<?php
session_start();
require_once '../BD/connexion.php'; 
require_once '../BD/gestionConsommation.php';
require_once '../IHM/Consommation.php'; 

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des entrées
    $date_facture = htmlspecialchars($_POST['date'] ?? '');
    $consommation = floatval($_POST['consommation'] ?? 0);
    $photo = $_FILES['photo'] ?? null;

    // Vérification des champs obligatoires
    if (empty($date_facture) || $consommation <= 0 || !$photo) {
        echo "<p style='color: red;'>Veuillez remplir tous les champs correctement.</p>";
        exit();
    }

    // Vérification et traitement de l'image
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Vérification du type de fichier et de sa taille
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5 Mo

    if (!in_array($photo['type'], $allowed_types) || $photo['size'] > $max_size) {
        echo "<p style='color: red;'>Le fichier doit être une image (JPEG, PNG, GIF) et ne doit pas dépasser 5 Mo.</p>";
        exit();
    }

    $target_file = $target_dir . basename($photo["name"]);
    if (!move_uploaded_file($photo["tmp_name"], $target_file)) {
        echo "<p style='color: red;'>Erreur lors du téléversement de l'image.</p>";
        exit();
    }

    // Récupération du tarif selon la consommation
    $tarif = getTarif($conn, $consommation);

    if (!$tarif) {
        echo "<p style='color: red;'>Aucun tarif trouvé pour cette consommation.</p>";
        exit();
    }

    // Calcul du prix
    $prix_ht = $consommation * $tarif;
    $taux_tva = 0.20;
    $prix_ttc = $prix_ht * (1 + $taux_tva);

    // Insertion des données dans la table facture
    $success = insertFacture($conn, $date_facture, $consommation, $prix_ht, $prix_ttc, $target_file);

    if ($success) {
        echo "<p style='color: green;'>Facture générée et enregistrée avec succès.</p>";
    } else {
        echo "<p style='color: red;'>Erreur lors de l'enregistrement de la facture.</p>";
    }
}
?>