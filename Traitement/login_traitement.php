<?php
session_start();
require_once('../BD/connexion.php');  // Connexion à la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Vérifier dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM fournisseur WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Vérifier si l'utilisateur existe
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Vérifier le mot de passe
            if (password_verify($password, $user['Mot_de_passe'])) {
                // Mot de passe correct, créer la session
                $_SESSION['user_id'] = $user['ID_Fournisseur'];
                $_SESSION['user_email'] = $user['Email'];
                
                // Redirection vers la page dashboard.php
                header("Location: ../IHM/dashboard.php");
                exit();
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Utilisateur non trouvé.";
        }
    }
}
?>
