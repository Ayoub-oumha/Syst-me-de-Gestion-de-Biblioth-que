<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = trim($_POST['user_id']);
    $book_id = trim($_POST['book_id']);

    if (!empty($user_id) && !empty($book_id)) {
        $bibliotheque->addReservation($user_id, $book_id); // Assuming this method exists
        header("Location: reservations.php");
        exit();
    } else {
        die("Tous les champs sont requis.");
    }
} else {
    header("Location: reservations.php");
    exit();
}
?> 