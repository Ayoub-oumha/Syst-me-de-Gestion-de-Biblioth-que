<?php 
include_once "./classes/dbconection.php" ;
include_once "./classes/bibliotique.php" ;
$connectTodb = new Database2("bibliotheque" , "root" , "") ;
$connectTodb->connect() ;
$bibliotheque = new Bibliotheque($connectTodb);

if(isset($_POST["delete_book_id"])){
    $id = $_POST["delete_book_id"] ;
    $bibliotheque->deletbook($id) ;
    echo "good" ;
    header("Location: livres.php") ;
    

}
?>