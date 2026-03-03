<?php
// 1. On inclut le moteur
include 'chatvatar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un chat</title>
    <style> label { cursor: pointer; } button { margin-top: 10px; } </style>
</head>
<body>
    <h1>Créer un chat</h1>
    <a href="index.php">Retour à l'accueil</a>

    <form action="" method="POST">
        <label for="nom">Nom du chat :</label><br>
        <input type="text" id="nom" name="nom" required><br><br>

        <label>Pouvoir :</label>
        <?php afficher_les_pouvoirs($les_pouvoirs); ?>

        <button type="submit">Enregistrer</button>
    </form>

    <hr>

    <?php
    // Traitement du formulaire
    if (!empty($_POST)) {
        session_start();

        if (!isset($_SESSION['les_chats'])) {
            $_SESSION['les_chats'] = [];
        }

        // NOUVEAUTÉ : On ajoute 100 PV à la création
        $nouveau_chat = [
            "nom" => $_POST['nom'],
            "type" => $_POST['type'],
            "pv" => 100
        ];

        array_push($_SESSION['les_chats'], $nouveau_chat);

        echo "<p style='color:green'>✅ Le chat <strong>" . htmlspecialchars($_POST['nom']) . "</strong> (" . $_POST['type'] . ") a été ajouté avec 100 PV !</p>";
    }
    ?>
</body>
</html>