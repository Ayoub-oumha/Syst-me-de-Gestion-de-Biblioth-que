<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = isset($_POST['delete_category_id']) ? intval($_POST['delete_category_id']) : 0;

    if ($category_id > 0) {
        $bibliotheque->deletCate($category_id); // Assuming this method exists
        header("Location: categories.php");
        exit();
    } else { 
        die("Invalid category ID.");
    }
} else {
    header("Location: categories.php");
    exit();
}
?> 