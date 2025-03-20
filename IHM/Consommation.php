<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie de Consommation</title>
    <style>
        /* Styles généraux */
        :root {
            --sidebar-width: 250px;
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --hover-color: #2980b9;
            --background-color: #f8f9fa;
            --text-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            margin-left: var(--sidebar-width);
            padding: 30px;
            background-color: var(--background-color);
            min-height: 100vh;
        }

        /* Conteneur principal */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.2em;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
        }

        /* Formulaire */
        form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-color);
            font-weight: 500;
            font-size: 1.1em;
        }

        input[type="date"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        button[type="submit"] {
            background-color: var(--secondary-color);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        button[type="submit"]:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                margin-left: 60px;
                padding: 15px;
            }

            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.8em;
            }

            input, button {
                font-size: 0.9em;
            }
        }

        @media (max-width: 480px) {
            button[type="submit"] {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    
    <div class="container">
        <h1>Saisie de Consommation d'Électricité</h1>
        
        <form id="consumptionForm" action="../Traitement/traitementCons.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="date">Date de la facture:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div>
                <label for="consommation">Consommation (kWh):</label>
                <input type="number" id="consommation" name="consommation" required min="0">
            </div>

            <div>
                <label for="photo">Photo du Compteur:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>

            <button type="submit">Soumettre</button>
        </form>
    </div>

    <script>
        document.getElementById('consumptionForm').addEventListener('submit', function(event) {
            const consommation = document.getElementById('consommation').value;
            const photo = document.getElementById('photo').files[0];

            if (!consommation || !photo) {
                alert('Veuillez remplir tous les champs et téléverser une photo.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>