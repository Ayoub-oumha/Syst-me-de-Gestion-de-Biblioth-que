<?php
session_start();
require_once 'config/database.php'; // Include your database class
require_once 'Book.php'; // Include your book class

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$db = new Database();
$pdo = $db->connect();
$bookModel = new Book($pdo);

$userId = $_SESSION['user']['id'];
$bookId = intval($_POST['book_id']);
$borrowDate = $_POST['borrow_date'];
$dueDate = $_POST['due_date'];

if (empty($bookId) || empty($borrowDate) || empty($dueDate)) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

$currentDate = date('Y-m-d');
if ($borrowDate < $currentDate || $dueDate < $currentDate) {
    http_response_code(400);
    echo json_encode(['error' => 'Dates cannot be in the past']);
    exit;
}

if ($bookModel->borrowBook($userId, $bookId, $borrowDate, $dueDate)) {
    echo json_encode(['success' => true]);
    header('Location: user.php'); // Redirect on success
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to borrow book']);
}
