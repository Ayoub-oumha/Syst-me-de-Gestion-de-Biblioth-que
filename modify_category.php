<?php
include_once "./classes/dbconection.php";
include_once "./classes/bibliotique.php";

$connectTodb = new Database2("bibliotheque", "root", "");
$connectTodb->connect();


$bibliotheque = new Bibliotheque($connectTodb);
if (isset($_POST['category_id'])) {
    $CateId = $_POST['category_id'];
    $infoOfCate = $bibliotheque->getCateBytId($CateId)[0] ;
}else header("Location: categories.php") ;

if(isset($_POST["update"])){
    if(!empty($_POST["title"]) && !empty($_POST["cate_id"])) {
         $name = $_POST["title"] ;
    $id = $_POST["cate_id"] ;
    $connectTodb->prepareAndExecute("UPDATE categories SET name = ?  WHERE id = ?",
                [$name, $id ]) ;
    }else echo "error : input empty" ;
   
}

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
                    <li class="mb-4"><a href="index.php" class="block py-2 px-4 rounded hover:bg-blue-700">Tableau de Bord</a></li>
                    <li class="mb-4"><a href="livres.php" class="block py-2 px-4 rounded hover:bg-blue-700">Livres</a></li>
                    <li class="mb-4"><a href="categories.php" class="block py-2 px-4 rounded hover:bg-blue-700 bg-blue-700">Catégories</a></li>
                    <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700">Utilisateurs</a></li>
                    <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700">Réservations</a></li>
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
                <form  method="POST" enctype="multipart/form-data" >
                   
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium">Titre</label>
                        <input type="text" id="title" name="title" value="<?php echo $infoOfCate->name ;?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                    </div>
                    <input type="hidden" name="cate_id" value="<?php echo $infoOfCate->id; ?>" />
                    <button type="submit" name="update" class="bg-blue-600 text-white px-4 py-2 rounded">Mettre à Jour cate</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>