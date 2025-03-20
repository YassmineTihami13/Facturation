<?php
try {
    // Connexion à la base de données avec un mot de passe pour l'utilisateur root
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_factures', 'root', 'imane2002');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
?>
