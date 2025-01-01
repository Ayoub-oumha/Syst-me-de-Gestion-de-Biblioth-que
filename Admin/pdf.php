<?php

require_once __DIR__ . '/vendor/autoload.php';
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

// Initialize Bibliotheque
$bibliotheque = new Bibliotheque($connectTodb);

// Fetch statistics
$totalLivres = $bibliotheque->getTotalLivres();
$totalUtilisateurs = $bibliotheque->getTotalUtilisateurs();
$activeReservations = $bibliotheque->getActiveReservations();
$mostBorrowed = $bibliotheque->getMostBorrowedBooks(5); // Get top 5 most borrowed books
$mostActiveUsers = $bibliotheque->getMostActiveUsers(5); // Get top 5 most active users

// Create a new mPDF instance
$mpdf = new \Mpdf\Mpdf();

// Write HTML content
$mpdf->WriteHTML('<h1>Rapport de Statistiques de la Bibliothèque</h1>');
$mpdf->WriteHTML("<p><strong>Total Livres:</strong> $totalLivres</p>");
$mpdf->WriteHTML("<p><strong>Total Utilisateurs:</strong> $totalUtilisateurs</p>");
$mpdf->WriteHTML("<p><strong>Total des Réservations:</strong> $activeReservations</p>");
$mpdf->WriteHTML('<h2>Livres les plus empruntés</h2>');

// Create a table for most borrowed books
$mpdf->WriteHTML('<table border="1" cellpadding="5" style="width: 100%; border-collapse: collapse;">');
$mpdf->WriteHTML('<tr><th>Titre</th><th>Auteur</th><th>Nombre d\'emprunts</th></tr>');
foreach ($mostBorrowed as $book) {
    $mpdf->WriteHTML('<tr>');
    $mpdf->WriteHTML('<td>' . htmlspecialchars($book->title) . '</td>');
    $mpdf->WriteHTML('<td>' . htmlspecialchars($book->author) . '</td>');
    $mpdf->WriteHTML('<td>' . $book->borrow_count . '</td>');
    $mpdf->WriteHTML('</tr>');
}
$mpdf->WriteHTML('</table>');

$mpdf->WriteHTML('<h2>Utilisateurs les plus actifs</h2>');

// Create a table for most active users
$mpdf->WriteHTML('<table border="1" cellpadding="5" style="width: 100%; border-collapse: collapse;">');
$mpdf->WriteHTML('<tr><th>Nom</th><th>Email</th><th>Nombre d\'emprunts</th></tr>');
foreach ($mostActiveUsers as $user) {
    $mpdf->WriteHTML('<tr>');
    $mpdf->WriteHTML('<td>' . htmlspecialchars($user->name) . '</td>');
    $mpdf->WriteHTML('<td>' . htmlspecialchars($user->email) . '</td>');
    $mpdf->WriteHTML('<td>' . $user->borrow_count . '</td>');
    $mpdf->WriteHTML('</tr>');
}
$mpdf->WriteHTML('</table>');

// Output the PDF
$mpdf->Output('rapport_statistiques.pdf', 'D'); // D for download
?>
