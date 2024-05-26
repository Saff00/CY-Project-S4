<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $name = $_POST["name"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];
  
    $city = $_POST["city"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConf = $_POST["passwordConf"];
    $adminstatut = 0;
    $subscriptionType = "a";
    $profilePic = $_FILES['profile_pic'];
    $birthDate = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

    if ($age < 18) {
        die("Vous devez avoir au moins 18 ans pour vous inscrire.");
    }

    if ($password !== $passwordConf) {
        die("Les mots de passe ne correspondent pas.");
    }

    $filename = 'utilisateurs.txt';
 
    $emailExists = false;

    // Check if email is banned
    if (file_exists($bannedFile)) {
        $bannedEmails = file($bannedFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (in_array($email, $bannedEmails)) {
            die("Erreur : Cette adresse email a été bannie.");
        }
    }

    if (file_exists($filename)) {
        $users = file($filename, FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            $user_data = explode(',', $user);
            if ($user_data[7] == $email) {
                $emailExists = true;
                break;
            }
        }
    }

    if ($emailExists) {
        die("Cette adresse email est déjà utilisée.");
    }

    if (isset($profilePic) && $profilePic['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $profilePic['tmp_name'];
        $fileName = $profilePic['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = $email . '.' . $fileExtension;
        $uploadFileDir = 'images/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $data = $firstname . ',' . $name . ',' . $birthdate . ',' . $gender . ',' .  $city . ',' . $email . ',' . $password . ',' . $newFileName  . PHP_EOL;
            file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
            header("Location: page_connexion.html");
            exit();
        } else {
            echo "Une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    } else {
        echo "Erreur: Aucun fichier téléchargé ou une erreur s'est produite lors du téléchargement.";
    }
}
