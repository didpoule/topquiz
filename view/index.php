<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Topquiz</title>
</head>
<body>
<div id="corps_page">
    <nav>
        <ul>
            <li><a href="?section=login">Se connecter</a></li>
            <li><a href="?section=user">Espace membre</a></li>
        </ul>
    </nav>
    <div class="liste_quiz">
        <?php
        foreach ($listeQuiz as $quiz) { ?>
            <div class="quiz">
                <a href="?section=quiz&quiz=<?= $quiz['id'] ?>"><h2><?= $quiz['titre'] ?></h2></a>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>