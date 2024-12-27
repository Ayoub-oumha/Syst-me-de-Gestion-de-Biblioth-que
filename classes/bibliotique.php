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
 
  
}
