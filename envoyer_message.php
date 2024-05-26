<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['email'])) {
        $sender = $_SESSION['email'];
        $recipient = $_POST['recipient'];
        $message = $_POST['message'];

        if (empty($recipient) || empty($message)) {
            echo "Veuillez remplir tous les champs.";
        } else {
            $filename = 'messages.txt';
            $message_data = $sender . '|' . $recipient . '|' . date('Y-m-d H:i:s') . '|' . $message . PHP_EOL;
            if (file_put_contents($filename, $message_data, FILE_APPEND | LOCK_EX) !== false) {
                header("Location: boite_messagerie.php?recipient=" . urlencode($recipient) . "&success=1");
                exit();
            } else {
                echo "Une erreur s'est produite lors de l'envoi du message.";
            }
        }
    } else {
        echo "Vous devez être connecté pour envoyer un message.";
    }
} else {
    header("Location: boite_messagerie.php");
    exit();
}
?>
