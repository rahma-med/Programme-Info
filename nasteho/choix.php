<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "programme_informatique");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si le niveau et le semestre sont spécifiés dans la requête GET
$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : null;
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
            background-color: #f0f8ff; /* New light blue background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            margin: 30px 0;
            color: #006400; /* Dark green for header text */
        }

        /* Style du header */
        header {
            background-color: #4682b4; /* Steel blue background */
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
            background-image: url('ima.jpg'); /* Image added in the header */
            background-size: cover;
            background-position: center;
        }

        /* Style du footer */
        footer {
            background-color: #4682b4;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Disposition du contenu en deux colonnes */
        .container {
            display: flex;
            width: 100%;
            padding: 20px;
            justify-content: space-between;
        }

        /* Formulaire à gauche */
        .left-column {
            width: 30%;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Section des résultats à droite */
        .right-column {
            width: 65%;
            padding: 20px;
            background-color: #ffffff;
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
            width: 100%;
            margin-bottom: 10px;
        }

        button {
            padding: 8px 15px;
            background-color: #32cd32; /* Lime green for buttons */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #228b22; /* Dark green on hover */
        }

        /* Section des résultats */
        #results {
            margin-top: 20px;
        }

        /* Liste des résultats */
        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 15px 0;
            font-size: 16px;
        }

        strong {
            color: #006400;
            font-size: 18px;
        }

        a {
            color: #1e90ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Header -->
<header>
    <h1>Programme Informatique</h1>
    
</header>

<!-- Conteneur principal avec deux colonnes -->
<div class="container">

    <!-- Formulaire de sélection du niveau et semestre -->
    <div class="left-column">
        <form method="GET" action="" id="filterForm">
            <label for="niveau">Niveau:</label>
            <select name="niveau" id="niveau">
                <option value="1" <?php if ($niveau == '1') echo 'selected'; ?>>---</option>
                <option value="1" <?php if ($niveau == '1') echo 'selected'; ?>>Licence 1</option>
                <option value="2" <?php if ($niveau == '2') echo 'selected'; ?>>Licence 2</option>
                <option value="3" <?php if ($niveau == '3') echo 'selected'; ?>>Licence 3</option>
            </select>

            <label for="semestre">Semestre:</label>
            <select name="semestre" id="semestre">
                <option value="1" <?php if ($semestre == '1') echo 'selected'; ?>>---</option>
                <option value="1" <?php if ($semestre == '1') echo 'selected'; ?>>Semestre 1</option>
                <option value="2" <?php if ($semestre == '2') echo 'selected'; ?>>Semestre 2</option>
            </select>

            <button type="submit">Filtrer</button>
        </form>
    </div>

    <!-- Zone pour afficher les résultats -->
    <div class="right-column">
        <div id="results">
            <?php
            // Construction de la requête SQL en fonction des filtres
            $sql = "SELECT * FROM programme WHERE 1";

            // Ajouter des conditions pour le niveau et le semestre si définis
            if ($niveau !== null) {
                $sql .= " AND niveau = '$niveau'";
            }
            if ($semestre !== null) {
                $sql .= " AND semestre = '$semestre'";
            }

            $sql .= " ORDER BY niveau, semestre, matiere";

            // Exécuter la requête SQL
            $result = $conn->query($sql);

            if ($result === false) {
                die("Erreur de requête SQL : " . $conn->error);
            }

            if ($result->num_rows > 0) {
                // Structure du programme
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
                echo "Aucun programme trouvé pour les critères sélectionnés.";
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

<script>
// Fonction pour afficher les résultats après la soumission du formulaire
document.getElementById("filterForm").addEventListener("submit", function(event) {
    var niveau = document.getElementById("niveau").value;
    var semestre = document.getElementById("semestre").value;

    if (niveau && semestre) {
        // Affiche les résultats si les deux filtres sont choisis
        document.getElementById("results").style.display = "block";
    } else {
        // Masque les résultats si les filtres ne sont pas définis
        document.getElementById("results").style.display = "none";
    }
});

// Afficher les résultats si des filtres sont sélectionnés au chargement
window.onload = function() {
    var niveau = document.getElementById("niveau").value;
    var semestre = document.getElementById("semestre").value;
    
    if (niveau && semestre) {
        document.getElementById("results").style.display = "block";
    } else {
        document.getElementById("results").style.display = "none";
    }
};
</script>

</body>
</html>
