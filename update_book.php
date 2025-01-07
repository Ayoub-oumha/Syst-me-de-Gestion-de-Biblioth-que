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

    $image_name = $_FILES['cover_image']['name'];
    $image_tmp = $_FILES['cover_image']['tmp_name'];
    $target_dir = "images/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }


    if (!empty($image_name)) {
        $target_file = $target_dir . basename($image_name);

      
        $oldImageQuery = $connectTodb->prepareAndExecute("SELECT image_path FROM books WHERE id = ?", [$book_id]);
        $oldImage = $oldImageQuery->fetch();

        if ($oldImage && file_exists($oldImage["image_path"])) {
            unlink($oldImage["image_path"]);
        }

        move_uploaded_file($image_tmp, $target_file);
    } else {
   
        $target_file = $oldImage["image_path"];
        $image_name = basename($target_file);
    }


    if (!empty($titre) && !empty($auteur) && !empty($resume) && !empty($categorie)) {
        try {
          
            $result = $connectTodb->prepareAndExecute(
                "UPDATE books SET title = ?, author = ?, category_id = ?, cover_image = ?, image_path = ?, summary = ? WHERE id = ?",
                [$titre, $auteur, $categorie, $image_name, $target_file, $resume, $book_id]
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