<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

if (isset($_POST["Mettre_Jour"])) {
    
    $book_id = $_POST["book_id"]; // ID of the book to update
    $titre = $_POST["title"];
    $auteur = $_POST["author"];
    $resume = $_POST["resume"];
    $categorie = $_POST["category"];

    $msg = null;
    if (!empty($_FILES['cover_image']['tmp_name'])) {
        $image_name = $_FILES['cover_image']['tmp_name'];

        // Check file type
        $fileType = mime_content_type($image_name);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($fileType, $allowedTypes)) {
            die('Unsupported file type! Please use JPEG, PNG, or GIF formats.');
        }

        // Check file size (2MB limit)
        if ($_FILES['cover_image']['size'] > 3 * 1024 * 1024) {
            die('File size is too large! Maximum size allowed is 3 MB.');
        }
    }
       
        $imageData = file_get_contents($image_name);

    if (!empty($titre) && !empty($auteur) && !empty($resume) && !empty($categorie)) {
        try {
          
            $result = $connectTodb->prepareAndExecute(
                "UPDATE books SET title = ?, author = ?, category_id = ?, cover_image = ?,  summary = ? WHERE id = ?",
                [$titre, $auteur, $categorie, $imageData, $resume, $book_id]
            );

            if ($result) {
                $msg = true;
                header("Location: livres.php");     
            } else {
                echo "Book update failed.";
            }
        } catch (Exception $e) {
            echo "Error updating book: " . $e->getMessage();
        }
    } else {
        $msg = false;
    }
}
?>