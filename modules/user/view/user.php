<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Espace membre</title>
</head>
<body>
<div id="corps_page">
    <?php
    include_once 'view/menu.php';
    ?>
    <h1>Bienvenue sur votre espace <?= $_SESSION['user_pseudo'] ?> !</h1>
    <?php if(isset($msg)) {
        get_msg($msg);
    }?>
    <nav>
        <ul>
            <li><a href="?section=user&action=history">Consulter les résultats de mes quiz</a></li>
        </ul>
    </nav>
<?php
    if(isset($action)) {
        if ($action == 'history') {
            echo '<h2>Voici les quiz que vous avez déjà réalisé: </h2>';
            $compteur = 0;
            foreach($history['titre'] as $v) {
                echo '<h3><a href="?section=user&action=history&quiz=' .$history['id_quiz'][$compteur] . '">' . $v . '</a></h3>';
            $compteur ++;
        }
    } elseif ($action == 'quizHistory') {
            echo '<h2>Historique pour le quiz: <em>' . $history[0]['titre'] . '</em></h2>';
            foreach($history as $v) {
                echo '<h3><a href="?section=user&action=view&quiz='. $v['id_quiz'] .  '&result=' . $v['id'] . '">'. $v['date'] . '</a></h3>';
            }
        }
}
?>
</div>
</body>
</html>
