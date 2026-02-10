<?php
// 1. Démarrer la session (OBLIGATOIRE pour récupérer les chats créés)
session_start();

// 2. Inclure le moteur
include 'chatvatar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des chats</title>
    <style> table { margin-top: 20px; } </style>
</head>
<body>
    <h1>Liste des chats</h1>
    <a href="index.php">Retour à l'accueil</a>

    <hr>

    <?php
    // 3. Vérifier si la variable de session existe, sinon envoyer un tableau vide
    if (isset($_SESSION['les_chats'])) {
        liste_des_chats($_SESSION['les_chats']);
    } else {
        liste_des_chats([]);
    }
    ?>

</body>
</html>