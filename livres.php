<?php 
include_once "./classes/dbconection.php" ;
include_once "./classes/bibliotique.php" ;
$connectTodb = new Database2("bibliotheque" , "root" , "") ;
$connectTodb->connect() ;

$bibliotheque = new Bibliotheque($connectTodb);
$books = $bibliotheque->getAllBooks(); 



?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Livres - Bibliothèque</title>
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
          <li class="mb-4"><a href="categories.php"class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'bg-blue-700' : ''; ?>">Catégories</a></li>
          <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'utilisateurs.php' ? 'bg-blue-700' : ''; ?>">Utilisateurs</a></li>
          <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'reservations.php' ? 'bg-blue-700' : ''; ?>">Réservations</a></li>
          <li class="mb-4"><a href="statistiques.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'statistiques.php' ? 'bg-blue-700' : ''; ?>">Statistiques</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 p-10">
      <header class="flex justify-between items-center mb-10">
        <h2 class="text-3xl font-semibold">Gestion du Catalogue de Livres</h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Déconnexion</button>
      </header>

      <!-- Add Book Section -->
      <div class="mb-10">
        <h3 class="text-xl font-bold mb-2">Ajouter un Livre</h3>
        <form action="Addbook.php" method="POST" enctype="multipart/form-data">
          <?php if(!empty($msg)){

            if($msg == true){
              echo '<div id="error-message" class="text-green-500 mt-2 ">book added succ.</div>' ;
            }
            else{
                  echo '<div id="error-message" class="text-red-500 mt-2 ">Veuillez remplir tous les champs.</div>' ;
            } 
          } ;?>
        <!-- <div id="error-message" class="text-red-500 mt-2 ">Veuillez remplir tous les champs.</div> -->
          <div class="mb-4">
            <label for="title" class="block text-sm font-medium">Titre</label>
            <input type="text" id="title" name="title" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
          </div>
          <div class="mb-4">
            <label for="author" class="block text-sm font-medium">Auteur</label>
            <input type="text" id="author" name="author" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
          </div>
          <div class="mb-4">
            <label for="resume" class="block text-sm font-medium">resume</label>
            <input type="text" id="resume" name="resume" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
          </div>
          <div class="mb-4">
            <label for="cover_image" class="block text-sm font-medium">Image de Couverture</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
          </div>
          <div class="mb-4">
            <label for="category" class="block text-sm font-medium">Catégorie</label>
            <input type="text" id="category" name="category" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
          </div>
          <button type="submit" name="AddBook" class="bg-blue-600 text-white px-4 py-2 rounded">Ajouter le Livre</button>
        </form>
      </div>

      <!-- List of Books -->
      <div>
        <h3 class="text-xl font-bold mb-2">Liste des Livres</h3>
        <table class="min-w-full bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b">image</th>
              <th class="py-2 px-4 border-b">Titre</th>
              <th class="py-2 px-4 border-b">Auteur</th>
              <th class="py-2 px-4 border-b">Catégorie</th>
              <th class="py-2 px-4 border-b">status</th>
              <th class="py-2 px-4 border-b">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($books as $book): ?>
              <tr>
                <td class="py-2 px-4 border-b"><img src='<?php echo $book->image_path ?>' width='150' height='150'> </td>
                <td class="py-2 px-4 border-b"><?php echo $book->title ;?></td>
                <td class="py-2 px-4 border-b"><?php echo $book->author ; ?></td>
                <td class="py-2 px-4 border-b"><?php echo $book->category_id ; ?></td>
                <td class="py-2 px-4 border-b"><?php echo $book->status ; ?></td>
                
                <td class="py-2 px-4 border-b">
                  <form action="modify_book.php" method="POST" class="inline">
                    <input type="hidden" name="book_id" value="<?php echo $book->id ?>" />
                    <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded">Modifier</button>
                  </form>
                  <form action="delete_book.php" method="POST" class="inline">
                    <input type="hidden" name="delete_book_id" value="<?php echo $book->id; ?>" />
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