<?php
// Connexion à la base de données
$host = 'localhost'; // Hôte de la base de données
$dbname = 'programme_informatique'; // Nom de la base de données
$username = 'nasteho'; // Nom d'utilisateur de la base de données
$password = 'nasteho'; // Mot de passe de la base de données

try {
    // Connexion avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}

// Ajouter un étudiant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO etudiants (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $email, $password]);
    header("Location: gestion_etudiants.php");
    exit();
}

// Modifier un étudiant
if (isset($_GET['modifier'])) {
    $id = $_GET['modifier'];
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
    $stmt->execute([$id]);
    $etudiant = $stmt->fetch();
    if (!$etudiant) {
        die("L'étudiant demandé n'existe pas.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE etudiants SET nom = ?, prenom = ?, email = ? WHERE id = ?");
    $stmt->execute([$nom, $prenom, $email, $id]);
    header("Location: gestion_etudiants.php");
    exit();
}

// Supprimer un étudiant
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $stmt = $pdo->prepare("DELETE FROM etudiants WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: gestion_etudiants.php");
    exit();
}

// Rechercher un étudiant
$recherche = '';
if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
    $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE nom LIKE ? OR prenom LIKE ?");
    $stmt->execute(["%$recherche%", "%$recherche%"]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM etudiants");
    $stmt->execute();
}

$etudiants = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Etudiants</title>
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
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        /* Form styling */
        form {
            margin-top: 20px;
        }

        input[type="text"], input[type="email"] {
            padding: 8px;
            margin-right: 10px;
            width: 250px;
        }

        button[type="submit"] {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 210px;
            }

            .search-container {
                flex-direction: column;
                align-items: flex-start;
            }

            input[type="text"] {
                width: 100%;
            }

            table {
                font-size: 14px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="sidebar">
        <div class="admin-logo">
            <img src="ima.jpg" alt="Admin Avatar">
        </div>
        <ul>
            <li><a href="testAFF.html">Admin</a></li>
            <li><a href="adAFFprog.php">Courses</a></li>
            <li><a href="etAFF.php">Students</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Gestion des Étudiants</h1>

        <!-- Formulaire de recherche -->
        <div class="search-container">
            <form action="gestion_etudiants.php" method="get">
                <input type="text" name="recherche" placeholder="Rechercher un étudiant" value="<?= htmlspecialchars($recherche) ?>">
                <button type="submit">Rechercher</button>
            </form>
        </div>

        <!-- Table des étudiants -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?= htmlspecialchars($etudiant['id']) ?></td>
                    <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                    <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                    <td><?= htmlspecialchars($etudiant['email']) ?></td>
                    <td class="actions">
                        <a href="gestion_etudiants.php?modifier=<?= htmlspecialchars($etudiant['id']) ?>">Modifier</a>
                        <a href="gestion_etudiants.php?supprimer=<?= htmlspecialchars($etudiant['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($_GET['modifier'])): ?>
        <!-- Modifier un étudiant -->
        <h2>Modifier un étudiant</h2>
        <form action="gestion_etudiants.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($etudiant['id']) ?>">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" required><br>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($etudiant['email']) ?>" required><br>

            <button type="submit" name="modifier">Modifier</button>
        </form>
        <?php endif; ?>
    </div>

</body>
</html>
