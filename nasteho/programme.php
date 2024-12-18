<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "programme_informatique");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si le niveau est spécifié dans la requête GET
$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme Informatique</title>
    <style>
        /* Style général */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9eff7; /* Couleur plus claire pour l'arrière-plan */
            color: #444; /* Couleur du texte légèrement plus foncée */
        }

        header {
            background-color:rgb(40, 68, 104); /* Un bleu plus vif */
            color: white;
            text-align: center;
            padding: 30px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin: 0;
            font-size: 2.5em;
            letter-spacing: 1px;
        }

        /* Container principal avec deux colonnes */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            gap: 30px;
            flex-wrap: wrap;
        }

        .left-column {
            width: 100%;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .right-column {
            width: 100%;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(42, 28, 169, 0.12);
            border: 1px solid #ddd;
        }
        .deconnexion {
           font-weight: bold;
           color: red;

        /* Styles pour le champ de sélection du niveau */
        fieldset {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            background-color: #f8f8f8;
        }

        legend {
            font-size: 1.3em;
            font-weight: bold;
            color:rgb(39, 46, 56); /* Couleur bleu vif */
        }

        label {
            font-size: 1.1em;
            color: #333;
        }

        .niveau-radio {
            margin-top: 10px;
        }

        .niveau-radio input {
            margin-right: 10px;
        }

        .niveau-radio label {
            font-size: 1.1em;
            color:rgb(210, 162, 16);
            cursor: pointer;
            margin-right: 20px;
        }

        /* Style du cadre des résultats */
        .results-frame {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 3px 6px rgba(24, 92, 188, 0.1);
        }

        /* Style des résultats */
        #results ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #results li {
            margin-bottom: 25px;
            padding: 18px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        #results li strong {
            font-size: 1.3em;
            color:rgb(21, 24, 25);
        }

        #results a {
            color:rgb(30, 35, 42);
            text-decoration: none;
            font-size: 1.1em;
        }

        #results a:hover {
            text-decoration: underline;
        }

        footer {
            background-color:rgb(40, 68, 104); /* Un bleu plus vif */
            color: white;
            text-align: center;
            padding: 40px;
            margin-top: 100px;
        }

        /* Masquer les résultats au début */
        .no-results {
            display: none;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .left-column, .right-column {
                width: 80%;
            }
        }
    </style>

    <script>
        // Afficher/masquer les résultats en fonction de la sélection du niveau
        function toggleResults() {
            var niveau = document.querySelector('input[name="niveau"]:checked');
            var resultsContainer = document.getElementById('results');
            if (niveau) {
                var niveauValue = niveau.value;
                // Mettre à jour l'URL avec le niveau sélectionné
                window.location.href = "?niveau=" + niveauValue;
            } else {
                resultsContainer.classList.add('no-results');
            }
        }
    </script>
</head>
<body>

<!-- Header -->
<header>
    <h1> Bienvenu votre Programme Informatique de Licence</h1>
    </header>
    <a href="deconnexion.php" class="deconnexion">Déconnexion</a>

<!-- Conteneur principal avec deux colonnes -->
<div class="container">

    <!-- Formulaire de sélection du niveau avec des boutons radio -->
    <div class="left-column">
        <fieldset>
            <legend>Veuillez choisi votre niveau:</legend>
            <div class="niveau-radio">
                <input type="radio" id="niveau1" name="niveau" value="1" <?php echo ($niveau == '1') ? 'checked' : ''; ?> onclick="toggleResults()">
                <label for="niveau1">Licence 1</label>
                <input type="radio" id="niveau2" name="niveau" value="2" <?php echo ($niveau == '2') ? 'checked' : ''; ?> onclick="toggleResults()">
                <label for="niveau2">Licence 2</label>
                <input type="radio" id="niveau3" name="niveau" value="3" <?php echo ($niveau == '3') ? 'checked' : ''; ?> onclick="toggleResults()">
                <label for="niveau3">Licence 3</label>
            </div>
        </fieldset>
    </div>

    <!-- Zone pour afficher les résultats -->
    <div class="right-column">
        <div id="results" class="results-frame <?php echo $niveau ? '' : 'no-results'; ?>">
            <?php
            // Construction de la requête SQL en fonction du niveau
            if ($niveau !== null) {
                $sql = "SELECT * FROM programme WHERE niveau = '$niveau' ORDER BY semestre, matiere";
                $result = $conn->query($sql);

                if ($result === false) {
                    die("Erreur de requête SQL : " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    $current_niveau = null;
                    $current_semestre = null;

                    while ($row = $result->fetch_assoc()) {
                        if ($current_niveau != $row['niveau']) {
                            if ($current_niveau !== null) echo "</ul></li>";
                            $current_niveau = $row['niveau'];
                            echo "<li><strong>Niveau " . $current_niveau . "</strong><ul>";
                        }

                        if ($current_semestre != $row['semestre']) {
                            $current_semestre = $row['semestre'];
                            echo "<li><strong>Semestre " . $current_semestre . "</strong><ul>";
                        }

                        echo "<li><strong>" . $row['matiere'] . "</strong><br>
                              <a href='" . $row['cours_pdf'] . "' target='_blank'>Cours (PDF)</a><br>
                              <a href='" . $row['td_pdf'] . "' target='_blank'>Travaux Dirigés (TD) (PDF)</a><br>
                              <a href='" . $row['tp_pdf'] . "' target='_blank'>Travaux Pratiques (TP) (PDF)</a></li>";
                    }

                    echo "</ul></li>";
                } else {
                    echo "vide.</p>";
                }
            }
            $conn->close();
            ?>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Programme Informatique. Tous droits réservés.</p>
</footer>

</body>
</html>
