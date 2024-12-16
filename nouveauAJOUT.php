<?php
$servername = "localhost";
$username = "nasteho"; // Replace with your database username
$password = "nasteho"; // Replace with your database password
$dbname = "programme_informatique"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $niveau = $_POST['niveau'];
    $semestre = $_POST['semestre'];
    $matiere = $_POST['matiere'];

    // Handle file uploads
    $cours_pdf = uploadFile('cours_pdf');
    $td_pdf = uploadFile('td_pdf');
    $tp_pdf = uploadFile('tp_pdf');

    // Prepare the SQL query to insert data, handling optional fields
    $sql = "INSERT INTO programme (niveau, semestre, matiere, cours_pdf, td_pdf, tp_pdf) 
            VALUES ('$niveau', '$semestre', '$matiere', 
                    '". ($cours_pdf ?: "NULL") ."', 
                    '". ($td_pdf ?: "NULL") ."', 
                    '". ($tp_pdf ?: "NULL") ."')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

// Function to handle file upload (optional fields)
function uploadFile($fileName) {
    if (isset($_FILES[$fileName]) && $_FILES[$fileName]['error'] == 0) {
        $targetDir = "uploads/";
        $fileTmpName = $_FILES[$fileName]['tmp_name'];
        $fileName = basename($_FILES[$fileName]['name']);
        $targetFile = $targetDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpName, $targetFile)) {
            return $targetFile;
        } else {
            return null; // Return null if file couldn't be uploaded
        }
    }
    return null; // Return null if no file was uploaded
}
?>
