<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: test.php');
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: test.php');
    exit;
}

require_once 'config/database.php'; // Include your database class

// Fetch books
function getBooks($pdo) {
    $stmt = $pdo->prepare("SELECT books.id, books.title, books.author, books.summary, books.status, books.cover_image, categories.name AS category_name FROM books JOIN categories ON books.category_id = categories.id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch categories and authors for filters
function getFilters($pdo, $type) {
    if ($type == 'category') {
        $stmt = $pdo->prepare("SELECT DISTINCT categories.name FROM categories JOIN books ON books.category_id = categories.id");
    } elseif ($type == 'author') {
        $stmt = $pdo->prepare("SELECT DISTINCT author FROM books");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}


$db = new Database();
$pdo = $db->connect();
$books = getBooks($pdo);
$categories = getFilters($pdo, 'category');
$authors = getFilters($pdo, 'author');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Books List</title>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-blue-800 text-white">
        <div class="flex items-center p-4 border-b border-blue-900">
            <i class="fas fa-book text-2xl"></i>
            <a href="user.php" class="ml-2 text-xl font-bold">Lorenz Book</a>
        </div>
        <nav class="mt-8">
            <a href="userBooks.php" class="block px-4 py-3 text-white-300 hover:bg-blue-700">My Books</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="ml-64">
        <header class="bg-white shadow fixed top-0 left-64 right-0">
            <div class="flex justify-between items-center h-16 px-6">
                <span>Welcome, <b><?php echo htmlspecialchars($_SESSION['user']['name']); ?></b></span>
                <form method="post">
                    <button type="submit" name="logout" class="text-red-600">Logout</button>
                </form>
            </div>
        </header>

        <!-- Book List -->
        <main class="p-6 mt-16">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-6">Books List</h2>

                <!-- Borrow Button -->
                <button id="borrowButton" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">Borrow a Book</button>

                <!-- Borrow Form -->
                <form id="borrowForm" class="hidden bg-gray-100 border rounded p-4 shadow mt-4" method="POST" action="borrow_book.php">
                    <label for="bookSelect" class="block mb-2">Select Book:</label>
                    <select id="bookSelect" name="book_id" class="border rounded w-full p-2 mb-4" required>
                        <option value="">-- Select a Book --</option>
                        <?php foreach ($books as $book): ?>
                            <option value="<?php echo htmlspecialchars($book['id']); ?>">
                                <?php echo htmlspecialchars($book['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="borrowDate" class="block mb-2">Borrow Date:</label>
                    <input type="date" id="borrowDate" name="borrow_date" class="border rounded w-full p-2 mb-4" required>

                    <label for="dueDate" class="block mb-2">Due Date:</label>
                    <input type="date" id="dueDate" name="due_date" class="border rounded w-full p-2 mb-4" required>

                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Confirm
                    </button>
                </form>

                <!-- Filters and Search -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex space-x-4">
                        <!-- Category Filter -->
                        <select id="categoryFilter" class="border border-gray-300 rounded px-4 py-2">
                            <option value="">Filter by Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category; ?>">
                                    <?php echo htmlspecialchars($category); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Author Filter -->
                        <select id="authorFilter" class="border border-gray-300 rounded px-4 py-2">
                            <option value="">Filter by Author</option>
                            <?php foreach ($authors as $author): ?>
                                <option value="<?php echo $author; ?>">
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
                

                <!-- Books List -->
                <div id="booksList">
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
                </div>
            </div>
        </main>
    </div>

    <script>

        const borrowButton = document.getElementById('borrowButton');
        const borrowForm = document.getElementById('borrowForm');

        borrowButton.addEventListener('click', () => {
            borrowForm.classList.toggle('hidden');
        });

        // AJAX for live search and filters
        const searchBar = document.getElementById('searchBar');
        const booksList = document.getElementById('booksList');
        const filters = document.querySelectorAll('#categoryFilter, #authorFilter');

        const fetchBooks = () => {
            const query = searchBar.value;
            const category = document.getElementById('categoryFilter').value;
            const author = document.getElementById('authorFilter').value;

            const xhr = new XMLHttpRequest();
            xhr.open('GET', `search_books.php?query=${query}&category=${category}&author=${author}`, true);
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
