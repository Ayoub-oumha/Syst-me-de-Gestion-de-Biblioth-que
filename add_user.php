<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $bibliotheque->addUser($username, $email, $hashed_password); // Assuming this method exists
        header("Location: utilisateurs.php");
        exit();
    } else {
        die("Tous les champs sont requis.");
    }
} else {
    header("Location: utilisateurs.php");
    exit();
}
?> 