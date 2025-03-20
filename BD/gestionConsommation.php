<?php
function getTarif($conn, $consommation) {
    $stmt_tarif = $conn->prepare("SELECT Prix_KWH FROM tarification WHERE ? BETWEEN Seuil_Min AND Seuil_Max LIMIT 1");
    $stmt_tarif->bind_param("d", $consommation);
    $stmt_tarif->execute();
    $result = $stmt_tarif->get_result();
    $tarif_row = $result->fetch_assoc();

    return $tarif_row ? $tarif_row['Prix_KWH'] : null;
}

function insertFacture($conn, $date_facture, $consommation, $prix_ht, $prix_ttc, $photo) {
    $sql = "INSERT INTO facture (ID_Client, Date_Facture, Consommation, Montant_HT, Montant_TTC, Photo_Compteur) 
            VALUES (1, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddds", $date_facture, $consommation, $prix_ht, $prix_ttc, $photo);

    return $stmt->execute();
}
?>