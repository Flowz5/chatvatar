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

function afficher_le_menu(){
    echo"——————————————————————————————————————————\n";
    echo" Menu:\n";
    echo" 1. Afficher la liste des chats\n";
    echo" 2. Créer un nouveau chaton\n";
    echo" 3. Supprimer un chaton\n";
    echo" 4. Lancer un combat\n";
    echo" 9. Quitter\n";
    echo"——————————————————————————————————————————\n\n";
}

function option_du_menu():int{
    $choix=intval(readline("Votre choix ? "));
    while ($choix != 1 and $choix != 2 and $choix != 3 and $choix != 4 and $choix != 9){
        afficher_le_menu();
		$choix=intval(readline("Votre choix ? "));
    }
    return $choix;
}

/**
 * Programme principal
 */

echo"\nBienvenue dans Catvatar\n";

$fin = false;

while (!$fin){

    afficher_le_menu();

    //traitement du choix du joueur
    switch (option_du_menu()) {
        case 1:
            echo"Liste des chats\n";
            liste_des_chats($les_chats);
            break;
        case 2 :
            echo"Création d'un chat\n";
            $nom = readline("Nom du chat : ");
            $type = option_des_pouvoirs($les_pouvoirs);
            
            $nouveau_chat = ["nom" => $nom, "type" => $type];
            array_push($les_chats, $nouveau_chat);
            
            echo "Le chat $nom a rejoint l'arène !\n";
            break;
        case 3 :
            echo"Suppression d'un chat\n";
            liste_des_chats($les_chats);
            $index = intval(readline("Numéro du chat à supprimer : "));
            
            if(isset($les_chats[$index])) {
                array_splice($les_chats, $index, 1);
                echo "Chat supprimé.\n";
            } else {
                echo "Ce chat n'existe pas.\n";
            }
            break;
        case 4 :
            echo"Nouveau combat\n";
            if (count($les_chats) < 2) {
                echo "Il faut au moins 2 chats pour se battre !\n";
                break;
            }

            liste_des_chats($les_chats);
            $id1 = intval(readline("Combattant 1 : "));
            $id2 = intval(readline("Combattant 2 : "));

            if (isset($les_chats[$id1]) && isset($les_chats[$id2])) {
                $c1 = $les_chats[$id1];
                $c2 = $les_chats[$id2];
                
                echo "\n⚔️ " . $c1['nom'] . " VS " . $c2['nom'] . " ⚔️\n";

                if ($c1['type'] == $c2['type']) {
                    echo "Match nul !";
                } else {
                    $victoire_j1 = false;
                    switch ($c1['type']) {
                        case 'eau':   if($c2['type'] == 'feu')   $victoire_j1 = true; break;
                        case 'feu':   if($c2['type'] == 'terre') $victoire_j1 = true; break;
                        case 'terre': if($c2['type'] == 'air')   $victoire_j1 = true; break;
                        case 'air':   if($c2['type'] == 'eau')   $victoire_j1 = true; break;
                    }

                    if ($victoire_j1) {
                        echo "🏆 " . $c1['nom'] . " gagne !\n";
                    } else {
                        echo "🏆 " . $c2['nom'] . " gagne !\n";
                    }
                }
            }
            break;
        case 9:
            $fin=true;
            break;
        default:
            echo"Valeur de choix impossible";
    };
}
