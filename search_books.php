<?php
require_once 'config/database.php'; // Include your database class

$query = isset($_GET['query']) ? $_GET['query'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$author = isset($_GET['author']) ? $_GET['author'] : '';

$db = new Database();
$pdo = $db->connect();

// Prepare the base SQL query
$sql = "SELECT books.id, books.title, books.author, books.summary, books.status, books.cover_image, categories.name AS category_name 
        FROM books 
        JOIN categories ON books.category_id = categories.id 
        WHERE 1=1";

// Add conditions based on the filters
if (!empty($query)) {
    $sql .= " AND (books.title LIKE :query OR books.author LIKE :query)";
}
if (!empty($category) && $category !== 'All') {
    $sql .= " AND categories.name = :category";
}
if (!empty($author) && $author !== 'All') {
    $sql .= " AND books.author = :author";
}

$stmt = $pdo->prepare($sql);

// Bind parameters
if (!empty($query)) {
    $stmt->bindValue(':query', '%' . $query . '%');
}
if (!empty($category) && $category !== 'All') {
    $stmt->bindValue(':category', $category);
}
if (!empty($author) && $author !== 'All') {
    $stmt->bindValue(':author', $author);
}

$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the filtered books
?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
<?php foreach ($books as $book): ?>
    <div class="bg-gray-50 rounded-lg shadow-md hover:shadow-xl transition-shadow relative group">
        <!-- Book Details -->
        <div class="p-4">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($book['cover_image']); ?>" 
                 alt="Cover" 
                 class="w-full h-40 object-cover rounded mb-4 transition-transform transform group-hover:scale-105">
            <h3 class="text-lg font-bold mb-2"><?php echo htmlspecialchars($book['title']); ?></h3>
            <p class="text-sm text-gray-600">By <?php echo htmlspecialchars($book['author']); ?></p>
            <p class="text-sm text-gray-600">Category: <?php echo htmlspecialchars($book['category_name']); ?></p>
            <p class="text-sm font-semibold <?php echo $book['status'] === 'Available' ? 'text-green-500' : 'text-red-500'; ?>">
                Status: <?php echo htmlspecialchars($book['status']); ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>
</div>
