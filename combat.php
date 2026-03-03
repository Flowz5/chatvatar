<?php
session_start();
include 'chatvatar.php';

// --- LOGIQUE DU COMBAT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    // 1. Démarrer le combat
    if ($_POST['action'] === 'demarrer' && isset($_POST['chat1']) && isset($_POST['chat2'])) {
        $c1 = $_SESSION['les_chats'][$_POST['chat1']];
        $c2 = $_SESSION['les_chats'][$_POST['chat2']];
        
        $c1['pv'] = $c1['pv'] ?? 100;
        $c2['pv'] = $c2['pv'] ?? 100;

        $_SESSION['combat'] = [
            'c1' => $c1, 'c2' => $c2, 'tour' => 1, 'log' => []
        ];
    } 
    
    // 2. Lancer un tour
    elseif ($_POST['action'] === 'tour' && isset($_SESSION['combat'])) {
        $c1 = &$_SESSION['combat']['c1'];
        $c2 = &$_SESSION['combat']['c2'];

        // Dégâts de base (entre 10 et 25)
        $degats1 = rand(10, 25);
        $degats2 = rand(10, 25);

        // Multiplicateurs (Avantage élémentaire = x1.5, Désavantage = x0.5)
        $m1 = 1; $m2 = 1;
        if (($c1['type'] == 'eau' && $c2['type'] == 'feu') || ($c1['type'] == 'feu' && $c2['type'] == 'terre') ||
            ($c1['type'] == 'terre' && $c2['type'] == 'air') || ($c1['type'] == 'air' && $c2['type'] == 'eau')) {
            $m1 = 1.5; $m2 = 0.5;
        } elseif (($c2['type'] == 'eau' && $c1['type'] == 'feu') || ($c2['type'] == 'feu' && $c1['type'] == 'terre') ||
            ($c2['type'] == 'terre' && $c1['type'] == 'air') || ($c2['type'] == 'air' && $c1['type'] == 'eau')) {
            $m2 = 1.5; $m1 = 0.5;
        }

        $d1 = round($degats1 * $m1);
        $d2 = round($degats2 * $m2);

        // Application des dégâts
        $c2['pv'] -= $d1;
        $c1['pv'] -= $d2;
        if ($c1['pv'] < 0) $c1['pv'] = 0;
        if ($c2['pv'] < 0) $c2['pv'] = 0;

        $msg = "Tour {$_SESSION['combat']['tour']} : {$c1['nom']} inflige $d1 dgts | {$c2['nom']} inflige $d2 dgts.";
        array_unshift($_SESSION['combat']['log'], $msg); // Ajoute au début de l'historique
        $_SESSION['combat']['tour']++;
    } 
    
    // 3. Quitter l'arène
    elseif ($_POST['action'] === 'terminer') {
        unset($_SESSION['combat']);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Arène de Combat</title>
    <style>
        .arene { display: flex; justify-content: space-around; text-align: center; margin-top: 20px;}
        .colonne { border: 2px solid #ccc; padding: 20px; border-radius: 10px; width: 40%; background: #fff; }
        progress { width: 100%; height: 25px; accent-color: #4caf50; }
        .log { margin-top: 20px; background: #eee; padding: 15px; height: 150px; overflow-y: scroll; text-align: left; }
    </style>
</head>
<body>
    <h1>⚔️ Arène de Combat RPG ⚔️</h1>
    <a href="index.php">Retour à l'accueil</a>
    <hr>

    <?php if (!isset($_SESSION['combat'])): ?>
        <?php if (empty($_SESSION['les_chats']) || count($_SESSION['les_chats']) < 2): ?>
            <p>⚠️ Il faut au moins 2 chats pour combattre !</p>
        <?php else: ?>
            <form action="" method="POST">
                <input type="hidden" name="action" value="demarrer">
                <div class="arene">
                    <div class="colonne">
                        <h3>Combattant 1</h3>
                        <?php foreach ($_SESSION['les_chats'] as $idx => $chat) echo "<div><input type='radio' name='chat1' value='$idx' required> ".htmlspecialchars($chat['nom'])." ({$chat['type']})</div>"; ?>
                    </div>
                    <div class="colonne">
                        <h3>Combattant 2</h3>
                        <?php foreach ($_SESSION['les_chats'] as $idx => $chat) echo "<div><input type='radio' name='chat2' value='$idx' required> ".htmlspecialchars($chat['nom'])." ({$chat['type']})</div>"; ?>
                    </div>
                </div>
                <center><button type="submit" style="margin-top:20px; padding: 10px; background: #6a1b9a; color: white; border: none; cursor: pointer;">Entrer dans l'arène</button></center>
            </form>
        <?php endif; ?>

    <?php else: ?>
        <?php 
            $c1 = $_SESSION['combat']['c1'];
            $c2 = $_SESSION['combat']['c2'];
            $fini = ($c1['pv'] <= 0 || $c2['pv'] <= 0);
        ?>
        
        <div class="arene">
            <div class="colonne">
                <h2><?= htmlspecialchars($c1['nom']) ?> (<?= ucfirst($c1['type']) ?>)</h2>
                <progress value="<?= $c1['pv'] ?>" max="100"></progress>
                <p><strong><?= $c1['pv'] ?> / 100 PV</strong></p>
            </div>
            <h2 style="margin-top: 50px;">VS</h2>
            <div class="colonne">
                <h2><?= htmlspecialchars($c2['nom']) ?> (<?= ucfirst($c2['type']) ?>)</h2>
                <progress value="<?= $c2['pv'] ?>" max="100"></progress>
                <p><strong><?= $c2['pv'] ?> / 100 PV</strong></p>
            </div>
        </div>

        <form action="" method="POST" style="text-align: center; margin-top: 20px;">
            <?php if (!$fini): ?>
                <input type="hidden" name="action" value="tour">
                <button type="submit" style="padding: 15px 30px; font-size: 1.2em; background-color: #d32f2f; color: white; border: none; cursor: pointer;">Lancer le tour 🥊</button>
            <?php else: ?>
                <h2 style="color: green;">🏆 Fin du combat !</h2>
                <input type="hidden" name="action" value="terminer">
                <button type="submit" style="padding: 10px 20px; cursor: pointer;">Retourner au choix des combattants</button>
            <?php endif; ?>
        </form>

        <div class="log">
            <h3>Historique du combat :</h3>
            <?php foreach($_SESSION['combat']['log'] as $ligne) echo "<p>$ligne</p>"; ?>
        </div>
    <?php endif; ?>
</body>
</html>