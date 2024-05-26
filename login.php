<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $filename = 'utilisateurs.txt';
    $users = file($filename, FILE_IGNORE_NEW_LINES);
    $is_authenticated = false;
    $user_data = [];

    foreach ($users as $user) {
        $user_data = explode(',', $user);
        if ($user_data[7] == $email && $user_data[8] == $password) {
            $_SESSION["email"] = $email;
            $_SESSION['user_data'] = $user_data; 
            $_SESSION['is_admin'] = ($user_data[10] == '1'); 
            $is_authenticated = true;
            break;
        }
    }

    if ($is_authenticated) {
                header('Location: page_profil.php');
        }
    } else {
        header("Location: page_connexion.html?error=1");
        exit();
    }
