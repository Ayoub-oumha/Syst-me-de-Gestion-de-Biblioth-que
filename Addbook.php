<?php 
include_once "./classes/dbconection.php" ;
include_once "./classes/bibliotique.php" ;
$connectTodb = new Database2("bibliotheque" , "root" , "") ;
$connectTodb->connect() ;

if(isset($_POST["AddBook"])){
    $titre = $_POST["title"] ;
    $auteur = $_POST["author"] ;
    $resume = $_POST["resume"] ;

    $categorie = $_POST["category"] ;
    $msg = null ;
  
    // $img = $_POST["cover_image"] ;
    $image_name = $_FILES['cover_image']['name'];
    $image_tmp = $_FILES['cover_image']['tmp_name'];
    $target_dir = "images/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }
    $target_file = $target_dir . basename($image_name);
   
    if(!empty($titre) && !empty($auteur) &&  !empty($resume) && !empty($image_name) && !empty($categorie) && move_uploaded_file($image_tmp, $target_file) ){
      
      try {
      $result = $connectTodb->prepareAndExecute(
          "INSERT INTO books (title, author, category_id, cover_image, image_path, summary) VALUES (?, ?, ?, ?, ? , ?);",
          [$titre, $auteur, $categorie, $image_name, $target_file  , $resume]
      );
  
      if ($result) {
        $msg = true ;
        header("Location:  livres.php") ;
      } else {
          echo "book not added " ;
      }
  } catch (Exception $e) {
      echo "eror book nto added " . $e->getMessage();
  }
    }else  $msg =  false ;
    
  }
  
?>