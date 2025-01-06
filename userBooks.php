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

// Fetch user-specific books
function getUserBooks($pdo, $userId) {
    $stmt = $pdo->prepare(
        "SELECT b.id AS book_id, b.title, b.author, b.status, c.name AS category_name, 
                br.borrow_date, br.due_date, br.return_date
         FROM borrowings br
         JOIN books b ON br.book_id = b.id
         JOIN categories c ON b.category_id = c.id
         WHERE br.user_id = :user_id"
    );
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Return a book
if (isset($_POST['return_book'])) {
    $bookId = $_POST['book_id'];
    $userId = $_SESSION['user']['id'];

    $pdo = (new Database())->connect();
    $stmt = $pdo->prepare(
        "UPDATE borrowings 
         SET return_date = CURDATE()
         WHERE book_id = :book_id AND user_id = :user_id"
    );
    $stmt->execute(['book_id' => $bookId, 'user_id' => $userId]);

    $stmt = $pdo->prepare("UPDATE books SET status = 'available' WHERE id = :book_id");
    $stmt->execute(['book_id' => $bookId]);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$db = new Database();
$pdo = $db->connect();
$userBooks = getUserBooks($pdo, $_SESSION['user']['id']);
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
                <!-- User Books List -->
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-bold mb-4">Your Borrowed Books</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($userBooks as $book): ?>
                    <div class="bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition-shadow p-4">
                        <h3 class="text-lg font-bold mb-2"><?php echo htmlspecialchars($book['title']); ?></h3>
                        <p class="text-sm text-gray-600">By <?php echo htmlspecialchars($book['author']); ?></p>
                        <p class="text-sm text-gray-600">Category: <?php echo htmlspecialchars($book['category_name']); ?></p>
                        <p class="text-sm text-gray-600">Borrowed: <?php echo htmlspecialchars($book['borrow_date']); ?></p>
                        <p class="text-sm text-gray-600">Due: <?php echo htmlspecialchars($book['due_date']); ?></p>
                        <p class="text-sm text-<?php echo $book['return_date'] ? 'green-500' : 'red-500'; ?>">
                            <?php echo $book['return_date'] ? "Returned: " . htmlspecialchars($book['return_date']) : "Not Returned"; ?>
                        </p>
                        <?php if (!$book['return_date']): ?>
                            <form method="post" class="mt-4">
                                <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                <button type="submit" name="return_book" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Return Book
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        </main>

</body>

</html>
