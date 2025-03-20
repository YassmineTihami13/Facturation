<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
echo "Session démarrée<br>";

$userId = $_SESSION['client_id'];
// Vérification de la session
if (!isset($_SESSION['client_id'])) {
    die("Erreur : utilisateur non connecté.");
}

echo "Utilisateur connecté: " . $userId . "<br>";

include('../BD/connexion.php');
echo "Connexion BD incluse<br>";

// Vérification de l'ID de facture
if (!isset($_GET['id'])) {
    die("Erreur : ID de facture non spécifié.");
}
$facture_id = intval($_GET['id']);

// Récupération des données de la facture
$sql = "SELECT f.*, c.Nom, c.Prenom, c.Adresse, c.Email, f.Photo_Compteur 
        FROM facture f
        JOIN client c ON f.ID_Client = c.ID_Client
        WHERE f.ID_Facture = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $facture_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Erreur : Facture non trouvée.");
}

$facture = $result->fetch_assoc();
$photo_compteur = $facture['Photo_Compteur'] ?? null;

// Récupération du prix unitaire
$sql_tarif = "SELECT Prix_KWH FROM tarification 
              WHERE Seuil_Min <= ? AND Seuil_Max >= ?";
$stmt_tarif = $conn->prepare($sql_tarif);
$stmt_tarif->bind_param("dd", $facture['Consommation'], $facture['Consommation']);
$stmt_tarif->execute();
$result_tarif = $stmt_tarif->get_result();

if ($result_tarif->num_rows === 0) {
    die("Erreur : Tarif non trouvé.");
}

$tarif = $result_tarif->fetch_assoc();
$prix_unitaire = $tarif['Prix_KWH'];

// Mise à jour des montants
if (empty($facture['Montant_HT'])) {
    $facture['Montant_HT'] = $facture['Consommation'] * $prix_unitaire;
    $update_sql = "UPDATE facture SET Montant_HT = ? WHERE ID_Facture = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("di", $facture['Montant_HT'], $facture_id);
    $update_stmt->execute();
}

if (empty($facture['Montant_TTC'])) {
    $tva = $facture['Montant_HT'] * 0.20;
    $facture['Montant_TTC'] = $facture['Montant_HT'] + $tva;
    $update_sql = "UPDATE facture SET Montant_TTC = ? WHERE ID_Facture = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("di", $facture['Montant_TTC'], $facture_id);
    $update_stmt->execute();
}

// Calcul de la date limite de paiement
$date_facture = new DateTime($facture['Date_Facture']);
$date_facture->add(new DateInterval('P30D'));
$date_limite_paiement = $date_facture->format('d/m/Y');

// Calcul de la période de consommation basée sur la date de facturation
$date_debut = clone $date_facture; 
$date_debut->sub(new DateInterval('P1M')); // Un mois avant la date de facturation
$periode_debut = $date_debut->format('d/m/Y');
$periode_fin = $date_facture->format('d/m/Y');
$periode_consommation = "Du $periode_debut au $periode_fin"; // Période de consommation

// Génération du PDF
$template = file_get_contents('template.html');
$photo_html = $photo_compteur;

$replacements = [
    '{{ID_Facture}}' => htmlspecialchars($facture['ID_Facture']),
    '{{Nom}}' => htmlspecialchars($facture['Nom']),
    '{{Prenom}}' => htmlspecialchars($facture['Prenom']),
    '{{Adresse}}' => htmlspecialchars($facture['Adresse']),
    '{{Numero_Compteur}}' => '789456123',
    '{{Montant_TTC}}' => number_format($facture['Montant_TTC'], 2, ',', ' '),
    '{{Date_Facture}}' => htmlspecialchars($facture['Date_Facture']),
    '{{Date_Limite_Paiement}}' => htmlspecialchars($date_limite_paiement),
    '{{Consommation}}' => htmlspecialchars($facture['Consommation']),
    '{{Prix_Unitaire}}' => number_format($prix_unitaire, 2, ',', ' '),
    '{{Montant_HT}}' => number_format($facture['Montant_HT'], 2, ',', ' '),
    '{{TVA}}' => number_format($facture['Montant_TTC'] - $facture['Montant_HT'], 2, ',', ' '),
    '{{Photo_Compteur}}' => $photo_html,
    '{{Periode_Consommation}}' => htmlspecialchars($periode_consommation) // Période calculée
];

$html = str_replace(array_keys($replacements), array_values($replacements), $template);

require __DIR__ . "/vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('chroot', __DIR__);
$options->set('isRemoteEnabled', true);

$pdf = new Dompdf($options);
$pdf->loadHtml($html);
$pdf->render();

$factureDir = 'factures';
if (!is_dir($factureDir)) {
    mkdir($factureDir, 0777, true);
}

$pdfPath = $factureDir . '/' . $facture_id . '_facture.pdf';
file_put_contents($pdfPath, $pdf->output());

$query = "UPDATE facture SET pdf_path = ? WHERE ID_Facture = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $pdfPath, $facture_id);
$stmt->execute();

header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=" . $facture_id . "_facture.pdf");
echo $pdf->output();
?>
