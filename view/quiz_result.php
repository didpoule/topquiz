<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Resultat</title>
    <link href="view/style.css" rel="stylesheet"/>
</head>
<body>
<div id="corps_page">
    <div class="titre"><h1><?= $quiz[0]['titre']?></h1></div>
    <?php
    for($question = 0; $question < $nbQuestions; $question++)
    {

        ?>
    <div class="question_quiz">
        <h2><?= $question+1 . ': '. $quiz[$question]['question']?></h2>
    </div>
    <div class="reponses_quiz">
    <?= $var ?>
        <?php
        for($j = 0; $j  < $nbReponses[$question]; $j++)
        {
            if ($reponse[$question]['contenu'][$j] != $repChoisies[$question]['contenu'])
            {
                echo '<div class="wrong">';
            } else
            {
                echo '<div class="right">';
            }
            ?>

            <p>
                <?= $reponse[$question]['contenu'][$j]//$reponse[$question][$j]  ?>
            </p>
            <?php
        }
    }
        ?>
    </div>
</div>
</div>
</body>
</html>
<?php