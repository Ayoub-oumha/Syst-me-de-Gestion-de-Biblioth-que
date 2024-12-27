<?php
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();


$bibliotheque = new Bibliotheque($connectTodb);
echo 'heloo' ;
if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    echo $book_id ;
    // $infoOfteBook = $bibliotheque->getBookWihtId($book_id)[0] ;
    if (isset($_POST["Mettre_Jour"])) {
        $titre = $_POST["title"];
        $auteur = $_POST["author"];
        $resume = $_POST["resume"];
        // $img = $_POST["cover_image"];  
        $categorie = $_POST["category"];
        $msg = null;
        echo $resume ;
        echo $titre ;
        // if (!empty($titre) && !empty($auteur) &&  !empty($resume) && !empty($img) && !empty($categorie)) {
        //     try {
        //         $result = $connectTodb->prepareAndExecute(
        //             "INSERT INTO books (title, author, category_id, cover_image, summary) VALUES (?, ?, ?, ?, ?);",
        //             [$titre, $auteur, $categorie, $img, $resume]
        //         );
        //         if ($result) {
        //             $msg = true;
        //         } else {
        //             echo "book not added ";
        //         }
        //     } catch (Exception $e) {
        //         echo "eror book nto added " . $e->getMessage();
        //     }
        // } else  $msg =  false;
    }
} else {

    // header("Location: livres.php");
    exit();
}
?>