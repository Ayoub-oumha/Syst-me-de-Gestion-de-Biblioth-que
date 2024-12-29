<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Fetch statistics
$totalBooks = $bibliotheque->getTotalLivres()  ; // Assuming this method exists
$totalUsers =  $bibliotheque->getTotalUtilisateurs() ; // Assuming this method exists
$totalReservations = $bibliotheque->getActiveReservations()  ; // Assuming this method exists
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-900 text-white p-5">
            <h1 class="text-2xl font-bold mb-6">Bibliothèque</h1>
            <nav>
                <ul>
                    <li class="mb-4"><a href="index.php" class="block py-2 px-4 rounded hover:bg-blue-700">Tableau de Bord</a></li>
                    <li class="mb-4"><a href="livres.php" class="block py-2 px-4 rounded hover:bg-blue-700">Livres</a></li>
                    <li class="mb-4"><a href="categories.php" class="block py-2 px-4 rounded hover:bg-blue-700">Catégories</a></li>
                    <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700">Utilisateurs</a></li>
                    <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700">Réservations</a></li>
                    <li class="mb-4"><a href="statistiques.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'statistiques.php' ? 'bg-blue-700' : ''; ?>">Statistiques</a></li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 p-10">
            <header class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-semibold">Statistiques de la Bibliothèque</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Déconnexion</button>
            </header>

            <!-- Statistics Section -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded shadow">
                    <h3 class="text-xl font-bold">Total des Livres</h3>
                    <p class="text-2xl"><?php echo htmlspecialchars($totalBooks); ?></p>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <h3 class="text-xl font-bold">Total des Utilisateurs</h3>
                    <p class="text-2xl"><?php echo htmlspecialchars($totalUsers); ?></p>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <h3 class="text-xl font-bold">Total des Réservations</h3>
                    <p class="text-2xl"><?php echo htmlspecialchars($totalReservations); ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 