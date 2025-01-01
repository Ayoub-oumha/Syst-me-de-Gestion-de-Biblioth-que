<?php 
require('fpdf.php'); // Include the FPDF library

include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Fetch statistics
$totalBooks = $bibliotheque->getTotalBooks();
$totalUsers = $bibliotheque->getTotalUsers();
$totalReservations = $bibliotheque->getTotalReservations();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Rapport de Statistiques de la Bibliothèque', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Total des Livres: ' . $totalBooks, 0, 1);
$pdf->Cell(0, 10, 'Total des Utilisateurs: ' . $totalUsers, 0, 1);
$pdf->Cell(0, 10, 'Total des Réservations: ' . $totalReservations, 0, 1);

// Output the PDF
$pdf->Output('D', 'rapport_statistiques.pdf'); // D for download
?> 