<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = trim($_POST['category_name']);

    if (!empty($category_name)) {
        // $bibliotheque->addCategory($category_name); // Assuming this method exists
        $connectTodb->prepareAndExecute("INSERT INTO categories (name ) VALUES (?)",  [$category_name]) ;
        header("Location: categories.php");
        exit();
    } else {
        die("Le nom de la catégorie ne peut pas être vide.");
    }
} else {
    header("Location: categories.php");
    exit();
}
?> 