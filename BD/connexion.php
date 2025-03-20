<?php
$servername = "localhost";
$username = "root";
$password = "";
$port = 3306;
$dbname = "gestionfacture";
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>