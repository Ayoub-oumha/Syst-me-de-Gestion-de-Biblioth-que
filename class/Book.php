<?php
class Book
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Fetch all books
    public function getBooks()
    {
        $stmt = $this->pdo->prepare("SELECT books.id, books.title, books.author, books.summary, books.status, books.cover_image, categories.name AS category_name 
                                     FROM books 
                                     JOIN categories ON books.category_id = categories.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch books by filters (used in AJAX)
    public function searchBooks($query, $category, $author)
    {
        $sql = "SELECT books.id, books.title, books.author, books.summary, books.status, books.cover_image, categories.name AS category_name 
                FROM books 
                JOIN categories ON books.category_id = categories.id
                WHERE 1=1";

        $params = [];
        if ($query) {
            $sql .= " AND (books.title LIKE :query OR books.summary LIKE :query)";
            $params['query'] = '%' . $query . '%';
        }
        if ($category) {
            $sql .= " AND categories.name = :category";
            $params['category'] = $category;
        }
        if ($author) {
            $sql .= " AND books.author = :author";
            $params['author'] = $author;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch available books for borrowing
    public function getAvailableBooks()
    {
        $stmt = $this->pdo->prepare("SELECT id, title FROM books WHERE status = 'Available'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Borrow a book
    public function borrowBook($userId, $bookId, $borrowDate, $dueDate)
    {
        $currentDate = date('Y-m-d');

        if ($borrowDate < $currentDate || $dueDate < $currentDate) {
            throw new Exception('Borrow or due date cannot be in the past.');
        }

        $this->pdo->beginTransaction();

        // Check if book is available
        $stmt = $this->pdo->prepare("SELECT status FROM books WHERE id = :book_id");
        $stmt->execute(['book_id' => $bookId]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$book) {
            $this->pdo->rollBack();
            throw new Exception('The selected book does not exist.');
        }

        if (strtolower($book['status']) !== 'available') { // Ensuring case-insensitive comparison
            $this->pdo->rollBack();
            throw new Exception('The selected book is not available. Current status: ' . $book['status'] . '.');
        }

        // Update book status
        $stmt = $this->pdo->prepare("UPDATE books SET status = 'Borrowed' WHERE id = :book_id");
        $stmt->execute(['book_id' => $bookId]);

        // Insert into borrowings
        $stmt = $this->pdo->prepare(
            "INSERT INTO borrowings (user_id, book_id, borrow_date, due_date, return_date, notification_sent)
             VALUES (:user_id, :book_id, :borrow_date, :due_date, NULL, :notification_sent)"
        );
        $stmt->execute([
            'user_id' => $userId,
            'book_id' => $bookId,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'notification_sent' => 0, // Assuming 0 indicates "not sent"
        ]);

        $this->pdo->commit();

        return true;
    }
}
