<?php
// 1. Démarrer la session pour récupérer la liste des chats
session_start();

// 2. Inclure le moteur
include 'chatvatar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un chat</title>
    <style> label { cursor: pointer; } button { margin-top: 10px; background-color: #d32f2f; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; } </style>
</head>
<body>
    <h1>Supprimer un chat</h1>
    <a href="index.php">Retour à l'accueil</a>

    <hr>

    <form action="" method="POST">
        <fieldset>
            <legend>Liste des chats</legend>

            <?php
            // Vérifier si la liste existe et n'est pas vide
            if (!isset($_SESSION['les_chats']) || empty($_SESSION['les_chats'])) {
                echo "<p>Aucun chat à supprimer.</p>";
            } else {
                // Parcourir le tableau pour afficher les boutons radio
                foreach ($_SESSION['les_chats'] as $index => $chat) {
                    echo '<div style="margin-bottom: 5px;">';
                    // La valeur du bouton radio est l'index (0, 1, 2...) pour savoir lequel supprimer
                    echo '<input type="radio" id="chat_'.$index.'" name="index_du_chat" value="'.$index.'" required>';
                    echo '<label for="chat_'.$index.'"> ' . htmlspecialchars($chat['nom']) . ' (' . htmlspecialchars($chat['type']) . ')</label>';
                    echo '</div>';
                }
                echo '<br><button type="submit">Supprimer</button>';
            }
            ?>
        </fieldset>
    </form>

    <?php
    // Traitement du formulaire (APRES l'affichage comme demandé)
    if (!empty($_POST) && isset($_POST['index_du_chat'])) {
        $index = $_POST['index_du_chat'];

        // Vérifier que l'index existe vraiment
        if (isset($_SESSION['les_chats'][$index])) {
            // On récupère les infos pour le message
            $chat_supprime = $_SESSION['les_chats'][$index];

            // On supprime le chat du tableau
            array_splice($_SESSION['les_chats'], $index, 1);

            echo "<p style='color:green; font-weight:bold;'>🗑️ Le chat <strong>" . htmlspecialchars($chat_supprime['nom']) . "</strong> (" . $chat_supprime['type'] . ") a bien été supprimé.</p>";

            // Petite astuce : on rafraichit la page après 2 secondes pour mettre à jour la liste visuelle
            echo "<meta http-equiv='refresh' content='2'>";
        }
    }
    ?>

</body>
</html>