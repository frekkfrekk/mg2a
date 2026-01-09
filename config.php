<?php
$host = "localhost";
$user = "dynamy_user";
$pass = "mot_de_passe";
$db   = "dynamy";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erreur DB : " . $conn->connect_error);
}
?>
