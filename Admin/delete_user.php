<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = isset($_POST['delete_user_id']) ? intval($_POST['delete_user_id']) : 0;

    if ($user_id > 0) {
        
        $connectTodb->prepareAndExecute("DELETE FROM users WHERE id = ?", [$_POST['delete_user_id']]); 
        header("Location: utilisateurs.php"); 
        exit();
    } else {
        die("Invalid user ID.");
    }
} else {
    header("Location: utilisateurs.php"); 
    exit();
}


?> 