<?php
session_start();
include '../BD/connexion.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirection si non connecté
    exit();
}

// Récupérer l'email de l'utilisateur connecté
$user_email = $_SESSION['user_email'];

// Récupérer la liste des clients
$sqlClients = "SELECT * FROM client";
$stmtClients = $pdo->prepare($sqlClients);
$stmtClients->execute();
$clients = $stmtClients->fetchAll(PDO::FETCH_ASSOC);

// Récupérer la liste des réclamations
$sqlReclamations = "SELECT r.ID_Reclamation, c.Nom, c.Prenom, r.Type, r.Description, r.Statut, r.Date_Reclamation 
                    FROM reclamation r 
                    JOIN client c ON r.ID_Client = c.ID_Client";
$stmtReclamations = $pdo->prepare($sqlReclamations);
$stmtReclamations->execute();
$reclamations = $stmtReclamations->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Intégration de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border-radius: 10px;
        }
        .btn-action {
            margin-right: 5px;
        }
        .status-actif {
            color: green;
            font-weight: bold;
        }
        .status-en-attente {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Bienvenue, <?php echo htmlspecialchars($user_email); ?>!</h1>
        
        <div class="d-flex justify-content-between">
            <h2>Gestion des Clients</h2>
            <a href="../Traitement/ajouter_client.php" class="btn btn-primary">Ajouter un Client</a>
        </div>

        <ul class="nav nav-tabs mt-3">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#clients">Liste des Clients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#reclamations">Réclamations</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Liste des Clients -->
            <div class="tab-pane fade show active" id="clients">
                <div class="card p-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>N° Client</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Adresse</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($clients) > 0) {
                                foreach ($clients as $client) {
                                    echo "<tr>
                                            <td>CLI-00{$client['ID_Client']}</td>
                                            <td>{$client['Nom']} {$client['Prenom']}</td>
                                            <td>{$client['Email']}</td>
                                            <td>{$client['Adresse']}</td>
                                            <td>
                                                <a href='../Traitement/modifier_traitement_client.php?id={$client['ID_Client']}' class='btn btn-warning btn-sm btn-action'>Modifier</a>
                                                <a href='../Traitement/supprimer_client.php?id={$client['ID_Client']}' class='btn btn-danger btn-sm'>Supprimer</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>Aucun client trouvé.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Liste des Réclamations -->
            <div class="tab-pane fade" id="reclamations">
                <div class="card p-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Réclamation</th>
                                <th>Client</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($reclamations) > 0) {
                                foreach ($reclamations as $reclamation) {
                                    $status_class = ($reclamation['Statut'] == "Actif") ? "status-actif" : "status-en-attente";
                                    echo "<tr>
                                            <td>REC-00{$reclamation['ID_Reclamation']}</td>
                                            <td>{$reclamation['Nom']} {$reclamation['Prenom']}</td>
                                            <td>{$reclamation['Type']}</td>
                                            <td>{$reclamation['Description']}</td>
                                            <td class='$status_class'>{$reclamation['Statut']}</td>
                                            <td>{$reclamation['Date_Reclamation']}</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Aucune réclamation trouvée.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <form action="../Traitement/logout.php" method="POST" class="mt-3">
            <input type="submit" value="Se déconnecter" class="btn btn-danger">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
