<?php 
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();

$bibliotheque = new Bibliotheque($connectTodb);


if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    $user = $bibliotheque->getUserById($user_id); 
    var_dump($user[0]->id) ;
} else {

    header("Location: utilisateurs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur - Bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-900 text-white p-5">
            <h1 class="text-2xl font-bold mb-6">Bibliothèque</h1>
            <nav>
                <ul>
                    <li class="mb-4"><a href="admin-dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-700">Tableau de Bord</a></li>
                    <li class="mb-4"><a href="livres.php" class="block py-2 px-4 rounded hover:bg-blue-700">Livres</a></li>
                    <li class="mb-4"><a href="categories.php" class="block py-2 px-4 rounded hover:bg-blue-700">Catégories</a></li>
                    <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700">Utilisateurs</a></li>
                    <!-- <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700">Réservations</a></li> -->
                    <li class="mb-4"><a href="statistiques.php" class="block py-2 px-4 rounded hover:bg-blue-700">Statistiques</a></li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 p-10">
            <header class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-semibold">Modifier Utilisateur</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Déconnexion</button>
            </header>

            <!-- Modify User Form -->
            <div>
                <h3 class="text-xl font-bold mb-2">Modifier les Détails de l'Utilisateur</h3>
                <form action="update_user.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user[0]->id); ?>" />
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user[0]->name); ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user[0]->email); ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <div class="mb-4">
                        <!-- <label for="password" class="block text-sm font-medium">Mot de passe (laisser vide pour ne pas changer)</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2" /> -->
                        <label for="password" class="block text-sm font-medium">Role</label>
                        <select name="role" class="mt-1 block w-full border border-gray-300 rounded-md p-2" >
                            <option ></option>
                            <option value="Admin">Admin</option>
                            <option value="authenticated">authenticated</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mettre à Jour l'Utilisateur</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 