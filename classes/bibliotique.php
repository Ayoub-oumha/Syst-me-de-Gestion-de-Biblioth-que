<?php
class Bibliotheque {
    private $db;

    public function __construct( $db) {
        $this->db = $db;
    }

    public function getTotalLivres() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM books;");
        return $result[0]->total;
    }

    public function getTotalUtilisateurs() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM users;");
        return $result[0]->total;
    }

    public function getActiveReservations() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM books WHERE status = 'reserved';");
        return $result[0]->total;
    }
    public function getAllBooks() {
        $result = $this->db->query("SELECT * FROM books;");
        return $result;
    }
    public function getBookWihtId($id) {
        $result = $this->db->query("SELECT * FROM books where id = $id;");
        return $result;
    }
    public function deletbook($id){
        $sql = "SELECT image_path FROM books WHERE id = $id";
        $result = $this->db->query($sql);
        $row = $result[0];
    
        if ($row) {
            $image_path = $row->image_path;
    
            // Delete the file from directory
            if (file_exists($image_path)) {
                unlink($image_path);
            }
    
            // Delete record from database
            $sql = "DELETE FROM books WHERE id = $id";
            $this->db->query($sql) ;
           
           
        }
    }
    public function getAllCategories(){
        $result = $this->db->query("SELECT * FROM categories ;");
        return $result;
    }
    public function getCateBytId($id) {
        $result = $this->db->query("SELECT * FROM categories where id = $id;");
        return $result;
    }
    public function deletCate($id){
        $sql = "DELETE FROM categories WHERE id = $id";
        $this->db->query($sql) ;
    }
    public function getAllUsers(){
        $result = $this->db->query("SELECT * FROM users;");
        return $result;

    }
    public function getUserById($id){
        $result = $this->db->query("SELECT * FROM users where id = $id;");
        return $result;
    }
  
 
  
}
