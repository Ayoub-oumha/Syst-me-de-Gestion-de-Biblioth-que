<?php
include_once "config/database.php"; // Assuming you have your database connection class here

// Create a database connection
$database = new Database(); // Make sure this matches your Database class
$db = $database->connect(); // Connect to the database

// Get the query parameters
$query = $_GET['query'] ?? '';
$category = $_GET['category'] ?? '';
$author = $_GET['author'] ?? '';

// SQL Query to Fetch Filtered Books
$sql = "SELECT b.id, b.title, b.author, b.cover_image, c.name AS category
        FROM books b
        LEFT JOIN categories c ON b.category_id = c.id
        WHERE (b.title LIKE :query OR b.author LIKE :query)
        AND (:category = '' OR c.name = :category)
        AND (:author = '' OR b.author = :author)";

try {
    // Prepare the SQL statement
    $stmt = $db->prepare($sql);
    
    // Execute the query with parameters
    $stmt->execute([
        'query' => "%$query%",
        'category' => $category,
        'author' => $author,
    ]);

    // Fetch the results
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the books
    foreach ($books as $book) {
        echo "
        <div class='relative bg-white p-4 shadow-lg rounded-md'>
            <div class='text-center mb-4'>
                <img src='" . htmlspecialchars($book['cover_image'] ?? 'default_cover.jpg') . "' 
                     alt='Book cover' 
                     class='h-64 w-full object-cover rounded-md'>
            </div>
            <div class='text-center'>
                <h2 class='text-lg font-bold text-gray-800'>Author: " . htmlspecialchars($book['author']) . "</h2>
                <p class='text-gray-600'>Title: " . htmlspecialchars($book['title']) . "</p>
                <p class='text-gray-500'>Category: " . htmlspecialchars($book['category'] ?? 'Unknown') . "</p>
            </div>
        </div>";
    }
} catch (PDOException $e) {
    // Display error message if the query fails
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    die();
}
?>
