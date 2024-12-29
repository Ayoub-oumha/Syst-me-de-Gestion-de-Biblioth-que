<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  

    if ($user_id > 0 && !empty($username) && !empty($email)) {
        // Prepare the data for updating
        $data = [
            'username' => $username,
            'email' => $email,
        ];

        // Update password only if it's provided
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        }

        $bibliotheque->updateUser($user_id, $data); // Assuming this method exists
        header("Location: utilisateurs.php");
        exit();
    } else {
        die("Invalid input. Please fill in all required fields.");
    }
} else {
    header("Location: utilisateurs.php");
    exit();
}
?> 