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
