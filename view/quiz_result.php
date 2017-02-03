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
        <?php
        for($j = 0; $j  < $nbReponses[$question]; $j++)
        {
            /* Si la réponse à afficher est celle choisie par l'utilisateur et qu'elle est juste
                OU Si la réponse à afficher est la bonne réponse et non choisie par l'utilisateur*/
            if (($reponse[$question]['contenu'][$j] == $repChoisies[$question]['contenu']) &&
                $repChoisies[$question]['reponse_id'] == $correction[$question]['reponse_id'] ||
                (($correction[$question]['contenu'] == $reponse[$question]['contenu'][$j]) &&
                    $repChoisies[$question]['reponse_id'] !=  $correction[$question]['reponse_id']))
            {
                echo '<div class="right">';
                // Si la réponse à afficher est celle choisie par l'utilisateur et qu'elle est fausse
            } elseif(($reponse[$question]['contenu'][$j] == $repChoisies[$question]['contenu']) &&
                $repChoisies[$question]['reponse_id'] != $correction[$question]['reponse_id'])
            {
                echo '<div class="wrong">';         
            } else
            {
                echo '<div class="neutre">';
            }

            ?>

            <p>
                <?= $reponse[$question]['contenu'][$j]//$reponse[$question][$j]  ?>
            </p>
            </div>
            <?php
        }
    }
        ?>
</div>
<h1>Score: <?= $score['score'] ?> %</h1>
</div>
</body>
</html>
<?php
