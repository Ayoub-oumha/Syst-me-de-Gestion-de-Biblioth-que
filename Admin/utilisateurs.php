<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);

// Fetch the list of users
$users = $bibliotheque->getAllUsers(); // Assuming this method exists
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs - Bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-900 text-white p-5">
            <h1 class="text-2xl font-bold mb-6">Bibliothèque</h1>
            <nav>
                <ul>
                    <li class="mb-4"><a href="admin-dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-blue-700' : ''; ?>">Tableau de Bord</a></li>
                    <li class="mb-4"><a href="livres.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'livres.php' ? 'bg-blue-700' : ''; ?>">Livres</a></li>
                    <li class="mb-4"><a href="categories.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'bg-blue-700' : ''; ?>">Catégories</a></li>
                    <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'utilisateurs.php' ? 'bg-blue-700' : ''; ?>">Utilisateurs</a></li>
                    <!-- <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700">Réservations</a></li> -->
                    <li class="mb-4"><a href="statistiques.php" class="block py-2 px-4 rounded hover:bg-blue-700">Statistiques</a></li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 p-10">
            <header class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-semibold">Gestion des Utilisateurs</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Déconnexion</button>
            </header>

            <!-- Add User Section -->
            <!-- <div class="mb-10">
                <h3 class="text-xl font-bold mb-2">Ajouter un Utilisateur</h3>
                <form action="add_user.php" method="POST">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium">Mot de passe</label>
                        <input type="password" id="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Ajouter l'Utilisateur</button>
                </form>
            </div> -->

            <!-- List of Users -->
            <div>
                <h3 class="text-xl font-bold mb-2">Liste des Utilisateurs</h3>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Nom d'utilisateur</th>
                            <th class="py-2 px-4 border-b">Email</th>
                            <th class="py-2 px-4 border-b">role</th>
                            <th class="py-2 px-4 border-b">created_at</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user->name); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user->email); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user->role); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user->created_at); ?></td>
                                <td class="py-2 px-4 border-b">
                                    <form action="modify_user.php" method="POST" class="inline">
                                        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>" />
                                        <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded">Modifier</button>
                                    </form>
                                    <form action="delete_user.php" method="POST" class="inline">
                                        <input type="hidden" name="delete_user_id" value="<?php echo $user->id; ?>" />
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