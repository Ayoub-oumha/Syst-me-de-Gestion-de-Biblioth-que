<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

if (isset($_POST["AddBook"])) {
    // Sanitize inputs
    $titre = htmlspecialchars(strip_tags(trim($_POST["title"])));
    $auteur = htmlspecialchars(strip_tags(trim($_POST["author"])));
    $resume = htmlspecialchars(strip_tags(trim($_POST["resume"])));
    $categorie = intval($_POST["category"]);
    $msg = null;

    // Check if a file is uploaded
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

       
        $imageData = file_get_contents($image_name);

        if (!empty($titre) && !empty($auteur) && !empty($resume) && !empty($imageData) && !empty($categorie)) {
            try {
                
                $result = $connectTodb->prepareAndExecute(
                    "INSERT INTO books (title, author, category_id, cover_image, summary) VALUES (?, ?, ?, ?, ?);",
                    [$titre, $auteur, $categorie, $imageData, $resume]
                );

                if ($result) {
                    
                    header("Location: livres.php");
                    exit;
                } else {
                    echo "Error: Book could not be added!";
                }
            } catch (Exception $e) {
                echo "Error adding book: " . $e->getMessage();
            }
        } else {
            echo "Please fill in all required fields!";
        }
    } else {
        echo "Please upload a cover image.";
    }
}
?>
