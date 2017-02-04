<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Resultat</title>
    <link href="view/style.css" rel="stylesheet"/>
</head>
<body>
<div id="corps_page">
    <div class="titre"><h1><?= $quiz['quiz_infos']['titre'] ?></h1></div>
    <?php
    for ($question = 0; $question < $quiz['quiz_infos']['nombre_questions']; $question++) {
        ?>
        <div class="question_quiz">
            <h2><?= $question + 1 . ': ' . $quiz['question_' . $question]['question_contenu'] ?></h2>
        </div>
        <div class="reponses_quiz">
        <?php
        for ($j = 0; $j < $quiz['question_' . $question]['nombre_reponses']; $j++) {
            /* Si la réponse à afficher est celle choisie par l'utilisateur et qu'elle est juste
                OU Si la réponse à afficher est la bonne réponse et non choisie par l'utilisateur*/
            if (($quiz['question_' . $question]['reponses_contenu'][$j] == $repChoisies['reponse']['contenu'][$question]) &&
                $repChoisies['reponse']['id'][$question] == $correction[$question]['reponse_id'] ||
                (($correction[$question]['contenu'] == $quiz['question_' . $question]['reponses_contenu'][$j]) &&
                    $repChoisies['reponse']['id'][$question] != $correction[$question]['reponse_id'])
            ) {
                echo '<div class="right">';
                // Si la réponse à afficher est celle choisie par l'utilisateur et qu'elle est fausse
            } elseif (($quiz['question_' . $question]['reponses_contenu'][$j] == $repChoisies['reponse']['contenu'][$question]) &&
                $repChoisies['reponse']['id'][$question] != $correction[$question]['reponse_id']
            ) {
                echo '<div class="wrong">';
            } else {
                echo '<div class="neutre">';
            }
            ?>
            <p>
                <?= $quiz['question_' . $question]['reponses_contenu'][$j] ?>
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
