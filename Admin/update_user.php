<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  

    if (!empty(isset($_POST["user_id"])) &&  !empty(isset($_POST["username"])) &&  !empty(isset($_POST["email"])) &&  !empty(isset($_POST["role"]))  ) {

        $username =  $_POST["username"] ;
        $email = $_POST["email"] ;
        $role  = $_POST["role"] ;
        $id = $_POST["user_id"] ;

    
        $result = $connectTodb->prepareAndExecute(
            "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?",
            [$username , $email , $role , $id ]
        );
        header("Location: utilisateurs.php");
        exit();
    } else {
        die("Invalid input. Please fill in all required fields.");
    }
} else {
    header("Location: utilisateurs.php");
    exit();
}
?> 