<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "programme_informatique");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si le semestre est spécifié dans la requête GET
$semestre = isset($_GET['semestre']) ? $_GET['semestre'] : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme Informatique</title>
    <style>
        /* Style global de la page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background-color: #silver;
            color: black;
            padding: 10px 0;
            text-align: center;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Formulaire de sélection du semestre */
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            margin: 20px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-right: 10px;
            font-weight: bold;
            color: #555;
        }

        select {
            margin-right: 20px;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Conteneur pour les blocs de programme (Licence 1, 2, 3) */
        .programme-block-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin: 30px auto;
        }

        /* Style pour chaque bloc de programme */
        .programme-block {
            max-width: 420px;
            margin: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
            transition: transform 0.3s ease;
        }

        /* Titre du programme */
        .programme-block h2 {
            color: #2E8B57;
            margin-bottom: 20px;
        }

        /* Liste des matières */
        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 15px 0;
            font-size: 16px;
        }

        strong {
            color: #2E8B57;
            font-size: 18px;
        }

        /* Liens */
        a {
            color: #1E90FF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Effet de survol sur les blocs */
        .programme-block:hover {
            transform: scale(1.05);
        }

        /* Style responsive pour les petits écrans */
        @media (max-width: 768px) {
            .programme-block-container {
                flex-direction: column;
                align-items: center;
            }

            .programme-block {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<header>
    <h1>Bien de Programme Informatique</h1>
</header>

<!-- Formulaire de sélection du semestre -->


<!-- Conteneur pour les blocs de programme (Licence 1, 2, 3) -->
<div class="programme-block-container">
    <?php
    // Liste des niveaux (Licence 1, 2, 3)
    $niveaux = [1, 2, 3];
    foreach ($niveaux as $niveau) {
        $niveau_text = "Licence " . $niveau;
        echo "<div class='programme-block'>";
        echo "<h2>$niveau_text" . ($semestre ? " - Semestre $semestre" : "") . "</h2>";

        // Requête pour obtenir les programmes en fonction du niveau et du semestre
        $sql = "SELECT * FROM programme WHERE niveau = $niveau";
        if ($semestre !== null) {
            $sql .= " AND semestre = '$semestre'";
        }
        $sql .= " ORDER BY semestre, matiere";

        $result = $conn->query($sql);

        // Séparation des matières par semestre
        $semestre_1 = [];
        $semestre_2 = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['semestre'] == 1) {
                    $semestre_1[] = $row;
                } else {
                    $semestre_2[] = $row;
                }
            }
        }

        // Affichage des matières pour chaque semestre
        if (!empty($semestre_1)) {
            echo "<h3>Semestre 1</h3><ul>";
            foreach ($semestre_1 as $row) {
                echo "<li><strong>" . $row['matiere'] . "</strong><br>
                      <a href='" . $row['cours_pdf'] . "' target='_blank'>Cours (PDF)</a><br>
                      <a href='" . $row['td_pdf'] . "' target='_blank'>Travaux Dirigés (TD) (PDF)</a><br>
                      <a href='" . $row['tp_pdf'] . "' target='_blank'>Travaux Pratiques (TP) (PDF)</a></li>";
            }
            echo "</ul>";
        }

        if (!empty($semestre_2)) {
            echo "<h3>Semestre 2</h3><ul>";
            foreach ($semestre_2 as $row) {
                echo "<li><strong>" . $row['matiere'] . "</strong><br>
                      <a href='" . $row['cours_pdf'] . "' target='_blank'>Cours (PDF)</a><br>
                      <a href='" . $row['td_pdf'] . "' target='_blank'>Travaux Dirigés (TD) (PDF)</a><br>
                      <a href='" . $row['tp_pdf'] . "' target='_blank'>Travaux Pratiques (TP) (PDF)</a></li>";
            }
            echo "</ul>";
        }

        if (empty($semestre_1) && empty($semestre_2)) {
            echo "Aucun programme trouvé pour ce niveau.";
        }
        echo "</div>";
    }
    ?>
</div>

<script>
    // Fonction pour afficher les résultats après la soumission du formulaire
    document.getElementById("filterForm").addEventListener("submit", function(event) {
        var semestre = document.getElementById("semestre").value;
        if (semestre) {
            // Affiche les résultats si le semestre est sélectionné
            document.querySelectorAll(".programme-block").forEach(function(block) {
                block.style.display = "block";
            });
        } else {
            // Masque les résultats si aucun semestre n'est sélectionné
            document.querySelectorAll(".programme-block").forEach(function(block) {
                block.style.display = "none";
            });
        }
    });
</script>

</body>
</html>
