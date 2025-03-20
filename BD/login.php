<?php
// Inclure la connexion à la base de données
include('connexion.php');
function verifierConnexion($email, $mot_de_passe) {
    global $conn;

    $sql = "SELECT * FROM Client WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($mot_de_passe === $row['Mot_de_passe']) {
            return $row;
        }
    }
    return false;
}
?>