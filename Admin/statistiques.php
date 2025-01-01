<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

$msot_active = $bibliotheque->getMostActiveUsers(5) ;


$mostBorrowed =  $bibliotheque->getMostBorrowedBooks(5) ;


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
        <aside class="w-64 bg-blue-900 text-white p-5 h-full">
            <h1 class="text-2xl font-bold mb-6">Bibliothèque</h1>
            <nav>
                <ul>
                    <li class="mb-4"><a href="admin-dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-700">Tableau de Bord</a></li>
                    <li class="mb-4"><a href="livres.php" class="block py-2 px-4 rounded hover:bg-blue-700">Livres</a></li>
                    <li class="mb-4"><a href="categories.php" class="block py-2 px-4 rounded hover:bg-blue-700">Catégories</a></li>
                    <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700">Utilisateurs</a></li>
                    <!-- <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700">Réservations</a></li> -->
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
                    <p class="text-2xl"><?php echo $bibliotheque->getTotalLivres(); ?></p>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <h3 class="text-xl font-bold">Total des Utilisateurs</h3>
                    <p class="text-2xl"><?php echo $bibliotheque->getTotalUtilisateurs() ; ?></p>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <h3 class="text-xl font-bold">Total des Réservations</h3>
                    <p class="text-2xl"><?php echo  $bibliotheque->getActiveReservations() ; ?></p>
                </div>
            </div>
                  <!-- Livres les plus empruntes -->
                  <div class="bg-white rounded-lg shadow mb-8 overflow-hidden mt-5">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold">Livres les plus empruntés</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Auteur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre d'emprunts</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($mostBorrowed as $book): ?>
                                <tr>
                                    <td class="px-6 py-4"><?php echo htmlspecialchars($book->title); ?></td>
                                    <td class="px-6 py-4"><?php echo htmlspecialchars($book->author); ?></td>
                                    <td class="px-6 py-4"><?php echo $book->borrow_count; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
               <!-- Utilisateurs les plus actifs -->
            <div class="bg-white rounded-lg shadow overflow-hidden mt-10">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold">Utilisateurs les plus actifs</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre d'emprunts</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($msot_active as $user): ?>
                                <tr>
                                    <td class="px-6 py-4"><?php echo htmlspecialchars($user->name); ?></td>
                                    <td class="px-6 py-4"><?php echo htmlspecialchars($user->email); ?></td>
                                    <td class="px-6 py-4"><?php echo $user->borrow_count; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- Button to Generate Report -->
            <div class="mt-10">
                <form action="pdf.php" method="POST"  target="_blank">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Générer Rapport PDF</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 