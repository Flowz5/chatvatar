<?php
// 1. Démarrer la session
session_start();

// 2. Inclure le moteur
include 'chatvatar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Combat de Chats</title>
    <style>
        .arene { display: flex; gap: 50px; margin-bottom: 20px; }
        .colonne { border: 1px solid #ccc; padding: 15px; border-radius: 8px; width: 45%; }
        button { background-color: #6a1b9a; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 1.2em; }
        .resultat { background-color: #e8f5e9; border: 2px solid #4caf50; padding: 20px; margin-top: 20px; text-align: center; font-size: 1.5em; }
    </style>
</head>
<body>
    <h1>⚔️ Arène de Combat ⚔️</h1>
    <a href="index.php">Retour à l'accueil</a>
    <hr>

    <?php
    // Si pas de chats, on prévient
    if (empty($_SESSION['les_chats']) || count($_SESSION['les_chats']) < 2) {
        echo "<p>⚠️ Il faut au moins 2 chats pour lancer un combat ! Allez en <a href='creer_chat.php'>créer</a>.</p>";
    } else {
    ?>
        <form action="" method="POST">
            <div class="arene">

                <div class="colonne">
                    <h3>Combattant 1</h3>
                    <?php
                    foreach ($_SESSION['les_chats'] as $index => $chat) {
                        echo '<div>';
                        echo '<input type="radio" id="c1_'.$index.'" name="chat1" value="'.$index.'" required>';
                        echo '<label for="c1_'.$index.'"> ' . htmlspecialchars($chat['nom']) . ' (' . $chat['type'] . ')</label>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="colonne">
                    <h3>Combattant 2</h3>
                    <?php
                    foreach ($_SESSION['les_chats'] as $index => $chat) {
                        echo '<div>';
                        echo '<input type="radio" id="c2_'.$index.'" name="chat2" value="'.$index.'" required>';
                        echo '<label for="c2_'.$index.'"> ' . htmlspecialchars($chat['nom']) . ' (' . $chat['type'] . ')</label>';
                        echo '</div>';
                    }
                    ?>
                </div>

            </div>
            <center><button type="submit">Lancer le combat ! 🥊</button></center>
        </form>
    <?php
    } // Fin du else
    ?>

    <?php
    // LOGIQUE DU COMBAT (Traitement PHP)
    if (!empty($_POST) && isset($_POST['chat1']) && isset($_POST['chat2'])) {

        $i1 = $_POST['chat1'];
        $i2 = $_POST['chat2'];

        // On récupère les deux objets chats
        $c1 = $_SESSION['les_chats'][$i1];
        $c2 = $_SESSION['les_chats'][$i2];

        echo "<div class='resultat'>";
        echo "🔥 <strong>" . htmlspecialchars($c1['nom']) . "</strong> (" . $c1['type'] . ") VS <strong>" . htmlspecialchars($c2['nom']) . "</strong> (" . $c2['type'] . ") 🔥<br><br>";

        if ($c1['type'] === $c2['type']) {
            echo "😐 Match nul ! Les éléments sont identiques.";
        } else {
            $victoire_j1 = false;

            // Logique des éléments (Switch comme demandé)
            switch ($c1['type']) {
                case 'eau':
                    // Eau bat Feu
                    if ($c2['type'] == 'feu') $victoire_j1 = true;
                    break;
                case 'feu':
                    // Feu bat Terre
                    if ($c2['type'] == 'terre') $victoire_j1 = true;
                    break;
                case 'terre':
                    // Terre bat Air
                    if ($c2['type'] == 'air') $victoire_j1 = true;
                    break;
                case 'air':
                    // Air bat Eau
                    if ($c2['type'] == 'eau') $victoire_j1 = true;
                    break;
            }

            if ($victoire_j1) {
                echo "🏆 Le vainqueur est <strong>" . htmlspecialchars($c1['nom']) . "</strong> !";
            } else {
                echo "🏆 Le vainqueur est <strong>" . htmlspecialchars($c2['nom']) . "</strong> !";
            }
        }
        echo "</div>";
    }
    ?>

</body>
</html>