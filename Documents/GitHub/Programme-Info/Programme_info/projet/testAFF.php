<?PHP
session_start();
// Vérifier si l'utilisateur est bien connecté (si la session est active)
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: conn.html");
    exit();
}
// Connexion à la base de données

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="admin-logo">
            <img src="ima.jpg" alt="Admin Avatar">
        </div>
        <ul>
            <li><a href="#">Admin</a></li>
            <li><a href="adAFFprog.php">Courses</a></li>
            <li><a href="etAFF.php">Students</a></li>
            <li><a href="deconnexion.php">deconnexion</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Bienvenu Mr. Admin </h1>

        <div class="stats">
            <div class="stat">
                <h2>Courses</h2>
                <p>Loading...</p> <!-- Données dynamiques à récupérer de la base de données -->
            </div>
            <div class="stat">
                <h2>Students</h2>
                <p>Loading...</p> <!-- Données dynamiques à récupérer de la base de données -->
            </div>
        </div>

        <!-- Sections des tableaux supprimées -->
    </div>

    <script>
        // Ce script gère des interactions simples sur le tableau des étudiants
        document.addEventListener('DOMContentLoaded', () => {
            const studentsTable = document.querySelector('table');

            // Ajoute un événement de clic sur chaque ligne du tableau des étudiants
            studentsTable.addEventListener('click', (event) => {
                const clickedRow = event.target.closest('tr');
                if (clickedRow && clickedRow !== studentsTable.querySelector('thead tr')) {
                    const studentName = clickedRow.cells[0].textContent;
                    const studentEmail = clickedRow.cells[1].textContent;
                    const studentProgram = clickedRow.cells[2].textContent;
                    alert(`Étudiant: ${studentName}\nEmail: ${studentEmail}\nProgramme: ${studentProgram}`);
                }
            });
        });
    </script>
</body>
</html>
