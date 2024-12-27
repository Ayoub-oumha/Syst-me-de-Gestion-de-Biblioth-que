<?php 
include_once "./classes/dbconection.php" ;
include_once "./classes/bibliotique.php" ;
$connectTodb = new Database2("bibliotheque" , "root" , "") ;
$connectTodb->connect() ;

// $TotalLivers = $connectTodb->query("SELECT COUNT(*) as total FROM books;");
// echo $TotalLivers[0]->total; 
// echo ("<br>")  ;


// $Totalutulisatuer = $connectTodb->query("SELECT COUNT(*) as total FROM users;");
// echo $Totalutulisatuer [0]->total; 

// echo "<br>" ;
// $activeReservations = $connectTodb->query("SELECT COUNT(*) as total FROM books WHERE status = 'reserved';");

$bibliotheque = new Bibliotheque($connectTodb);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de Bord - Bibliothèque</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <!-- Sidebar -->
  <div class="flex h-screen">
    <aside class="w-64 bg-blue-900 text-white p-5">
      <h1 class="text-2xl font-bold mb-6">Bibliothèque</h1>
      <nav>
        <ul>
          <li class="mb-4"><a href="index.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-blue-700' : ''; ?>">Tableau de Bord</a></li>
          <li class="mb-4"><a href="livres.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'livres.php' ? 'bg-blue-700' : ''; ?>">Livres</a></li>
          <li class="mb-4"><a href="#" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'bg-blue-700' : ''; ?>">Catégories</a></li>
          <li class="mb-4"><a href="#" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'utilisateurs.php' ? 'bg-blue-700' : ''; ?>">Utilisateurs</a></li>
          <li class="mb-4"><a href="#" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'reservations.php' ? 'bg-blue-700' : ''; ?>">Réservations</a></li>
          <li class="mb-4"><a href="#" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'statistiques.php' ? 'bg-blue-700' : ''; ?>">Statistiques</a></li>
          <li class="mb-4"><a href="#" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'parametres.php' ? 'bg-blue-700' : ''; ?>">Paramètres</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 p-10">
      <header class="flex justify-between items-center mb-10">
        <h2 class="text-3xl font-semibold">Tableau de Bord</h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Déconnexion</button>
      </header>

      <!-- Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-bold mb-2">Total Livres</h3>
          <p class="text-3xl font-semibold"><?php echo $bibliotheque->getTotalLivres() ?> </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-bold mb-2">Utilisateurs Inscrits</h3>
          <p class="text-3xl font-semibold"><?php echo $bibliotheque->getTotalUtilisateurs()  ?></p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-bold mb-2">Réservations Actives</h3>
          <p class="text-3xl font-semibold"><?php echo $bibliotheque->getActiveReservations() ?> </p>
        </div>
      </div>

      <!-- Tableau des Dernières Activités -->
      <div class="mt-10">
        <h3 class="text-2xl font-bold mb-4">Dernières Activités</h3>
        <table class="min-w-full bg-white border border-gray-200">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b">Nom</th>
              <th class="py-2 px-4 border-b">Action</th>
              <th class="py-2 px-4 border-b">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="py-2 px-4 border-b">Jean Dupont</td>
              <td class="py-2 px-4 border-b">Ajouté un nouveau livre</td>
              <td class="py-2 px-4 border-b">2024-12-25</td>
            </tr>
        
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
 