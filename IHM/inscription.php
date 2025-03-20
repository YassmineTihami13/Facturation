<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Fournisseur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h1>Inscription</h1>

        <form action="../Traitement/inscription_traitement.php" method="POST">
            <div class="input-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div class="input-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="input-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" required>
            </div>

            <div class="input-group">
                <label for="confirm_mot_de_passe">Confirmer le mot de passe</label>
                <input type="password" name="confirm_mot_de_passe" id="confirm_mot_de_passe" required>
            </div>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>
