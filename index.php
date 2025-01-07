<<<<<<< HEAD
<?php
session_start();

require_once 'config/database.php'; // Include your database class
require_once 'userC.php'; // Include your database class


$error_message = "";
$success_message = "";

$db = new Database();
$pdo = $db->connect();
$user = new User($pdo);

$show_login = true;
$show_signup = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!$user->login($email, $password)) {
            $error_message = "Invalid email or password.";
        }
    } elseif (isset($_POST['signup'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if ($user->register($name, $email, $password)) {
            $success_message = "Registration successful! You can now log in.";
        } else {
            $error_message = "Email already exists. Please use a different email.";
        }
        $show_login = true;
        $show_signup = false;
    } elseif (isset($_POST['show_signup'])) {
        $show_login = false;
        $show_signup = true;
    } elseif (isset($_POST['show_login'])) {
        $show_login = true;
        $show_signup = false;
    } elseif (isset($_POST['visitor'])) {
        header("Location: visitor.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Login & Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-lg rounded-lg">
        <?php if ($show_login): ?>
            <h1 class="text-2xl font-bold text-center text-gray-800">Library Login</h1>
            <?php if ($error_message): ?>
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg"> <?php echo $error_message; ?> </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg"> <?php echo $success_message; ?> </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" name="login" class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Login</button>
            </form>

            <form method="POST" action="" class="text-center mt-4">
                <button type="submit" name="visitor" class="px-4 py-2 text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Continue as Visitor</button>
            </form>

            <form method="POST" action="" class="text-center mt-4">
                <button type="submit" name="show_signup" class="text-blue-500 hover:underline">Don’t have an account? Sign up</button>
            </form>
        <?php endif; ?>

        <?php if ($show_signup): ?>
            <h2 class="text-2xl font-bold text-center text-gray-800">Sign Up</h2>
            <?php if ($error_message): ?>
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg"> <?php echo $error_message; ?> </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" name="signup" class="w-full px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Sign Up</button>
            </form>

            <form method="POST" action="" class="text-center mt-4">
                <button type="submit" name="show_login" class="text-blue-500 hover:underline">Already have an account? Log in</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        gsap.from(".w-full", { 
            duration: 1, 
            opacity: 0, 
            y: -20, 
            ease: "power2.out" 
        });
    </script>
</body>
</html>
=======
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
          <li class="mb-4"><a href="categories.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'bg-blue-700' : ''; ?>">Catégories</a></li>
          <li class="mb-4"><a href="utilisateurs.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'utilisateurs.php' ? 'bg-blue-700' : ''; ?>">Utilisateurs</a></li>
          <li class="mb-4"><a href="reservations.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'reservations.php' ? 'bg-blue-700' : ''; ?>">Réservations</a></li>
          <li class="mb-4"><a href="statistiques.php" class="block py-2 px-4 rounded hover:bg-blue-700 <?php echo basename($_SERVER['PHP_SELF']) == 'statistiques.php' ? 'bg-blue-700' : ''; ?>">Statistiques</a></li>
   
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
 
>>>>>>> Filali
