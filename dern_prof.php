<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$filename = 'utilisateurs.txt';
$blocked_file = 'utilisateurs_bloques.txt';
if (!file_exists($filename)) {
    die("Le fichier des utilisateurs n'existe pas.");
}
if (!file_exists($blocked_file)) {
    file_put_contents($blocked_file, "");
}
$blocked_users = file($blocked_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$lines = file($filename, FILE_IGNORE_NEW_LINES);
$lines = array_reverse($lines);
$user_email = $_SESSION['email'];
$current_user_subscription = 'basique'; 
foreach ($lines as $line) {
    $user_data = explode(',', $line);
    if ($user_data[7] == $user_email) {
        $current_user_subscription = $user_data[11];
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Engine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('pgin.jpg') repeat;
        }
        .header-title {
            margin: 0;
            padding: 0;
            color: white;
            font-size: 24px;
        }

        .header-title a {
            color: white;
            text-decoration: none;
        }

        .header-title a:hover {
            text-decoration: underline;
        }

        .bhead {
            background: #000;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-buttons {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .bhead button {
            background: green;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-left: 10px;
        }

        .bhead button:hover {
            background-color: #c40000;
        }

        h1 {
            text-align: left;
            margin: 20px;
            color: #fff;
            font-size: 36px;
        }

        #profiles {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
            padding: 20px;
        }

        .profile {
            width: 45%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
        }

        .profile h2 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .profile p {
            color: #666;
            margin: 0;
            line-height: 1.5;
        }

        .profile-button {
            background: blue; 
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 10px;
            display: inline-block;
        }

        .profile-button:hover {
            background-color: #0000c4;
        }

        .block-button {
            background: green; 
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 10px;
            display: inline-block;
        }

        .block-button:hover {
            background-color: #c40000;
        }

        .blocked-users-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .blocked-users-btn:hover {
            background-color: #0000c4;
        }

        #blockedUsersModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #blockedUsersModal .close-btn {
            background: green;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }

        #blockedUsersModal .close-btn:hover {
            background-color: #c40000;
        }
    </style>
    <script>
        function blockUser(userId) {
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "block_user.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                    location.reload();
                } else if (this.readyState == 4) {
                    alert("Erreur lors du blocage de l'utilisateur.");
                }
            };
            xhttp.send("user_id=" + userId);
        }

        function showBlockedUsers() {
            window.location.href = 'get_blocked_users.php';
        }

        function closeModal() {
            var modal = document.getElementById('blockedUsersModal');
            modal.style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="bhead">
        <h1 class="header-title"><a href="index.html">Cardate</a></h1>
        <div class="header-buttons">
            <button onclick="window.location.href='rech_ajax.html'">Recherche</button>
        </div>
    </div>
    <div id="profiles">
        <?php
        $count = 0;
        foreach ($lines as $line) {
            $user_data = explode(',', $line);
            $user_id = $user_data[7];
            if ($user_id == $user_email || in_array($user_id, $blocked_users)) {
                continue;
            }
            echo "<div class='profile'>";
            echo "<img src='images/" . htmlspecialchars($user_data[9]) . "' alt='Photo de profil'>";
            echo "<h2>" . htmlspecialchars($user_data[0]) . " " . htmlspecialchars($user_data[1]) . "</h2>";
            echo "<p><strong>Date de naissance:</strong> " . htmlspecialchars($user_data[2]) . "</p>";
            echo "<p><strong>Sexe:</strong> " . htmlspecialchars($user_data[3]) . "</p>";
            echo "<p><strong>Description physique:</strong> " . htmlspecialchars($user_data[4]) . "</p>";
            echo "<p><strong>Statut relationnel:</strong> " . htmlspecialchars($user_data[5]) . "</p>";
            echo "<p><strong>Ville:</strong> " . htmlspecialchars($user_data[6]) . "</p>";
            echo "<a href='detail.php?user_id=" . htmlspecialchars($user_id) . "' class='profile-button'>Voir le détail</a>";
            echo "<button class='block-button' onclick='blockUser(\"" . htmlspecialchars($user_id) . "\")'>Bloquer</button>";
            echo "</div>";
            $count++;
            if (($current_user_subscription == 'basique' ||$current_user_subscription == 'a') && $count >= 10) {
                break;
            }
        }
        ?>
    </div>
    <button class="blocked-users-btn" onclick="showBlockedUsers()">Voir les utilisateurs bloqués</button>
</body>
</html>
