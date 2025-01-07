<?php

include_once "config/database.php"; // Assuming you have db configuration in this file

class Visitor {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBooks() {
        $query = "
            SELECT b.id, b.title, b.author, b.cover_image, c.name AS category
            FROM books b
            LEFT JOIN categories c ON b.category_id = c.id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    
    public function getCategories() {
        $query = "
            SELECT DISTINCT c.name
            FROM categories c
            JOIN books b ON b.category_id = c.id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    

    public function getAuthors() {
        $query = "SELECT DISTINCT author FROM books";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}

try {
    $database = new Database();
    $db = $database->connect();
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$visitor = new Visitor($db);
$books = $visitor->getBooks();
$categories = $visitor->getCategories();
$authors = $visitor->getAuthors();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Page</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex items-center justify-between bg-blue-900 text-white p-4">
        <div class="flex items-center">
            <i class="fas fa-book text-2xl"></i>
            <a href="user.php" class="ml-2 text-xl font-bold">Lorenz Book</a>
        </div>
        <a href="login.php" class="text-white hover:text-gray-300">Login</a>
    </div>

    <div class="container mx-auto px-4 py-6">
<!-- Filters and Search -->
<div class="flex items-center justify-between mb-4">
    <div class="flex space-x-4">
        <!-- Category Filter -->
        <select id="categoryFilter" class="border border-gray-300 rounded px-4 py-2">
            <option value="">Filter by Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category); ?>">
                    <?php echo htmlspecialchars($category); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Author Filter -->
        <select id="authorFilter" class="border border-gray-300 rounded px-4 py-2">
            <option value="">Filter by Author</option>
            <?php foreach ($authors as $author): ?>
                <option value="<?php echo htmlspecialchars($author); ?>">
                    <?php echo htmlspecialchars($author); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Search Bar -->
    <input 
        id="searchBar" 
        type="text" 
        class="border border-gray-300 rounded px-4 py-2 w-1/3" 
        placeholder="Search for a book..."
    >
</div>

        <div id="booksList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($books as $book): ?>
                <div class="bg-white p-4 shadow-md rounded-md">
                    <div class="text-center mb-4">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($book['cover_image']); ?>" 
                                         alt="Cover" 
                                         class="w-full h-40 object-cover rounded mb-4 transition-transform transform group-hover:scale-105">                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Author: <?php echo htmlspecialchars($book['author']); ?></h2>
                    <p class="text-gray-600">Title: <?php echo htmlspecialchars($book['title']); ?></p>
                    <p class="text-gray-500">Category: <?php echo htmlspecialchars($book['category']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    // AJAX for live search and filters
    const searchBar = document.getElementById('searchBar');
    const booksList = document.getElementById('booksList');
    const filters = document.querySelectorAll('#categoryFilter, #authorFilter');

    const fetchBooks = () => {
        const query = searchBar.value;
        const category = document.getElementById('categoryFilter').value;
        const author = document.getElementById('authorFilter').value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `Vsearch_books.php?query=${encodeURIComponent(query)}&category=${encodeURIComponent(category)}&author=${encodeURIComponent(author)}`, true);
        xhr.onload = () => {
            if (xhr.status === 200) {
                booksList.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    };

    searchBar.addEventListener('input', fetchBooks);
    filters.forEach(filter => filter.addEventListener('change', fetchBooks));
</script>
</body>
</html>
