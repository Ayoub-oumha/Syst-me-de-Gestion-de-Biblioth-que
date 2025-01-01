<?php
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();


$bibliotheque = new Bibliotheque($connectTodb);
if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $infoOfteBook = $bibliotheque->getBookWihtId($book_id)[0];
} else header("Location: livres.php");
$categories = $bibliotheque->getAllCategories();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Livre - Bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-900 text-white p-5">
            <h1 class="text-2xl font-bold mb-6">Bibliothèque</h1>
            <nav>
                <ul>
                    <li class="mb-4"><a href="admin-dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-700">Tableau de Bord</a></li>
                    <li class="mb-4"><a href="livres.php" class="block py-2 px-4 rounded hover:bg-blue-700 bg-blue-700">Livres</a></li>
                    <li class="mb-4"><a href="categories.php" class="block py-2 px-4 rounded hover:bg-blue-700">Catégories</a></li>
                    <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700">Utilisateurs</a></li>
                    <!-- <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700">Réservations</a></li> -->
                    <li class="mb-4"><a href="statistiques.php" class="block py-2 px-4 rounded hover:bg-blue-700">Statistiques</a></li>

                </ul>
            </nav>
        </aside>

        <div class="flex-1 p-10">
            <header class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-semibold">Modifier Livre</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Déconnexion</button>
            </header>

            <!-- Modify Book Form -->
            <div>
                <h3 class="text-xl font-bold mb-2">Modifier les Détails du Livre</h3>
                <form action="update_book.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="book_id" value="<?php $infoOfteBook->id; ?>" />
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium">Titre</label>
                        <input type="text" id="title" name="title" value="<?php echo $infoOfteBook->title; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="author" class="block text-sm font-medium">Auteur</label>
                        <input type="text" id="author" name="author" value="<?php echo $infoOfteBook->author; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="resume" class="block text-sm font-medium">resume</label>
                        <input type="text" id="resume" name="resume" value="<?php echo $infoOfteBook->summary; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="cover_image" class="block text-sm font-medium">Image de Couverture</label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium">Catégorie</label>
                        <!-- <input type="text" id="category" name="category" value="<?php echo $infoOfteBook->category_id; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" /> -->
                        <!-- <input type="text" id="category" name="category" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" /> -->
                        <select name="category" id="category" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo htmlspecialchars($category->id); ?>"><?php echo htmlspecialchars($category->name); ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <input type="hidden" name="book_id" value="<?php echo $infoOfteBook->id; ?>" />
                    <button type="submit" name="Mettre_Jour" class="bg-blue-600 text-white px-4 py-2 rounded">Mettre à Jour le Livre</button>
                        <a href="./livres.php" class="ml-5  bg-blue-600 text-white px-4 py-2 rounded">annuler</a>
                </form>

            </div>
        </div>
    </div>
</body>

</html>