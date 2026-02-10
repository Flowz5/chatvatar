<?php
/**
 * ------------------------------------------------------
 *                        CATVATAR
 * un jeu inspiré de l'anime Avatar mais avec des chats !
 * ------------------------------------------------------
 * 
 * Les chat ont un type qui régit l'issue de leurs combats :
 * 
 *  - 💧 eau > feu 🔥
 *  - 🔥 feu > terre 🪨
 *  - 🪨 terre > air 🌪️
 *  - 🌪️ air > eau 💧
 *
 */

/** 
 * Tableaux des données 
 */

$les_pouvoirs = ["eau", "terre", "feu", "air"];
$les_chats = [];

/**
 * Fonctions
 */

function afficher_les_pouvoirs($liste_pouvoirs) {
    echo "Liste des pouvoirs :\n";
    foreach ($liste_pouvoirs as $index => $pouvoir) {
        echo "$index - $pouvoir\n";
    }
}

function option_des_pouvoirs($liste_pouvoirs) {
    do {
        afficher_les_pouvoirs($liste_pouvoirs);
        $choix = intval(readline("Choisissez un pouvoir (numéro) : "));
    } while (!isset($liste_pouvoirs[$choix]));
    
    return $liste_pouvoirs[$choix];
}

function liste_des_chats($tableau_chats) {
    if (empty($tableau_chats)) {
        echo "Aucun chat dans la liste.\n";
        return;
    }
    foreach($tableau_chats as $index => $chat) {
        echo "$index : " . $chat['nom'] . " (" . $chat['type'] . ")\n";
    }
}

function afficher_le_menu() {
    echo "<h1>Bienvenue sur Chatvatar</h1>";
    echo "<ul>";
    echo '<li><a href="creer_chat.php">Créer un chat</a></li>';
    echo '<li><a href="liste_chat.php">Liste des chats</a></li>';
    echo '<li><a href="supprimer_chat.php">Supprimer un chat</a></li>';
    echo '<li><a href="combat.php">Nouveau combat</a></li>';
    echo "</ul>";
}

function option_du_menu():int{
    $choix=intval(readline("Votre choix ? "));
    while ($choix != 1 and $choix != 2 and $choix != 3 and $choix != 4 and $choix != 9){
        afficher_le_menu();
		$choix=intval(readline("Votre choix ? "));
    }
    return $choix;
}