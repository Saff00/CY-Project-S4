<?php
session_start();
if (isset($_SESSION['email'])) {
    $filename = 'utilisateurs.txt';
    $users = file($filename, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        $user_data = explode(',', $user);
        if ($user_data[7] == $_SESSION['email']) {
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('pgin.jpg'); 
            background-size: cover;
            background-attachment: fixed;
        }

        .bhead {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            margin: 0;
            padding: 0;
        }

        .header-title a {
            color: white;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
        }

        .header-title a:hover {
            text-decoration: underline;
        }

        .header-buttons {
            display: flex;
        }

        .bhead button {
            background-color: #20b2aa; /* Pastel sea green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
        }

        .bhead button:hover {
            background-color: #17a589;
        }

        form {
            max-width: 600px;
            margin: 80px auto 20px; 
            background: rgba(255, 255, 255, 0.9); 
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="file"],
        textarea,
        select {
            width: calc(100% - 12px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button[type="submit"] {
            background: #20b2aa; /* Pastel sea green */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            display: block;
            width: 100%;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background: #17a589;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }

        #profile_pic_preview {
            display: none;
            max-width: 200px;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script>
        function validateForm() {
            var birthdate = document.querySelector('input[name="birthdate"]').value;
            var birthdateDate = new Date(birthdate);
            var today = new Date();
            var age = today.getFullYear() - birthdateDate.getFullYear();
            var m = today.getMonth() - birthdateDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthdateDate.getDate())) {
                age--;
            }

            if (age < 18) {
                alert("Vous devez avoir au moins 18 ans pour modifier votre profil.");
                return false;
            }

            var email = document.querySelector('input[name="email"]').value;
            if (!validateEmail(email)) {
                alert("L'adresse e-mail n'est pas valide.");
                return false;
            }

            return true;
        }

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function previewProfilePic(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile_pic_preview').style.display = 'block';
                    document.getElementById('profile_pic_preview').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('profile_pic_input').addEventListener('change', function () {
                previewProfilePic(this);
            });
        });
    </script>
</head>

<body>
    <div class="bhead">
        <h1 class="header-title"><a href="index.html">Travel Shuffle</a></h1>
        <div class="header-buttons">
            <button onclick="window.location.href='page_profil.php'">Retour au profil</button>
            <button onclick="window.location.href='dern_prof.php'">Consulter les profils</button>
        </div>
    </div>
    <form action="update_profil.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="firstname">Prénom :</label>
        <input type="text" name="firstname" value="<?php echo $user_data[0]; ?>" required><br>
        <label for="lastname">Nom :</label>
        <input type="text" name="lastname" value="<?php echo $user_data[1]; ?>" required><br>
        <label for="birthdate">Date de naissance :</label>
        <input type="date" name="birthdate" value="<?php echo $user_data[2]; ?>" required><br>
        <label for="gender">Sexe :</label>
        <input type="radio" id="male" name="gender" value="homme" <?php echo ($user_data[3] == 'homme') ? 'checked' : ''; ?> required>
        <label for="male">Homme</label><br>
        <input type="radio" id="female" name="gender" value="femme" <?php echo ($user_data[3] == 'femme') ? 'checked' : ''; ?> required>
        <label for="female">Femme</label><br>
        <label for="city">Ville :</label>
        <input type="text" name="city" value="<?php echo $user_data[6]; ?>" required><br>
        <label for="email">Email :</label>
        <input type="email" name="email" value="<?php echo $user_data[7]; ?>" required><br>
        <label for="profile_pic">Photo de profil :</label>
        <input type="file" name="profile_pic" id="profile_pic_input" accept="image/*"><br>
        <img id="profile_pic_preview" src="#" alt="Prévisualisation de la photo de profil"><br>
        <button type="submit">Enregistrer les modifications</button>
    </form>
</body>

</html>
<?php
            exit();
        }
    }
    echo "Erreur : Utilisateur non trouvé.";
} else {
    header("Location: page_connexion.html");
    exit();
}
?>
