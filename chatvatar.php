<?php
/**
 * ------------------------------------------------------
 * CATVATAR
 * un jeu inspiré de l'anime Avatar mais avec des chats !
 * ------------------------------------------------------
 */

/** * Tableaux des données 
 */
$les_pouvoirs = ["eau", "terre", "feu", "air"];

// NOTE : On a supprimé $les_chats = [] ici.
// Les données seront désormais stockées dans $_SESSION['les_chats']
// géré directement dans les pages (creer_chat.php, etc.)

/**
 * Fonctions d'affichage HTML
 */

/**
 * Affiche le menu de navigation
 */
function afficher_le_menu() {
    echo "<h1>Bienvenue sur Chatvatar</h1>";
    echo "<ul>";
    echo '<li><a href="creer_chat.php">Créer un chat</a></li>';
    echo '<li><a href="liste_chat.php">Liste des chats</a></li>';
    echo '<li><a href="supprimer_chat.php">Supprimer un chat</a></li>';
    echo '<li><a href="combat.php">Nouveau combat</a></li>';
    echo "</ul>";
}

/**
 * Affiche les boutons radio pour le choix des pouvoirs
 * @param array $liste_pouvoirs Le tableau des pouvoirs disponibles
 */
function afficher_les_pouvoirs($liste_pouvoirs) {
    echo "<div class='choix-pouvoirs'>";
    foreach ($liste_pouvoirs as $index => $pouvoir) {
        // ucfirst met la première lettre en majuscule (eau -> Eau)
        $label = ucfirst($pouvoir);
        
        echo "<div style='margin-bottom: 5px;'>";
        echo "<input type='radio' id='$pouvoir' name='type' value='$pouvoir' required>";
        echo "<label for='$pouvoir'> $label</label>";
        echo "</div>";
    }
    echo "</div>";
}

/**
 * Affiche la liste des chats sous forme de tableau HTML
 * @param array $tableau_chats Le tableau des chats (souvent $_SESSION['les_chats'])
 */
function liste_des_chats($tableau_chats) {
    // Si la liste est vide ou n'existe pas
    if (empty($tableau_chats)) {
        echo "<p>Aucun chat à afficher.</p>";
        return;
    }

    // Début du tableau HTML avec bordures
    echo '<table border="1" style="border-collapse: collapse; width: 50%;">';

    // En-tête du tableau
    echo '<thead>';
    echo '<tr style="background-color: #f2f2f2;">';
    echo '<th style="padding: 8px;">Nom</th>';
    echo '<th style="padding: 8px;">Pouvoir</th>';
    echo '</tr>';
    echo '</thead>';

    // Corps du tableau
    echo '<tbody>';
    foreach($tableau_chats as $chat) {
        echo '<tr>';
        echo '<td style="padding: 8px;">' . htmlspecialchars($chat['nom']) . '</td>';
        echo '<td style="padding: 8px;">' . htmlspecialchars($chat['type']) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
?>