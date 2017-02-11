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
            $compteur = 0;
            foreach($history['titre'] as $v) {
                echo '<h2><a href="?section=user&action=view&quiz=' .$history['id_quiz'][$compteur] . '">' . $v . '</a></h2><br />';
            $compteur ++;
        }
    }
}
?>
</div>
</body>
</html>
