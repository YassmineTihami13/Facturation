<!-- index.php (Page principale) -->
<?php session_start(); ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion des Factures</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5 text-center">
            <h1>Bienvenue sur la Gestion des Factures</h1>
            <?php if (isset($_SESSION['user'])) : ?>
                <p>Connecté en tant que <?php echo $_SESSION['user']; ?></p>
                <a href="IHM/clients.php" class="btn btn-primary">Gérer les Clients</a>
                <a href="IHM/consommations.php" class="btn btn-warning">Voir les Consommations</a>
                <a href="Traitement/logout.php" class="btn btn-danger">Déconnexion</a>
            <?php else : ?>
                <a href="IHM/login.php" class="btn btn-success">Connexion</a>
            <?php endif; ?>
        </div>
    </body>
    </html>
