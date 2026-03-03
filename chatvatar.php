<?php
/**
 * ------------------------------------------------------
 * CATVATAR
 * Moteur du jeu
 * ------------------------------------------------------
 */

$les_pouvoirs = ["eau", "terre", "feu", "air"];

function afficher_le_menu() {
    echo "<h1>Bienvenue sur Chatvatar</h1>";
    echo "<ul>";
    echo '<li><a href="creer_chat.php">Créer un chat</a></li>';
    echo '<li><a href="liste_chat.php">Liste des chats</a></li>';
    echo '<li><a href="supprimer_chat.php">Supprimer un chat</a></li>';
    echo '<li><a href="combat.php">Nouveau combat</a></li>';
    echo "</ul>";
}

function afficher_les_pouvoirs($liste_pouvoirs) {
    echo "<div class='choix-pouvoirs'>";
    foreach ($liste_pouvoirs as $index => $pouvoir) {
        $label = ucfirst($pouvoir);
        echo "<div style='margin-bottom: 5px;'>";
        echo "<input type='radio' id='$pouvoir' name='type' value='$pouvoir' required>";
        echo "<label for='$pouvoir'> $label</label>";
        echo "</div>";
    }
    echo "</div>";
}

function liste_des_chats($tableau_chats) {
    if (empty($tableau_chats)) {
        echo "<p>Aucun chat à afficher.</p>";
        return;
    }

    echo '<table border="1" style="border-collapse: collapse; width: 60%;">';
    // NOUVEAUTÉ : Ajout de la colonne Points de Vie
    echo '<thead><tr style="background-color: #f2f2f2;"><th style="padding: 8px;">Nom</th><th style="padding: 8px;">Pouvoir</th><th style="padding: 8px;">Points de Vie</th></tr></thead>';
    echo '<tbody>';
    foreach($tableau_chats as $chat) {
        // Sécurité pour les anciens chats
        $pv = isset($chat['pv']) ? $chat['pv'] : 100;
        
        echo '<tr>';
        echo '<td style="padding: 8px;">' . htmlspecialchars($chat['nom']) . '</td>';
        echo '<td style="padding: 8px;">' . htmlspecialchars($chat['type']) . '</td>';
        echo '<td style="padding: 8px; font-weight: bold; color: #2e7d32;">' . $pv . ' / 100 PV</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}
?>