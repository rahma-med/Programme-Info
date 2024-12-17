<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "programme_informatique");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement de la suppression d'une matière
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_sql = "DELETE FROM programme WHERE id = $id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Matière supprimée avec succès.";
    } else {
        echo "Erreur de suppression: " . $conn->error;
    }
}

// Traitement de la recherche
$semestre = isset($_GET['semestre']) ? $_GET['semestre'] : '';
$matiere = isset($_GET['matiere']) ? $_GET['matiere'] : '';

// Requête pour obtenir les programmes organisés par niveau et semestre avec filtrage
$sql = "SELECT * FROM programme WHERE 1=1";

if ($semestre) {
    $sql .= " AND semestre = '$semestre'";
}
if ($matiere) {
    $sql .= " AND matiere LIKE '%$matiere%'";
}

$sql .= " ORDER BY niveau DESC, semestre, matiere";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme Informatique</title>
    <style>
        /* Styles généraux */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            color: white;
            transition: all 0.3s ease-in-out;
        }

        .sidebar:hover {
            width: 270px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 15px 25px;
            border-bottom: 1px solid #34495e;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
        }

        /* Logo de l'admin avec animation */
        .sidebar .admin-logo {
            text-align: center;
            padding-bottom: 20px;
            animation: rotateAvatar 5s infinite;
        }

        @keyframes rotateAvatar {
            0% {
                transform: rotate(0deg);
            }
            50% {
                transform: rotate(180deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .sidebar .admin-logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar .admin-logo img:hover {
            transform: scale(1.1);
        }

        /* Main content */
        .main-content {
            margin-left: 270px;
            padding: 30px;
            background-color: white;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        h1 {
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            animation: fadeIn 1s ease-in-out;
        }

        .stat {
            background-color: #ecf0f1;
            padding: 20px;
            width: 45%;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat:hover {
            transform: translateY(-10px);
        }

        .stat h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .stat p {
            font-size: 36px;
            font-weight: bold;
            color: #3498db;
        }

        h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 15px;
        }

        /* Animation pour l'apparition */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 210px;
            }

            .stats {
                flex-direction: column;
            }

            .stat {
                width: 100%;
                margin-bottom: 20px;
            }
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            margin-right: 10px;
        }
        .search-container {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 8px;
            margin-right: 10px;
            width: 200px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <ul>
        <li><a href="testAFF.html">Admin</a></li>
        <li><a href="adAFFprog.php">Courses</a></li>
        <li><a href="etAFF.php">Students</a></li>
        <li><a href="deconnexion.php">deconnexion</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Gestion de Programme</h1>

    <!-- Tableau des matières -->
    <table>
        <thead>
            <tr>
                <th>Niveau</th>
                <th>Semestre</th>
                <th>Matière</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $current_niveau = null;
                while ($row = $result->fetch_assoc()) {
                    if ($current_niveau != $row['niveau']) {
                        echo "<tr><td colspan='4'><strong>Licence " . $row['niveau'] . "</strong></td></tr>";
                        $current_niveau = $row['niveau'];
                    }
                    echo "<tr>";
                    echo "<td>Licence " . $row['niveau'] . "</td>";
                    echo "<td>Semestre " . $row['semestre'] . "</td>";
                    echo "<td>" . $row['matiere'] . "</td>";
                    echo "<td>
                            <a href='?action=delete&id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette matière ?\")'>Supprimer</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Aucune matière trouvée</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Formulaire de recherche en bas -->
    <div class="search-form">
        <h3>Recherche :</h3>
        <form method="GET">
            <label for="semestre">Semestre :</label>
            <input type="number" name="semestre" value="<?= $semestre; ?>" placeholder="Semestre"><br><br>

            <label for="matiere">Matière :</label>
            <input type="text" name="matiere" value="<?= $matiere; ?>" placeholder="Rechercher une matière"><br>

            <input type="submit" value="Rechercher">
        </form>
    </div>

    <!-- Bouton Ajouter une matière -->
  <!-- Bouton Ajouter une matière -->
  <a href="adj.html" >Ajouter une matière</a>
</div>

</body>
</html>
