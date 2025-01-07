<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Fetch the list of categories
$categories = $bibliotheque->getAllCategories(); // Assuming this method exists

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories - Bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-900 text-white p-5">
            <h1 class="text-2xl font-bold mb-6">Bibliothèque</h1>
            <nav>
                <ul>
                    <li class="mb-4"><a href="index.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-blue-700' : ''; ?>">Tableau de Bord</a></li>
                    <li class="mb-4"><a href="livres.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'livres.php' ? 'bg-blue-700' : ''; ?>">Livres</a></li>
                    <li class="mb-4"><a href="categories.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'bg-blue-700' : ''; ?>">Catégories</a></li>
                    <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700">Utilisateurs</a></li>
                    <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700">Réservations</a></li>
                    <li class="mb-4"><a href="statistiques.php" class="block py-2 px-4 rounded hover:bg-blue-700">Statistiques</a></li>
          
                </ul>
            </nav>
        </aside>

        <div class="flex-1 p-10">
            <header class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-semibold">Gestion des Catégories</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Déconnexion</button>
            </header>

            <!-- Add Category Section -->
            <div class="mb-10">
                <h3 class="text-xl font-bold mb-2">Ajouter une Catégorie</h3>
                <form action="add_category.php" method="POST">
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm font-medium">Nom de la Catégorie</label>
                        <input type="text" id="category_name" name="category_name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Ajouter la Catégorie</button>
                </form>
            </div>

            <!-- List of Categories -->
            <div>
                <h3 class="text-xl font-bold mb-2">Liste des Catégories</h3>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Nom de la Catégorie</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($category->name); ?></td>
                                <td class="py-2 px-4 border-b">
                                    <form action="modify_category.php" method="POST" class="inline">
                                        <input type="hidden" name="category_id" value="<?php echo $category->id; ?>" />
                                        <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded">Modifier</button>
                                    </form>
                                    <form action="delete_category.php" method="POST" class="inline">
                                        <input type="hidden" name="delete_category_id" value="<?php echo $category->id; ?>" />
                                        <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 