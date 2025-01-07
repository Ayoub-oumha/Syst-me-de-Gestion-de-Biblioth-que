<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE LOWER(email) = LOWER(?)");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'name' => $user['name'],
                'role' => $user['role'],
                'id' => $user['id']
            ];

            // Redirect based on the user's role
            if ($user['role'] == 'admin') {
                header("Location: Admin/admin-dashboard.php");
                exit;
            } elseif ($user['role'] == 'authenticated') {
                header("Location: login.php");
                exit;
            }
        }

        // If login failed, return false
        return false;
    }

    public function register($name, $email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE LOWER(email) = LOWER(?)");
        $stmt->execute([$email]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return false; 
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword]);
    }

}
?>