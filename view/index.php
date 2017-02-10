<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Topquiz</title>
</head>
<body>
<div id="corps_page">
    <?php include_once 'view/menu.php'; ?>
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